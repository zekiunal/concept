<?php
namespace Concept\Storage\Handler;

use Concept\Entity\EntityInterface;
use Concept\Entity\Manager\EntityManagerInterface;
use Concept\Filter\FilterInterface;
use Concept\Handler\HandlerInterface;
use Concept\Query\MySql as MySqlQuery;

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
     * @var \PDO
     */
    protected static $connection;

    /**
     * @var EntityManagerInterface
     */
    protected static $processor;

    public function __construct($configuration=array())
    {
        $engine = $configuration['engine'].':dbname=';
        $db = new \PDO(
            $engine.$configuration['database'].";host=".$configuration['hostname'],
            $configuration['username'],
            $configuration['password']
        );
        $db->query('SET NAMES UTF8');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        self::$connection = $db;
    }

    /**
     * @param EntityInterface $entity
     * @param                 $source
     * @param FilterInterface $filter
     *
     * @return EntityInterface
     */
    public static function save(EntityInterface $entity, $source, FilterInterface $filter)
    {
        self::$processor->save($entity, $source, $filter);

        $primary_get = "get".ucwords($source)."Id";

        $properties = ($filter->getProperties($source));

        $data = $entity->convertArray();

        $result = (
        ($entity->$primary_get() === 0 || $entity->$primary_get() === null) ?
            self::insert($data, MySqlQuery::insert($source, $properties), $properties, $source) :
            self::update($data, MySqlQuery::update($source, $properties), $properties)
        );

        $primary_set = "set".ucwords($source)."Id";
        $entity->$primary_set($result[$source.'_id']);

        return $entity;
    }

    /**
     * @author      Zeki Unal <zekiunal@gmail.com>
     * @description
     *
     * @param $data
     * @param $statement
     * @param $properties
     * @param $source
     *
     * @return       mixed
     */
    protected static function insert($data, $statement, $properties, $source)
    {
        $statement = self::$connection->prepare($statement);

        foreach ($properties as $key=>$value) {
            $statement->bindValue(':'.$value[1], $data[$value[1]]);
        }

        $statement->execute();
        $key = $source.'_id';
        $data[$key] = self::$connection->lastInsertId();
        $statement->closeCursor();
        return $data;
    }

    /**
     * @param  string  $statement
     * @param  array   $parameters
     * @param  integer $method
     *
     * @return array
     */
    protected static function runSQL($statement, $parameters, $method=\PDO::FETCH_ASSOC)
    {
        $stmt = self::$connection->prepare($statement);
        $stmt->execute($parameters);
        $result = $stmt->fetchAll($method);
        $stmt->closeCursor();
        return $result;
    }

    /**
     * @param $data
     * @param $statement
     * @param $properties
     * @return       mixed
     */
    protected static function update($data, $statement, $properties)
    {
        $statement = self::$connection->prepare($statement);

        foreach ($properties as $key=>$value) {
            $statement->bindValue(':'.$value[1], $data[$value[1]]);
        }

        $statement->execute();
        $statement->closeCursor();

        return $data;
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
        $data = self::runSQL(MySqlQuery::select($filter), $filter->getParameters());

        if ($data) {
            return $data;
        } else {
            /**
             * fetch data from next data handler
             */
            $data = self::$processor->load($filter);

            if($data) {

                /**
                 * Generate insert query for MySql database
                 */
                $query = MySqlQuery::insert($data, $filter->getSource());

                /**
                 * insert data from mysql database
                 */
                return array(self::insert($data, $query, $filter->getProperties($filter->getSource()) ,$filter->getSource()));
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
