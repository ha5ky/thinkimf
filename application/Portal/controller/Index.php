<?php
namespace app\Portal\controller;

use think\Controller;
use app\Portal\controller\Base;

class Index extends Base
{
    public function index()
    {
        $this->assign('title','首页');
        return $this->fetch('index/index');
    }

    public function aboutus()
    {
        $this->assign('title','关于我们');
        return $this->fetch('index/about-us');
    }

    public function projecttimeline()
    {
        $this->assign('title','项目时间线');
        return $this->fetch('index/project-timeline');
    }
}
