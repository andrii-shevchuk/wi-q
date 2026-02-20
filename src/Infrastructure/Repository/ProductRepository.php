<?php

namespace WiQ\Infrastructure\Repository;

use WiQ\Domain\Models\Product;
use WiQ\Domain\Repository\ProductRepositoryInterface;
use WiQ\Infrastructure\Client\ApiGreatFoodClient;
use WiQ\Infrastructure\Client\Exception\ApiException;

readonly class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private ApiGreatFoodClient $client
    ) {
    }

    /**
     * @inheritDoc
     */
    public function findByMenuId(int $menuId): array
    {
        $productModels = [];

        $menuProducts = $this->client->getMenuProducts($menuId);

        foreach ($menuProducts[0] as $menuProduct) {
            $productModels[] = new Product($menuProduct['id'], $menuProduct['name']);
        }

        return $productModels;
    }

    /**
     * @inheritDoc
     */
    public function update(int $menuId, int $productId, Product $product): Product
    {
        $product = $this->client->updateProduct($menuId, $productId, [
            'name' => $product->name
        ]);

        return new Product($productId, $product['data']['name']);
    }
}
