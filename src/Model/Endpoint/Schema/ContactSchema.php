<?php
namespace Trois\Zinvoice\Model\Endpoint\Schema;
use Muffin\Webservice\Model\Schema;
class ContactSchema extends Schema
{
    /**
     * {@inheritDoc}
     */
    public function initialize()
    {
        parent::initialize();
        $this->addColumn('contact_id', [
            'type' => 'integer',
            'primaryKey' => true,
        ]);
        $this->addColumn('contact_name', [
            'type' => 'string',
        ]);
    }
}
