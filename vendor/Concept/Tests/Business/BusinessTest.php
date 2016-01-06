<?php
namespace Concept\Tests\Business;

use Concept\Entity\Manager\EntityManager;
use Concept\Storage\Handler\DataProcess;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Tests\Business
 * @name        BusinessTest
 * @version     0.1
 */
class BusinessTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \User
     */
    protected $user;

    public function setUp()
    {
        /**
         * Data handler set.
         */
        $sql_configurations = array(array(
            'engine'   => 'sqlite',
            'database' => 'test.sqlite'), 3);
        $processor_configurations = array(
            'sqlite' => $sql_configurations
        );
        $processor = new DataProcess($processor_configurations);
        EntityManager::setHandler($processor);

        $this->user = new \User();
    }

    public function testBind()
    {
        $data = array(
            'user_id'  => 1,
            'username' => 'test'
        );

        $this->user->bind($data);

        $this->assertEquals($data['user_id'], $this->user->getUserId());
        $this->assertEquals($data['username'], $this->user->getUsername());
    }

    public function testConvertArray()
    {
        $this->user->setUserId(1);
        $this->user->setUsername('test');

        $data = array(
            'user_id'  => 1,
            'username' => 'test'
        );

        $this->assertSame($data, $this->user->convertArray());
    }

    public function testSave()
    {
        $this->user->setUsername('username');
        $this->assertEmpty($this->user->getId());
        $this->user->save();
        $this->assertNotEmpty($this->user->getId());
        $this->assertEquals('username', $this->user->getUsername());
    }

    public function testDelete()
    {
        $this->user->setUsername('username');
        $this->assertEmpty($this->user->getId());
        $this->user->save();
        $this->assertNotEmpty($this->user->getId());
        $this->assertEquals('username', $this->user->getUsername());
        $this->user->delete();
    }
}
