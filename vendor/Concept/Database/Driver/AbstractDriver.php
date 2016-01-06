<?php
namespace Concept\Database\Driver;

use Concept\EventDispatcher\EventDispatcher;
use Concept\EventDispatcher\EventDispatcherInterface;

abstract class AbstractDriver
{
    /**
     * The event dispatcher instance.
     *
     * @var EventDispatcher
     */
    protected static $dispatcher;

    /**
     * @var string
     */
    public $time;

    /**
     * @var string
     */
    public $statement;

    /**
     * @var array
     */
    public $data;

    /**
     * @var string
     */
    public $source;

    /**
     * @var array
     */
    public $properties;

    /**
     * Register a model event with the dispatcher.
     *
     * @param  string $event
     * @param  \Closure|string $callback
     * @param  int $priority
     * @return void
     */
    protected static function registerEvent($event, $callback, $priority = 0)
    {
        if (!isset(static::$dispatcher)) {
            static::setEventDispatcher(new EventDispatcher());
        }

        static::$dispatcher->listen($event, $callback, $priority);
    }

    /**
     * Set the event dispatcher instance.
     *
     * @param   $dispatcher
     * @return void
     */
    public static function setEventDispatcher(EventDispatcherInterface $dispatcher)
    {
        static::$dispatcher = $dispatcher;
    }

    /**
     * Get the event dispatcher instance.
     *
     * @return       EventDispatcher
     */
    public static function getEventDispatcher()
    {
        if (!isset(static::$dispatcher)) {
            static::setEventDispatcher(new EventDispatcher());
        }

        return static::$dispatcher;
    }

    /**
     * Fire the given event for the model.
     *
     * @param  string $event
     * @param  bool $halt
     * @return mixed
     */
    protected function fireModelEvent($event, $halt = true)
    {
        if (!isset(static::$dispatcher)) {
            return true;
        }

        $event = "monorm.sqllite_driver.{$event}";
        static::$dispatcher->dispatch($event, $this);
    }

    /**
     * Register a inserting event with the dispatcher.
     *
     * @param  \Closure|string $callback
     * @param int $priority
     * @return void
     */
    public static function inserting($callback, $priority = 0)
    {
        static::registerModelEvent('inserting', $callback, $priority);
    }

    /**
     * Register a inserted event with the dispatcher.
     *
     * @param  \Closure|string $callback
     * @param int $priority
     * @return void
     */
    public static function inserted($callback, $priority = 0)
    {
        static::registerModelEvent('inserted', $callback, $priority);
    }

    /**
     * Register a updated event with the dispatcher.
     *
     * @param  \Closure|string $callback
     * @param int $priority
     * @return void
     */
    public static function updated($callback, $priority = 0)
    {
        static::registerModelEvent('updated', $callback, $priority);
    }

    /**
     * Register a updating event with the dispatcher.
     *
     * @param  \Closure|string $callback
     * @param int $priority
     * @return void
     */
    public static function updating($callback, $priority = 0)
    {
        static::registerModelEvent('updating', $callback, $priority);
    }
}
