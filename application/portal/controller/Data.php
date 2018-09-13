<?php
namespace app\portal\controller;

use think\Controller;
use app\portal\controller\Base;
use app\api\model\Device;

class Data extends Base
{
    /**
     * @desc 数据详情中心，展示数据
     * @return mixed
     */
    public function index()
    {

        $this->assign('title','数据中心');
        return $this->fetch('data/index');
    }
}
