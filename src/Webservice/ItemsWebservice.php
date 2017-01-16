<?php

namespace Trois\Zinvoice\Webservice;

use Trois\Zinvoice\Webservice\Webservice;

class ItemsWebservice extends Webservice
{
  protected $_settings = [
    'globalQueries' => [
      'endpoint' => '/api/v3/items'
    ],
  ];
}
