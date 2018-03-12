<?php

namespace app\Admin\controller;

use think\Controller;
use app\Admin\controller\AuthAdminBase;

class Index extends AuthAdminBase
{
    public function index()
    {

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
        return $this->fetch('index/welcome');
    }
}
