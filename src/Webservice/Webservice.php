<?php

namespace Trois\Zinvoice\Webservice;
use Cake\Core\App;
use Muffin\Webservice\Model\Endpoint;
use Muffin\Webservice\ResultSet;
use Cake\Network\Http\Client;
use Muffin\Webservice\Query;
use Trois\Zinvoice\Exception\ZohoException;
use Trois\Zinvoice\Exception\ZohoSettingsException;
use Muffin\Webservice\Webservice\Webservice as BasWebservice;

abstract class Webservice extends BasWebservice
{
  protected $_settings = [
    'globalQueries' => [
      'authtoken' => null,
      'endpoint' => null
    ]
  ];

  /**
  * {@inheritDoc}
  */
  public function initialize()
  {
    $this->_settings['globalQueries']['authtoken'] = $this->driver()->config('authtoken');
  }

  protected function _getSettings($queryType)
  {
    $querySettigs = (!empty($this->_settings[$queryType]))? $this->_settings[$queryType]: [];

    $params = array_merge($this->_settings['globalQueries'], $querySettigs);
    if(empty($params['endpoint']))
    {
      throw new ZohoSettingsException(['Missing webservice path to call for '.$queryType]);
    }
    $endpoint = $params['endpoint'];
    unset($params['endpoint']);

    return [$endpoint, $params];
  }

  /**
  * {@inheritDoc}
  */
  protected function _executeUpdateQuery(Query $query, array $options = [])
  {
    debug($options);
    debug($query);
    /*
    // query settings
    list($endpoint, $params) = $this->_getSettings('createQuery');
    $endpoint .= '?'.http_build_query($params);
    $jData = json_encode($query->set());

    // quering service
    $response = $this->driver()->client()->put($endpoint,['JSONString' => $jData]);
    if (!$response->isOk()) {
      throw new ZohoException([$response->code, $response->json['message'].' code '.$response->json['code']]);
    }
    return $this->_transformResource($query->endpoint(), $response->json['contact']);
    */
  }

  /**
  * {@inheritDoc}
  */
  protected function _executeCreateQuery(Query $query, array $options = [])
  {
      // query settings
      list($endpoint, $params) = $this->_getSettings('createQuery');
      $endpoint .= '?'.http_build_query($params);
      $jData = json_encode($query->set());

      // quering service
      $response = $this->driver()->client()->post($endpoint,['JSONString' => $jData]);
      if (!$response->isOk()) {
        throw new ZohoException([$response->code, $response->json['message'].' code '.$response->json['code']]);
      }
      return $this->_transformResource($query->endpoint(), $response->json['contact']);
  }

  /**
  * {@inheritDoc}
  */
  protected function _executeReadQuery(Query $query, array $options = [])
  {
    // listMode
    $listMode = true;

    // query settings
    list($endpoint, $params) = $this->_getSettings('readQuery');
    if($query->page()){ $params['page'] = $query->page();}
    if($query->limit()){ $params['per_page'] = $query->limit();}
    if(!empty($query->clause('order')))
    {
      foreach($query->clause('order') as $fields => $direction)
      {
        $params['sort_column'] = substr($fields,strpos($fields,'.')+1, 200);
        $params['sort_order'] = ($direction == 'asc')? 'A': 'D';
      }
      $params['per_page'] = $query->limit();
    }

    // query conditions
    $conditions = $query->where();
    if(!empty($conditions)){
      $schema = $query->endpoint()->schema();
      foreach($conditions as $field => $condition)
      {
        if($schema->column($field))
        {
          if($schema->column($field)['primaryKey'])
          {
            $endpoint .= '/'.$condition;
            $listMode = false;
          }else
          {
            $params[$field.'_contains'] = $condition;
          }
        }
      }
    }

    // quering service
    $response = $this->driver()->client()->get($endpoint, $params);
    if (!$response->isOk()) {
      throw new ZohoException([$response->code, $response->json['message'].' code '.$response->json['code']]);
    }

    if($listMode)
    {
      // set ressources
      $resources = $this->_transformResults($query->endpoint(), $response->json[$query->endpoint()->endpoint()]);
      // pagging
      $pageContext = $response->json['page_context'];
      $total = ($pageContext['has_more_page'])? ($pageContext['page'] + 1) * $pageContext['per_page']: (($pageContext['page'] == 0)? count($resources): (($pageContext['page'] - 1) * $pageContext['per_page']) +count($resources) );
    }else
    {
      $name = strtolower(substr($query->endpoint()->resourceClass(), strrpos($query->endpoint()->resourceClass(), '\\') + 1));
      $resources = $this->_transformResults($query->endpoint(), [$response->json[$name]]);
      $total = 1;
    }

    return new ResultSet($resources, $total);
  }

  protected function __createResource(Endpoint $endpoint, $resourceClass, array $properties = [])
  {
    return new $resourceClass($properties, [
      'markClean' => true,
      'markNew' => false,
      'source' => App::shortName(get_class($endpoint), 'Model/Endpoint', 'Endpoint')
    ]);
  }

  protected function _transformResource(Endpoint $endpoint, array $result)
  {
    $properties = [];
    foreach ($result as $property => $value) {
      $properties[$property] = $value;
    }
    return $this->__createResource($endpoint, $endpoint->resourceClass(), $properties);
  }
}
