<?php
namespace Concept\Tests\Cache;

use Concept\Cache\GlobalCache;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Tests\Cache
 * @name        GlobalCacheTest
 * @version     0.1
 */
class GlobalCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GlobalCache
     */
    protected $cache;

    public function setUp()
    {
        $configuration = array(
            'prefix' => 'concept_test_gc'
        );
        $this->cache = new GlobalCache($configuration);
    }

    public function testGet()
    {
        $GLOBALS['concept_test_gc']['test'] = 'test_value';
        $this->assertEquals('test_value', $this->cache->get('test'));
        $this->assertArrayHasKey('test', $GLOBALS['concept_test_gc']);
    }

    public function testSet()
    {
        $this->cache->set('test', 'test_value');
        $this->assertEquals('test_value', $this->cache->get('test'));
        $this->assertArrayHasKey('test', $GLOBALS['concept_test_gc']);
    }

    public function testDelete()
    {
        $this->cache->set('test', 'test_value');
        $this->assertArrayHasKey('test', $GLOBALS['concept_test_gc']);
        $this->cache->delete('test');
        $this->assertArrayNotHasKey('test', $GLOBALS['concept_test_gc']);
    }
}
