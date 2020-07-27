<?php


namespace Admin;


use Admin\Listener\AuthenticationListener;
use Admin\Listener\AuthorizationListener;
use Admin\Listener\DefineTemplateListener;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\InitProviderInterface;
use Laminas\ModuleManager\ModuleManagerInterface;
use Laminas\Mvc\MvcEvent;

class Module implements ConfigProviderInterface, InitProviderInterface
{
    public function getConfig(){
        return include __DIR__ . '/../config/module.config.php';
    }

    public function init(ModuleManagerInterface $manager)
    {
        $eventManager = $manager->getEventManager();
        $eventManagerShared = $eventManager->getSharedManager();

        $eventManagerShared->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, [new DefineTemplateListener(),"checkDefineTemplate"], 100);

        $eventManagerShared->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, [new AuthenticationListener(),"checkAuthentication"], 100);

        $eventManagerShared->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, [new AuthorizationListener(),"checkAuthorization"], 100);

    }

}