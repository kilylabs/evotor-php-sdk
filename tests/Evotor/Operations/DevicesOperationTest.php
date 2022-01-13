<?php

declare(strict_types=1);

namespace Kily\API\Evotor\Operations;

use PHPUnit\Framework\TestCase;

class DevicesOperationTest extends TestCase
{
    /** @var DevicesOperation */
    private $devicesOperation;

    protected function setUp(): void
    {
        $this->clnt = $this->createMock(\Kily\API\Evotor\Client::class);
        $this->devicesOperation = new DevicesOperation(
            $this->clnt,
            'devices',
            [],
            null
        );
    }

    public function test()
    {
        $this->assertTrue($this->devicesOperation->run() instanceof Operation);
    }
}
