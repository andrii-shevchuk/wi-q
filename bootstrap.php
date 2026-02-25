<?php

require __DIR__ . '/vendor/autoload.php';

use DI\ContainerBuilder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use WiQ\Application\UseCase\GetProductList\GetProductList;
use WiQ\Domain\Repository\MenuRepositoryInterface;
use WiQ\Domain\Repository\ProductRepositoryInterface;
use WiQ\Infrastructure\Client\ApiGreatFoodClient;
use WiQ\Infrastructure\Repository\MenuRepository;
use WiQ\Infrastructure\Repository\ProductRepository;

$builder = new ContainerBuilder();


$builder->addDefinitions([
    ApiGreatFoodClient::class => DI\create(ApiGreatFoodClient::class),
    ProductRepositoryInterface::class => DI\autowire(ProductRepository::class)
        ->constructorParameter('client', DI\get(ApiGreatFoodClient::class)),
    MenuRepositoryInterface::class => DI\autowire(MenuRepository::class)
        ->constructorParameter('client', DI\get(ApiGreatFoodClient::class)),
    GetProductList::class => DI\autowire(GetProductList::class),
    SerializerInterface::class => function () {
        $normalizers = [new ObjectNormalizer()];
        $encoders = [new JsonEncoder()];
        return new Serializer($normalizers, $encoders);
    },
]);

$container = $builder->build();

return $container;
