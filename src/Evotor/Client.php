<?php

namespace Kily\API\Evotor;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client as Guzzle;
use Kily\API\Evotor\Operations\OperationFactory;

class Client
{

    protected $api_key;
    protected $app_key;

    protected $id = null;
    protected $requested = null;
    protected $response = null;
    protected $client = null;
    protected $request_options = [];

    protected $http_message;
    protected $http_code;
    protected $error_message;
    protected $error_code;

    protected $_metadata = [];

    protected $is_called = false;

    public function __construct($api_key,$app_key='',$options=[]) {
        $this->api_key = $api_key;
        $this->app_key = $app_key;
        $this->client = new Guzzle(array_replace_recursive([
            'base_uri'=>'https://api.evotor.ru/',
            //'base_uri'=>'https://api.evotor.ru/api/v1/',
            'timeout'=>'300',
            'headers'=>[
                'Accept'=>'application/vnd.evotor.v2+json',
                'Content-Type'=>'application/vnd.evotor.v2+json',
                //'X-Authorization'=>$this->api,
                'Authorization'=>'bearer '.$this->api_key,
            ],
        ],$options));
    }

    public function _request($method,$uri,$data,$filter = null) {
        $resp = null;

        $this->http_code = null;
        $this->http_message = null;
        $this->error_code = null;
        $this->error_message = null;

        $options = $data;

        try {
            $resp = $this->client->request($method,$uri,$options);
        } catch(TransferException $e) {
            if($e instanceof TransferException) {
                if($e->hasResponse() && ($resp = $e->getResponse()) ) {
                    $this->http_code = $resp->getStatusCode();
                    $this->http_message = $resp->getReasonPhrase();
                } else {
                    $this->http_code = $e->getCode();
                    $this->http_message = $e->getMessage();
                }
            } else {
                $this->http_code = $e->getCode();
                $this->http_message = $e->getMessage();
                return null;
            }
        } catch(\Exception $e) {
            $this->http_code = 0;
            $this->http_message = 'Library error';
        } finally {
            $this->http_code = $resp->getStatusCode();
            $this->http_message = $resp->getReasonPhrase();
        }

        $this->response = new Response($this,$resp,$filter);
        $this->requested = [];

        return $this->response;
    }

    public function getClient() {
        return $this->client;
    }

    public function __call($name,$arguments=[]) {
        $op = OperationFactory::fromName($this,$name,$arguments);
        return $op->run();
    }

    public function getHttpErrorMessage() {
        return $this->http_message;
    }

    public function getHttpErrorCode() {
        return $this->http_code;
    }

    public function getErrorMessage() {
        return $this->error_message;
    }

    public function getErrorCode() {
        return $this->error_code;
    }

    public function isOk() {
        return strpos((string)$this->http_code,'2') === 0;
    }

    public function getAppKey() {
        return $this->app_key;
    }
}
