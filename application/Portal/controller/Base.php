<?php
namespace app\Portal\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct();
        if ($request->isMobile()) {
            $this->view->config('view_path','themes/default/mobile/' . $request->module() . "/");
        } else {
            $this->view->config('view_path','themes/default/web/' . $request->module() . "/");
        }
    }
}
