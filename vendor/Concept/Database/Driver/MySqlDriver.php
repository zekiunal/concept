<?php
namespace Concept\Database\Driver;

use Concept\EventDispatcher\EventDispatcher;
use Concept\EventDispatcher\EventDispatcherInterface;

class MySqlDriver extends AbstractDriver
{
    /**
     * @var \PDO
     */
    protected $connection;

    public function __construct($configuration = array())
    {
        $engine = $configuration['engine'] . ':dbname=';
        $db = new \PDO(
            $engine . $configuration['database'] . ";host=" . $configuration['hostname'],
            $configuration['username'],
            $configuration['password']
        );
        $db->query('SET NAMES UTF8');
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

        $event = "monorm.mysql_driver.{$event}";
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
        $event_name = "monorm.mysql_driver.{$event}";
        self::registerEvent($event_name, $callback, $priority = 0);
    }
}
