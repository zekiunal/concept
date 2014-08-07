<?php
namespace Concept\Storage\Handler;

use Concept\Entity\EntityInterface;
use Concept\Entity\Manager\EntityManagerInterface;
use Concept\Filter\FilterInterface;
use Concept\Handler\HandlerInterface;
use Concept\Cache\GlobalCache as CacheDrive;
use Concept\Query\GlobalCache as CacheQuery;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Storage\Handler
 * @name        GlobalCache
 * @version     0.1
 */
class GlobalCache implements HandlerInterface, EntityManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected static $processor;

    /**
     * @var \Concept\Cache\GlobalCache
     */
    protected static $cache;

    /**
     * @param HandlerInterface $processor
     */
    public function setSuccessor(HandlerInterface $processor)
    {
        self::$processor = $processor;
    }

    public function __construct($configuration=array())
    {
        self::$cache = new CacheDrive($configuration);
    }

    /**
     * @param EntityInterface $entity
     * @param                 $source
     * @param FilterInterface $filter
     *
     * @return EntityInterface
     */
    public static function save(EntityInterface $entity, $source, FilterInterface $filter)
    {
        self::$processor->save($entity, $source, $filter);

        $key = CacheQuery::select($filter->setId($entity->getId()));

        $entity = self::$cache->set($key, $entity);

        return $entity;
    }

    /**
     * @param        FilterInterface $filter
     *
     * @return       array
     */
    public static function load(FilterInterface $filter)
    {
        /**
         * Generate key
         */
        $key = CacheQuery::select($filter);

        $data = self::$cache->get($key);

        return ($data) ? $data : self::loadByProcessor($filter, $key);
    }

    /**
     * @param FilterInterface $filter
     * @param                 $key
     *
     * @return array
     */
    protected static function loadByProcessor(FilterInterface $filter, $key)
    {
        $data = self::$processor->load($filter);

        if ($data) {
            self::$cache->set($key, $data);
            return $data;
        }

        return array();
    }


    /**
     * @param $name
     * @param $id
     *
     * @return bool
     */
    public static function delete($name, $id)
    {
        // TODO: Implement delete() method.
    }
}
