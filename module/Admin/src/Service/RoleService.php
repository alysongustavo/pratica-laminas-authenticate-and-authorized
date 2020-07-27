<?php


namespace Admin\Service;


use Admin\Entity\Role;
use Admin\Service\Exception\ServiceException;
use Doctrine\DBAL\Exception\ConstraintViolationException;

class RoleService extends AbstractService
{

    protected $entity = Role::class;

    function destroy($id)
    {

        $roleRepository = $this->entityManager->getRepository($this->entity);

        $role = $roleRepository->findOneByParent($id);

        if($role != null){
            throw new ServiceException('O role informado tem depedencia de exclusão');
        }

        parent::destroy($id);

    }

}