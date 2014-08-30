<?php
namespace ExampleProject\Core\Data;

use Concept\Entity\Manager\EntityManager;
use ExampleProject\Custom\Business\User;
use ExampleProject\Custom\Collection\UserCollection;
use ExampleProject\Custom\Filter\UserFilter;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     ExampleProject\Core\Data
 * @name        AbstractUserDA
 * @version     0.1
 */
abstract class AbstractUserDA
{
    /**
     * @param        int   $user_id
     *
     * @return       User|false
     */
    public static function loadById($user_id)
    {
        $filter = new UserFilter();
        $filter->setUserId($user_id);
        $data = EntityManager::load($filter);
        $result = self::bind($data);
        if($result->count() > 0) {
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
        return self::bind(EntityManager::load($filter));
    }

    /**
     * @param User $entity
     *
     * @return User
     */
    public static function save(User $entity)
    {
        return EntityManager::save($entity, 'user');
    }

    /**
     * @param  array          $array
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
