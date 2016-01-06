<?php
namespace Concept\Storage\Handler;

use Concept\Entity\EntityInterface;
use Concept\Entity\Manager\EntityManager;
use Concept\Entity\Manager\EntityManagerInterface;
use Concept\Filter\FilterInterface;
use Concept\Handler\HandlerInterface;
use Concept\Query\MySql as MySqlQuery;
use Concept\Database\Driver\MySqlDriver;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Storage\Handler
 * @name        MySql
 * @version     0.1
 */
class MySql implements HandlerInterface, EntityManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected static $processor;

    /**
     * @var MySqlDriver
     */
    protected static $driver;

    /**
     * MySql constructor.
     * @param array $configuration
     */
    public function __construct($configuration = array())
    {
        self::$driver = new MySqlDriver($configuration);
    }

    /**
     * @param EntityInterface $entity
     * @param boolean $process
     *
     * @return EntityInterface
     */
    public static function save(EntityInterface $entity, $process = false)
    {
        $filter = EntityManager::getEntityFilter($entity);
        $source = EntityManager::getEntitySource($entity);

        if ($process) self::$processor->save($entity, $process);

        $properties = ($filter->getProperties($source));

        $data = $entity->convertArray();

        $result = (
        ($entity->getId() === 0 || $entity->getId() === null) ?
            self::$driver->insert($data, MySqlQuery::insert($source, $properties, $data), $properties, $source) :
            self::$driver->update($data, MySqlQuery::update($source, $properties, $data), $properties)
        );

        $entity->setId($result[$source . '_id']);

        return $entity;
    }

    /**
     * @param        FilterInterface $filter
     *
     * @return       array
     */
    public static function load(FilterInterface $filter)
    {
        /**
         * fetch data from mysql database
         */
        $data = self::$driver->runSQL(MySqlQuery::select($filter), $filter->getParameters());

        if ($data) {
            return $data;
        } else {
            /**
             * fetch data from next data handler
             */
            $data = self::$processor->load($filter);

            if ($data) {
                /**
                 * insert data from mysql database
                 */
                return array(
                    self::$driver->insert($data, MySqlQuery::insert($data, $filter->getSource()), $filter->getProperties($filter->getSource()), $filter->getSource())
                );
            }
        }
        return array();
    }

    /**
     * @param $name
     * @param $id
     *
     * @return bool
     */
    public static function delete($name, $id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param HandlerInterface $processor
     */
    public function setSuccessor(HandlerInterface $processor)
    {
        self::$processor = $processor;
    }
}
