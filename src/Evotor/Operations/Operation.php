<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;
use Kily\API\Evotor\Exception;
use Kily\API\Evotor\Request;

class Operation implements OperationInterface {

    protected $client;
    protected $name;

    protected $allowed_methods = [];

    protected $path;
    protected $path_parts = [];
    protected $data = [];
    protected $type;
    protected $request_options = [];
    protected $prev_operation = null;

    public function __construct(Client $client, string $name, array $arguments, Operation $op = null) {
        $this->client = $client;
        $this->name = $name;
        $this->prev_operation = $op;

        $this->init($arguments);
    }

    protected function init($arguments) {
    }

    public function run(Operation $prev = null) {
        throw new Exception('This should be overriden');
    }

    public function __call($name,$arguments=[]) {
        if(!in_array($name,$this->allowed_methods)) {
            throw new Exception('Operation '.__CLASS__.' does not support '.$name.'() request method');
        }
        $req = $this->generateRequest($name,$arguments);
        return $req->request();
    }

    protected function generateRequest($name,$arguments) {
        if($name == 'bulk') {
            $name = 'post';
            if(!isset($this->request_options['headers'])) {
                $this->request_options['headers'] = [];
            }
            $this->request_options['headers']['Content-Type'] = 'application/vnd.evotor.v2+bulk+json';
        }
        $req = Request::fromName($this->client,$name,$arguments,$this->generateRequestData($name,$arguments));
        return $req;
    }

    protected function generateRequestData($name,$arguments) {
        $data = [
            'uri'=>$this->path_parts ? implode('/',$this->path_parts) : $this->path,
            'data'=>$this->data,
            'type'=>$this->type,
            'options'=>$this->request_options,
        ];
        return $data;
    }

    public function limit($cnt) {
        if(!isset($this->request_options['query'])) {
            $this->request_options['query'] = [];
        }
        $this->request_options['query']['limit'] = $cnt;
    }

}


