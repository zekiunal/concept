<?php
$loader = new \Phalcon\Loader();
$loader->registerNamespaces(array(
    'Concept'       => 'vendor\Concept',
    'ProjectName'   => 'ProjectName'
));
$loader->register();

$mysql  = array(array('engine' => 'mysql', 'hostname' => 'production1.mysql.monapi.com', 'username' => 'root', 'password' => 'monapi@2014', 'database' => 'test2'), 3);
$global = array(array('prefix' => 'my_custom_prefix'), 1);

$configuration = array(
    'global_cache'    => $global,
    'mysql'           => $mysql,
);

$processor = new \Concept\Storage\Handler\DataProcess($configuration);

\Concept\Entity\Manager\EntityManager::setHandler($processor);

$user = new \ProjectName\Custom\Entity\User();
$user->setUsername("zekiunal");
$user->setEmail('zekiunal@gmail.com');
$user->setLastName('Unal');
$user->setFirstName('Zeki');
$user->setPassword(md5(21331));
$user->save();
