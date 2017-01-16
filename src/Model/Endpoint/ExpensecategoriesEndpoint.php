<?php

namespace Trois\Zinvoice\Model\Endpoint;

use Muffin\Webservice\Model\Endpoint;
use Cake\Validation\Validator;

class ItemsEndpoint extends Endpoint
{
  public function initialize(array $config)
  {
    parent::initialize($config);
    $this->primaryKey('account_id');
    $this->displayField('account_name');
  }

  public function validationDefault(Validator $validator)
  {
    $validator
    ->requirePresence('account_name', 'create')
    ->notEmpty('item_name');
    
    return $validator;
  }
}
