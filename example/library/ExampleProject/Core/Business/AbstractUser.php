<?php
namespace ExampleProject\Core\Business;

use Concept\Business\AbstractBusiness;
use ExampleProject\Custom\Business\User;

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
     * @var mixed
     */
    protected $user_id;

    /**
     * EntityInterface implementation of convertArray()
     *
     * @return array
     */
    public function convertArray()
    {
        // TODO: Implement convertArray() method.
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
}
