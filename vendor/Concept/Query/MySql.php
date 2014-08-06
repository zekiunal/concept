<?php
namespace Concept\Query;


use Concept\Filter\FilterInterface;

class MySql
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
        foreach($filter->select() as $key=>$value) {
            if($k != 0) {
                $statement .= ', ';
            }
            $statement .= '`' . $value['0']. '`.`' . $value['1']. '`';
            $k++;
        }

        $statement .= " FROM ";

        $k=0;
        foreach($filter->from() as $key=>$value) {
            if($k != 0) {
                $statement .= ', ';
            }
            $statement .= '`' . $value. '`';
            $k++;
        }

        $statement .= " WHERE 1=1 ";

        $k=0;
        foreach($filter->where() as $key=>$value) {
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
     *
     * @return  string
     */
    public static function insert($source, $properties=array())
    {

        $statement = "INSERT INTO `" . $source . "` SET ";
        $k=0;
        foreach($properties as $key=>$value) {
            if($k > 0) {
                $statement .= ', ';
            }
            $statement .= '`' . $source . '`.`' . $value[1] .'` = :'. $value[1] .'';
            $k++;
        }
        return $statement;
    }

    /**
     * @param   string $source
     * @param   array $properties
     * @return  string
     */
    public static function update($source, $properties)
    {
        $statement = "UPDATE `" . $source . "` SET ";
        $k=0;

        foreach($properties as $key=>$value) {
            if($k > 0) {
                $statement .= ', ';
            }
            $statement .= '`' . $source . '`.`' . $value[1] .'` = :'. $value[1] .'';
            $k++;
        }

        $statement .= ' WHERE `' . $source . '`.`' . $source .'_id` = :'. $source .'_id';
        return $statement;
    }
}
