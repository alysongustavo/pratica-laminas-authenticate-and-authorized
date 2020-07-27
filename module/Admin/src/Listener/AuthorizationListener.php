<?php


namespace Admin\Listener;


use Admin\Controller\AuthController;
use Admin\Entity\User;
use Admin\Service\AclService;
use Doctrine\ORM\EntityManager;
use Laminas\Authentication\AuthenticationService;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Laminas\Mvc\MvcEvent;

class AuthorizationListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, [$this, 'checkAuthorization'], $priority);
    }

    public function checkAuthorization($event){

        $match       = $event->getRouteMatch();
        $authService = $event->getApplication()->getServiceManager()->get(AuthenticationService::class);
        $matchedController = $match->getParam('controller');
        $routeName   = $match->getMatchedRouteName();
        $matchedAction     = $match->getParam('action');
        $em          = $event->getApplication()->getServiceManager()->get(EntityManager::class);

        $role = 'Funcionario';

        /* Valid ACL */
        $acl = $event->getApplication()->getServiceManager()->get(AclService::class);

        if (!$acl->isAllowed($role, $matchedController, $matchedAction)) {
            var_dump(['Não tem acesso']);
        }else{
            var_dump(['Tem acesso']);
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