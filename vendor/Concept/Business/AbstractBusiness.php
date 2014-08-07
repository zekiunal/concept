<?php
namespace Concept\Business;

use Concept\Entity\EntityInterface;
use Concept\EventDispatcher\EventDispatcherInterface;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Business
 * @name        AbstractBusiness
 * @version     0.1
 */
abstract class AbstractBusiness implements EntityInterface
{
    /**
     * @return array
     */
    abstract public function convertArray();

    /**
     * @return mixed
     */
    abstract public function getId();

    /**
     * @param  mixed $id
     *
     * @return mixed
     */
    abstract public function setId($id);

    /**
     * User exposed observable events
     *
     * @var array
     */
    protected $observables = array();

    /**
     * The event dispatcher instance.
     *
     * @var EventDispatcherInterface
     */
    protected static $dispatcher;

    /**
     * Get the observable event names.
     *
     * @return array
     */
    public function getObservableEvents()
    {
        return array_merge(
            array(
                'creating', 'created', 'updating', 'updated',
                'deleting', 'deleted', 'saving', 'saved',
                'restoring', 'restored',
            ),
            $this->observables
        );
    }

    /**
     * Get the event dispatcher instance.
     *
     * @return       EventDispatcherInterface
     */
    public static function getEventDispatcher()
    {
        return static::$dispatcher;
    }

    /**
     * Set the event dispatcher instance.
     *
     * @param   $dispatcher
     * @return void
     */
    public static function setEventDispatcher($dispatcher)
    {
        static::$dispatcher = $dispatcher;
    }

    /**
     * Unset the event dispatcher for models.
     *
     * @return void
     */
    public static function unsetEventDispatcher()
    {
        static::$dispatcher = null;
    }

    /**
     * Register a model event with the dispatcher.
     *
     * @param  string  $event
     * @param  \Closure|string  $callback
     * @param  int  $priority
     * @return void
     */
    protected static function registerEvent($event, $callback, $priority=0)
    {
        if ( ! isset(static::$dispatcher)) {
            static::setEventDispatcher(new EventDispatcher());
        }

        static::$dispatcher->listen($event, $callback, $priority);
    }


}
