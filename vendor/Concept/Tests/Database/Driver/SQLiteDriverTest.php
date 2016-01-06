<?php
namespace Concept\Tests\Database\Driver;

use Concept\Database\Driver\SQLiteDriver;
use Concept\Entity\Manager\EntityManager;
use Concept\Query\SQLite;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Tests\Database\Driver
 * @name        SQLiteDriverTest
 * @version     0.1
 */
class SQLiteDriverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SQLiteDriver
     */
    protected $driver;

    public function setUp()
    {
        $configuration = array(
            'engine'   => 'sqlite',
            'database' => 'test.sqlite');
        $this->driver = new SQLiteDriver($configuration);
    }

    /*
    public function testInsert()
    {
        $data = array(
            'user_id'  => null,
            'username' => 'username_' . rand(1, 10000)
        );

        $sql = 'INSERT INTO `user` (`user_id`, `username`) VALUES (:user_id, :username)';

        $properties = array(
            array('user', 'user_id'),
            array('user', 'username')
        );

        $source = 'user';
        $result = $this->driver->insert($data, $sql, $properties, $source);

        $this->assertArrayHasKey('user_id', $result);
        $this->assertNotEmpty($result['user_id']);
        $this->assertNotEmpty($result['username']);
        $this->assertEquals($result['username'], $data['username']);
    }

    public function testUpdate()
    {
        $result = $this->driver->runSQL('SELECT * FROM user', array());
        $user = $result[rand(0, count($result) - 1)];

        $data = array('user_id' => $user['user_id'], 'username' => 'username_driver_update_test_random_updated');
        $sql = 'UPDATE `user` SET `username` = :username WHERE `user_id` = :user_id';

        $properties = array(array('user', 'user_id'), array('user', 'username'));
        $source = 'user';
        $result = $this->driver->update($data, $sql, $properties, $source);

        $this->assertEquals('username_driver_update_test_random_updated', $result['username']);
        $this->assertEquals($user['user_id'], $result['user_id']);
    }

    public function testRunSQL()
    {
        $sql = 'SELECT * FROM user';
        $result = $this->driver->runSQL($sql, array());

        $this->assertGreaterThan(0, count($result));
    }

    public function testDelete()
    {
        $entity = new \User();
        $entity->setId(401);

        $source = EntityManager::getEntitySource($entity);

        $data = array(
            $source . '_id' => $entity->getId()
        );

        $properties = array(
            array('user', 'user_id')
        );

        $statement = SQLite::delete($source);

        $this->driver->delete($data, $statement, $properties, $source);
    }
*/
    public function testEvents()
    {
        SQLiteDriver::inserted(function (SQLiteDriver $event) {
            echo 'inserted' . " " .
                $event->getStatement() . " " .
                $event->getTime() . " " .
                json_encode($event->getData()) .
                json_encode($event->getProperties()) .
                "\n";
        });

        $data = array(
            'user_id'  => null,
            'username' => 'username_' . rand(1, 10000)
        );

        $sql = 'INSERT INTO `user` (`user_id`, `username`) VALUES (:user_id, :username)';

        $properties = array(
            array('user', 'user_id'),
            array('user', 'username')
        );

        $source = 'user';
        $result = $this->driver->insert($data, $sql, $properties, $source);
    }
}
