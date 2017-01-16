<?php
namespace Trois\Zinvoice\Model\Endpoint\Schema;
use Muffin\Webservice\Model\Schema;
class ExpensecategorySchema extends Schema
{
  /**
  * {@inheritDoc}
  */
  public function initialize()
  {
    parent::initialize();
    $this->addColumn('account_id', [
      'type' => 'integer',
      'primaryKey' => true,
    ]);
    $this->addColumn('account_name', [
      'type' => 'string',
    ]);
    
  }
}
