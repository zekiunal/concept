<?php
/**
 * register classes with namespaces
 */
include_once '../library/ClassLoader/Loader.php';
$loader = new \ClassLoader\Loader('Concept', '../../vendor');
$loader->register();
$loader = new \ClassLoader\Loader('ExampleProject', '../library');
$loader->register();

/**
 * Bootstrap
 */
$mysql_configurations = array(array(
    'engine'   => 'mysql',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => 'mysql',
    'database' => 'test'),3);
$processor_configurations = array(
    'mysql'           => $mysql_configurations
);
$processor = new \Concept\Storage\Handler\DataProcess($processor_configurations);
\Concept\Entity\Manager\EntityManager::setHandler($processor);