<?php
namespace app\Portal\controller;

use think\Controller;
use app\Portal\controller\Base;

class Index extends Base
{
    public function index()
    {
        return $this->fetch('index/index');
    }

    public function aboutus()
    {
        return $this->fetch('index/about-us');
    }

    public function projecttimeline()
    {
        return $this->fetch('index/project-timeline');
    }
}
