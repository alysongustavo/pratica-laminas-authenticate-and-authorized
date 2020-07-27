<?php


namespace Admin\Controller\Factory;


use Admin\Controller\UserController;
use Admin\Form\UserForm;
use Admin\Service\RoleService;
use Admin\Service\UserService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class UserControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userService = $container->get(UserService::class);
        $roleService = $container->get(RoleService::class);
        $userForm = $container->get(UserForm::class);
        return new UserController($userService, $userForm, $roleService);
    }
}