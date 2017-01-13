<?php

namespace Trois\Zinvoice\Webservice\Driver;

use Cake\Network\Http\Client;
use Muffin\Webservice\AbstractDriver;

class Zinvoice extends AbstractDriver
{

  /**
  * {@inheritDoc}
  */
  public function initialize()
  {
    $this->client(new Client([
      'host' => 'invoice.zoho.com',
      'scheme' => 'https',
    ]));
  }
}
