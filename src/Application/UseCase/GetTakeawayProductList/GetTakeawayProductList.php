<?php

namespace WiQ\Application\UseCase\GetTakeawayProductList;

use WiQ\Application\UseCase\GetTakeawayProductList\Exception\MenuNotFoundException;
use WiQ\Domain\Models\Menu;
use WiQ\Domain\Models\Product;
use WiQ\Domain\Repository\MenuRepositoryInterface;
use WiQ\Domain\Repository\ProductRepositoryInterface;
use WiQ\Infrastructure\Client\Exception\ApiException;

readonly class GetTakeawayProductList
{
    public function __construct(
        private MenuRepositoryInterface $menuRepository,
        private ProductRepositoryInterface $productRepository,
    ) {
    }

    /**
     * @return Product[]
     *
     * @throws ApiException
     * @throws MenuNotFoundException
     */
    public function execute(): array
    {
        $takeawayMenu = null;

        $menus = $this->menuRepository->findAll();

        foreach ($menus as $menu) {
            if ($menu->name === 'Takeaway') {
                $takeawayMenu = $menu;

                break;
            }
        }

        if (!$takeawayMenu instanceof Menu) {
            throw new MenuNotFoundException('Menu "Takeaway" isn\'t found');
        }

        return $this->productRepository->findByMenuId($takeawayMenu->id);
    }
}
