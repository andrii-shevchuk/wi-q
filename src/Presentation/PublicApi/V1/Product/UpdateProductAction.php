<?php

namespace WiQ\Presentation\PublicApi\V1\Product;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use WiQ\Application\UseCase\UpdateProduct\UpdateProduct;
use WiQ\Presentation\PublicApi\V1\Model\ProductResponseModel;
use WiQ\Presentation\PublicApi\V1\Model\UpdateProductRequestModel;

class UpdateProductAction
{
    public function __invoke(int $menuId, int $productId, Request $request): JsonResponse
    {
        try {
            $container = require __DIR__ . '/../../../../../bootstrap.php';

            /** @var UpdateProduct $useCase */
            $useCase = $container->get(UpdateProduct::class);

            /** @var SerializerInterface $serializer */
            $serializer = $container->get(SerializerInterface::class);

            $json = $request->getContent();

            /** @var UpdateProductRequestModel $updateRequest */
            $updateRequest = $serializer->deserialize(
                $json,
                UpdateProductRequestModel::class,
                'json'
            );

            $product = $useCase->execute(
                $menuId,
                $productId,
                $updateRequest->name
            );

            return new JsonResponse(['data' => ProductResponseModel::fromModels($product)]);
        } catch (\Throwable) {
            return new JsonResponse(['error' => 'Unexpected error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
