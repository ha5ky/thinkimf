<?php
/**
 *
 * ============================================================================
 * [UD DataMap BigData System] Copyright (c) 1995-2028 www.unnnnn.com
 * 版权所有 1995-2028 UD数据信息有限公司【中国】，并保留所有权利。
 * This is not  free soft ware, use is subject to license.txt
 * 网站地址: http://www.unnnnn.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: 陈建华 $
 * $Create Time: 2018/2/9 0009 $
 * email:unnnnn@foxmail.com
 * function:Auth.php
 */

namespace think\facade;

use think\Facade;

/**
 * @see \think\Response
 * @mixin \think\Response
 * @method \think\response create(mixed $data = '', string $type = '', int $code = 200, array $header = [], array $options = []) static 创建Response对象
 * @method void send() static 发送数据到客户端
 * @method \think\Response options(mixed $options = []) static 输出的参数
 * @method \think\Response data(mixed $data) static 输出数据设置
 * @method \think\Response header(mixed $name, string $value = null) static 设置响应头
 * @method \think\Response content(mixed $content) static 设置页面输出内容
 * @method \think\Response code(int $code) static 发送HTTP状态
 * @method \think\Response lastModified(string $time) static LastModified
 * @method \think\Response expires(string $time) static expires
 * @method \think\Response eTag(string $eTag) static eTag
 * @method \think\Response cacheControl(string $cache) static 页面缓存控制
 * @method \think\Response contentType(string $contentType, string $charset = 'utf-8') static 页面输出类型
 * @method mixed getHeader(string $name) static 获取头部信息
 * @method mixed getData() static 获取原始数据
 * @method mixed getContent() static 获取输出数据
 * @method int getCode() static 获取状态码
 */
class Response extends Facade
{
}
