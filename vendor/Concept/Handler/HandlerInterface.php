<?php
namespace Concept\Handler;

use Concept\Entity\EntityInterface;
use Concept\Filter\FilterInterface;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Handler
 * @name        HandlerInterface
 * @version     0.1
 */
interface HandlerInterface
{
    /**
     * @param HandlerInterface $nextService
     */
    public function setSuccessor(HandlerInterface $nextService);

    /**
     * @param EntityInterface $entity
     * @param                 $source
     * @param FilterInterface $filter
     *
     * @return mixed
     */
    public function save(EntityInterface $entity, $source, FilterInterface $filter);

    /**
     * @param        FilterInterface $filter
     *
     * @return       array|false
     */
    public function load(FilterInterface $filter);

    /**
     * @param $name
     * @param $id
     *
     * @return bool
     */
    public function delete($name, $id);
}
