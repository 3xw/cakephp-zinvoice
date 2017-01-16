<?php

namespace Trois\Zinvoice\Model\Endpoint;

use Muffin\Webservice\Model\Endpoint;
use Cake\Validation\Validator;

class InvoicesEndpoint extends Endpoint
{
  public function initialize(array $config)
  {
    parent::initialize($config);
    $this->primaryKey('invoice_id');
    $this->displayField('invoice_number');
  }

  public function validationDefault(Validator $validator)
  {
    $validator
    ->requirePresence('customer_id', 'create')
    ->notEmpty('customer_id');

    $validator
    ->requirePresence('line_items', 'create')
    ->notEmpty('line_items');

    return $validator;
  }
}
