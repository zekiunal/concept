<?php
namespace Concept\Query;

use Concept\Filter\FilterInterface;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Query
 * @name        GlobalCache
 * @version     0.1
 */
class GlobalCache
{
    /**
     * @param  FilterInterface $filter
     *
     * @return string
     */
    public static function select(FilterInterface $filter)
    {
        return md5($filter->getSource() . '_' . $filter->getId() . '_' . json_encode($filter->getParameters()));
    }
}
