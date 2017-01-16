<?php

namespace Trois\Zinvoice\Webservice;

use Trois\Zinvoice\Webservice\Webservice;

class ContactsWebservice extends Webservice
{
  protected $_settings = [
    'globalQueries' => [
      'endpoint' => '/api/v3/contacts'
    ],
  ];
}
