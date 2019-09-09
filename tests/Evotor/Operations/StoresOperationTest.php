<?php declare(strict_types = 1);

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Exception;
use Kily\API\Evotor\Operations\ProductsOperations;
use PHPUnit\Framework\TestCase;

class StoresOperationTest extends TestCase
{
    /** @var StoresOperation */
    private $storesOperation;

    protected function setUp()
    {
        $this->clnt = $this->createMock(\Kily\API\Evotor\Client::class);
        $this->storesOperation = new StoresOperation(
            $this->clnt,
            'stores',
            [],
            null
        );
    }

    public function test()
    {
        $this->assertTrue($this->storesOperation->run() instanceof Operation);
    }

    public function testId()
    {
        $this->assertTrue($this->storesOperation->id("123") === null);
        $this->assertTrue($this->storesOperation->id() === "123");
    }

    public function testProductsBad() {
        $this->expectException(Exception::class);
        $this->storesOperation->products();
    }

    public function testProductsGood() {
        $this->storesOperation->id("123");
        $this->assertTrue($this->storesOperation->products() instanceof ProductsOperation);
    }

    public function testDocumentsBad() {
        $this->expectException(Exception::class);
        $this->storesOperation->documents();
    }

    public function testDocumentsGood() {
        $this->storesOperation->id("123");
        $this->assertTrue($this->storesOperation->documents() instanceof DocumentsOperation);
    }

    public function testGroupsBad() {
        $this->expectException(Exception::class);
        $this->storesOperation->groups();
    }

    public function testGroupsGood() {
        $this->storesOperation->id("123");
        $this->assertTrue($this->storesOperation->groups() instanceof GroupsOperation);
    }
}
