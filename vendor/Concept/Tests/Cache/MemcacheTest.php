<?php
namespace Concept\Tests\Cache;

use Concept\Cache\Memcache;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Tests\Cache
 * @name        MemcacheTest
 * @version     0.1
 */
class MemcacheTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Memcache
     */
    protected $cache;

    /**
     * @var Memcache
     */
    protected $memcache;

    public function setUp()
    {
        $host = '127.0.0.1';
        $port = 11211;
        $this->cache = new \Memcache();
        $this->cache->connect($host, $port);
        $this->memcache = new Memcache();
        $this->memcache->connect($host, $port);
    }

    public function testGet()
    {
        $this->cache->add('test', 'test_value');
        $this->assertEquals('test_value', $this->memcache->get('test'));
        $this->assertEquals($this->cache->get('test'), $this->memcache->get('test'));
        $this->cache->flush();
        $this->assertNotEquals('test_value', $this->memcache->get('test'));
        $this->assertEquals($this->cache->get('test'), $this->memcache->get('test'));
    }

    public function testSet()
    {
        $this->memcache->set('test', 'test_value');
        $this->assertEquals('test_value', $this->cache->get('test'));
        $this->assertEquals($this->cache->get('test'), $this->memcache->get('test'));
        $this->cache->flush();
        $this->assertNotEquals('test_value', $this->memcache->get('test'));
        $this->assertEquals($this->cache->get('test'), $this->memcache->get('test'));
    }

    public function testDelete()
    {
        $this->memcache->set('test', 'test_value');
        $this->assertEquals('test_value', $this->cache->get('test'));
        $this->memcache->delete('test');
        $this->assertNotEquals('test_value', $this->memcache->get('test'));
        $this->assertFalse($this->memcache->get('test'));
    }
}
