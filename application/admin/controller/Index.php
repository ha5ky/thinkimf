<?php

namespace app\admin\controller;

use function getDomain;
use think\Controller;
use app\admin\controller\AuthAdminBase;
use app\admin\model\MenuModel;

class Index extends AuthAdminBase
{
    public function index()
    {

        $this->assign('menus',self::$Menus);
        $this->assign('domain',getDomain());

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
