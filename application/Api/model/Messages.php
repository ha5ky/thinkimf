<?php
/**
 * Created by PhpStorm.
 * UserModel: Administrator
 * Date: 2018/3/12
 * Time: 17:17
 */

namespace app\Api\model;

use function get_client_ip;
use function session;
use think\Db;
use think\model;
use function time;

class Messages extends Model
{
    protected $table = 'imf_data_message';

    public function getListByUid($uid)
    {
        $this->find([

        ]);
    }

}