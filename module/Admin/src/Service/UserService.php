<?php


namespace Admin\Service;


use Admin\Entity\User;
use Admin\Service\Exception\ServiceException;

class UserService extends AbstractService
{
    protected $entity = User::class;

}