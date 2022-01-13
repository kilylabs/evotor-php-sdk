<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;

class BulksOperation extends Operation {

    const PATH = 'bulks';

    protected $path = self::PATH;
    protected $allowed_methods = ['get'];

    protected $id;

    public function  run(Operation $prev = null) {
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
                $this->path = self::PATH.'/'.$id;
            } else {
                $this->path = self::PATH;
            }
        }
    }


}
