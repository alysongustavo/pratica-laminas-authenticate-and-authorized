<?php


namespace Admin\Form\Factory;


use Admin\Entity\Resource;
use Admin\Entity\Role;
use Admin\Form\PrivilegeForm;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class PrivilegeFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $entityManager = $container->get(EntityManager::class);

        $roles = $entityManager->getRepository(Role::class)->findAll();
        $roleArray = [
            0 => 'Selecione o role'
        ];

        foreach($roles as $role){
            $roleArray[$role->getId()] = $role->getName();
        }

        $resources = $entityManager->getRepository(Resource::class)->findAll();
        $resourceArray = [
            0 => 'Selecione o resource'
        ];

        foreach($resources as $resource){
            $resourceArray[$resource->getId()] = $resource->getDescription();
        }

        return new PrivilegeForm($roleArray, $resourceArray);
    }
}