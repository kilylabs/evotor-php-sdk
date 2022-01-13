<?php

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Client;

interface OperationInterface
{
    public function __construct(Client $client, string $name, array $arguments);
    public function run();
}
