<?php
namespace Concept\Filter;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Filter
 * @name        AbstractFilter
 * @version     0.1
 */
abstract class AbstractFilter implements FilterInterface
{

    /**
     * @param string  $column_name
     * @param string  $value
     * @param boolean $equal
     *
     * @return FilterInterface
     */
    public function findBy($column_name, $value, $equal = true)
    {
        // TODO: Implement findBy() method.
    }

    /**
     * @return array
     */
    public function select()
    {
        // TODO: Implement select() method.
    }

    /**
     * @return array
     */
    public function from()
    {
        // TODO: Implement from() method.
    }

    /**
     * @return array
     */
    public function where()
    {
        // TODO: Implement where() method.
    }

    /**
     * @return string
     */
    public function limit()
    {
        // TODO: Implement limit() method.
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        // TODO: Implement getParameters() method.
    }

    /**
     * @return array
     */
    public function getSource()
    {
        // TODO: Implement getSource() method.
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        // TODO: Implement getId() method.
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function setId($id)
    {
        // TODO: Implement setId() method.
    }

    /**
     * @description
     * @return       array
     */
    public function getProperties()
    {
        // TODO: Implement getProperties() method.
    }
}
