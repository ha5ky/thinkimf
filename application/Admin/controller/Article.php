<?php

namespace app\Admin\controller;

use app\Admin\controller\AdminBase;
use app\Admin\model\Post;

/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/3/19
 * Time: 下午10:50
 */
class Article extends AdminBase
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