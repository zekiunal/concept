<?php
namespace Concept\Entity\Manager;

use Concept\Entity\EntityInterface;
use Concept\Filter\FilterInterface;

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
     * @param boolean $process
     *
     * @return EntityInterface
     */
    public static function save(EntityInterface $entity, $process = true);

    /**
     * @param        FilterInterface $filter
     *
     * @return       array
     */
    public static function load(FilterInterface $filter);

    /**
     * @param $name
     * @param $id
     *
     * @return bool
     */
    public static function delete($name, $id);
}
