<?php
namespace Concept\Cache;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Cache
 * @name        GlobalCache
 * @version     0.1
 */
class GlobalCache implements CacheInterface
{
    /**
     * @var array
     */
    protected $cache;

    private $config = array(
        'prefix' => 'monorm_gc'
    );

    /**
     * @todo array merge fix
     * @param array $configuration
     */
    public function __construct($configuration=array())
    {
        $this->config = array_merge($configuration, $this->config);
        $GLOBALS[$this->config['prefix']] = array();
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return isset($GLOBALS[$this->config['prefix']][$key]) ? $GLOBALS[$this->config['prefix']][$key] : false;
    }

    /**
     * @param string $key
     * @param mixed $data
     *
     * @return mixed
     */
    public function set($key, $data)
    {
        $GLOBALS[$this->config['prefix']][$key] = $data;
        return $GLOBALS[$this->config['prefix']][$key];
    }

    /**
     * @param string $key
     *
     * @return boolean
     */
    public function delete($key)
    {
        unset($GLOBALS[$this->config['prefix']][$key]);
        return true;
    }
}
