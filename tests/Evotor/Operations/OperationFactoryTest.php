<?php declare(strict_types = 1);

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Operations\OperationFactory;
use Kily\API\Evotor\Exception;
use Kily\API\Evotor\Operations\Operation;
use PHPUnit\Framework\TestCase;

class OperationFactoryTest extends TestCase
{
    /** @var OperationFactory */
    private $clnt = null;

    protected function setUp(): void
    {
        $this->clnt = $this->createMock(\Kily\API\Evotor\Client::class);
    }

    public function testFromNameBad()
    {
        $this->expectException(Exception::class);
        OperationFactory::fromName($this->clnt,'_nonexistent_',[]);
    }

    public function testFromNameGood()
    {
        $this->assertTrue(OperationFactory::fromName($this->clnt,'stores',[]) instanceof Operation);
    }
}
