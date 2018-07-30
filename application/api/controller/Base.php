<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/26
 * Time: 上午2:12
 */
namespace app\api\controller;
use function is_array;
use function json_encode;
use function RedisInstance;
use think\Controller;
class Base extends Controller{
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
        $this->redis = RedisInstance();
    }
}