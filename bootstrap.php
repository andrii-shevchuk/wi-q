<?php

require __DIR__ . '/vendor/autoload.php';

use WiQ\Infrastructure\Client\ApiGreatFoodClient;
use WiQ\Infrastructure\Repository\ProductRepository;
use WiQ\Infrastructure\Repository\MenuRepository;

$client = new ApiGreatFoodClient();
$client->getAuthToken();

return [
    'productRepository' => new ProductRepository($client),
    'menuRepository' => new MenuRepository($client),
];
