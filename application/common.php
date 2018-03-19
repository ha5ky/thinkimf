<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
if (!function_exists("imf_user_login")) {
    function imf_admin_login()
    {
        if (empty($_SESSION['userid'])) {
            header('Location:/admin/user/login');
        }
    }
};
function imf_rand_str($length = 8, $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'):String
{
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= $str[mt_rand(0, strlen($str) - 1)];
    }
    return $string;
}

