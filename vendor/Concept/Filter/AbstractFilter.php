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

    public function __construct()
    {
    }

    /**
     * @param $where
     * @return FilterInterface
     */
    public function addWhere($where)
    {
        if(!empty($where) && !in_array($where, $this->where)) {
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
        if(!empty($source) && !in_array($source, $this->from)) {
            $this->from[] = $source;
        }
        return $this;
    }

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

    public function getProperties($source=null)
    {
        if($source) {
            return $this->properties[$source];
        }
        return $this->properties;
    }
}
