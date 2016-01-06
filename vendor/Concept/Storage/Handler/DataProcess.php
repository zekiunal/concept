<?php
namespace Concept\Storage\Handler;

use Concept\Entity\EntityInterface;
use Concept\Entity\Manager\EntityManagerInterface;
use Concept\Filter\FilterInterface;
use Concept\Handler\HandlerInterface;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Storage\Handler
 * @name        DataProcess
 * @version     0.1
 */
class DataProcess implements EntityManagerInterface
{
    /**
     * @var HandlerInterface
     */
    protected static $processor;

    /**
     * DataProcess constructor.
     * @param array $configuration
     */
    public function __construct($configuration = array())
    {
        $k = 0;

        /**
         * @var HandlerInterface|false $parent
         */
        $parent = false;

        foreach ($configuration as $key => $value) {

            $config = $value[0];
            $handler = $this->getProcessor($key, $config);

            if ($k === 0) {
                self::$processor = $handler;
            }

            if ($parent !== false) {
                $parent->setSuccessor($handler);
            }

            $parent = $handler;
            $k++;
        }

        if ($parent) {
            $parent->setSuccessor(new NullHandler());
        } else {
            self::$processor = new NullHandler();
        }

    }

    /**
     * @param string $key
     * @param array $config
     * @return          HandlerInterface
     */
    protected function getProcessor($key, $config = array())
    {
        switch ($key) {
            case 'global_cache' :
                return new GlobalCache($config);
            case 'mysql' :
                return new MySql($config);
            case 'sqlite' :
                return new SQLite($config);
            /*
            case 'redis' :
                return new Redis($config);
            case 'redis_cache' :
                return new RedisCache($config);

            case 'memcache' :
                return new Memcache($config);
            case 'mongodb' :
                return new Mongo($config);
            */
        }

        return false;
    }

    /**
     * @param EntityInterface $entity
     * @param boolean $process
     *
     * @return array|false
     */
    public static function save(EntityInterface $entity, $process = false)
    {
        return self::$processor->save($entity, $process);
    }

    /**
     * @param        FilterInterface $filter
     *
     * @return       array|bool
     */
    public static function load(FilterInterface $filter)
    {
        return self::$processor->load($filter);
    }

    /**
     * @param $name
     * @param $id
     *
     * @return bool
     */
    public static function delete($name, $id)
    {
        return self::$processor->delete($name, $id);
    }
}
