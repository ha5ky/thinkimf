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
 * @see \think\Log
 * @mixin \think\Log
 * @method \think\Log init(array $config = []) static 日志初始化
 * @method mixed getLog(string $type = '') static 获取日志信息
 * @method \think\Log record(mixed $msg, string $type = 'info', array $context = []) static 记录日志信息
 * @method \think\Log clear() static 清空日志信息
 * @method \think\Log key(string $key) static 当前日志记录的授权key
 * @method bool check(array $config) static 检查日志写入权限
 * @method bool save() static 保存调试信息
 * @method void write(mixed $msg, string $type = 'info', bool $force = false) static 实时写入日志信息
 * @method void log(string $level,mixed $message, array $context = []) static 记录日志信息
 * @method void emergency(mixed $message, array $context = []) static 记录emergency信息
 * @method void alert(mixed $message, array $context = []) static 记录alert信息
 * @method void critical(mixed $message, array $context = []) static 记录critical信息
 * @method void error(mixed $message, array $context = []) static 记录error信息
 * @method void warning(mixed $message, array $context = []) static 记录warning信息
 * @method void notice(mixed $message, array $context = []) static 记录notice信息
 * @method void info(mixed $message, array $context = []) static 记录info信息
 * @method void debug(mixed $message, array $context = []) static 记录debug信息
 * @method void sql(mixed $message, array $context = []) static 记录sql信息
 */
class Log extends Facade
{
}
