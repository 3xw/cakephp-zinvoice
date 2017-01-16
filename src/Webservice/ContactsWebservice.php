<?php

namespace Trois\Zinvoice\Webservice;

use Trois\Zinvoice\Webservice\Webservice;

class ContactsWebservice extends Webservice
{

  protected $_settings =[
    'globalQueries' => [
      'authtoken' => null,
      'organization_id' => null,
      'endpoint' => '/api/v3/contacts'
    ],
  ];

  /**
  * {@inheritDoc}
  */
  public function initialize()
  {
    parent::initialize();
    $this->_settings['globalQueries']['organization_id'] = $this->driver()->config('organization_id');
  }

}
