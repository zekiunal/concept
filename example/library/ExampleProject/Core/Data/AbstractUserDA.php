<?php
namespace ExampleProject\Core\Data;

use Concept\Entity\EntityInterface;
use Concept\Entity\Manager\EntityManager;
use ExampleProject\Custom\Business\User;
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
     * @param User $entity
     *
     * @return User
     */
    public static function save(User $entity)
    {
        return EntityManager::save($entity, 'user', new UserFilter());
    }
}
