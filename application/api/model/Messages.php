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
use function time;

class Messages extends \think\Model
{
    protected $table = 'imf_data_message';

    public function getListByUid($uid)
    {
        $this->find([

        ]);
    }

}