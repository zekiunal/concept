<?php
$loader = new \Phalcon\Loader();
$loader->registerNamespaces(array(
    'Concept' => 'vendor\Concept'
));
$loader->register();

$cache = new \Concept\Cache\GlobalCache(array('key'=>'value'));