<?php
namespace Concept\Entity\Manager;

use Concept\Entity\EntityInterface;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Entity\Manager
 * @name        EntityManagerInterface
 * @version     0.1
 */
interface EntityManagerInterface
{
    /**
     * @param EntityInterface $entity
     * @param                 $source
     * @param FilterInterface $filter
     *
     * @return array|false
     */
    public static function save(EntityInterface $entity, $source, FilterInterface $filter);

    /**
     * @param        FilterInterface $filter
     *
     * @return       array|bool
     */
    public static function load($filter);

    /**
     * @param $name
     * @param $id
     *
     * @return bool
     */
    public static function delete($name, $id);
}
