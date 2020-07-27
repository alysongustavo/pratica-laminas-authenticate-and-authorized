<?php


namespace Admin\Listener;


use Admin\Controller\AuthController;
use Admin\Entity\User;
use Admin\Service\AclService;
use Doctrine\ORM\EntityManager;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Laminas\Mvc\MvcEvent;
use Laminas\Mvc\View\Http\InjectTemplateListener;
use Laminas\View\Helper\Navigation\Listener\AclListener;

class AuthenticationListener extends InjectTemplateListener
{

    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, [$this, 'checkAuthentication'], $priority);
    }

    public function checkAuthentication($event){

        $controller = $event->getTarget();
        $match       = $event->getRouteMatch();
        $authService = $event->getApplication()->getServiceManager()->get(AuthenticationService::class);
        $routeName   = $match->getMatchedRouteName();
        $em          = $event->getApplication()->getServiceManager()->get(EntityManager::class);

        $matchedController = $match->getParam('controller');

        $matchedAction     = $match->getParam('action');

        if(!$authService->hasIdentity()){

        }




    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }
}