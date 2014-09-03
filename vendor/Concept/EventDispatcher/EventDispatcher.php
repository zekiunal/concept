<?php
namespace Concept\EventDispatcher;

class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var array
     */
    private $listeners = array();

    /**
     * Adds an event subscriber.
     *
     *
     * @param EventSubscriberInterface $subscriber The subscriber.
     *
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $listeners = $subscriber->getSubscribedEvents();

        foreach ($listeners as $event => $listener)
        {
            // Add the subscribed function as an event
            $this->listen($event, array($subscriber, $listener));
        }
    }

    /**
     * @param     $event
     * @param     $callback
     * @param int $priority
     * @return mixed
     */
    public function listen($event, $callback, $priority = 0)
    {
        $this->listeners[$event][] = $callback;
    }

    /**
     * @param $event
     * @param $param
     *
     * @return boolean
     */
    public function dispatch($event, $param)
    {
        if (!isset($this->listeners[$event])) {
            return true;
        }

        foreach ($this->listeners[$event] as $listener)
        {
            call_user_func_array($listener, array($param));
        }

        return true;
    }
}
