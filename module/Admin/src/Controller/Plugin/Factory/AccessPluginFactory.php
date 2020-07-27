<?php


namespace Admin\Controller\Plugin\Factory;


use Admin\Controller\Plugin\AccessPlugin;
use Admin\Service\AclService;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;

class AccessPluginFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $aclService = $container->get(AclService::class);
        return new AccessPlugin($aclService);
    }
}