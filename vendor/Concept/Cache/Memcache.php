<?php
namespace Concept\Cache;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Cache
 * @name        Memcache
 * @version     0.1
 */
class Memcache implements CacheInterface
{
    /**
     * @var Memcache
     */
    protected $cache;

    /**
     * @param     $host
     * @param int $port
     */
    public function connect($host, $port=11211)
    {
        try {
            $this->cache = new \Memcache();
            $this->cache->connect($host, $port);
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";exit;
        }
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->cache->get($key);
    }

    /**
     * @param string $key
     * @param mixed  $data
     *
     * @return mixed
     */
    public function set($key, $data)
    {
        $this->cache->set($key, $data);
        return $data;
    }

    /**
     * @param string $key
     *
     * @return boolean
     */
    public function delete($key)
    {
        $this->cache->delete($key);
        return true;
    }
}
