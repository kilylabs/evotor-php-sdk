<?php declare(strict_types = 1);

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Operations\Operation;
use Kily\API\Evotor\Response;
use PHPUnit\Framework\TestCase;

class BulksOperationTest extends TestCase
{
    /** @var BulksOperation */
    private $bulksOperation;

    protected function setUp(): void
    {
        $this->clnt = $this->createMock(\Kily\API\Evotor\Client::class);
        $this->bulksOperation = new BulksOperation(
            $this->clnt,
            'bulks',
            [],
            null
        );
    }

    public function test()
    {
        $this->assertTrue($this->bulksOperation->run() instanceof Operation);
    }
}
