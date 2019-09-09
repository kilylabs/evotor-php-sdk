<?php declare(strict_types = 1);

namespace Kily\API\Evotor;

use Kily\API\Evotor\Operations\Operation;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /** @var Client */
    private $client;

    /** @var mixed */
    private $api_key;

    /** @var mixed */
    private $app_key;

    /** @var array */
    private $options;

    protected function setUp()
    {
        if(!isset($_SERVER['API_KEY'])) {
            $this->markTestSkipped(
                'You should define API_KEY in phpunit.xml to pass this test'
            );
        }

        if(!isset($_SERVER['APP_KEY'])) {
            $this->markTestSkipped(
                'You should define APP_KEY in phpunit.xml to pass this test'
            );
        }

        $this->api_key = $_SERVER['API_KEY'];
        $this->app_key = $_SERVER['APP_KEY'];
        $this->options = [];
        $this->client = new Client(
            $this->api_key,
            $this->app_key,
            $this->options
        );
    }

    public function test_request() {
        $resp = $this->client->_request('get','_nonexistent_',[]);
        $this->assertTrue($this->client->getHttpErrorMessage() === 'Not Found');
        $this->assertTrue($this->client->getHttpErrorCode() === 404);
    }

    public function testGetClient() {
        $this->assertTrue($this->client->getClient() instanceof \GuzzleHttp\Client);
    }

    public function test__call() {
        $this->assertTrue($this->client->stores() instanceof Operation);
        $this->expectException(Exception::class);
        $this->client->nonexistent();
    }

    public function testIsOk() {
        $resp = $this->client->stores()->get();
        $this->assertTrue($this->client->isOk());
        $resp = $this->client->stores('_NONEXISTENT_')->get();
        $this->assertTrue(!$this->client->isOk());
    }

}
