<?php


namespace Admin\Listener;

use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Laminas\Mvc\MvcEvent;

class DefineTemplateListener implements ListenerAggregateInterface
{

    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, [$this, 'checkDefineTemplate'],$priority);
    }

    public function checkDefineTemplate($event){

        $controller = $event->getTarget();
        $controllerClass = get_class($controller);

        $module = substr($controllerClass, 0, strpos($controllerClass, '\\'));

        if($module == "Admin"){
            $viewModel = $event->getViewModel();
            $viewModel->setTemplate('layout/admin');
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