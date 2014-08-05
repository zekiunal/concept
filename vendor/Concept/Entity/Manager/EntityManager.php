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
     * @param EntityInterface $entity
     * @param                 $source
     * @param FilterInterface $filter
     *
     * @return array|false
     */
    public static function save(EntityInterface $entity, $source, FilterInterface $filter)
    {
        // TODO: Implement save() method.
    }

    /**
     * @param        FilterInterface $filter
     *
     * @return       array|bool
     */
    public static function load($filter)
    {
        // TODO: Implement load() method.
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
