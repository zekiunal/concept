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

    protected $type;

    /**
     * EntityInterface implementation of convertArray()
     *
     * @return array
     */
    public function convertArray()
    {
        return array(
            'user_id'  => $this->user_id,
            'username' => $this->username,
            'type'     => $this->type
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
     * @param mixed $type
     *
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
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

    /**
     * @return bool
     */
    public function delete()
    {
        $result = false;
        self::fireModelEvent('deleting');
        if ($this->user_id) {
            $result = UserDA::delete($this);
            self::fireModelEvent('deleted');
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function deleteById()
    {
        $result = false;
        self::fireModelEvent('deleting');
        if ($this->user_id) {
            $result = UserDA::deleteById($this->user_id);
            self::fireModelEvent('deleted');
        }

        return $result;
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
     * @param $id
     * @return bool
     */
    public static function deleteById($id)
    {
        $entity = new User();
        $entity->setId($id);
        return self::delete($entity);
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



class Profile extends User
{
    /**
     * @var int
     */
    protected $profile_id;

    /**
     * EntityInterface implementation of convertArray()
     *
     * @return array
     */
    public function convertArray()
    {

        return array_merge(parent::convertArray(), array(
            'profile_id' => $this->profile_id
        ));
    }

    /**
     * EntityInterface implementation of getId()
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->profile_id;
    }

    /**
     * EntityInterface implementation of setId()
     *
     * @param  mixed $id
     *
     * @return Profile
     */
    public function setId($id)
    {
        $this->profile_id = $id;
        return $this;
    }

    /**
     * @param mixed $profile_id
     *
     * @return Profile
     */
    public function setProfileId($profile_id)
    {
        $this->profile_id = $profile_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProfileId()
    {
        return $this->profile_id;
    }



    /**
     * @return      Profile
     */
    public function save()
    {
        self::fireModelEvent('saving');
        if ($this->profile_id) {
            self::performUpdate();
        } else {
            self::performInsert();
        }
        self::fireModelEvent('saved');
        return $this;
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $result = false;
        self::fireModelEvent('deleting');
        if ($this->profile_id) {
            $result = UserDA::delete($this);
            self::fireModelEvent('deleted');
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function deleteById()
    {
        $result = false;
        self::fireModelEvent('deleting');
        if ($this->profile_id) {
            $result = UserDA::deleteById($this->profile_id);
            self::fireModelEvent('deleted');
        }

        return $result;
    }

    /**
     * @return       Profile
     */
    protected function performInsert()
    {
        self::fireModelEvent('creating');
        UserDA::save($this);
        self::fireModelEvent('created', false);
        return $this;
    }

    /**
     * @return       Profile
     */
    protected function performUpdate()
    {
        self::fireModelEvent('updating');
        ProfileDA::save($this);
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
        $event = "monorm.model.{$event}: " . "profile";
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
        $name = 'profile';
        $event_name = "monorm.model.{$event}: {$name}";
        parent::registerEvent($event_name, $callback, $priority);
    }
}

class ProfileDA
{
    /**
     * @param        int $profile_id
     *
     * @return       Profile|false
     */
    public static function loadById($profile_id)
    {
        $filter = new ProfileFilter();
        $filter->setProfileId($profile_id);
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
     * @return       ProfileCollection
     */
    public static function load($filter)
    {
        return self::bind(\Concept\Entity\Manager\EntityManager::load($filter));
    }

    /**
     * @param Profile $entity
     *
     * @return Profile
     */
    public static function save(Profile $entity)
    {
        return \Concept\Entity\Manager\EntityManager::save($entity, 'profile');
    }

    /**
     * @param Profile $entity
     * @return bool
     */
    public static function delete(Profile $entity)
    {
        return \Concept\Entity\Manager\EntityManager::delete($entity);
    }

    /**
     * @param $id
     * @return bool
     */
    public static function deleteById($id)
    {
        $entity = new Profile();
        $entity->setId($id);
        return self::delete($entity);
    }

    /**
     * @param  array $array
     * @return ProfileCollection
     */
    public static function bind($array)
    {
        $collection = new ProfileCollection();
        foreach ($array as $data) {
            $collection->add(self::create($data));
        }
        return $collection;

    }

    /**
     * @param  array $data
     * @return Profile
     */
    public static function create(array $data)
    {
        $entity = new Profile();
        $entity->bind($data);

        return $entity;
    }
}

class ProfileCollection extends \Concept\Collection\AbstractCollection
{

}




class Band extends Profile
{
    /**
     * @var int
     */
    protected $band_id;

    /**
     * EntityInterface implementation of convertArray()
     *
     * @return array
     */
    public function convertArray()
    {
        return array_merge(parent::convertArray(), array(
            'band_id' => $this->band_id
        ));
    }

    /**
     * EntityInterface implementation of getId()
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->band_id;
    }

    /**
     * EntityInterface implementation of setId()
     *
     * @param  mixed $id
     *
     * @return Band
     */
    public function setId($id)
    {
        $this->band_id = $id;
        return $this;
    }

    /**
     * @param mixed $band_id
     *
     * @return Band
     */
    public function setBandId($band_id)
    {
        $this->band_id = $band_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBandId()
    {
        return $this->band_id;
    }



    /**
     * @return      Band
     */
    public function save()
    {
        self::fireModelEvent('saving');
        if ($this->band_id) {
            self::performUpdate();
        } else {
            self::performInsert();
        }
        self::fireModelEvent('saved');
        return $this;
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $result = false;
        self::fireModelEvent('deleting');
        if ($this->band_id) {
            $result = BandDA::delete($this);
            self::fireModelEvent('deleted');
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function deleteById()
    {
        $result = false;
        self::fireModelEvent('deleting');
        if ($this->band_id) {
            $result = BandDA::deleteById($this->band_id);
            self::fireModelEvent('deleted');
        }

        return $result;
    }

    /**
     * @return       Band
     */
    protected function performInsert()
    {
        self::fireModelEvent('creating');
        BandDA::save($this);
        self::fireModelEvent('created', false);
        return $this;
    }

    /**
     * @return       Band
     */
    protected function performUpdate()
    {
        self::fireModelEvent('updating');
        BandDA::save($this);
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
        $event = "monorm.model.{$event}: " . "band";
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
        $name = 'band';
        $event_name = "monorm.model.{$event}: {$name}";
        parent::registerEvent($event_name, $callback, $priority);
    }
}

class BandDA
{
    /**
     * @param        int $band_id
     *
     * @return       Band|false
     */
    public static function loadById($band_id)
    {
        $filter = new BandFilter();
        $filter->setBandId($band_id);
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
     * @return       BandCollection
     */
    public static function load($filter)
    {
        return self::bind(\Concept\Entity\Manager\EntityManager::load($filter));
    }

    /**
     * @param Band $entity
     *
     * @return Band
     */
    public static function save(Band $entity)
    {
        return \Concept\Entity\Manager\EntityManager::save($entity, 'band');
    }

    /**
     * @param Band $entity
     * @return bool
     */
    public static function delete(Band $entity)
    {
        return \Concept\Entity\Manager\EntityManager::delete($entity);
    }

    /**
     * @param $id
     * @return bool
     */
    public static function deleteById($id)
    {
        $entity = new Band();
        $entity->setId($id);
        return self::delete($entity);
    }

    /**
     * @param  array $array
     * @return BandCollection
     */
    public static function bind($array)
    {
        $collection = new BandCollection();
        foreach ($array as $data) {
            $collection->add(self::create($data));
        }
        return $collection;

    }

    /**
     * @param  array $data
     * @return Profile
     */
    public static function create(array $data)
    {
        $entity = new Profile();
        $entity->bind($data);

        return $entity;
    }
}

class BandCollection extends \Concept\Collection\AbstractCollection
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
                array('user', 'username'),
                array('user', 'type')
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
class ProfileFilter extends UserFilter
{
    /**
     * source table name
     * @var string
     */
    protected $source = 'profile';

    /**
     * Group by primary key (profile_id)
     * @var string
     */
    protected $group_by = 'profile_id';

    /**
     * @var integer $profile_id
     */
    protected $profile_id;

    public function __construct($filter = null)
    {
        $this->filter = ($filter != null) ? $filter : $this;

        parent::__construct($this->filter);
        $this->setup(
            array(
                array('profile', 'profile_id')
            ),
            'profile'
        );
        $this->addWhere(array(
            'source' => 'profile',
            'field'  => 'user_id',
            'value'  => '`'.'user'.'`'.'.`user_id'.'`',
            'equal'  => true
        ));

    }

    /**
     * @max 10
     * @param integer $profile_id
     * @param boolean $equal
     * @return ProfileFilter
     */
    public function setProfileId($profile_id, $equal = true)
    {
        $this->profile_id = $profile_id;
        $this->filter->addWhere(array(
            'source' => 'profile',
            'field'  => 'profile_id',
            'value'  => $profile_id,
            'equal'  => $equal
        ));
        return $this;
    }

    /**
     * @max 10
     * @param integer $user_id
     * @param boolean $equal
     * @return ProfileFilter
     */
    public function setId($user_id, $equal = true)
    {
        $this->setProfileId($user_id, $equal);
        return $this;
    }

    /**
     * @return integer
     */
    public function getProfileId()
    {
        return $this->profile_id;
    }
}
class BandFilter extends ProfileFilter
{
    /**
     * source table name
     * @var string
     */
    protected $source = 'band';

    /**
     * Group by primary key (band_id)
     * @var string
     */
    protected $group_by = 'band_id';

    /**
     * @var integer $band_id
     */
    protected $band_id;

    public function __construct($filter = null)
    {
        $this->filter = ($filter != null) ? $filter : $this;
        parent::__construct($this->filter);
        $this->setup(
            array(
                array('band', 'band_id')
            ),
            'band'
        );


            $this->addWhere(array(
                'source' => 'band',
                'field'  => 'profile_id',
                'value'  => '`'.'profile'.'`'.'.`profile_id'.'`',
                'equal'  => true
            ));

    }

    /**
     * @max 10
     * @param integer $band_id
     * @param boolean $equal
     * @return BandFilter
     */
    public function setBandId($band_id, $equal = true)
    {
        $this->band_id = $band_id;
        $this->filter->addWhere(array(
            'source' => 'profile',
            'field'  => 'band_id',
            'value'  => $band_id,
            'equal'  => $equal
        ));
        return $this;
    }

    /**
     * @max 10
     * @param integer $band_id
     * @param boolean $equal
     * @return BandFilter
     */
    public function setId($band_id, $equal = true)
    {
        $this->setBandId($band_id, $equal);
        return $this;
    }

    /**
     * @return integer
     */
    public function getBandId()
    {
        return $this->band_id;
    }
}
