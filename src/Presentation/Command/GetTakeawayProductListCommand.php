<?php

$container = require __DIR__ . '/../../../bootstrap.php';

use WiQ\Application\UseCase\GetTakeawayProductList\GetTakeawayProductList;
use WiQ\Presentation\TakeawayProductListPresenter;

$useCase = new GetTakeawayProductList($container['menuRepository'], $container['productRepository']);
$takeawayProducts = $useCase->execute();

$presenter = new TakeawayProductListPresenter();
$presenter->render($takeawayProducts);
