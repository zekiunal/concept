<?php
namespace Concept\Cache;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Cache
 * @name        Redis
 * @version     0.1
 */
class Redis implements CacheInterface
{
    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        // TODO: Implement get() method.
    }

    /**
     * @param string $key
     * @param mixed $data
     *
     * @return mixed
     */
    public function set($key, $data)
    {
        // TODO: Implement set() method.
    }

    /**
     * @param string $key
     *
     * @return boolean
     */
    public function delete($key)
    {
        // TODO: Implement delete() method.
    }
}
