<?php
namespace Concept\Query;

use Concept\Filter\FilterInterface;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Query
 * @name        SQLite
 * @version     0.1
 */
class SQLite
{
    /**
     * @param  FilterInterface $filter
     *
     * @return string
     */
    public static function select($filter)
    {
        $k=0;
        $statement = "SELECT ";
        foreach($filter->select() as $value) {
            if($k != 0) {
                $statement .= ', ';
            }
            $statement .= '`' . $value['0']. '`.`' . $value['1']. '`';
            $k++;
        }

        $statement .= " FROM ";

        $k=0;
        foreach($filter->from() as $value) {
            if($k != 0) {
                $statement .= ', ';
            }
            $statement .= '`' . $value. '`';
            $k++;
        }

        $statement .= " WHERE 1=1 ";

        $k=0;
        foreach($filter->where() as $value) {
            $statement .= ' AND ';
            if($value['equal']) {
                $equal = '=';
            } else {
                $equal = '!=';
            }

            if($value['value'][0] == '`' or is_int($value['value'])) {
                $result =  $value['value'];
            } else {
                $result = "'" . $value['value']. "'";
            }

            $statement .= '`' . $value['source']. '`.`' . $value['field']. '`' . $equal . $result ;
            $k++;
        }

        $statement .= $filter->limit();

        return $statement;
    }

    /**
     * @param   string $source
     * @param   array  $properties
     * @param   array  $data
     *
     * @return  string
     */
    public static function insert($source, $properties=array(), $data)
    {

        $statement = "INSERT INTO `" . $source . "` (";
        $k=0;
        foreach($properties as $value) {
            if($data[$value[1]]) {
                if($k > 0) {
                    $statement .= ', ';
                }
                $statement .= '`' . $value[1] .'`';
                $k++;
            }
        }
        $statement .= ') VALUES (';

        $k=0;
        foreach($properties as $value) {
            if($data[$value[1]]) {
                if($k > 0) {
                    $statement .= ', ';
                }
                $statement .= ':'. $value[1] .'';
                $k++;
            }
        }
        $statement .= ')';

        return $statement;
    }

    /**
     * @param   string $source
     * @param   array  $properties
     * @param   array  $data
     *
     * @return  string
     */
    public static function update($source, $properties=array(), $data)
    {
        $statement = "UPDATE `" . $source . "` SET ";

        $k=0;
        foreach($properties as $value) {
            if($data[$value[1]]) {
                if($k > 0) {
                    $statement .= ', ';
                }
                $statement .= '`' . $value[1] .'` = :'. $value[1] .'';
                $k++;
            }
        }

        $statement .= ' WHERE `' . $source . '`.`' . $source .'_id` = :'. $source .'_id';
        return $statement;
    }
}

