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


User::created(function(){echo "created<br>";});
User::saved(function(){ echo "saved<br>";});
User::updated(function(){echo "updated<br>";});

\Concept\Database\Driver\MySqlDriver::inserted(function(\Concept\Database\Driver\MySqlDriver $driver) {
    echo $driver->getStatement()."<br>";
    var_dump($driver->getData());
    var_dump($driver->getProperties());
});

/**
 * Example
 **/
$user = new User();
$user->setEmail('zekiunal@gmail.com');
$user->setFirstName('Zeki');
$user->setLastName('Unal');
$user->setPassword('password'.rand());
$user->setUsername('zekiunal');
$user->save();

//$user->setPassword('password_updated')->save();

$user_1 = \ExampleProject\Custom\Data\UserDA::loadById(2);
$user_1->setPassword('password_updated_2')->save();
dump($user_1);

$filter = new \ExampleProject\Custom\Filter\UserFilter();
$filter->setLimit(10);
$filter->findBy('password','password',true);

$user_list = \ExampleProject\Custom\Data\UserDA::load($filter);
dump($user_list);

\Concept\Storage\Handler\Mysql::save($user);
