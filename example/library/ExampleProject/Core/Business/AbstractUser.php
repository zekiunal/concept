<?php
namespace ExampleProject\Core\Business;

use Concept\Business\AbstractBusiness;
use ExampleProject\Custom\Business\User;
use ExampleProject\Custom\Data\UserDA;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     ExampleProject\Core\Business
 * @name        AbstractUser
 * @version     0.1
 */
abstract class AbstractUser extends AbstractBusiness
{
    /**
     * @var int
     */
    protected $user_id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $first_name;

    /**
     * @var string
     */
    protected $last_name;

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $first_name
     *
     * @return User
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $last_name
     *
     * @return User
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param int $user_id
     *
     * @return User
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * EntityInterface implementation of convertArray()
     *
     * @return array
     */
    public function convertArray()
    {
        $data['user_id']    = $this->user_id;
        $data['username']   = $this->username;
        $data['email']      = $this->email;
        $data['password']   = $this->password;
        $data['first_name'] = $this->first_name;
        $data['last_name']  = $this->last_name;
        return $data;
    }

    /**
     * EntityInterface implementation of getId()
     *
     * @see getUserId()
     */
    public function getId()
    {
        return $this->getUserId();
    }

    /**
     * EntityInterface implementation of setId()
     *
     * @param  mixed $id
     *
     * @see getUserId()
     *
     * @return mixed
     */
    public function setId($id)
    {
        return $this->setUserId($id);
    }

    /**
     * Fire the given event for the model.
     *
     * @param  string  $event
     * @param  bool    $halt
     * @return mixed
     */
    protected function fireModelEvent($event, $halt = true)
    {
        if ( ! isset(static::$dispatcher)) {
            return true;
        }

        $event = "monorm.model.{$event}: "."user";

        static::$dispatcher->dispatch($event, $this);
    }

    /**
     * Register a model event with the dispatcher.
     *
     * @param  string  $event
     * @param  \Closure|string  $callback
     * @param  int  $priority
     * @return void
     */
    protected static function registerModelEvent($event, $callback, $priority = 0)
    {
        $name = 'user';
        $event_name = "monorm.model.{$event}: {$name}";
        parent::registerEvent($event_name, $callback, $priority);
    }

    /**
     * @author      Zeki Unal <zekiunal@gmail.com>
     * @description
     * @return      User
     */
    public function save()
    {
        self::fireModelEvent('saving');
        if ($this->user_id)
        {
            self::performUpdate();
        } else {
            self::performInsert();
        }
        self::fireModelEvent('saved');
        return $this;
    }

    /**
     * @author       Zeki Unal <zekiunal@gmail.com>
     * @description
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
     * @author       Zeki Unal <zekiunal@gmail.com>
     * @description
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
     * Register a saving model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @param int $priority
     * @return void
     */
    public static function saving($callback, $priority = 0)
    {
        static::registerModelEvent('saving', $callback, $priority);
    }

    /**
     * Register a saved model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @param int $priority
     * @return void
     */
    public static function saved($callback, $priority = 0)
    {
        static::registerModelEvent('saved', $callback, $priority);
    }

    /**
     * Register an updating model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @param int $priority
     * @return void
     */
    public static function updating($callback, $priority = 0)
    {
        static::registerModelEvent('updating', $callback, $priority);
    }

    /**
     * Register an updated model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @param int $priority
     * @return void
     */
    public static function updated($callback, $priority = 0)
    {
        static::registerModelEvent('updated', $callback, $priority);
    }

    /**
     * Register a creating model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @param int $priority
     * @return void
     */
    public static function creating($callback, $priority = 0)
    {
        static::registerModelEvent('creating', $callback, $priority);
    }

    /**
     * Register a created model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @param int $priority
     * @return void
     */
    public static function created($callback, $priority = 0)
    {
        static::registerModelEvent('created', $callback, $priority);
    }

    /**
     * Register a deleting model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @param int $priority
     * @return void
     */
    public static function deleting($callback, $priority = 0)
    {
        static::registerModelEvent('deleting', $callback, $priority);
    }

    /**
     * Register a deleted model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @param int $priority
     * @return void
     */
    public static function deleted($callback, $priority = 0)
    {
        static::registerModelEvent('deleted', $callback, $priority);
    }
}
