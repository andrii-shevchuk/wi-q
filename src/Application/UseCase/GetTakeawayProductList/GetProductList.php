<?php

namespace WiQ\Application\UseCase\GetTakeawayProductList;

use WiQ\Application\UseCase\GetTakeawayProductList\Exception\MenuNotFoundException;
use WiQ\Domain\Models\Menu;
use WiQ\Domain\Models\Product;
use WiQ\Domain\Repository\MenuRepositoryInterface;
use WiQ\Domain\Repository\ProductRepositoryInterface;
use WiQ\Infrastructure\Client\Exception\ApiException;

readonly class GetProductList
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
    public function execute(string $menuName): array
    {
        $needMenu = null;

        $menus = $this->menuRepository->findAll();

        foreach ($menus as $menu) {
            if (mb_strtolower($menu->name) === mb_strtolower($menuName)) {
                $needMenu = $menu;

                break;
            }
        }

        if (!$needMenu instanceof Menu) {
            throw new MenuNotFoundException(sprintf('Menu "%s" isn\'t found', $menuName));
        }

        return $this->productRepository->findByMenuId($needMenu->id);
    }
}
