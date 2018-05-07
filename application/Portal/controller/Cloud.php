<?php
namespace app\Portal\controller;

use think\Controller;
use app\Portal\controller\Base;


class Cloud extends Base
{
    public function index()
    {

        $this->assign('title','☁️发现|设备云');
        $this->assign('ak',config('baidu_map_ak'));
        return $this->fetch('cloud/index');
    }

    public function addDevice()
    {
        if($this->request->isPost()){
        }else{
            $this->assign('ak',config('baidu_map_ak'));
            $this->assign('title','☁️设备云|添加设备');
            $this->assign('description','模拟物联网设备,实时消息服务器推送技术');
            $this->assign('keywords','模拟物联网设备,实时消息服务器推送技术');
            return $this->fetch('cloud/adddevice');
        }
    }

    public function deviceDetail()
    {
        $deviceid = $this->request->request('device',0);
        //判断 device 是否存在,不存在则跳转至设备云
        $this->assign('ak',config('baidu_map_ak'));
        $this->assign('deviceid',$deviceid);
        $this->assign('title',$deviceid.' - ☁️设备云|设备详情');
        $this->assign('description','模拟物联网设备,实时消息服务器推送技术');
        $this->assign('keywords','模拟物联网设备,实时消息服务器推送技术');
        return $this->fetch('cloud/devicedetail');
    }
}
