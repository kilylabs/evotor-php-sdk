<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;

class EmployeesOperation extends Operation
{
    public const PATH = 'employees';

    protected $path = self::PATH;
    protected $allowed_methods = ['get'];

    protected $id;

    public function run(Operation $prev = null)
    {
        return $this;
    }

    public function id($id=false)
    {
        throw new Exception('Employees operation does not support fetch by id');
    }
}
