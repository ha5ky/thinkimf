<?php
/**
 * Created by PhpStorm.
 * UserModel: Administrator
 * Date: 2018/3/12
 * Time: 17:17
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;
class MenuModel extends Base
{
    public $table = 'imf_menu';
    public static function getInfo()
    {

    }
    public static function getAllMenu()
    {
        $menus = self::where('parent_id',0)->select()->toArray();
        return $menus;
    }

    public static function AllList()
    {
        $menus = self::where('')->select()->toArray();
        return $menus;
    }

    public static function getUserMenus($userid):array
    {
        return [];
    }

    public function MenuList($parent_id):array
    {
        return [];
    }
}