<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;
use Kily\API\Evotor\Exception;

class GroupsOperation extends Operation {

    const PATH = 'stores/{store_id}/product-groups';

    protected $path = self::PATH;
    protected $allowed_methods = ['get','put','post','delete'];
    protected $id = null;

    public function  run() {
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
            $this->id = $id;
            if($id) {
                $this->path = str_replace('{store_id}',$this->prev_operation->id(),self::PATH).'/'.$id;
            } else {
                $this->path = str_replace('{store_id}',$this->prev_operation->id(),self::PATH);
            }
        }
    }
}
