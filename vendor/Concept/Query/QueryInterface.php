<?php
namespace Concept\Query;

use Concept\Filter\FilterInterface;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Query
 * @name        QueryInterface
 * @version     0.1
 */
interface QueryInterface
{
    /**
     * @param  FilterInterface $filter
     *
     * @return string
     */
    public static function select(FilterInterface $filter);

    /**
     * @param array       $data
     * @param string      $source
     * @param array       $properties
     *
     * @return string
     */
    public static function insert(array $data, $source, $properties=array());

    /**
     * @param array       $data
     * @param string      $source
     * @param array       $properties
     *
     * @return string
     */
    public static function update($data, $source, $properties=array());
}
