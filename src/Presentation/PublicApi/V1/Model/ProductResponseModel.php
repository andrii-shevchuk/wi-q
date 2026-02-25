<?php

namespace WiQ\Presentation\PublicApi\V1\Model;

use WiQ\Domain\Models\Product;

class ProductResponseModel
{
    public function __construct(
        public string $id,
        public string $name,
    ) {

    }

    /**
     * @param Product[] $products
     * @return ProductResponseModel[]
     */
    public static function fromModels(...$products): array
    {
        $models = [];
        foreach ($products as $product) {
            $models[] = new self(
                $product->id,
                $product->name
            );
        }

        return $models;
    }
}
