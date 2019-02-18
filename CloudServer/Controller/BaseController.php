<?php

/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/5/19
 * Time: 下午10:48
 */

namespace CloudServer\Controller;


Class BaseController
{
    public $result = [
        'code' => 1,
        'msg'  => 'ok',
        'data' => null
    ];

    public function __construct()
    {
        $this->result['data'] = new \stdClass();
    }

    public function json($re)
    {
        if (is_array($re)) {
            exit(json_encode($re, JSON_UNESCAPED_UNICODE));
        }
        if (is_object($re)) {
            exit(json_encode(serialize($re), JSON_UNESCAPED_UNICODE));
        }
        return false;
    }
}