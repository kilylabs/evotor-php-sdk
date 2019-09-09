<?php declare(strict_types = 1);

namespace Kily\API\Evotor\Operations;

use PHPUnit\Framework\TestCase;

class OperationTest extends TestCase
{
    /** @var Operation */
    private $operation;

    /** @var Kily\API\Evotor\Client | PHPUnit_Framework_MockObject_MockObject */
    private $client;

    /** @var string */
    private $name;

    /** @var array */
    private $arguments;

    /** @var Kily\API\Evotor\Operations\Operation | PHPUnit_Framework_MockObject_MockObject */
    private $op;

    protected function setUp()
    {
        $this->client = $this->createMock(\Kily\API\Evotor\Client::class);
        $this->name = '';
        $this->arguments = [];
        $this->op = null;
        $this->operation = new Operation(
            $this->client,
            $this->name,
            $this->arguments,
            $this->op
        );
    }

    public function testMissing()
    {
        $this->markTestSkipped('Test not yet implemented');
    }
}
