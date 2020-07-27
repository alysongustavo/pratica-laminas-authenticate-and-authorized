<?php


namespace Admin\Controller\Factory;


use Admin\Controller\RoleController;
use Admin\Form\RoleForm;
use Admin\Service\RoleService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class RoleControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userService = $container->get(RoleService::class);
        $roleForm = $container->get(RoleForm::class);
        return new RoleController($userService, $roleForm);
    }
}