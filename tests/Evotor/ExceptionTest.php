<?php declare(strict_types = 1);

namespace Kily\API\Evotor;

use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    /** @var Exception */
    private $exception;

    protected function setUp(): void
    {
        $this->exception = new Exception();
    }

    public function testMissing()
    {
        $this->assertTrue($this->exception instanceof \Kily\API\Evotor\Exception);
    }
}
