<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/26
 * Time: 13:39
 */

namespace app\portal\controller;

use app\portal\controller\Base;

class Education extends Base
{
    public function index()
    {

        $this->assign('title','教育');
        return $this->fetch('duty/index');
    }
}