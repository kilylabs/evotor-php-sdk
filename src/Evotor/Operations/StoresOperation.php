<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;
use Kily\API\Evotor\Exception;

class StoresOperation extends Operation {

    protected $path = 'stores';
    //protected $path = 'inventories/stores/search';
    protected $allowed_methods = ['get','post'];
    protected $id = null;

    public function  run() {
        return $this;
    }

    protected function init($args) {
        $id = $args[0] ?? null;
        if($id) {
            $this->id($id);
        }
    }

    public function id($id=false) {
        if($id === false) {
            return $this->id;
        } else {
            $this->id = $id;
            if($id) {
                $this->path = 'stores/'.$id;
            } else {
                $this->path = 'stores';
            }
        }
    }

    public function products() {
        if($this->id) {
            $op = OperationFactory::fromName($this->client,'products',[],$this);
            return $op->run();
        } else {
            throw new Exception('You should define store id for using products');
        }
    }

    public function documents() {
        if($this->id) {
            $op = OperationFactory::fromName($this->client,'documents',[],$this);
            return $op->run();
        } else {
            throw new Exception('You should define store id for using documents');
        }
    }

    public function groups() {
        if($this->id) {
            $op = OperationFactory::fromName($this->client,'groups',[],$this);
            return $op->run();
        } else {
            throw new Exception('You should define store id for using groups');
        }
    }

}
