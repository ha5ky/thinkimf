<?php
/**
 * Created by PhpStorm.
 * UserModel: Administrator
 * Date: 2018/3/12
 * Time: 17:17
 */

namespace app\admin\model;
use app\admin\model\Base;

class UserType extends Base
{
    protected $table = 'imf_user_type';

    public static function getRoleById($typeId)
    {
        return self::find(['id'=>$typeId])['title'];
    }
}