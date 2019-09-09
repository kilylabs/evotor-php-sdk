<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;

class DevicesOperation extends Operation {

    protected $path = 'devices';
    protected $allowed_methods = ['get'];

    public function  run() {
        return $this;
    }

}
