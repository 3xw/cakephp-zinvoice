<?php

namespace Trois\Zinvoice\Model\Endpoint;

use Muffin\Webservice\Model\Endpoint;
use Cake\Validation\Validator;

class ContactsEndpoint extends Endpoint
{
  public function initialize(array $config)
  {
    parent::initialize($config);
    $this->primaryKey('contact_id');
    $this->displayField('contact_name');
  }

  public function validationDefault(Validator $validator)
  {
    $validator
    ->requirePresence('contact_name', 'create')
    ->notEmpty('contact_name');

    return $validator;
  }
}
