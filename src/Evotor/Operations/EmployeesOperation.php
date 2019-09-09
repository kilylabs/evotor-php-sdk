<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;

class EmployeesOperation extends Operation {

    protected $path = 'employees';
    protected $allowed_methods = ['get'];

    public function  run() {
        return $this;
    }

}
