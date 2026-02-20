<?php

namespace WiQ\Application\UseCase\GetTakeawayProductList;

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

        return $this->productRepository->findByMenuId($takeawayMenu->id);
    }
}
