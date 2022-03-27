<?php

declare(strict_types=1);

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

    protected function setUp(): void
    {
        if (!isset($_SERVER['API_KEY'])) {
            $this->markTestSkipped(
                'You should define API_KEY in phpunit.xml to pass this test'
            );
        }

        if (!isset($_SERVER['APP_KEY'])) {
            $this->markTestSkipped(
                'You should define APP_KEY in phpunit.xml to pass this test'
            );
        }

        $this->api_key = $_SERVER['API_KEY'];
        $this->app_key = $_SERVER['APP_KEY'];
        $this->options = isset($_SERVER['DEBUG']) && $_SERVER['DEBUG'] ? ['debug'=>true] : [];
        $this->client = new Client(
            $this->api_key,
            $this->app_key,
            $this->options
        );
    }

    public function testGet()
    {
        $this->assertTrue(is_array($stores = $this->client->stores()->get()->toArray()));
        $this->assertTrue(is_array($devices = $this->client->devices()->get()->toArray()));
        $this->assertTrue(is_array($this->client->employees()->get()->toArray()));
        $this->assertTrue(is_array($this->client->bulks()->get()->toArray()));

        if (isset($stores[0])) {
            $store_id = $stores[0]['id'];
            $this->assertTrue(is_array($this->client->stores($store_id)->documents()->limit(1)->get()->toArray()));
            $this->assertTrue(is_array($this->client->stores($store_id)->products()->limit(1)->get()->toArray()));
            $this->assertTrue(is_array($this->client->stores($store_id)->groups()->limit(1)->get()->toArray()));

            if (isset($devices[0])) {
                $device_id = $devices[0]['id'];
                $this->assertTrue(is_array($this->client->stores($store_id)->device($device_id)->documents()->limit(1)->get()->toArray()));
            } else {
                $this->markTestSkipped(
                    'There is no device, so we cant check other operations'
                );
            }
        } else {
            $this->markTestSkipped(
                'There is no store, so we cant check other operations'
            );
        }
    }

    public function testCreateUpdateDelete()
    {
        if (!isset($_SERVER['ALLOW_UNSAFE_OPERATIONS']) || !$_SERVER['ALLOW_UNSAFE_OPERATIONS']) {
            $this->markTestSkipped(
                'You should set ALLOW_UNSAFE_OPERATIONS in phpunit.xml to true to pass the test'
            );
        }

        $stores = $this->client->stores()->get()->toArray();
        $devices = $this->client->devices()->get()->toArray();

        if (isset($stores[0])) {
            $store_id = $stores[0]['id'];

            // PRODUCTS
            $data = $this->client->stores($store_id)->products()->create([
                'type' => 'NORMAL',
                'name' => 'JACKET',
                'code' => '100500',
                'price' => 100,
                'cost_price' => 50,
                'quantity'=>1,
                'measure_name' => 'шт',
                'tax' => 'NO_VAT',
                'allow_to_sell' => true,
                'description' => 'JACKET',
                'article_number' => '3773-9001-046',
                'barcodes' =>
                [
                    0 => '3773-9001-046',
                ],
            ]);
            $this->assertTrue(is_array($data->toArray()));
            $this->assertTrue(isset($data->toArray()['id']));
            $this->assertTrue($data->toArray()['name'] === 'JACKET');

            $product_id = $data->toArray()['id'];

            $data = $this->client->stores($store_id)->products()->update($product_id, [
                'type' => 'NORMAL',
                'name' => 'JACKET2',
                'code' => '100500',
                'price' => 100,
                'cost_price' => 50,
                'quantity'=>2,
                'measure_name' => 'шт',
                'tax' => 'NO_VAT',
                'allow_to_sell' => true,
                'description' => 'JACKET',
                'article_number' => '3773-9001-046',
                'barcodes' =>
                [
                    0 => '3773-9001-046',
                ],
            ]);
            $this->assertTrue(is_array($data->toArray()));
            $this->assertTrue(isset($data->toArray()['id']));
            $this->assertTrue($data->toArray()['name'] === 'JACKET2');
            $this->assertTrue($data->toArray()['quantity'] === 2);

            $data = $this->client->stores($store_id)->products()->fetchUpdate($product_id, [
                'quantity'=>3
            ]);
            $this->assertTrue(is_array($data->toArray()));
            $this->assertTrue(isset($data->toArray()['id']));
            $this->assertTrue($data->toArray()['name'] === 'JACKET2');
            $this->assertTrue($data->toArray()['quantity'] === 3);

            $data = $this->client->stores($store_id)->products()->delete($product_id);
            $this->assertTrue(strlen($data->__toString()) === 0);
            $this->assertTrue(!count($this->client->stores($store_id)->products($product_id)->get()->toArray()));


            // GROUPS
            $data = $this->client->stores($store_id)->groups()->create([
                'name' => 'TESTGROUP',
            ]);
            $this->assertTrue(is_array($data->toArray()));
            $this->assertTrue(isset($data->toArray()['id']));
            $this->assertTrue($data->toArray()['name'] === 'TESTGROUP');

            $group_id = $data->toArray()['id'];

            $data = $this->client->stores($store_id)->groups()->update($group_id, [
                'name' => 'TESTGROUP2',
            ]);
            $this->assertTrue(is_array($data->toArray()));
            $this->assertTrue(isset($data->toArray()['id']));
            $this->assertTrue($data->toArray()['name'] === 'TESTGROUP2');

            $data = $this->client->stores($store_id)->groups()->delete($group_id);
            $this->assertTrue(strlen($data->__toString()) === 0);
            $this->assertTrue(!count($this->client->stores($store_id)->groups($group_id)->get()->toArray()));
        } else {
            $this->markTestSkipped(
                'There is no store, so we cant check other operations'
            );
        }
    }

    public function testBULKCreateUpdateDelete()
    {
        if (!isset($_SERVER['ALLOW_UNSAFE_OPERATIONS']) || !$_SERVER['ALLOW_UNSAFE_OPERATIONS']) {
            $this->markTestSkipped(
                'You should set ALLOW_UNSAFE_OPERATIONS in phpunit.xml to true to pass the test'
            );
        }

        $stores = $this->client->stores()->get()->toArray();
        $devices = $this->client->devices()->get()->toArray();

        if (isset($stores[0])) {
            $store_id = $stores[0]['id'];

            $this->markTestIncomplete(
                'We need complex logic here, because of async nature of bulk request... so trust me bulk requests works fine! No, really! Bulk requests SHOULD work fine... :-)'
            );
        } else {
            $this->markTestSkipped(
                'There is no store, so we cant check other operations'
            );
        }
    }

    public function test_request()
    {
        $resp = $this->client->_request('get', '_nonexistent_', []);
        $this->assertEquals('Not Found', $this->client->getHttpErrorMessage());
        $this->assertEquals(404, $this->client->getHttpErrorCode());
    }

    public function testGetClient()
    {
        $this->assertTrue($this->client->getClient() instanceof \GuzzleHttp\Client);
    }

    public function test__call()
    {
        $this->assertTrue($this->client->stores() instanceof Operation);
        $this->expectException(Exception::class);
        $this->client->nonexistent();
    }

    public function testIsOk()
    {
        $resp = $this->client->stores()->get();
        $this->assertTrue($this->client->isOk());
        $resp = $this->client->stores('_NONEXISTENT_')->get();
        $this->assertTrue(!$this->client->isOk());
    }
}
