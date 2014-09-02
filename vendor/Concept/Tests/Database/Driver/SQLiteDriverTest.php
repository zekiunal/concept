<?php
namespace Concept\Tests\Database\Driver;

use Concept\Database\Driver\SQLiteDriver;

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

    public function testInsert()
    {
        $data = array('user_id' => null);
        $sql = 'INSERT INTO `user` (`user_id`) VALUES (:user_id)';
        $properties = array(array('user','user_id'));
        $source = 'user';
        $result = $this->driver->insert($data, $sql, $properties, $source);

        $this->assertArrayHasKey('user_id', $result);
        $this->assertNotEmpty($result['user_id']);
    }

    public function testUpdate()
    {
        $result = $this->driver->runSQL('SELECT * FROM user',array());
        $user = $result[rand(0,count($result)-1)];
        $data = array('user_id' => $user['user_id'], 'username'=>'new username');
        $sql = 'UPDATE `user` SET `username` = :username WHERE `user_id` = :user_id' ;
        $properties = array(array('user','user_id'), array('user', 'username'));
        $source = 'user';
        $result = $this->driver->update($data, $sql, $properties, $source);

        $this->assertEquals('new username', $result['username']);
        $this->assertEquals($user['user_id'], $result['user_id']);
    }

    public function testRunSQL()
    {
        $sql = 'SELECT * FROM user';
        $result = $this->driver->runSQL($sql, array());

        $this->assertGreaterThan(0, count($result));

    }
}
