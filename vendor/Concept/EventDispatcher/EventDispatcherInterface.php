<?php
namespace Concept\EventDispatcher;

/**
 * @author      Bernhard Schussek <bschussek@gmail.com>
 *
 * @description The EventDispatcherInterface is the central point of Symfony's event listener system.
 *              Listeners are registered on the manager and events are dispatched through the
 *              manager.
 *
 * @package     Concept\EventDispatcher
 * @name        EventDispatcherInterface
 * @version     0.1
 */
interface EventDispatcherInterface
{
    /**
     * Adds an event subscriber.
     *
     *
     * @param EventSubscriberInterface $subscriber The subscriber.
     *
     */
    public function addSubscriber(EventSubscriberInterface $subscriber);

    /**
     * @param     $event
     * @param     $callback
     * @param int $priority
     * @return mixed
     */
    public function listen($event, $callback, $priority = 0);

    /**
     * @param $event
     * @param $param
     */
    public function dispatch($event, $param);
}
