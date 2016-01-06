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

    public function testSelect()
    {
        $filter = new \ProfileFilter();
        $filter->setProfileId(1);
        $filter->findBy('username', 'zeki');
        $filter->setUserId(1);
        $sql = SQLite::select($filter);
        $this->assertEquals('SELECT `profile`.`profile_id`, `user`.`user_id`, `user`.`username` FROM `user`, `profile` WHERE 1=1  AND `profile`.`profile_id`=1 AND `user`.`username`=\'zeki\' AND `user`.`user_id`=1 LIMIT 0, 30', $sql);
    }
}
