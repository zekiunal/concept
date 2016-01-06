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
            'user_id'  => $this->user_id,
            'username' => $this->username
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

    /**
     * @return      User
     */
    public function save()
    {
        self::fireModelEvent('saving');
        if ($this->user_id) {
            self::performUpdate();
        } else {
            self::performInsert();
        }
        self::fireModelEvent('saved');
        return $this;
    }

    public function delete()
    {
        self::fireModelEvent('deleting');
        if ($this->user_id) {
            UserDA::delete($this);
            self::fireModelEvent('deleted');
        }

        return $this;
    }

    /**
     * @return       User
     */
    protected function performInsert()
    {
        self::fireModelEvent('creating');
        UserDA::save($this);
        self::fireModelEvent('created', false);
        return $this;
    }

    /**
     * @return       User
     */
    protected function performUpdate()
    {
        self::fireModelEvent('updating');
        UserDA::save($this);
        self::fireModelEvent('updated', false);
        return $this;
    }

    /**
     * Fire the given event for the model.
     *
     * @param  string $event
     * @param  bool $halt
     * @return mixed
     */
    protected function fireModelEvent($event, $halt = true)
    {
        if (!isset(static::$dispatcher)) {
            return true;
        }

        $event = "monorm.model.{$event}: " . "user";

        static::$dispatcher->dispatch($event, $this);
    }

    /**
     * Register a model event with the dispatcher.
     *
     * @param  string $event
     * @param  \Closure|string $callback
     * @param  int $priority
     * @return void
     */
    protected static function registerModelEvent($event, $callback, $priority = 0)
    {
        $name = 'user';
        $event_name = "monorm.model.{$event}: {$name}";
        parent::registerEvent($event_name, $callback, $priority);
    }
}

class UserDA
{
    /**
     * @param        int $user_id
     *
     * @return       User|false
     */
    public static function loadById($user_id)
    {
        $filter = new UserFilter();
        $filter->setUserId($user_id);
        $data = \Concept\Entity\Manager\EntityManager::load($filter);
        $result = self::bind($data);
        if ($result->count() > 0) {
            return $result->get(0);
        }
        return false;
    }

    /**
     * @param        $filter
     *
     * @return       UserCollection
     */
    public static function load($filter)
    {
        return self::bind(\Concept\Entity\Manager\EntityManager::load($filter));
    }

    /**
     * @param User $entity
     *
     * @return User
     */
    public static function save(User $entity)
    {
        return \Concept\Entity\Manager\EntityManager::save($entity, 'user');
    }

    /**
     * @param User $entity
     * @return bool
     */
    public static function delete(User $entity)
    {
        return \Concept\Entity\Manager\EntityManager::delete($entity);
    }

    /**
     * @param  array $array
     * @return UserCollection
     */
    public static function bind($array)
    {
        $collection = new UserCollection();
        foreach ($array as $data) {
            $collection->add(self::create($data));
        }
        return $collection;

    }

    /**
     * @param  array $data
     * @return User
     */
    public static function create(array $data)
    {
        $entity = new User();
        $entity->bind($data);

        return $entity;
    }
}

class UserCollection extends \Concept\Collection\AbstractCollection
{

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

    public function __construct($filter = null)
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
    public function setUserId($user_id, $equal = true)
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
    public function setId($user_id, $equal = true)
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
