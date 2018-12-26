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
 * @see \think\Session
 * @mixin \think\Session
 * @method void init(array $config = []) static session初始化
 * @method bool has(string $name,string $prefix = null) static 判断session数据
 * @method mixed prefix(string $prefix = '') static 设置或者获取session作用域（前缀）
 * @method mixed get(string $name,string $prefix = null) static session获取
 * @method mixed pull(string $name,string $prefix = null) static session获取并删除
 * @method void push(string $key, mixed $value) static 添加数据到一个session数组
 * @method void set(string $name, mixed $value , string $prefix = null) static 设置session数据
 * @method void flash(string $name, mixed $value = null) static session设置 下一次请求有效
 * @method void flush() static 清空当前请求的session数据
 * @method void delete(string $name, string $prefix = null) static 删除session数据
 * @method void clear($prefix = null) static 清空session数据
 * @method void start() static 启动session
 * @method void destroy() static 销毁session
 * @method void pause() static 暂停session
 * @method void regenerate(bool $delete = false) static 重新生成session_id
 */
class Session extends Facade
{
}
