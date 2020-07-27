<?php


namespace Admin\Controller\Factory;


use Admin\Controller\PrivilegeController;
use Admin\Form\PrivilegeForm;
use Admin\Service\PrivilegeService;
use Admin\Service\ResourceService;
use Admin\Service\RoleService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class PrivilegeControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $privilegeService = $container->get(PrivilegeService::class);
        $privilegeForm = $container->get(PrivilegeForm::class);

        $roleService = $container->get(RoleService::class);
        $resourceService = $container->get(ResourceService::class);

        return new PrivilegeController($privilegeService, $privilegeForm, $roleService, $resourceService);
    }
}