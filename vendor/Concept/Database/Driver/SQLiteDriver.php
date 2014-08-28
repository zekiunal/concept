<?php
namespace Concept\Database\Driver;

class SQLiteDriver
{
    /**
     * @var \PDO
     */
    protected $connection;

    public function __construct($configuration=array())
    {
        $engine = $configuration['engine'].':';
        $db = new \PDO(
            $engine.$configuration['database']
        );
        $db->query('SET NAMES UTF8');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->connection = $db;
    }

    /**
     * @param  string  $statement
     * @param  array   $parameters
     * @param  integer $method
     *
     * @return array
     */
    public function runSQL($statement, $parameters, $method=\PDO::FETCH_ASSOC)
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
        $statement = $this->connection->prepare($statement);

        foreach ($properties as $value) {
            $statement->bindValue(':'.$value[1], $data[$value[1]]);
        }

        $statement->execute();
        $key = $source.'_id';
        $data[$key] = $this->connection->lastInsertId();
        $statement->closeCursor();
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
        $statement = $this->connection->prepare($statement);

        foreach ($properties as $value) {
            $statement->bindValue(':'.$value[1], $data[$value[1]]);
        }

        $statement->execute();
        $statement->closeCursor();

        return $data;
    }
}
