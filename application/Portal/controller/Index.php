<?php
namespace app\Portal\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
       /* if ($this->request->isMobile()) {
            config('template.view_path', 'template/default/mobile/' . $request->module() . "/");
        } else {
            config('template.view_path', 'template/default/web/' . $request->module() . "/");
        }*/
        echo 'index';
    }
}
