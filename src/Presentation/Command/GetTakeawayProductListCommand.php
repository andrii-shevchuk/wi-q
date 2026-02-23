<?php

$container = require __DIR__ . '/../../../bootstrap.php';

use WiQ\Application\UseCase\GetTakeawayProductList\Exception\MenuNotFoundException;
use WiQ\Application\UseCase\GetTakeawayProductList\GetTakeawayProductList;
use WiQ\Presentation\TakeawayProductListPresenter;

try {
    $useCase = new GetTakeawayProductList($container['menuRepository'], $container['productRepository']);
    $takeawayProducts = $useCase->execute();

    $presenter = new TakeawayProductListPresenter();
    $presenter->render($takeawayProducts);

    exit(0);
} catch (MenuNotFoundException $e) {
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (\Throwable $e) {
    error_log($e->getMessage() . "\n" . $e->getTraceAsString());
    fwrite(STDERR, "Unexpected error: " . $e->getMessage() . PHP_EOL);
    exit(99);
}
