# evotor-php-sdk

Удобный REST API v2 клиент для облака Evotor. Позволяет манипулировать данными как из облака, так и из терминалов ЭВОТОР. Имеет удобный fluent-интерфейс и тесты :-)

ВНИМАНИЕ! Данный клиент является неофициальным, поддержка не гарантируется!

Установка
------------

Рекомендуемый способ установки через
[Composer](http://getcomposer.org):

```
$ composer require kilylabs/evotor-php-sdk
```

Использование
-----

1) Для начала, получите API токен ([вот здесь](https://developer.evotor.ru/docs/doc_authorization.html))
2) (не обязательно) Получите идентификатор вашего приложения (нужен только для PUSH-уведомлений)
3) Проставьте необходимые права в разделе Интеграция портала для разработчика Эвотор (https://dev.evotor.ru)


#### Инициализация
```php
<?php

require 'vendor/autoload.php';

$client = new Kily\API\Evotor\Client('<API_KEY>','<APP_KEY>',[
    'debug'=>true, // Только для тестирования
]);

```

#### Магазины (https://developer.evotor.ru/docs/rest_stores.html);
```php
// Получить все магазины
$stores = $client->stores()->get()->toArray();
var_dump($stores);

// Получить все магазины и выбрать первый из них
$store = $client->stores()->get()->first();
var_dump($store);

$store_id = $store['id'];

// Получить магазина по id
$store = $client->stores()->get($store_id)->toArray();
var_dump($store);

// То же самое
$store = $client->stores($store_id)->get()->toArray();
var_dump($store);

```

#### Терминалы (https://developer.evotor.ru/docs/rest_smart_terminals.html)
```php
// Получить все терминалы
$devices = $client->devices()->get()->toArray();
var_dump($devices);

// Получить все магазины и выбрать первый из них
$device = $client->devices()->get()->first();
var_dump($device);
```

#### Сотрудники (https://developer.evotor.ru/docs/rest_employees.html)
```php
// Получить всех сотрудников
$employees = $client->employees()->get()->toArray();
var_dump($employees);

// Получить всех сотрудников и выбрать первого из них
$employee = $client->employees()->get()->first();
var_dump($employee);
```

#### Документы (https://developer.evotor.ru/docs/rest_documents.html)
```php
// Получить все документы
$documents = $client->stores($store_id)->documents()->get()->toArray();
var_dump($documents);

// Получить 5 первых документов
$documents = $client->stores($store_id)->documents()->limit(5)->get()->toArray();
var_dump($documents);

// Получить все документы и выбрать первый из них
$document = $client->stores($store_id)->documents()->get()->first();
var_dump($document);

$document_id = $document['id'];

// Получить документ по id
$document = $client->stores($store_id)->documents($document_id)->get()->toArray();
var_dump($document);
```

#### Продукция (https://developer.evotor.ru/docs/rest_products.html)
```php
// Получить все товары
$products = $client->stores($store_id)->products()->get()->toArray();
var_dump($products);

// Получить 5 первых товаров
$products = $client->stores($store_id)->products()->limit(5)->get()->toArray();
var_dump($products);

// Получить все товары и выбрать первый из них
$product = $client->stores($store_id)->products()->get()->first();
var_dump($product);

$product_id = $product['id'];

// Получить товар по id
$product = $client->stores($store_id)->products($product_id)->get()->toArray();
var_dump($product);

// Создать товар
$data = $client->stores($store_id)->products()->create([
    'type' => 'NORMAL',
    'name' => 'JACKET1',
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
    array ( 
        0 => '3773-9001-046',
    ),
]);
if($client->isOk()) {
    $product = $data->toArray();
    var_dump($product);
    
    $product_id = $product['id'];
}

// Обновить товар
$data = $client->stores($store_id)->products()->update($product_id,[
    'type' => 'NORMAL',
    'name' => 'JACKET1',
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
    array ( 
        0 => '3773-9001-046',
    ),
]);
if($client->isOk()) {
    $product = $data->toArray();
    var_dump($product);
    
    $product_id = $product['id'];
}

// Обновить товар (пакетный запрос)
// Несмотря на то, что это НЕ ОПИСАНО в документации, опытным путем
// удалось выяснить, что для пакетного обновления нужно вставлять id
// в тело запроса
$data = $client->stores($store_id)->products()->bulk()->update([
    [
        'id' => '52f811b4-3940-4206-83c3-673badf5468c',
	    'type' => 'NORMAL',
	    'name' => 'JACKET1',
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
	    array ( 
	        0 => '3773-9001-046',
	    ),
    ],
    [
        'id' => '53f811b4-3940-4206-83c3-673badf5468c',
	    'type' => 'NORMAL',
	    'name' => 'JACKET2',
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
	    array ( 
	        0 => '3773-9001-046',
	    ),
    ],
])->toArray();
if($client->isOk()) {
    if($data['status'] == 'ACCEPTED') {
        $bulk_id = $data['id'];
        $bulk_data = $client->bulks()->get($bulk_id)->toArray();
        if($bulk_data['status'] == 'COMPLETED') {
            // обработка результата...
        }
    }
}

// Обновить товар (более короткая версия)
// Из-за ограничения REST API v2, чтобы одновить товар, вам нужно подставлять все данные
// при обновлении товара. Данный метод решает эту проблему ценой дополнительного запроса get()
$data = $client->stores($store_id)->products()->fetchUpdate($product_id,[
    'name' => 'JACKET100500',
]);
if($client->isOk()) {
    $product = $data->toArray();
    var_dump($product);
    
    $product_id = $product['id'];
}

// Удалить товар
$data = $client->stores($store_id)->products()->delete($product_id);

// Удалить товар (пакетный запрос):
$data = $client->stores($store_id)->products()->bulk()->delete([$product_id1,$product_id2,$product_id3])->toArray();
if($data['status'] == 'ACCEPTED') {
    $bulk_id = $data['id'];
    $bulk_data = $client->bulks()->get($bulk_id)->toArray();
    if($bulk_data['status'] == 'COMPLETED') {
        // обработка результата...
    }
}
```

#### Группы продукции (https://developer.evotor.ru/docs/rest_products_groups.html);
```php
// Получить все группы товаров
$groups = $client->stores($store_id)->groups()->get()->toArray();
var_dump($groups);

// Получить 5 первых групп товаров
$groups = $client->stores($store_id)->groups()->limit(5)->get()->toArray();
var_dump($groups);

// Получить все группы товаров и выбрать первый из них
$group = $client->stores($store_id)->groups()->get()->first();
var_dump($group);

$group_id = $group['id'];

// Получить группу товара по id
$group = $client->stores($store_id)->groups($group_id)->get()->toArray();
var_dump($group);

// Создать группу товара
$data = $client->stores($store_id)->groups()->create([
    'name' => 'TEST TEST TEST',
]);
if($client->isOk()) {
    $group = $data->toArray();
    var_dump($group);
    
    $group_id = $group['id'];
}

// Обновить группу товара
$data = $client->stores($store_id)->groups()->update($group_id,[
    'name' => 'TEST TEST TEST 2',
]);
if($client->isOk()) {
    $group = $data->toArray();
    var_dump($group);
    
    $group_id = $group['id'];
}

// Обновить группу товара (пакетный запрос)
// Несмотря на то, что это НЕ ОПИСАНО в документации, опытным путем
// удалось выяснить, что для пакетного обновления нужно вставлять id
// в тело запроса
$data = $client->stores($store_id)->groups()->bulk()->update([
    [
        'id' => '52f811b4-3940-4206-83c3-673badf5468c',
	    'name' => 'TEST321',
    ],
    [
        'id' => '53f811b4-3940-4206-83c3-673badf5468c',
	    'name' => 'TEST123',
    ],
]);
if($client->isOk()) {
    if($data['status'] == 'ACCEPTED') {
        $bulk_id = $data['id'];
        $bulk_data = $client->bulks()->get($bulk_id)->toArray();
        if($bulk_data['status'] == 'COMPLETED') {
            // обработка результата...
        }
    }
}

// Удалить группу товара
$data = $client->stores($store_id)->groups()->delete($group_id);

// Удалить группу товара (пакетный запрос):
$data = $client->stores($store_id)->groups()->bulk()->delete([$group_id1,$group_id2,$group_id3])->toArray();
if($data['status'] == 'ACCEPTED') {
    $bulk_id = $data['id'];
    $bulk_data = $client->bulks()->get($bulk_id)->toArray();
    if($bulk_data['status'] == 'COMPLETED') {
        // обработка результата...
    }
}
```

#### Пакетные запросы (https://developer.evotor.ru/docs/rest_bulk_tasks.html)
```php
// Получить все пакетные задачи
$bulks = $client->bulks()->get()->toArray();
var_dump($bulks);

// Получить все пакетные задачи и выбрать первый из них
$bulk = $client->bulks()->get()->first();
var_dump($bulk);

$bulk_id = $bulk['id'];

// Получить пакетную задачу по id
$bulk = $client->bulks()->get($bulk_id)->get()->toArray();
var_dump($bulk);


```

TODO
-----
- доделать PUSH-уведомления
- документация
- валидация методов
- пагинация
