<?php


namespace Admin\Controller;


use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function dashboardAction(){
        return new ViewModel();
    }

}