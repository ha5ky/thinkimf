<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/12
 * Time: 17:17
 */

namespace app\Admin\model;

use think\Db;

class Device extends Base
{
    protected $table = 'imf_device';

    public static function getList()
    {
        print_r(self::all());
        exit;
    }

    //生成一批devices code
    public static function returnDeviceID()
    {

        for ($i = 0; $i < 10; $i++) {
            $str = substr(md5(time() . mt_rand(1, 1000000)), 0, 10);
            self::insert([
                "type" => "遥控车",
                "series" => "by-ccar",
                "dev_id" => $str,
                "name" => "智能遥控车".$i,
                "version"=>"v.0.1",
                "user_id"=>1
            ]);
        }
    }

}