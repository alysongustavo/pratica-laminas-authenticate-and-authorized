<?php


namespace Admin\Controller;


use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class AuthController extends AbstractActionController
{

    public function loginAction(){
        return new ViewModel();
    }

    public function logoutAction(){
        return new ViewModel();
    }

}