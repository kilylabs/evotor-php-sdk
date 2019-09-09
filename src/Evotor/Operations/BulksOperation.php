<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;

class BulksOperation extends Operation {

    protected $path = 'bulks';
    protected $allowed_methods = ['get'];

    public function  run() {
        return $this;
    }

}
