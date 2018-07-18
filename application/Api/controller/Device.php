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
use app\Api\model\Device as DeviceModel;
use function get_client_ip;
use function imf_admin_login;
use function RedisInstance;
use function strtoupper;
use function time;
use function uniqueString;

class Device extends Base
{

    public function getDevice()
    {
        $appid = genUuid();
        $secret = strtoupper(uniqueString(32));
        $deviceId = strtoupper(uniqueString(32));
        $clientIp = get_client_ip();

//        //写入数据
//        $app = new App();
//        $app->appid = $appid;
//        $app->secret = $secret;
//        $app->ip = $clientIp;
//        $app->create_at = time();
//        $app->device_id = $deviceId;
//	    $app->save()
        if ($deviceId) {
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
        $pid = $this->request->request('pid', 0);
        $level = $this->request->request('level', 0);

        $types = DeviceType::Where([
            'parent' => $pid,
            'level' => $level
        ])->order(['t_id' => 'asc'])->group('name')->select()->toArray();
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
    public function AddDevice()
    {
	    if (!session('userid')) {
		    return $this->json([
			    'code' => 40001,
			    'msg' => '请先登录',
			    'data' => []
		    ]);
	    }
        $data = $this->request->post();
        $device = new \app\Api\model\Device();

        $device_id = $device->add($data);
        //信息保存到 redis
        if ($device_id) {
            RedisInstance()->set('device' . $data['device_id'], 1);
            return $this->json([
                'code' => 200,
                'msg' => 'ok',
                'data' => [
                	'device_id'=>$device_id
                ]
            ]);
        } else {
            return $this->json([
                'code' => 41677,
                'msg' => '添加失败',
                'data' => []
            ]);
        }

    }

    /*
     * 删除一台设备
     */
    public function deleteDevice()
    {

    }

    /*
     * 修改一台设备信息
     */
    public function editDevice()
    {

    }

    /*
     * list 某一设备
     */
    public function list()
    {

    }

    /*
     * list 所有设备
     */
    public function CloudList()
    {
        $condition = [];
        $province = $this->request->get('province', false);
        $city = $this->request->get('province', false);
        $district = $this->request->get('district', false);
        if($province){
            $condition['province'] = $province;
        }
        if($city){
            $condition['city'] = $city;
        }
        if($district){
            $condition['district'] = $district;
        }
        $page = $this->request->get('page', 1);
        $page_size = $this->request->get('page_size', 500);
        $offset = ($page - 1) * $page_size;
        $list = DeviceModel::where([])
            ->field(['device_id',
                'device_name',
                'version',
                'desc',
                'ip',
                'city',
                'location',
                'icon',
                'map_marker',
                'baidu_map_poi'])
            ->limit($offset, $page_size)
            ->select()
            ->toArray();
        //todo
        //处理是否在线
        if ($list) {
            $result = [
                'code' => 200,
                'status' => 1,
                'msg' => 'ok',
                'msg_code' => 0,
                'data' => $list
            ];
        } else {
            $result = [
                'code' => 40023,
                'status' => -1,
                'msg' => 'no data',
                'msg_code' => 0,
                'data' => []
            ];
        }
        return $this->json($result);
    }

    /*
     * check 一台设备是否在线
     */
    public function checkOnline()
    {
        $deviceId = $this->request->get('device_id');
        $deviceIdKey = 'device' . $deviceId;
        if (RedisInstance()->exists($deviceIdKey)) {
            $result = [
                'code' => 200,
                'status' => 1,
                'msg' => 'ok',
                'msg_code' => 0,
                'data' => []
            ];
        } else {
            $result = [
                'code' => 505,
                'status' => -1,
                'msg' => 'not online',
                'msg_code' => 0,
                'data' => []
            ];
        }
        return $this->json($result);
    }

    public function deviceDetail()
    {
        $deviceId = $this->request->get('device_id');
        if (1) {
            $result = [
                'code' => 200,
                'status' => 1,
                'msg' => 'ok',
                'msg_code' => 0,
                'data' => []
            ];
        } else {
            $result = [
                'code' => 505,
                'status' => -1,
                'msg' => 'not online',
                'msg_code' => 0,
                'data' => []
            ];
        }
        return $this->json($result);
    }
}