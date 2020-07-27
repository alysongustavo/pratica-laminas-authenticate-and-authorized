<?php


namespace Admin\Service\Factory;


use Admin\Entity\Privilege;
use Admin\Entity\Resource;
use Admin\Entity\Role;
use Admin\Service\AclService;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class AclServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /**
         * @var EntityManager
         */
        $entityManager = $container->get(EntityManager::class);

        $roles = $entityManager->getRepository(Role::class)->findAll();
        $resources = $entityManager->getRepository(Resource::class)->findAll();
        $privileges = $entityManager->getRepository(Privilege::class)->findAll();

        return new AclService($roles, $resources, $privileges);
    }
}