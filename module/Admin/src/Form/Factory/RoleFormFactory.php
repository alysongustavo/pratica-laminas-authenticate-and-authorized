<?php


namespace Admin\Form\Factory;


use Admin\Entity\Role;
use Admin\Form\RoleForm;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class RoleFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $entityManager = $container->get(EntityManager::class);

        $roles = $entityManager->getRepository(Role::class)->findAll();
        $roleArray = [
            0 => 'Selecione a role pai'
        ];

        foreach($roles as $role){
            $roleArray[$role->getId()] = $role->getName();
        }

        return new RoleForm($roleArray);
    }
}