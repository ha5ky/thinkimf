<?php
namespace app\install\controller;

use const APP_ROOT;
use function realpath;
use const SOURCE_ROOT;
use think\Controller;
use think\Request;

class Base extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct();

	    $this->view->config('view_path','themes/default/web/' . $request->module() . "/");

    }

    public function json($re)
    {
        header('content-type:application/json');
        exit(json_encode($re,JSON_UNESCAPED_UNICODE));
    }

}
