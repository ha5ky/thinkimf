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
 * function:Auth.php
 */

namespace think\facade;

use think\Facade;

/**
 * @see \think\Lang
 * @mixin \think\Lang
 * @method mixed range($range = '') static 设定当前的语言
 * @method mixed set(mixed $name, string $value = null, string $range = '') static 设置语言定义
 * @method array load(mixed $file, string $range = '') static 加载语言定义
 * @method mixed get(string $name = null, array $vars = [], string $range = '') static 获取语言定义
 * @method mixed has(string $name, string $range = '') static 获取语言定义
 * @method string detect() static 自动侦测设置获取语言选择
 * @method void saveToCookie(string $lang = null) static 设置当前语言到Cookie
 * @method void setLangDetectVar(string $var) static 设置语言自动侦测的变量
 * @method void setLangCookieVar(string $var) static 设置语言的cookie保存变量
 * @method void setAllowLangList(array $list) static 设置允许的语言列表
 */
class Lang extends Facade
{
}
