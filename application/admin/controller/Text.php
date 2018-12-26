<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/3/19
 * Time: 下午10:50
 */
namespace app\admin\controller;

use app\admin\controller\AdminBase;
use app\admin\controller\AuthAdminBase;
use app\admin\model\Post;
use think\Config;

class Text extends AuthAdminBase
{
    public function index()
    {

        $list = Post::getList();
        //print_r($list->render());
        $this->assign('','',false);
        $this->assign("hello",html_entity_decode("<h1>111111111</h1>"));

        //exit;
        $this->assign("articles", $list);
        return $this->fetch();
    }
}