<?php
namespace Concept\Tests\Storage\Handler;

use Concept\Storage\Handler\SQLite;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Tests\Storage\Handler
 * @name        MemcacheTest
 * @version     0.1
 */
class SQLiteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SQLite
     */
    protected $handler;

    public function setUp()
    {
        $configuration = array(
            'engine'   => 'sqlite',
            'database' => 'test.sqlite');
        $this->handler = new SQLite($configuration);
    }

    public function testSave()
    {
        $entity = new \User();
        $this->assertEmpty($entity->getId());
        $user = $this->handler->save($entity);

        $this->assertNotEmpty($entity->getId());
        $this->assertEquals($user->getId(), $entity->getId());
        $this->assertInstanceOf('User', $user);
        $this->assertSame($user, $entity);
    }

    public function testLoad()
    {
        $entity = new \User();
        $user = $this->handler->save($entity);

        $filter = new \UserFilter();
        $filter->setId($user->getId());

        $this->assertSame($this->handler->load($filter), array($user->convertArray()));
    }
}
