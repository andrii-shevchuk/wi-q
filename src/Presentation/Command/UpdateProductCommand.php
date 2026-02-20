<?php

$container = require __DIR__ . '/../../../bootstrap.php';

use WiQ\Application\UseCase\UpdateProduct\UpdateProduct;
use WiQ\Presentation\UpdateProductPresenter;

$useCase = new UpdateProduct($container['productRepository']);
$product = $useCase->execute();

$presenter = new UpdateProductPresenter();
$presenter->render($product);
