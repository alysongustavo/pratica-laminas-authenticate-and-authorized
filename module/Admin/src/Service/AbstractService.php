<?php


namespace Admin\Service;


use Admin\Service\Exception\ServiceException;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Laminas\Hydrator\ClassMethods;

class AbstractService implements ServiceInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    protected $entity;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    function find($id)
    {
        $entityRepository = $this->entityManager->getRepository($this->entity);

        try{
            $entityFind = $entityRepository->find($id);
            return $entityFind;
        }catch (EntityNotFoundException $exception){
            throw new ServiceException($exception->getMessage());
        }
    }

    function findAll()
    {
        return $this->entityManager->getRepository($this->entity)->findAll();
    }

    function save($entityParam)
    {
        try{
            $this->entityManager->persist($entityParam);
            $this->entityManager->flush();
        }catch (\Exception $exception){
            var_dump($exception);exit;
        }


    }

    function update($entityParam, $id)
    {
        $ent = $this->entityManager->getRepository($this->entity)->find($id);

        $entityArray = $entityParam->exchangeArray();

        $classMethod = new ClassMethods();
        $classMethod->hydrate($entityArray, $ent);
        $this->entityManager->flush();
    }

    function destroy($id)
    {
        $ent = $this->entityManager->getRepository($this->entity)->find($id);

        if($ent === null){
            throw new ServiceException("Registro não encontrado");
        }

        try{
            $this->entityManager->remove($ent);
            $this->entityManager->flush();
        }catch (ConstraintViolationException $exception){
            throw new ServiceException('O registro informado tem dependencia de exclusão');
        }


    }

    /**
     * Checks whether an active user with given email address already exists in the database.
     */
    protected function checkEntityExist($name) {

        $entityCheck = $this->entityManager->getRepository($this->entity)->findOneByName($name);

        return $entityCheck !== null;
    }
}