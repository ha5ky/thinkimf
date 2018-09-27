<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/26
 * Time: 13:39
 */

namespace app\portal\controller;

use app\portal\controller\Base;

class Duty extends Base
{
    public function index()
    {

        $this->assign('title','社会责任');
        return $this->fetch('duty/index');
    }
}