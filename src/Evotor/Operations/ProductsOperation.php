<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;
use Kily\API\Evotor\Exception;

class ProductsOperation extends Operation {

    const PATH = 'stores/{store_id}/products';

    protected $path = self::PATH;
    protected $allowed_methods = ['get','post','put','delete'];
    protected $id = null;

    public function  run(Operation $prev = null) {
        return $this;
    }

    protected function init($args) {
        if($this->prev_operation instanceof StoresOperation) {
            $id = $args[0] ?? null;
            $this->id($id);
        } else {
            throw new Exception('Unable to get prev operation');
        }
    }

    public function id($id=false) {
        if($id === false) {
            return $this->id;
        } else {
            if(is_array($id)) {
                if(isset($id['id'])) $id['id'] = implode(',',$id['id']);
            } else {
                $this->id = $id;
            }
            if($id) {
                if(is_array($id)) {
                    $this->path = str_replace('{store_id}',$this->prev_operation->id(),self::PATH).'?'.http_build_query($id);
                } else {
                    $this->path = str_replace('{store_id}',$this->prev_operation->id(),self::PATH).'/'.$id;
                }
            } else {
                $this->path = str_replace('{store_id}',$this->prev_operation->id(),self::PATH);
            }
        }
    }
}
