<?php
namespace ExampleProject\Core\Filter;
use Concept\Filter\AbstractFilter;
use Concept\Filter\FilterInterface;
use ExampleProject\Custom\Filter\UserFilter;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     ExampleProject\Core\Filter
 * @name        AbstractUserFilter
 * @version     0.1
 */
abstract class AbstractUserFilter extends AbstractFilter
{
    /**
     * source table name
     * @var string
     */
    protected $source = 'user';

    /**
     * Group by primary key (user_id)
     * @var string
     */
    protected $group_by = 'user_id';

    /**
     * @var integer $user_id
     */
    protected $user_id;

    /**
     * $var array
     */
    protected $keys = array();

    /**
     * @param null|FilterInterface $filter
     */
    public function __construct($filter=null)
    {
        $this->filter = ($filter != null) ? $filter : $this;
        parent::__construct($this->filter);
        $this->setup(
            array(
                array('user', 'user_id'),
                array('user', 'username'),
                array('user', 'email'),
                array('user', 'password'),
                array('user', 'first_name'),
                array('user', 'last_name')
            ),
            'user'
        );
    }

    /**
     * @max 10
     * @param integer $user_id
     * @param boolean $equal
     * @return UserFilter
     */
    public function setUserId($user_id, $equal=true)
    {
        $this->user_id = $user_id;
        $this->filter->addWhere(array(
            'source' => 'user',
            'field'  => 'user_id',
            'value'  => $user_id,
            'equal'  => $equal
        ));
        return $this;
    }

    /**
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->keys;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function setId($id)
    {
        $this->user_id = $id;
        return $this;
    }
}
