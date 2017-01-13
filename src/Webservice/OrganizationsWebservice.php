<?php

namespace Trois\Zinvoice\Webservice;

use Muffin\Webservice\ResultSet;
use Cake\Network\Http\Client;
use Muffin\Webservice\Query;
use Muffin\Webservice\Webservice\Webservice;
use Trois\Zinvoice\Webservice\Exception\ZohoException;

class OrganizationsWebservice extends Webservice
{

    /**
     * {@inheritDoc}
     */
    protected function _executeReadQuery(Query $query, array $options = [])
    {
        $response = $this->driver()->client()->get('/api/v3/organizations',['authtoken' => $this->driver()->config('authtoken')]);

        if (!$response->isOk()) {
            throw new ZohoException([$response->code, $response->json['message'].' code '.$response->json['code']]);
        }

        $resources = $this->_transformResults($query->endpoint(), $response->json['organizations']);
        return new ResultSet($resources, count($resources));
    }
}
