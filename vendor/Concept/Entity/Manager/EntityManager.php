<?php
namespace Concept\Entity\Manager;

use Concept\Filter\FilterInterface;
use Concept\Entity\EntityInterface;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Entity\Manager
 * @name        EntityManager
 * @version     0.1
 */
class EntityManager implements EntityManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected static $processor;

    public static function setHandler(EntityManagerInterface $processor)
    {
        self::$processor = $processor;
    }

    /**
     * @param EntityInterface $entity
     * @param                 $source
     * @param FilterInterface $filter
     *
     * @return EntityInterface
     */
    public static function save(EntityInterface $entity, $source, $filter=null)
    {
        return self::$processor->save($entity, $source, self::getEntityFilter($entity));
    }

    /**
     * @param        FilterInterface $filter
     *
     * @return       array|false
     */
    public static function load(FilterInterface $filter)
    {
        return self::$processor->load($filter);
    }

    /**
     * @param $name
     * @param $id
     *
     * @return bool
     */
    public static function delete($name, $id)
    {
        return self::$processor->delete($name, $id);
    }

    protected static function getEntitySource($entity)
    {

    }

    /**
     * @param EntityInterface $entity
     * @return FilterInterface
     */
    protected static function getEntityFilter($entity)
    {
        $class = str_replace('Business', 'Filter', get_class($entity)).'Filter';
        return new $class();
    }

    protected static function get_class_name($entity)
    {
        $class_name = get_class($entity);

        if (preg_match('@\\\\([\w]+)$@', $class_name, $matches)) {
            $class_name = $matches[1];
        }

        return $class_name;
    }
}
