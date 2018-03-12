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
 * @see \think\Route
 * @mixin \think\Route
 * @method \think\route\Domain domain(mixed $name, mixed $rule = '', array $option = [], array $pattern = []) static 注册域名路由
 * @method \think\Route pattern(mixed $name, string $rule = '') static 注册变量规则
 * @method \think\Route option(mixed $name, mixed $value = '') static 注册路由参数
 * @method \think\Route bind(string $bind) static 设置路由绑定
 * @method mixed getBind(string $bind) static 读取路由绑定
 * @method \think\Route name(string $name) static 设置当前路由标识
 * @method mixed getName(string $name) static 读取路由标识
 * @method void setName(string $name) static 批量导入路由标识
 * @method void import(array $rules, string $type = '*') static 导入配置文件的路由规则
 * @method \think\route\RuleItem rule(string $rule, mixed $route, string $method = '*', array $option = [], array $pattern = []) static 注册路由规则
 * @method void rules(string $rules, string $method = '*', array $option = [], array $pattern = []) static 批量注册路由规则
 * @method \think\route\RuleGroup group(string $name, mixed $route, string $method = '*', array $option = [], array $pattern = []) static 注册路由分组
 * @method \think\route\RuleItem any(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册路由
 * @method \think\route\RuleItem get(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册路由
 * @method \think\route\RuleItem post(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册路由
 * @method \think\route\RuleItem put(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册路由
 * @method \think\route\RuleItem delete(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册路由
 * @method \think\route\RuleItem patch(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册路由
 * @method \think\route\Resource resource(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册资源路由
 * @method \think\Route controller(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册控制器路由
 * @method \think\Route alias(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册别名路由
 * @method \think\Route setMethodPrefix(mixed $method, string $prefix = '') static 设置不同请求类型下面的方法前缀
 * @method \think\Route rest(string $name, array $resource = []) static rest方法定义和修改
 * @method \think\RuleItem miss(string $route, string $method = '*', array $option = []) static 注册未匹配路由规则后的处理
 * @method \think\RuleItem auto(string $route) static 注册一个自动解析的URL路由
 * @method \think\Dispatch check(string $url, string $depr = '/', bool $must = false, bool $completeMatch = false) static 检测URL路由
 */
class Route extends Facade
{
}
