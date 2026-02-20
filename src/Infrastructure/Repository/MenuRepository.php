<?php

namespace WiQ\Infrastructure\Repository;

use WiQ\Domain\Models\Menu;
use WiQ\Domain\Repository\MenuRepositoryInterface;
use WiQ\Infrastructure\Client\ApiGreatFoodClient;

readonly class MenuRepository implements MenuRepositoryInterface
{
    public function __construct(
        private ApiGreatFoodClient $client
    ) {
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $menuModels = [];

        $menus = $this->client->getMenus();

        foreach ($menus['data'] as $menu) {
            $menuModels[] = new Menu($menu['id'], $menu['name']);
        }

        return $menuModels;
    }
}
