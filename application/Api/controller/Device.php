<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/26
 * Time: 上午2:30
 */

namespace app\Api\controller;

use app\Admin\model\App;
use app\Admin\model\DeviceType;
use function get_client_ip;
use function strtolower;
use function strtoupper;
use function time;
use function uniqueString;
use function var_dump;

class Device extends Base
{

    public function getDevice()
    {
        $appid = genUuid();
        $secret = strtoupper(uniqueString(32));
        $deviceId = strtoupper(uniqueString(32));
        $clientIp = get_client_ip();

        //写入数据
        $app = new App();
        $app->appid = $appid;
        $app->secret = $secret;
        $app->ip = $clientIp;
        $app->create_at = time();
        $app->device_id = $deviceId;
        if ($app->save()) {
            return $this->json([
                'code' => 200,
                'msg' => 'ok',
                'data' => [
                    'appid' => $appid,
                    'appsecret' => $secret,
                    'deviceid' => $deviceId,
                    'ip' => $clientIp
                ]
            ]);
        } else {
            return $this->json([
                'code' => 400134,
                'msg' => '数据获取太过频繁'
            ]);
        }

    }

    public function getDeviceType()
    {
        $pid = $this->request->request('pid',0);
        $level = $this->request->request('level',0);

        $types = DeviceType::Where([
            'parent'=>$pid,
            'level'=>$level
        ])->order(['t_id'=>'asc'])->group('name')->select()->toArray();
        if ($types) {
            return $this->json([
                'code' => 200,
                'msg' => 'ok',
                'data' => $types
            ]);
        } else {
            return $this->json([
                'code' => 400135,
                'msg' => '分组获取失败'
            ]);
        }

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