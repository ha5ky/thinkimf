<?php
/**
 * Created by PhpStorm.
 * UserModel: Administrator
 * Date: 2018/3/12
 * Time: 17:17
 */

namespace app\admin\model;

use think\Db;

class Devcilent extends Base
{
    protected $table = 'imf_devclient';

    //获取上线的设备
    public static function getList()
    {
        $returnDevclient = [];
        $devclientList = self::alias('dc')->where(["dc.status" => 0])
            ->join('imf_device d', 'd.dev_id = dc.dev_id')
            ->field("dc.location,d.dev_id,d.type,d.name")->select()->toArray();

        foreach ($devclientList as $key => $val) {
            $location = explode(",",$val["location"]);
            $returnDevclient[] = [
                trim($location[0]),
                trim($location[1]),
                "设备类型:" . $val["type"] . "<br>设备ID:" . $val["dev_id"] . "<br>设备名称:" . $val["name"],
            ];
        }

        return json_encode($returnDevclient,true);
    }

    //上线一批devices code
    public static function returnDeviceID()
    {

        $arr = Device::all()->toArray();
        foreach ($arr as $key => $val) {
            self::insert([
                "dev_id" => $val["dev_id"]
            ]);
        }
        exit;
    }

}