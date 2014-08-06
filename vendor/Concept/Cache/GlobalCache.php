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

    /**
     * @var array
     */
    private $config = array(
        'prefix' => 'concept_gc'
    );

    /**
     * @param array $configuration
     */
    public function __construct($configuration=array())
    {
        $this->config = $configuration + $this->config;
        $GLOBALS[$this->config['prefix']] = array();
    }

    /**
     * Fetches an entry from the storage.
     *
     * @param string $key
     * @param boolean $default The default value to return if $key is not found
     *
     * @return mixed
     */
    public function get($key, $default = false)
    {
        return $this->getPersistentData($key, $default);
    }

    /**
     * Puts data into the storage.
     *
     * @param string $key
     * @param mixed $data
     *
     * @return mixed
     */
    public function set($key, $data)
    {
        $this->setPersistentData($key, $data);
        return $data;
    }

    /**
     * Deletes a entry from storage.
     *
     * @param string $key
     *
     * @return boolean
     */
    public function delete($key)
    {
        $this->clearPersistentData($key);
        return true;
    }

    /**
     * Stores the given ($key, $value) pair, so that future calls to
     * getPersistentData($key) return $value. This call may be in another request.
     *
     * @param string $key
     * @param array $value
     *
     * @return void
     */
    protected function setPersistentData($key, $value)
    {
        $var_name = $this->constructVariableName($key);
        $GLOBALS[$this->config['prefix']][$var_name] = $value;
    }

    /**
     * Get the data for $key, persisted by setPersistentData()
     *
     * @param string $key The key of the data to retrieve
     * @param boolean $default The default value to return if $key is not found
     *
     * @return mixed
     */
    protected function getPersistentData($key, $default = false)
    {
        $var_name = $this->constructVariableName($key);
        return isset($GLOBALS[$this->config['prefix']][$var_name]) ? $GLOBALS[$this->config['prefix']][$var_name] : $default;
    }

    /**
     * Clear the data with $key from the persistent storage
     *
     * @param string $key
     *
     * @return void
     */
    protected function clearPersistentData($key)
    {
        $var_name = $this->constructVariableName($key);
        if (isset($GLOBALS[$this->config['prefix']][$var_name])) {
            unset($GLOBALS[$this->config['prefix']][$var_name]);
        }
    }

    /**
     * Clear all data from the persistent storage
     *
     * @return void
     */
    protected function clearAllPersistentData()
    {
        if (isset($GLOBALS[$this->config['prefix']])) {
            unset($GLOBALS[$this->config['prefix']]);
        }
    }

    /**
     * Constructs and returns the name of the key.
     *
     * @see setPersistentData()
     * @param string $key The key for which the variable name to construct.
     *
     * @return string The name of the key.
     */
    protected function constructVariableName($key)
    {
        return $key;
    }
}
