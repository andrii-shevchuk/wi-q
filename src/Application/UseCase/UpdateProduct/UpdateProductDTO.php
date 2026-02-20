<?php

namespace WiQ\Application\UseCase\UpdateProduct;

readonly class UpdateProductDTO
{
    public function __construct(
        public string $name,
    ) {

    }
}
