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
    public function testGet()
    {
        $GLOBALS['concept_gc']['test'] = 'test_value';
        $cache = new GlobalCache();
        $this->assertEquals('test_value', $cache->get('test'));
        $this->assertArrayHasKey('test', $GLOBALS['concept_gc']);
    }

    public function testSet()
    {
        $cache = new GlobalCache();
        $cache->set('test','test_value');
        $this->assertEquals('test_value', $cache->get('test'));
        $this->assertArrayHasKey('test', $GLOBALS['concept_gc']);
    }

    public function testDelete()
    {
        $cache = new GlobalCache();
        $cache->set('test','test_value');
        $this->assertArrayHasKey('test', $GLOBALS['concept_gc']);
        $cache->delete('test');
        $this->assertArrayNotHasKey('test', $GLOBALS['concept_gc']);
    }
}
