<?php

namespace WiQ\Domain\Repository;

use WiQ\Domain\Models\Menu;
use WiQ\Infrastructure\Client\Exception\ApiException;

interface MenuRepositoryInterface
{
    /**
     * @return Menu[]
     * @throws ApiException
     */
    public function findAll(): array;
}
