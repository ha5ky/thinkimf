<?php
/**
 * Created by PhpStorm.
 * UserModel: Administrator
 * Date: 2018/3/12
 * Time: 17:17
 */

namespace app\api\model;

use function get_client_ip;
use function session;
use think\Db;
use think\model;
use function time;

class Device extends Model
{
    protected $table = 'imf_device';

    public function add($data)
    {

        $this->appid = $data['appid'];
        $this->appsecret = $data['appsecret'];
        $this->device_id = $data['device_id'];
        $this->device_name = $data['name'];
        $this->device_type = json_encode((object)$data['type']);
        $this->version = $data['version'];
        $this->uuid = session('userid');
        $this->status = 1;
        $this->location = $data['location'];
        $this->create_at = time();
        $this->update_at = time();
        $this->baidu_map_poi = $data['baidu_map_poi'];
        $this->is_fake = $data['is_fake'];
        $this->accept_cloud = $data['accept_cloud'];
        $this->upload_cloud = $data['upload_cloud'];
        $this->desc = $data['desc'];
        $this->tech_way = $data['tech_way'];
        $this->ip = get_client_ip();
        $this->province = $data['province'];
        $this->city = $data['city'];
        $this->district = $data['district'];
        $this->street = $data['street'];
        $f = $this->save();
        if($f){
        	return $data['device_id'];
        }else{
        	return false;
        }
    }

}