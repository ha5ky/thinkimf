<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/26
 * Time: 上午2:12
 */
namespace app\api\controller;
use think\Controller;

class AuthBase extends Controller{
    public $redis = null;
    //返回json数据
    public function json($re)
    {
        if($re){
            header('Content-type: application/json');
            exit(json_encode($re,JSON_UNESCAPED_UNICODE));
        }else{
            exit('response data not correct!');
        }
    }

}