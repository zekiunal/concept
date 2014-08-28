<?php
namespace ExampleProject\Tests\Business;

use ExampleProject\Custom\Business\User;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     ExampleProject\Tests\Business
 * @name        UserTest
 * @version     0.1
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testConvertArray()
    {
        $user = new User();
        $user->setId(1);
        $user->setUsername('username');
        $user->setEmail('test@email.com');
        $user->setPassword('password');
        $user->setFirstName('first_name');
        $user->setLastName('last_name');

        $user_array = $user->convertArray();

        $data['user_id']    = 1;
        $data['username']   = 'username';
        $data['email']      = 'test@email.com';
        $data['password']   = 'password';
        $data['first_name'] = 'first_name';
        $data['last_name']  = 'last_name';

        $this->assertSame($user_array, $data);
    }

    public function testBind()
    {
        $data['user_id']    = 1;
        $data['username']   = 'username';
        $data['email']      = 'test@email.com';
        $data['password']   = 'password';
        $data['first_name'] = 'first_name';
        $data['last_name']  = 'last_name';

        $user = new User();
        $user->bind($data);

        $this->assertSame($user->convertArray(), $data);
    }

    public function testSave()
    {
        $user = new User();
        $user->setUsername('username');
        $user->setEmail('test@email.com');
        $user->setPassword('password');
        $user->setFirstName('first_name');
        $user->setLastName('last_name');
        $this->assertEmpty($user->getId());
        $user->save();
        $this->assertNotEmpty($user->getId());
    }

    public function testUpdate()
    {
        $user = new User();
        $user->setUsername('username');
        $user->setEmail('test@email.com');
        $user->setPassword('password');
        $user->setFirstName('first_name');
        $user->setLastName('last_name');
        $this->assertEmpty($user->getId());
        $user->save();
        $this->assertNotEmpty($user->getId());
        $user->setFirstName('updated_first_name');
        $user->save();

        $this->assertEquals($user->getFirstName(), 'updated_first_name');

    }
}
