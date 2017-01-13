<?php

namespace Trois\Zinvoice\Webservice;

use Muffin\Webservice\ResultSet;
use Cake\Network\Http\Client;
use Muffin\Webservice\Query;
use Muffin\Webservice\Webservice\Webservice;
use Trois\Zinvoice\Webservice\Exception\ZohoException;

class ContactsWebservice extends Webservice
{

  /**
  * {@inheritDoc}
  */
  protected function _executeReadQuery(Query $query, array $options = [])
  {
    // query config
    $params = [
      'authtoken' => $this->driver()->config('authtoken'),
      'organization_id' => $this->driver()->config('organization_id')
    ];
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

    // quering service
    $response = $this->driver()->client()->get('/api/v3/contacts', $params);
    if (!$response->isOk()) {
      throw new ZohoException([$response->code, $response->json['message'].' code '.$response->json['code']]);
    }
    $resources = $this->_transformResults($query->endpoint(), $response->json['contacts']);

    // pagging
    $pageContext = $response->json['page_context'];
    $total = ($pageContext['has_more_page'])? ($pageContext['page'] + 1) * $pageContext['per_page']: (($pageContext['page'] == 0)? count($resources): (($pageContext['page'] - 1) * $pageContext['per_page']) +count($resources) );

    debug($pageContext);
    debug($resources);

    return new ResultSet($resources, $total);
  }
}
