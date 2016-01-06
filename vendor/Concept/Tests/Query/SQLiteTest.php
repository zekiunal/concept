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

        //$this->assertEquals('DELETE FROM `user` WHERE `user`.`user_id` = :user_id', $sql);
    }

    public function testSelect()
    {
        $filter = new \ProfileFilter();
        $filter->setProfileId(1);
        $filter->findBy('username', 'zeki');
        $filter->setUserId(1);
        $sql = SQLite::select($filter);
        echo $sql."\n";
        //$this->assertEquals('SELECT `profile`.`profile_id`, `user`.`user_id`, `user`.`username`, `user`.`type` FROM `user`, `profile` WHERE 1=1  AND `user`.`user_id`=`profile`.`user_id` AND `profile`.`profile_id`=1 AND `user`.`username`=\'zeki\' AND `user`.`user_id`=1 LIMIT 0, 30', $sql);
    }

    public function testSelect2()
    {
        $filter = new \BandFilter();
        $filter->setProfileId(1);
        $filter->findBy('username', 'zeki');
        $filter->setUserId(1);
        $filter->setBandId(1);
        $filter->findBy('band_id', 'zeki');
        $sql = SQLite::select($filter);
        echo $sql."\n";
        //$this->assertEquals('SELECT `profile`.`profile_id`, `user`.`user_id`, `user`.`username`, `user`.`type` FROM `user`, `profile` WHERE 1=1  AND `user`.`user_id`=`profile`.`user_id` AND `profile`.`profile_id`=1 AND `user`.`username`=\'zeki\' AND `user`.`user_id`=1 LIMIT 0, 30', $sql);
    }
}
