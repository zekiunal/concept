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
     * @var FilterInterface
     */
    protected $filter;

    /**
     * @var string
     */
    protected $limit = " LIMIT 0, 30";

    /**
     * @var array
     */
    protected $where = array();

    /**
     * @var array
     */
    protected $from = array();

    /**
     * @var array
     */
    protected $fields = array();

    /**
     * @var array
     */
    protected $properties = array();

    /**
     * @var array
     */
    protected $find_by;

    public function __construct()
    {
    }

    /**
     * @param int $count
     * @param int $offset
     */
    public function setLimit($count = 30, $offset = 0)
    {
        $this->limit = " LIMIT " . $offset . ", " . $count;
    }

    /**
     * @param $where
     * @return FilterInterface
     */
    public function addWhere($where)
    {
        if (!empty($where) && !in_array($where, $this->where)) {
            $this->where[] = $where;
        }

        return $this;
    }

    /**
     * @param $fields
     * @param $source
     */
    protected function setup($fields, $source)
    {
        $this->fields = array_merge($fields, $this->fields);
        $this->properties[$source] = $fields;
        $this->addFrom($source);
    }

    /**
     * @param string $source
     * @return FilterInterface
     */
    public function addFrom($source)
    {
        if (!empty($source) && !in_array($source, $this->from)) {
            $this->from[] = $source;
        }

        return $this;
    }

    /**
     * @param string $column_name
     * @param string $value
     * @param boolean $equal
     *
     * @return FilterInterface
     */
    public function findBy($column_name, $value, $equal = true)
    {
        $source = $this->getSourceM($column_name);
        $this->filter->addWhere(array(
            'source' => $source,
            'field'  => $column_name,
            'value'  => $value,
            'equal'  => $equal
        ));
        return $this;
    }

    /**
     * @param string $column_name
     * @return string
     */
    protected function getSourceM($column_name)
    {
        $size = count($this->fields);
        for ($i = 0; $i < $size; $i++) {
            if ($this->fields[$i][1] == $column_name) {
                return $this->fields[$i][0];
            }
        }
    }

    /**
     * @return array
     */
    public function select()
    {
        return $this->fields;
    }

    /**
     * @return array
     */
    public function from()
    {
        return $this->from;
    }

    /**
     * @return array
     */
    public function where()
    {
        return $this->where;
    }

    /**
     * @return string
     */
    public function limit()
    {
        return $this->limit;
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
     * @param null $source
     * @return array
     */
    public function getProperties($source = null)
    {
        if ($source) {
            return $this->properties[$source];
        }

        return $this->properties;
    }
}
