<?php
/**
 * register classes with namespaces
 */
include_once '../../../example/library/ClassLoader/Loader.php';

$loader = new \ClassLoader\Loader('Concept', '../../../vendor');
$loader->register();

class User extends \Concept\Business\AbstractBusiness
{
    protected $user_id;

    protected $username;

    /**
     * EntityInterface implementation of convertArray()
     *
     * @return array
     */
    public function convertArray()
    {
        return array(
            'user_id' => $this->user_id,
            'username'=> $this->username
        );
    }

    /**
     * EntityInterface implementation of getId()
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->user_id;
    }

    /**
     * EntityInterface implementation of setId()
     *
     * @param  mixed $id
     *
     * @return User
     */
    public function setId($id)
    {
        $this->user_id = $id;
        return $this;
    }

    /**
     * @param mixed $user_id
     *
     * @return User
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }
}

class UserFilter extends \Concept\Filter\AbstractFilter
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

    public function __construct($filter=null)
    {
        $this->filter = ($filter != null) ? $filter : $this;
        parent::__construct($this->filter);
        $this->setup(
            array(
                array('user', 'user_id'),
                array('user', 'username')
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
     * @max 10
     * @param integer $user_id
     * @param boolean $equal
     * @return UserFilter
     */
    public function setId($user_id, $equal=true)
    {
        $this->setUserId($user_id, $equal);
        return $this;
    }

    /**
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }
}
