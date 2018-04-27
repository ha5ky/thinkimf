<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/26
 * Time: 下午5:36
 */
namespace app\Portal\controller;

use app\Portal\controller\Base;
Class Partner extends Base{

    /*
     * 合伙人招募列表
     */
    public function index()
    {
        if($this->request->isPost()){

            //写入会员数据

        }else{

            return $this->fetch('partner/index');
        }
    }
}