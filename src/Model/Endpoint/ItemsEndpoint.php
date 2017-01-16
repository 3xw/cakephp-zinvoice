<?php

namespace Trois\Zinvoice\Model\Endpoint;

use Muffin\Webservice\Model\Endpoint;
use Cake\Validation\Validator;

class ItemsEndpoint extends Endpoint
{
  public function initialize(array $config)
  {
    parent::initialize($config);
    $this->primaryKey('item_id');
    $this->displayField('item_name');
  }

  public function validationDefault(Validator $validator)
  {
    $validator
    ->requirePresence('item_name', 'create')
    ->notEmpty('item_name');

    $validator
    ->requirePresence('rate', 'create')
    ->notEmpty('rate');

    return $validator;
  }
}
