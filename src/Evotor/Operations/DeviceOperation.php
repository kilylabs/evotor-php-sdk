<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;
use Kily\API\Evotor\Exception;
use Kily\API\Evotor\Operations\OperationFactory;

class DeviceOperation extends Operation {

    const PATH = 'stores/{store_id}/devices/{device_id}';

    protected $path = self::PATH;
    protected $allowed_methods = ['get'];
    protected $id = null;

    public function  run(Operation $prev = null) {
        return $this;
    }

    protected function init($args) {
        if($this->prev_operation && ($this->prev_operation instanceof StoresOperation)) {
            $id = $args[0] ?? null;
            if($id) {
                $this->id($id);
            } else {
                throw new Exception('You must supply device id');
            }
        } else {
            throw new Exception('Unable to get prev operation');
        }
    }

    public function id($id=false) {
        if($id === false) {
            return $this->id;
        } else {
            $this->id = $id;
            if($id) {
                $this->path = str_replace(['{store_id}','{device_id}'],[$this->prev_operation->id(),$id],self::PATH);
            }
        }
    }

    public function documents() {
        if($this->id) {
            $op = OperationFactory::fromName($this->client,'documents',[],$this);
            return $op->run();
        } else {
            throw new Exception('You should define device id for using documents');
        }
    }
}
