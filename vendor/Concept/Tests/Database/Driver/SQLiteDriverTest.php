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
        $data = array(
            'user_id' => null,
            'username' => 'username_'.rand(1,10000)
        );

        $sql = 'INSERT INTO `user` (`user_id`, `username`) VALUES (:user_id, :username)';

        $properties = array(
            array('user','user_id'),
            array('user','username')
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
        $result = $this->driver->runSQL('SELECT * FROM user',array());
        $user = $result[rand(0,count($result)-1)];

        $data = array('user_id' => $user['user_id'], 'username'=>'username_driver_update_test_random_updated');
        $sql = 'UPDATE `user` SET `username` = :username WHERE `user_id` = :user_id' ;

        $properties = array(array('user','user_id'), array('user', 'username'));
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
}
