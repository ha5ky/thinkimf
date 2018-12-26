<?php

namespace app\api\model;

use think\Model;

/**
 * 存储用户appid，app_secret等值，为每个用户分配对应的值，生成access_token
 */
class Oauth extends Model
{

    /**
     * 表名,
     */
    protected $table = 'cfg_oauth';

    /**
     * 只读
     */
    protected $readonly = ['app_key'];

    // 设置返回数据集为数组
    protected $resultSetType = '';

    /**
     * 验证合法的appkey
     * @param appkey
     * @return true|false
     */
    public function checkAppkey($app_key = '')
    {
        #
    }

    /**
     * @desc 身份认证，使用身份证，学生证，工作证等任意证件都可以
     */
    public function identifyVerify()
    {

    }

    /**
     * @desc 我的认证证书
     */
    public function myCertificate()
    {
        
    }
}