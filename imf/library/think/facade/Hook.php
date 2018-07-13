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
 * @see \think\Hook
 * @mixin \think\Hook
 * @method \think\Hook alias(mixed $name, mixed $behavior = null) static 指定行为标识
 * @method void add(string $tag, mixed $behavior, bool $first = false) static 动态添加行为扩展到某个标签
 * @method void import(array $tags, bool $recursive = true) static 批量导入插件
 * @method array get(string $tag = '') static 获取插件信息
 * @method mixed listen(string $tag, mixed $params = null, bool $once = false) static 监听标签的行为
 * @method mixed exec(mixed $class, mixed $params = null) static 执行行为
 */
class Hook extends Facade
{
}
