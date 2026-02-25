<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use WiQ\Presentation\PublicApi\V1\Product\GetProductListAction;
use WiQ\Presentation\PublicApi\V1\Product\UpdateProductAction;

$request = Request::createFromGlobals();
$path = $request->getPathInfo();
$method = $request->getMethod();

$container = require __DIR__ . '/../bootstrap.php';

// GET v1/menu/takeaway/products
if (preg_match('#^/v1/menu/([^/]+)/products$#', $path, $matches) && $method === 'GET') {
    $menuName = $matches[1];
    $action = $container->get(GetProductListAction::class);
    $response = $action($menuName);
    $response->send();
    exit;
}

// PUT /v1/menu/{id}/product/{id}
if (preg_match('#^/v1/menu/(\d+)/products/(\d+)$#', $path, $matches) && $method === 'PUT') {
    $menuId = (int)$matches[1];
    $productId = (int)$matches[2];
    $action = $container->get(UpdateProductAction::class);
    $response = $action($menuId, $productId, $request);
    $response->send();
    exit;
}

$response = new JsonResponse(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
$response->send();
exit;
