<?php

namespace ZInvoice\Webservice\Driver;

use Cake\Network\Http\Client;
use Muffin\Webservice\AbstractDriver;

class ZInvoice extends AbstractDriver
{

  /**
  * {@inheritDoc}
  */
  public function initialize()
  {
    $this->client(new Client([
      'host' => 'invoice.zoho.com/api/v3',
      'scheme' => 'https',
    ]));
  }
}
