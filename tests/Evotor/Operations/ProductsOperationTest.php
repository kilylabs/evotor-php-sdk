<?php declare(strict_types = 1);

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Exception;
use PHPUnit\Framework\TestCase;

class ProductsOperationTest extends TestCase
{
    /** @var ProductsOperation */
    private $productsOperation;

    protected function setUp(): void
    {
        $this->clnt = $this->createMock(\Kily\API\Evotor\Client::class);
        $this->productsOperation = new ProductsOperation(
            $this->clnt,
            'products',
            [],
            $this->createMock(\Kily\API\Evotor\Operations\StoresOperation::class)
        );
    }

    public function test()
    {
        $this->assertTrue($this->productsOperation->run() instanceof Operation);
    }

    public function testException()
    {
        $this->expectException(Exception::class);
        $this->productsOperation = new ProductsOperation(
            $this->clnt,
            'products',
            [],
            null
        );
        $this->productsOperation->run();
    }

    public function testException2()
    {
        $this->expectException(Exception::class);
        $this->productsOperation = new ProductsOperation(
            $this->clnt,
            'products',
            [],
            $this->createMock(\Kily\API\Evotor\Operations\Operation::class)
        );
        $this->productsOperation->run();
    }
}
