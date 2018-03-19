<?php
/**
 * Created by PhpStorm.
 * UserModel: Administrator
 * Date: 2018/3/12
 * Time: 17:17
 */

namespace app\Admin\model;

class MenuModel extends Base
{
    public static function getInfo()
    {

    }

    public static function getUserMenus($userid):array
    {
        //self::query();
        return [];
    }

    public function MenuList($parent_id):array
    {
        $this->where()
             ->whereOr()
             ->toArray();
        return [];
    }
}