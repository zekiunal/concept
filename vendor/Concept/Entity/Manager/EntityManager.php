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
     *
     * @return EntityInterface
     */
    public static function save(EntityInterface $entity)
    {
        return self::$processor->save($entity);
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

    public static function getEntitySource($entity)
    {
        return self::from_camel_case(self::get_class_name($entity));
    }

    public static function getPrimaryKey($entity)
    {
        return self::get_class_name($entity)."Id";
    }

    /**
     * @param EntityInterface $entity
     * @return FilterInterface
     */
    public static function getEntityFilter($entity)
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

    private static function from_camel_case($input) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}
