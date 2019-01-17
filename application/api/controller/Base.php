<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/26
 * Time: 上午2:12
 */

namespace app\api\controller;

use function is_array;
use function json_encode;
use function RedisInstance;
use think\Controller;

class Base extends Controller
{
    public $redis = null;

    public function json($code = 1, $message = '', $data = [])
    {
        header('Content-type: application/json');
        exit(json_encode([
            'code'    => $code,
            'message' => $message,
            'data'    => $data
        ], JSON_UNESCAPED_UNICODE));
    }
}