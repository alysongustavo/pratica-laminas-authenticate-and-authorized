<?php


namespace Admin\Controller\Factory;


use Admin\Controller\ResourceController;
use Admin\Service\ResourceService;
use Admin\Service\RoleService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ResourceControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userService = $container->get(ResourceService::class);
        return new ResourceController($userService);
    }
}