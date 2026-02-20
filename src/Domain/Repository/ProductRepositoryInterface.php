<?php

namespace WiQ\Domain\Repository;

use WiQ\Domain\Models\Menu;
use WiQ\Domain\Models\Product;
use WiQ\Infrastructure\Client\Exception\ApiException;

interface ProductRepositoryInterface
{
    /**
     * @return Menu[]
     *
     * @throws ApiException
     */
    public function findByMenuId(int $menuId): array;

    /**
     * @throws ApiException
     */
    public function update(int $menuId, int $productId, Product $product): Product;
}
