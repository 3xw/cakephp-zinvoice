<?php

namespace Trois\Zinvoice\Webservice;

use Cake\Core\Configure;
use Cake\Network\Http\Client;
use Muffin\Webservice\Query;
use Muffin\Webservice\Webservice\Webservice;

class ZorganizationsWebservice extends Webservice
{

    /**
     * {@inheritDoc}
     */
    protected function _executeReadQuery(Query $query, array $options = [])
    {
        $response = $this->driver()->client()->get('/api/v3/organizations',['authtoken' => Configure::read('Api.zinvoice.authtoken')]);
        debug($response->body());
        debug(Configure::read('Api.zoho.authtoken'));

        if (!$response->isOk()) {
            return false;
        }

        $resources = $this->_transformResults($query->endpoint(), $response->json['articles']);

        return new ResultSet($resources, count($resources));
    }
}
