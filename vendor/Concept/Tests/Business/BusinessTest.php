<?php
namespace Concept\Tests\Business;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Concept\Tests\Business
 * @name        BusinessTest
 * @version     0.1
 */
class BusinessTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \User
     */
    protected $user;

    public function setUp()
    {
        $this->user = new \User();
    }

    public function testBind()
    {
        $data = array(
            'user_id' => 1,
            'username'=> 'test'
        );

        $this->user->bind($data);

        $this->assertEquals($data['user_id'], $this->user->getUserId());
        $this->assertEquals($data['username'], $this->user->getUsername());
    }

    public function testConvertArray()
    {
        $this->user->setUserId(1);
        $this->user->setUsername('test');

        $data = array(
            'user_id' => 1,
            'username'=> 'test'
        );

        $this->assertSame($data, $this->user->convertArray());
    }


}
