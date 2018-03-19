<?php

namespace app\Admin\controller;

use think\Controller;
use app\Admin\controller\AuthAdminBase;
use app\Admin\model\MenuModel;

class Index extends AdminBase
{
    public function index()
    {
//        echo 123;
//        exit;
        //MenuModel::getInfo();
        //$this->assign('lists', $program);
        return $this->fetch('index/index', [
            'code' => 200
        ]);
    }

    public function MainFrameDefault()
    {
        return $this->fetch('main_default');
    }

    public function welcome()
    {
        return $this->fetch();
    }
}
