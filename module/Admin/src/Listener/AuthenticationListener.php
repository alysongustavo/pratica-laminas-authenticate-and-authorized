<?php


namespace Admin\Listener;


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

         //   var_dump(['AuthenticationListener']);exit;

    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }
}