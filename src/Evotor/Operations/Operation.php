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
    protected $data = null;
    protected $type;
    protected $request_options = [];
    protected $prev_operation = null;
    protected $is_bulk = false;

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

    public function get($id=null,$options = []) {
        if(!in_array('get',$this->allowed_methods)) {
            throw new Exception('Operation '.__CLASS__.' does not support get() request method');
        }
        if($id) {
            $this->id($id);
        }
        $req = $this->generateRequest('get',[$id,$options]);
        return $req->request();
    }

    public function create($data,$options = []) {
        if(!in_array('post',$this->allowed_methods)) {
            throw new Exception('Operation '.__CLASS__.' does not support post() request method');
        }
        if($this->id()) {
            throw new Exception('Operation '.__CLASS__.' does not require id');
        }
        $this->data = $data;
        $req = $this->generateRequest('post',[$data,$options]);
        return $req->request();
    }

    public function update($id,$data = null,$options = []) {
        if(!in_array('put',$this->allowed_methods)) {
            throw new Exception('Operation '.__CLASS__.' does not support put() request method');
        }
        if(is_array($id)) {
            if(!$this->id()) {
                throw new Exception('For operation '.__CLASS__.' you mustt supply id on update');
            }
            $options = $data;
            $data = $id;
            $id = $this->id();
        }
        if($id) {
            $this->id($id);
        }
        $this->data = $data;
        $req = $this->generateRequest('put',[$data,$options]);
        return $req->request();
    }

    public function delete($id=null,$options = []) {
        if(!in_array('delete',$this->allowed_methods)) {
            throw new Exception('Operation '.__CLASS__.' does not support delete() request method');
        }
        if(is_array($id)) {
            if(!$this->id()) {
                throw new Exception('For operation '.__CLASS__.' you mustt supply id on delete');
            }
            $options = $id;
            $id = $this->id();
        }
        if($id) {
            $this->id($id);
        }
        $req = $this->generateRequest('delete',[$id,$options]);
        return $req->request();
    }

    public function fetchUpdate($id,$data = null, $options = []) {
        if(is_array($id)) {
            if(!$this->id()) {
                throw new Exception('For operation '.__CLASS__.' you mustt supply id on update');
            }
            $options = $data;
            $data = $id;
            $id = $this->id();
        }
        $g_data = $this->get($id);
        if($g_data && ($g_data = $g_data->toArray()) && isset($g_data['id'])) {
            unset($g_data['id']);
            unset($g_data['created_at']);
            unset($g_data['updated_at']);
            $data = array_merge($g_data,$data);
            return $this->update($id,$data,$options);
        } else {
            return $g_data;
        }
    }

    public function bulk() {
        if(!isset($this->request_options['headers'])) {
            $this->request_options['headers'] = [];
        }
        $this->request_options['headers']['Content-Type'] = 'application/vnd.evotor.v2+bulk+json';
        $this->is_bulk = true;
    }

    protected function generateRequest($name,$arguments) {
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

    public function getPath() {
        return $this->path;
    }

}


