<?php
namespace Trois\Zinvoice\Exception;
use Cake\Core\Exception\Exception;
class ZohoException extends Exception
{
    protected $_messageTemplate = 'Zoho error: %2$s (%1$d)';
}
