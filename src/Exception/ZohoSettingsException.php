<?php
namespace Trois\Zinvoice\Exception;
use Cake\Core\Exception\Exception;
class ZohoSettingsException extends Exception
{
    protected $_messageTemplate = 'Zoho settings error: %1$s';
}
