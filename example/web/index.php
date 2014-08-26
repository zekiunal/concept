<?php
use ExampleProject\Custom\Business\User;

function dump($data) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

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

/**
 * Example
 **/
$user = new User();
$user->setEmail('zekiunal@gmail.com');
$user->setFirstName('Zeki');
$user->setLastName('Unal');
$user->setPassword('password');
$user->setUsername('zekiunal');
//$user->save();

//$user->setPassword('password_updated')->save();

$user_1 = \ExampleProject\Custom\Data\UserDA::loadById(2);
$user_1->setPassword('password_updated_2')->save();
dump($user_1);

$filter = new \ExampleProject\Custom\Filter\UserFilter();
$filter->setLimit(10);

$user_list = \ExampleProject\Custom\Data\UserDA::load($filter);

