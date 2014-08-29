<?php
/**
 * register classes with namespaces
 */
include_once '../../../example/library/ClassLoader/Loader.php';

$loader = new \ClassLoader\Loader('Concept', '../../../vendor');
$loader->register();