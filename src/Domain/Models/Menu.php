<?php

namespace WiQ\Domain\Models;

class Menu
{
    public function __construct(
        public int $id,
        public string $name
    ) {
    }
}
