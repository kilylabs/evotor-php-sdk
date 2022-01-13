<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;
use Kily\API\Evotor\Exception;

class DocumentsOperation extends Operation {

    const PATH = 'stores/{store_id}/documents';

    protected $path = self::PATH;
    protected $allowed_methods = ['get','post'];
    protected $id = null;

    public function run(Operation $prev = null) {
        return $this;
    }

    protected function init($args) {
        if($this->prev_operation) {
            if($this->prev_operation instanceof StoresOperation) {
                $this->path = str_replace('{store_id}',$this->prev_operation->id(),self::PATH);
            } elseif($this->prev_operation instanceof DeviceOperation) {
                $this->path = $this->prev_operation->getPath().'/documents';
            }
        } else {
            throw new Exception('Unable to get prev operation');
        }
    }

    public function id($id=false) {
        if($id === false) {
            return $this->id;
        } else {
            if($this->prev_operation instanceof DeviceOperation) {
                throw new Exception('You should not use id when fetching device documents');
            }
            $this->id = $id;
            if($id) {
                $this->path = str_replace('{store_id}',$this->prev_operation->id(),self::PATH).'/'.$id;
            } else {
                $this->path = str_replace('{store_id}',$this->prev_operation->id(),self::PATH);
            }
        }
    }

}
