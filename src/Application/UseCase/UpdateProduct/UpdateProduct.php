<?php

namespace WiQ\Application\UseCase\UpdateProduct;

use WiQ\Domain\Models\Product;
use WiQ\Domain\Repository\ProductRepositoryInterface;
use WiQ\Infrastructure\Client\Exception\ApiException;

readonly class UpdateProduct
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(): Product
    {
        $needMenuId = 7;
        $needProductId = 84;

        $product = new Product($needMenuId, 'Chips');

        return $this->productRepository->update($needMenuId, $needProductId, $product);
    }
}
