<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/26
 * Time: 下午5:36
 */
namespace app\portal\controller;

use app\portal\controller\Base;
use app\portal\model\PartnerModel;
use function json;

Class Partner extends Base{

    /*
     * 合伙人招募列表
     */
    public function index()
    {
        if($this->request->isPost()){
            $data = $this->request->post();
            //写入会员数据
            $partner = new PartnerModel();
            $f = $partner->save($data);
            if($f){
                return $this->json([
                    'code'=>200,
                    'msg'=>'数据提交成功,我们及时联系你'
                ]);
            }else{
                return $this->json([
                    'code'=>400123,
                    'msg'=>'数据提交失败,你可以加入我们的QQ群:'
                ]);
            }


        }else{

            $this->assign('title','合伙人招募');
            return $this->fetch('partner/index');
        }
    }
}