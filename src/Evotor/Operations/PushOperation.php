<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;
use Kily\API\Evotor\Exception;

class PushOperation extends Operation {

    protected $path = 'api/apps/{app_id}/push-notifications';
    protected $allowed_methods = ['post'];
    protected $payload = [];

    public function  run() {
        return $this;
    }

    protected function init($args) {
        $payload = $args[0] ?? null;
        if($payload) {
            $this->payload($payload);
        }
        $this->path = str_replace('{app_id}',$this->client->getAppKey(),$this->path);
    }

    public function payload($payload=false) {
        if($payload === false) {
            return $this->payload;
        } else {
            $this->payload = $payload;
        }
    }

    protected function generateRequestData($name,$arguments) {
        $data = parent::generateRequestData($name,$arguments);
        $data['data']['payload'] = $this->payload;
        $devices = $arguments[0] ?? [];
        if(!$devices) {
            throw new Exception('You must supply devices to send push notification to');
        }
        $data['data']['devices'] = $devices;
        return $data;
    }
}
