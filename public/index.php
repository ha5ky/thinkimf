<?php
/**
 *
 * ============================================================================
 * [Innovation Framework] Copyright (c) 1995-2028 www.thinkimf.com;
 * 版权所有 1995-2028 陈建华/陈炼/DyoungChen/Dyoung【中国】，并保留所有权利。
 * This is not  free soft ware, use is subject to license.txt
 * 网站地址: http://www.thinkimf.com;
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；作者是一个还要还房贷的码农,请尊重作者的劳动成果,商业用途和技术支持请联系QQ:1367784103。
 * ============================================================================
 * $Author: 陈建华 $
 * $Create Time: 2018/2/9 0009 $
 * email:dyoungchen@gmail.com
 * function:auth.php
 */

// [ 应用入口文件 ]
namespace think;
//网页主色调 #1E9FFF
use function dirname;
use function header;
use function realpath;

define('THINKIMF_VERSION', '1.36.201802');
define('IN_THINKIMF', true);
define('APP_ROOT', __DIR__);
define('SOURCE_ROOT', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
header("Content-Type:charset=utf-8"); // 允许任意域名发起的跨域请求
header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求
//设置options访问
header("Access-Control-Allow-Headers:Origin, X-Requested-With, Content-Type, Accept"); // 允许域名请求头
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
    exit;
}
require 'waf.php';
// 加载基础文件
require __DIR__ . '/../imf/base.php';

// 执行应用并响应
Container::get('app')->run()->send();