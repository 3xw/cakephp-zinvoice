<?php
namespace Trois\Zinvoice\Model\Endpoint\Schema;
use Muffin\Webservice\Model\Schema;
class ItemSchema extends Schema
{
  /**
  * {@inheritDoc}
  */
  public function initialize()
  {
    parent::initialize();
    $this->addColumn('item_id', [
      'type' => 'integer',
      'primaryKey' => true,
    ]);
    $this->addColumn('item_name', [
      'type' => 'string',
    ]);
    $this->addColumn('rate', [
      'type' => 'float'
    ]);
  }
}
