<?php


namespace Admin\ViewHelper\Factory;


use Admin\Service\AclService;
use Admin\ViewHelper\Access;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;

class AccessFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $aclService = $container->get(AclService::class);
        return new Access($aclService);
    }
}