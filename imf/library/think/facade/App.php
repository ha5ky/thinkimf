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
 * @see \think\App
 * @mixin \think\App
 * @method \think\App bind(string $bind) static 绑定模块或者控制器
 * @method void initialize() static 初始化应用
 * @method void init(string $module='') static 初始化模块
 * @method \think\Response run() static 执行应用
 * @method \think\App dispatch(\think\route\Dispatch $dispatch) static 设置当前请求的调度信息
 * @method void log(mixed $log, string $type = 'info') static 记录调试信息
 * @method mixed config(string $name='') static 获取配置参数
 * @method \think\route\Dispatch routeCheck() static URL路由检测（根据PATH_INFO)
 * @method \think\App routeMust(bool $must = false) static 设置应用的路由检测机制
 * @method \think\Model model(string $name = '', string $layer = 'model', bool $appendSuffix = false, string $common = 'common') static 实例化模型
 * @method object controller(string $name, string $layer = 'controller', bool $appendSuffix = false, string $empty = '') static 实例化控制器
 * @method \think\Validate validate(string $name = '', string $layer = 'validate', bool $appendSuffix = false, string $common = 'common') static 实例化验证器类
 * @method \think\db\Query db(mixed $config = [], mixed $name = false) static 数据库初始化
 * @method mixed action(string $url, $vars = [], $layer = 'controller', $appendSuffix = false) static 调用模块的操作方法
 * @method string parseClass(string $module, string $layer, string $name, bool $appendSuffix = false) static 解析应用类的类名
 * @method string version() static 获取框架版本
 * @method bool isDebug() static 是否为调试模式
 * @method string getModulePath() static 获取当前模块路径
 * @method void setModulePath(string $path) static 设置当前模块路径
 * @method string getRootPath() static 获取应用根目录
 * @method string getAppPath() static 获取应用类库目录
 * @method string getRuntimePath() static 获取应用运行时目录
 * @method string getThinkPath() static 获取核心框架目录
 * @method string getRoutePath() static 获取路由目录
 * @method string getConfigPath() static 获取应用配置目录
 * @method string getConfigExt() static 获取配置后缀
 * @method string setNamespace(string $namespace) static 设置应用类库命名空间
 * @method string getNamespace() static 获取应用类库命名空间
 * @method string getSuffix() static 是否启用类库后缀
 * @method float getBeginTime() static 获取应用开启时间
 * @method integer getBeginMem() static 获取应用初始内存占用
 * @method \think\Container container() static 获取容器实例
 */
class App extends Facade
{
}
