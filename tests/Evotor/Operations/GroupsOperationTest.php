<?php declare(strict_types = 1);

namespace Kily\API\Evotor\Operations;

use Kily\API\Evotor\Exception;
use PHPUnit\Framework\TestCase;

class GroupsOperationTest extends TestCase
{
    /** @var GroupsOperation */
    private $groupsOperation;

    protected function setUp(): void
    {
        $this->clnt = $this->createMock(\Kily\API\Evotor\Client::class);
        $this->groupsOperation = new GroupsOperation(
            $this->clnt,
            'groups',
            [],
            $this->createMock(\Kily\API\Evotor\Operations\StoresOperation::class)
        );
    }

    public function test()
    {
        $this->assertTrue($this->groupsOperation->run() instanceof Operation);
    }

    public function testException()
    {
        $this->expectException(Exception::class);
        $this->groupsOperation = new GroupsOperation(
            $this->clnt,
            'groups',
            [],
            null
        );
        $this->groupsOperation->run();
    }

    public function testException2()
    {
        $this->expectException(Exception::class);
        $this->groupsOperation = new GroupsOperation(
            $this->clnt,
            'groups',
            [],
            $this->createMock(\Kily\API\Evotor\Operations\Operation::class)
        );
        $this->groupsOperation->run();
    }
}
