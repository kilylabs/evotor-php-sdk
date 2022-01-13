<?php

namespace Kily\API\Evotor;

use Psr\Http\Message\RequestInterface;

class Request
{
    protected $response;
    protected $clnt;

    private $arr;

    public $name;
    public $rname;
    public $uri;
    public $data;
    public $type = 'json';
    public $filter;
    public $options = [];

    public static function fromName(Client $client, string $name, array $arguments = [], array $request_data = [])
    {
        $cls = static::class;
        $req = new $cls($client, $name, $arguments);
        foreach ($request_data as $k=>$v) {
            $req->$k = $v;
        }
        return $req;
    }

    public function __construct(Client $client, string $name, array $arguments = [])
    {
        $this->client = $client;
        $this->name = $this->rname = mb_strtolower($name);

        if ($this->name == 'bulk') {
            $this->name = 'post';
        } elseif ($name == 'get') {
            $this->filter = $arguments[0] ?? null;
        }
    }

    public function request()
    {
        $data = [];
        if ($this->data !== null) {
            if ($this->type == 'form_data') {
                $data['form_data'] = $this->data;
            } else {
                $data['body'] = json_encode($this->data);
            }
        }
        if ($this->options) {
            $data = array_replace_recursive($this->options, $data);
        }
        return $this->client->_request($this->name, $this->uri, $data, $this->filter);
    }
}
