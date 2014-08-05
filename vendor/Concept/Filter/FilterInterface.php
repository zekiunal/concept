<?php
namespace Concept\Filter;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Filter
 * @name        FilterInterface
 * @version     0.1
 */
interface FilterInterface
{
    /**
     * @param string  $column_name
     * @param string  $value
     * @param boolean $equal
     *
     * @return FilterInterface
     */
    public function findBy($column_name, $value, $equal = true);

    /**
     * @return array
     */
    public function select();

    /**
     * @return array
     */
    public function from();

    /**
     * @return array
     */
    public function where();

    /**
     * @return string
     */
    public function limit();

    /**
     * @return array
     */
    public function getParameters();

    /**
     * @return array
     */
    public function getSource();

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param $id
     *
     * @return mixed
     */
    public function setId($id);

    /**
     * @description
     * @return       array
     */
    public function getProperties();
}
