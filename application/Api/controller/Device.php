<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/26
 * Time: 上午2:30
 */
namespace app\Api\controller;
use app\Api\controller\Base;
use function strtolower;
use function uniqueString;

class Device extends Base{

    public function getdeviceid()
    {
        return $this->json([
            'code'=>200,
            'msg'=>'ok',
            'uuid'=> strtolower('imf'.uniqueString(32))
        ]);
    }

    /*
     * 手动添加设备
     */
    public function handAddDevice()
    {
        
    }

    /*
     * 自动添加设备
     */
    public function autoAddDevice()
    {
        
    }
}