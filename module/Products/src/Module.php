<?php

namespace Products;

use Products\Service\ProductService;
use Products\Service\AlbumService;
use Products\Service\BookService;
use Products\Service\ThrillerService;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Service\ProductService::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $sql = new Sql($dbAdapter);
                    return new ProductService($sql);
                },
                Service\AlbumService::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $sql = new Sql($dbAdapter);
                    return new AlbumService($sql);
                },
                Service\BookService::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $sql = new Sql($dbAdapter);
                    return new BookService($sql);
                },
                Service\ThrillerService::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $sql = new Sql($dbAdapter);
                    return new ThrillerService($sql);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\AlbumController::class => function ($container) {
                    return new Controller\AlbumController(
                        $container->get(Service\AlbumService::class)
                    );
                },
                Controller\BookController::class => function ($container) {
                    return new Controller\BookController(
                        $container->get(Service\BookService::class)
                    );
                },
                Controller\ProductsController::class => function ($container) {
                    return new Controller\ProductsController(
                        $container->get(Service\ProductService::class)
                    );
                },
                Controller\ThrillerController::class => function ($container) {
                    return new Controller\ThrillerController(
                        $container->get(Service\ThrillerService::class)
                    );
                },
            ],
        ];
    }
}
