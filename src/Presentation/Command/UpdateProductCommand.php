<?php

$container = require __DIR__ . '/../../../bootstrap.php';

use WiQ\Application\UseCase\UpdateProduct\UpdateProduct;
use WiQ\Presentation\UpdateProductPresenter;

try {
    $useCase = new UpdateProduct($container['productRepository']);
    $product = $useCase->execute();

    $presenter = new UpdateProductPresenter();
    $presenter->render($product);

    exit(0);
} catch (\Throwable $e) {
    error_log($e->getMessage() . "\n" . $e->getTraceAsString());
    fwrite(STDERR, "Unexpected error: " . $e->getMessage() . PHP_EOL);
    exit(99);
}
