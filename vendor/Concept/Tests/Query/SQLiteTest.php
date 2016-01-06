<?php
namespace Concept\Tests\Query;
use Concept\Query\SQLite;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @name        SQLiteTest
 * @version     0.1
 * @created     2016/01/06 13:54
 */
class SQLiteTest extends \PHPUnit_Framework_TestCase
{
    public function testDelete()
    {
        $source = 'user';

        $sql = SQLite::delete($source);

        $this->assertEquals('DELETE FROM `user` WHERE `user`.`user_id` = :user_id', $sql);
    }
}
