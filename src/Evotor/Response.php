<?php

namespace Kily\API\Evotor;

use Psr\Http\Message\ResponseInterface;
use DusanKasan\Knapsack\Collection;

class Response
{
    protected $response;
    protected $clnt;
    protected $filter;

    private $arr;

    public function __construct(Client $clnt, ResponseInterface $resp, $filter = null) {
        $this->client = $clnt;
        $this->response = $resp;
        $this->filter = $filter;
    }

    public function __toString() {
        return $this->response->getBody()->__toString();
    }

    public function getResponse() {
        return $this->response;
    }

    public function toArray() {
        if(!$this->arr) {
            $data = json_decode($this->response->getBody(),true);
            $this->arr = $data['items'] ?? $data;
        }
        /*
        if($this->filter) {
            if($this->arr) {
                foreach($this->arr as $item) {
                    if($item && isset($item['id'])) {
                        if(strtolower($item['id']) == strtolower($this->filter)) {
                            return $item;
                        }
                    }
                }
            }
        }
        */
        return $this->arr;
    }

    public function first() {
        return $this->toArray()[0] ?? null;
    }

    public function __call($name,$arguments) {
        return call_user_func_array([Collection::from($this->toArray()?:[]),$name],$arguments);
    }

}
