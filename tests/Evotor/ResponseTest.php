<?php declare(strict_types = 1);

namespace Kily\API\Evotor;

use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /** @var Response */
    private $response;

    /** @var Kily\API\Evotor\Client | PHPUnit_Framework_MockObject_MockObject */
    private $clnt;

    /** @var Psr\Http\Message\ResponseInterface | PHPUnit_Framework_MockObject_MockObject */
    private $resp;

    /** @var mixed */
    private $filter;

    protected function setUp(): void
    {
        $streamStub = $this->createMock(\Psr\Http\Message\StreamInterface::class);
        $streamStub->expects($this->any())
            ->method('__toString')
            ->will($this->returnValue('{"items":[{"id":"123"},{"id":"321"}]}'));

        $stub = $this->createMock(\Psr\Http\Message\ResponseInterface::class);
        $stub->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue($streamStub));

        $this->clnt = $this->createMock(\Kily\API\Evotor\Client::class);
        $this->resp = $stub;

        $this->filter = null;
        $this->response = new Response(
            $this->clnt,
            $this->resp,
            $this->filter
        );
    }

    public function test__toString() {
        $this->assertTrue(is_string($this->response->__toString()));
    }

    public function testToArray() {
        $this->assertTrue(is_array(json_decode($this->response->__toString(),true)));
        $this->assertTrue($this->response->toArray() === json_decode($this->response->__toString(),true)['items']);
    }

    public function testFirst() {
        $this->assertTrue(($this->response->first()) == ['id'=>'123']);
    }

}
