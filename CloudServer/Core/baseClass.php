<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/5/19
 * Time: 下午1:50
 */

namespace CloudServer\Core;

use function is_object;
use function is_string;
use function serialize;

class baseClass
{
    public $result = [
        'status' => 1,
        'msg' => 'ok',
        'msg_code' => 20000,
        'data' => [

        ]
    ];

    public function json($data)
    {
        if (is_string($data)) {
            return $data;
        }
        if (is_object($data)) {
            return json_encode(serialize($data), JSON_UNESCAPED_UNICODE);
        }
        if (is_array($data)) {
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
}