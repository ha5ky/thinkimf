<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/26
 * Time: 13:39
 */

namespace app\portal\controller;

use app\portal\controller\Base;

class Lib extends Base
{
    public function index()
    {

        $this->assign('title', '实验室');
        return $this->fetch('lib/index');
    }

    /**
     * 信息救助
     */
    public function infoHelpOrg()
    {

    }



}