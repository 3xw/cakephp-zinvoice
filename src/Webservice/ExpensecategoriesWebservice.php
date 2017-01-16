<?php

namespace Trois\Zinvoice\Webservice;

use Trois\Zinvoice\Webservice\Webservice;

class ExpensecategoriesWebservice extends Webservice
{
  protected $_settings = [
    'globalQueries' => [
      'endpoint' => '/api/v3/expensecategories'
    ],
  ];
}
