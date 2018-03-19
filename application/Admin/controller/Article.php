<?php

use app\Admin\controller\AdminBase;

/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/3/19
 * Time: 下午10:50
 */
class Article extends AdminBase{
    public function index()
    {
        return $this->fetch('article/index');
    }
}