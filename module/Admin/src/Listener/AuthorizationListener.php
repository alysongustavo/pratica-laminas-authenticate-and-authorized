<?php


namespace Admin\Listener;


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

    }

    public function detach(EventManagerInterface $events)
    {
        // TODO: Implement detach() method.
    }
}