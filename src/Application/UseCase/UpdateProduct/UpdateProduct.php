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
    public function execute(int $menuId, int $productId, string $name): Product
    {
        $product = new Product($menuId, $name);

        return $this->productRepository->update($menuId, $productId, $product);
    }
}
