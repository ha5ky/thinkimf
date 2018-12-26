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

namespace think\facade;

use think\Facade;

/**
 * @see \think\Config
 * @mixin \think\Config
 * @method bool has(string $name) static 检测配置是否存在
 * @method array pull(string $name) static 获取一级配置
 * @method mixed get(string $name) static 获取配置参数
 * @method mixed set(string $name, mixed $value = null) static 设置配置参数
 * @method array reset(string $prefix ='') static 重置配置参数
 */
class Config extends Facade
{
}
