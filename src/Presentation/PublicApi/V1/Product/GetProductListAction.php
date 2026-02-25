<?php

namespace WiQ\Presentation\PublicApi\V1\Product;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use WiQ\Application\UseCase\GetProductList\Exception\MenuNotFoundException;
use WiQ\Application\UseCase\GetProductList\GetProductList;
use WiQ\Presentation\PublicApi\V1\Model\ProductResponseModel;

class GetProductListAction
{
    public function __invoke(string $menuName): JsonResponse
    {
        try {
            $container = require __DIR__ . '/../../../../../bootstrap.php';

            /** @var GetProductList $useCase */
            $useCase = $container->get(GetProductList::class);

            $takeawayProducts = $useCase->execute($menuName);

            return new JsonResponse(['data' => ProductResponseModel::fromModels(...$takeawayProducts)]);

        } catch (MenuNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Throwable) {
            return new JsonResponse(['error' => 'Unexpected error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
