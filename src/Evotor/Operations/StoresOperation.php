<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;
use Kily\API\Evotor\Exception;

class StoresOperation extends Operation
{
    public const PATH = 'stores';

    protected $path = self::PATH;
    protected $allowed_methods = ['get'];
    protected $id = null;

    public function run(Operation $prev = null)
    {
        return $this;
    }

    protected function init($args)
    {
        $id = $args[0] ?? null;
        if ($id) {
            $this->id($id);
        }
    }

    public function id($id=false)
    {
        if ($id === false) {
            return $this->id;
        } else {
            $this->id = $id;
            if ($id) {
                $this->path = self::PATH.'/'.$id;
            } else {
                $this->path = self::PATH;
            }
        }
    }

    public function device($id)
    {
        if ($this->id) {
            $op = OperationFactory::fromName($this->client, 'device', [$id], $this);
            return $op->run();
        } else {
            throw new Exception('You should define store id for using groups');
        }
    }

    public function products($id=null)
    {
        if ($this->id) {
            $op = OperationFactory::fromName($this->client, 'products', [$id], $this);
            return $op->run();
        } else {
            throw new Exception('You should define store id for using products');
        }
    }

    public function documents($id=null)
    {
        if ($this->id) {
            $op = OperationFactory::fromName($this->client, 'documents', [$id], $this);
            return $op->run();
        } else {
            throw new Exception('You should define store id for using documents');
        }
    }

    public function groups($id=null)
    {
        if ($this->id) {
            $op = OperationFactory::fromName($this->client, 'groups', [$id], $this);
            return $op->run();
        } else {
            throw new Exception('You should define store id for using groups');
        }
    }
}
