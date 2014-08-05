<?php
namespace Concept\Cache;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Cache
 * @name        CacheInterface
 * @version     0.1
 */
interface CacheInterface
{
    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @param string $key
     * @param mixed $data
     *
     * @return mixed
     */
    public function set($key, $data);

    /**
     * @param string $key
     *
     * @return boolean
     */
    public function delete($key);
}
