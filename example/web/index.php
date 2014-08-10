<?php
include_once '../library/ClassLoader/Loader.php';

// register classes with namespaces
$loader = new \ClassLoader\Loader('Concept', '../../vendor');
$loader->register();
$loader = new \ClassLoader\Loader('ExampleProject', '../library');
$loader->register();

$user = new \ExampleProject\Custom\Business\User();

echo $user->setId(2)->getId();
