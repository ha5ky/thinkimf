<?php
/**
 *
 * ============================================================================
 * [UD DataMap BigData System] Copyright (c) 1995-2028 www.unnnnn.com
 * 版权所有 1995-2028 UD数据信息有限公司【中国】，并保留所有权利。
 * This is not  free soft ware, use is subject to license.txt
 * 网站地址: http://www.unnnnn.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: 刘亚博 $
 * $Create Time: 2018/3/17 0009 $
 * email:554251986@qq.com
 * function:Device.php
 */

namespace app\Admin\controller;

use app\Admin\model\Devcilent;
use think\Controller;
use think\Request;
use app\Admin\model\Device as DeviceModel;
use app\Admin\model\Devcilent as DevclientModel;

class Device extends AdminBase
{
    public function map()
    {
        //获取上线的设备
        $devclientList = Devcilent::getList();
        $this->assign('devclientList', $devclientList);
        return $this->fetch('device/map');
    }

    public function getList()
    {
        DevclientModel::getList();

    }

    public function index()
    {
        return 'device index';
    }

}