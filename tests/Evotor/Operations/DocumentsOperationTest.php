<?php

declare(strict_types=1);

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Exception;
use PHPUnit\Framework\TestCase;

class DocumentsOperationTest extends TestCase
{
    /** @var DocumentsOperation */
    private $documentsOperation;

    protected function setUp(): void
    {
        $this->clnt = $this->createMock(\Kily\API\Evotor\Client::class);
        $this->documentsOperation = new DocumentsOperation(
            $this->clnt,
            'documents',
            [],
            $this->createMock(\Kily\API\Evotor\Operations\Operation::class)
        );
    }

    public function test()
    {
        $this->assertTrue($this->documentsOperation->run() instanceof Operation);
    }

    public function testException()
    {
        $this->expectException(Exception::class);
        $this->documentsOperation = new DocumentsOperation(
            $this->clnt,
            'documents',
            [],
            null
        );
        $this->documentsOperation->run();
    }
}
