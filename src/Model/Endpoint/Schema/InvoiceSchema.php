<?php
namespace Trois\Zinvoice\Model\Endpoint\Schema;
use Muffin\Webservice\Model\Schema;
class InvoiceSchema extends Schema
{
  /**
  * {@inheritDoc}
  */
  public function initialize()
  {
    parent::initialize();
    $this->addColumn('invoice_id', [
      'type' => 'integer',
      'primaryKey' => true,
    ]);
    $this->addColumn('customer_id', [
      'type' => 'integer',
    ]);
  }
}
