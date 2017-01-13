<?php

namespace 3xw\Zinvoice\Webservice;

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
        $response = $this->driver()->client()->get('/organizations',['authtoken' => Configure::read('Webservices.z_invoice.authtoken')]);

        if (!$response->isOk()) {
            return false;
        }

        $resources = $this->_transformResults($query->endpoint(), $response->json['articles']);

        return new ResultSet($resources, count($resources));
    }
}
