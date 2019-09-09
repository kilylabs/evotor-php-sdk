<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;
use Kily\API\Evotor\Exception;

class ProductsOperation extends Operation {

    protected $path = 'stores/{store_id}/products';
    protected $allowed_methods = ['get','post','bulk'];
    protected $id = null;

    public function  run() {
        if(!$this->prev_operation) {
            throw new Exception('You must define store to manipulate products from');
        }
        return $this;
    }

    protected function init($args) {
        if($this->prev_operation) {
            $this->path = str_replace('{store_id}',$this->prev_operation->id(),$this->path);
        } else {
            throw new Exception('Unable to get prev operation');
        }
    }

}
