<?php
/**
 * Created by PhpStorm.
 * UserModel: Administrator
 * Date: 2018/3/12
 * Time: 17:17
 */

namespace app\Admin\model;
use app\Admin\model\Base;
use think\Db;
class MenuModel extends Base
{
    public $table = 'imf_menu';
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
        return [];
    }
}