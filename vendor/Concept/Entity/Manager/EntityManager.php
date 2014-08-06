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
     * @return array|false
     */
    public static function save(EntityInterface $entity, $source, FilterInterface $filter)
    {
        return self::$processor->save($entity, $source, $filter);
    }

    /**
     * @param        FilterInterface $filter
     *
     * @return       array|false
     */
    public static function load($filter)
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
}
