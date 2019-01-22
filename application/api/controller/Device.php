<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/26
 * Time: 上午2:30
 */

namespace app\api\controller;

use app\admin\model\App;
use app\admin\model\DeviceType;
use app\api\model\Device as DeviceModel;
use function get_client_ip;
use function imf_admin_login;
use function RedisInstance;
use function strtoupper;
use function time;
use function uniqueString;

class Device extends Base
{
    public function initialize()
    {
        /*if (!session('userid')) {
            return $this->json([
                'code' => 40001,
                'msg' => '请先登录',
                'data' => []
            ]);
        }*/
    }

    public function getDevice()
    {
        $appid    = genUuid();
        $secret   = strtoupper(uniqueString(32));
        $deviceId = strtoupper(uniqueString(32));
        $clientIp = get_client_ip();

//        //写入数据
//        $app = new app();
//        $app->appid = $appid;
//        $app->secret = $secret;
//        $app->ip = $clientIp;
//        $app->create_at = time();
//        $app->device_id = $deviceId;
//	    $app->save()
        if ($deviceId) {
            $this->json(1, 'ok', [
                'appid'     => $appid,
                'appsecret' => $secret,
                'deviceid'  => $deviceId,
                'ip'        => $clientIp
            ]);
        } else {
            $this->json('400134', '数据获取太过频繁');
        }

    }

    public function getDeviceType()
    {
        $pid   = $this->request->request('pid', 0);
        $level = $this->request->request('level', 0);

        $types = DeviceType::Where([
            'parent' => $pid,
            'level'  => $level
        ])->order(['t_id' => 'asc'])->group('name')->select()->toArray();
        if ($types) {
            return $this->json(1, 'ok', $types);
        } else {
            return $this->json(400135, '分组获取失败');
        }

    }

    /**
     * @desc 设备列表
     * @author chenjianhua
     * @version v1.0
     */
    public function deviceList()
    {
        $page      = $this->request->get('page', 1);
        $page_size = $this->request->get('limit', 10);

        $offset = ($page - 1) * $page_size;
        $total  = DeviceModel::where([['status','<>',100]])
            ->field(['device_id', 'device_name', 'desc', 'status', 'location', 'create_at'])->count();
        $list   = DeviceModel::where([['status','<>',100]])
            ->field(['device_id', 'device_name', 'desc', 'status', 'location', 'create_at'])
            ->limit($offset,$page_size)->select()
            ->toArray();
        foreach ($list as $k=>$v){
            $list[$k]['create_at'] = date('Y-m-d H:i:s',$v['create_at']);
        }
        //处理是否在线
        if ($list) {
            $this->json(1, "成功", ['total' => $total, 'rows' => $list]);
        } else {
            $this->json(-1, "获取失败");
        }
    }

    /*
     * 手动添加设备
     */
    public function AddDevice()
    {
        $data   = $this->request->post();
        $device = new \app\api\model\Device();

        $device_id = $device->add($data);
        //信息保存到 redis
        if ($device_id) {
            //RedisInstance()->set('device' . $data['device_id'], 1);
            return $this->json(1, 'ok', ['device_id' => $device_id]);
        } else {
            $this->json(-1, '添加失败');
        }
    }

    /*
     * 删除一台设备
     */
    public function deleteDevice()
    {
        $data   = $this->request->post();
        $device = new \app\api\model\Device();
        if (empty($data['device_id']) || !is_string($data['device_id']))
            $this->json(-1, 'device_id为空或者格式不正确');
        $find = \app\api\model\Device::get(['device_id' => $data['device_id']]);
        if (!$find) {
            $this->json(-1, 'deviceid 为' . $data['device_id'] . '的数据记录不存在');
        }
        $delete = $device->softRemove($data['device_id']);
        //信息保存到 redis
        if ($delete) {
            //RedisInstance()->del('device' . $data['device_id'], 1);
            $this->json(1, '删除成功', ['device_id' => $data['device_id']]);
        } else {
            $this->json(-1, '删除失败');
        }
    }

    /*
     * 修改一台设备信息
     */
    public function editDevice()
    {
        $deviceId = $this->request->post('device_id');

    }


    public function CloudList()
    {
        $condition = [];
        $province  = $this->request->get('province', false);
        $city      = $this->request->get('city', false);
        $district  = $this->request->get('district', false);
        $page      = $this->request->get('page', 1);
        $page_size = $this->request->get('page_size', 500);

        if ($province) {
            $condition['province'] = $province;
        }
        if ($city) {
            $condition['city'] = $city;
        }
        if ($district) {
            $condition['district'] = $district;
        }

        $offset = ($page - 1) * $page_size;
        $list   = DeviceModel::where([])
            ->field(['device_id', 'device_name', 'version', 'desc', 'ip', 'city', 'location', 'icon', 'map_marker', 'baidu_map_poi'])
            ->limit($offset, $page_size)->select()->toArray();
        //处理是否在线
        if ($list) {
            $this->json(1, "成功", ['list' => $list]);
        } else {
            $this->json(-1, "获取失败");
        }
    }

    /*
     * check 一台设备是否在线
     */
    public function checkOnline()
    {
        $deviceId    = $this->request->get('device_id');
        $deviceIdKey = 'device' . $deviceId;
        if (RedisInstance()->exists($deviceIdKey)) {
            $this->json(1, "成功", []);
        } else {
            $this->json(-1, "失败");
        }
    }

    public function deviceDetail()
    {
        $deviceId = $this->request->get('device_id');
        if ($deviceId) {
            $this->json(1, "成功", []);
        } else {
            $this->json(-1, "失败");
        }
    }
}