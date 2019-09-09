<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;
use Kily\API\Evotor\Exception;
use Kily\API\Evotor\Operations\Operation;

class OperationFactory 
{
    public static function fromName(Client $client, string $name, array $arguments, Operation $op=null) {
        $cls = 'Kily\\API\\Evotor\\Operations\\'.ucfirst($name).'Operation';
        if($name && class_exists($cls)) {
            return new $cls($client,$name,$arguments,$op);
        }
        throw new Exception('Unable to find method '.$name.' of class '.ucfirst($name).'Operation');
    }
}
