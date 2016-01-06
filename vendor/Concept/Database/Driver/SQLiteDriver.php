<?php
namespace Concept\Database\Driver;

use PDO;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Database\Driver
 * @name        SQLiteDriver
 * @version     0.1
 */
class SQLiteDriver extends AbstractDriver
{
    /**
     * @var \PDO
     */
    protected $connection;

    /**
     * @var string
     */
    protected $charset = 'UTF-8';

    /**
     * @var string
     */
    protected $engine = 'sqlite';

    /**
     * @var string
     */
    protected $database;

    public function __construct($configuration = array())
    {
        $this->database = $configuration['database'];

        if (isset($configuration['charset'])) {
            $this->charset = $configuration['charset'];
        }

        if (isset($configuration['engine'])) {
            $this->engine = $configuration['engine'];
        }

        $db = new PDO($this->engine . ':' . $this->database);
        $db->query('SET NAMES ' . $this->charset);
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->connection = $db;
    }

    /**
     * @param  string $statement
     * @param  array $parameters
     * @param  integer $method
     *
     * @return array
     */
    public function runSQL($statement, $parameters, $method = \PDO::FETCH_ASSOC)
    {
        $stmt = $this->connection->prepare($statement);
        $stmt->execute($parameters);
        $result = $stmt->fetchAll($method);
        $stmt->closeCursor();
        return $result;
    }

    /**
     * @param $data
     * @param $statement
     * @param $properties
     * @param $source
     *
     * @return       array
     */
    public function insert(array $data, $statement, array $properties, $source)
    {
        $start_time = microtime(TRUE);
        $this->data = $data;
        $this->source = $source;
        $this->properties = $properties;
        $this->statement = $statement;

        self::fireModelEvent('inserting');

        $statement = $this->connection->prepare($statement);

        $this->bind($statement, $properties, $data);

        $statement->execute();

        $this->time = microtime(TRUE) - $start_time;

        $data[$source . '_id'] = $this->connection->lastInsertId();

        $statement->closeCursor();

        $this->data = $data;

        self::fireModelEvent('inserted');

        return $data;
    }

    /**
     * @param $data
     * @param $statement
     * @param $properties
     * @return  array
     */
    public function update($data, $statement, $properties)
    {
        $start_time = microtime(TRUE);
        $this->data = $data;
        $this->source = $properties[0][0];
        $this->properties = $properties;
        $this->statement = $statement;

        self::fireModelEvent('updating');

        $statement = $this->connection->prepare($statement);

        $this->bind($statement, $properties, $data);

        $statement->execute();

        $this->time = microtime(TRUE) - $start_time;

        $statement->closeCursor();

        $this->data = $data;

        self::fireModelEvent('updated');

        return $data;
    }

    /**
     * @param array $data
     * @param $statement
     * @param array $properties
     * @param $source
     * @return bool
     */
    public function delete(array $data, $statement, array $properties, $source)
    {
        $start_time = microtime(TRUE);
        $this->data = $data;
        $this->source = $source;
        $this->properties = $properties;
        $this->statement = $statement;

        self::fireModelEvent('deleting');

        $statement = $this->connection->prepare($statement);
        $this->bind($statement, $properties, $data);

        $statement->execute();

        $this->time = microtime(TRUE) - $start_time;

        self::fireModelEvent('deleted');

        return true;
    }

    /**
     * @param \PDOStatement $statement
     * @param  array $properties
     * @param  array $data
     */
    protected function bind(\PDOStatement $statement, array $properties, array $data)
    {

        foreach ($properties as $value) {
            if ($data[$value[1]]) {
                $statement->bindValue(':' . $value[1], $data[$value[1]]);
            }
        }
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

        $event = "monorm.sqllite_driver.{$event}";
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
        $event_name = "monorm.sqllite_driver.{$event}";
        self::registerEvent($event_name, $callback, $priority = 0);
    }
}
