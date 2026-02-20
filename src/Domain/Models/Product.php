<?php

namespace WiQ\Domain\Models;

class Product
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
