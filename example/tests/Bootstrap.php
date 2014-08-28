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
$sql_configurations = array(array(
    'engine'   => 'sqlite',
    'database' => 'test.sqlite'),3);
$processor_configurations = array(
    'sqlite'           => $sql_configurations
);
$processor = new \Concept\Storage\Handler\DataProcess($processor_configurations);
\Concept\Entity\Manager\EntityManager::setHandler($processor);