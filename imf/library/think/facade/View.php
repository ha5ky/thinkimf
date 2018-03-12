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
 * @see \think\View
 * @mixin \think\View
 * @method \think\View init(mixed $engine = [], array $replace = []) static 初始化
 * @method \think\View share(mixed $name, mixed $value = '') static 模板变量静态赋值
 * @method \think\View assign(mixed $name, mixed $value = '') static 模板变量赋值
 * @method \think\View config(mixed $name, mixed $value = '') static 配置模板引擎
 * @method \think\View exists(mixed $name) static 检查模板是否存在
 * @method \think\View filter(Callable $filter) static 视图内容过滤
 * @method \think\View engine(mixed $engine = []) static 设置当前模板解析的引擎
 * @method string fetch(string $template = '', array $vars = [], array $replace = [], array $config = [], bool $renderContent = false) static 解析和获取模板内容
 * @method string display(string $content = '', array $vars = [], array $replace = [], array $config = []) static 渲染内容输出
 */
class View extends Facade
{
}
