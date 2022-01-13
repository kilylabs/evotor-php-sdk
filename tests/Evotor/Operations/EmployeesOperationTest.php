<?php declare(strict_types = 1);

namespace Kily\API\Evotor\Operations;

use PHPUnit\Framework\TestCase;

class EmployeesOperationTest extends TestCase
{
    /** @var EmployeesOperation */
    private $employeesOperation;

    protected function setUp(): void
    {
        $this->clnt = $this->createMock(\Kily\API\Evotor\Client::class);
        $this->employeesOperation = new EmployeesOperation(
            $this->clnt,
            'employees',
            [],
            null
        );
    }

    public function test()
    {
        $this->assertTrue($this->employeesOperation->run() instanceof Operation);
    }
}
