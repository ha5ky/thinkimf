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

namespace think\route\dispatch;

use think\Container;
use think\exception\ClassNotFoundException;
use think\exception\HttpException;
use think\Loader;
use think\route\Dispatch;

class Module extends Dispatch
{
    public function run()
    {
        $result = $this->dispatch;

        if (is_string($result)) {
            $result = explode('/', $result);
        }

        if ($this->app->config('app.app_multi_module')) {
            // 多模块部署
            $module    = strip_tags(strtolower($result[0] ?: $this->app->config('app.default_module')));
            $bind      = $this->app['route']->getBind();
            $available = false;

            if ($bind && preg_match('/^[a-z]/is', $bind)) {
                // 绑定模块
                list($bindModule) = explode('/', $bind);
                if (empty($result[0])) {
                    $module = $bindModule;
                }
                $available = true;
            } elseif (!in_array($module, $this->app->config('app.deny_module_list')) && is_dir($this->app->getAppPath() . $module)) {
                $available = true;
            } elseif ($this->app->config('app.empty_module')) {
                $module    = $this->app->config('app.empty_module');
                $available = true;
            }

            // 模块初始化
            if ($module && $available) {
                // 初始化模块
                $this->app['request']->module($module);
                $this->app->init($module);

                // 加载当前模块语言包
                $this->app['lang']->load($this->app->getAppPath() . $module . '/lang/' . $this->app['request']->langset() . '.php');

                // 模块请求缓存检查
                $this->app['request']->cache(
                    $this->app->config('app.request_cache'),
                    $this->app->config('app.request_cache_expire'),
                    $this->app->config('app.request_cache_except')
                );
            } else {
                throw new HttpException(404, 'module not exists:' . $module);
            }
        } else {
            // 单一模块部署
            $module = '';
            $this->app['request']->module($module);
        }

        // 当前模块路径
        $this->app->setModulePath($this->app->getAppPath() . ($module ? $module . '/' : ''));

        // 是否自动转换控制器和操作名
        $convert = is_bool($this->convert) ? $this->convert : $this->app->config('app.url_convert');
        // 获取控制器名
        $controller = strip_tags($result[1] ?: $this->app->config('app.default_controller'));
        $controller = $convert ? strtolower($controller) : $controller;

        // 获取操作名
        $actionName = strip_tags($result[2] ?: $this->app->config('app.default_action'));
        $actionName = $convert ? strtolower($actionName) : $actionName;

        // 设置当前请求的控制器、操作
        $this->app['request']->controller(Loader::parseName($controller, 1))->action($actionName);

        // 监听module_init
        $this->app['hook']->listen('module_init');

        // 实例化控制器
        try {
            $instance = $this->app->controller($controller,
                $this->app->config('app.url_controller_layer'),
                $this->app->config('app.controller_suffix'),
                $this->app->config('app.empty_controller'));
        } catch (ClassNotFoundException $e) {
            throw new HttpException(404, 'controller not exists:' . $e->getClass());
        }

        // 获取当前操作名
        $action = $actionName . $this->app->config('app.action_suffix');

        if (is_callable([$instance, $action])) {
            // 执行操作方法
            $call = [$instance, $action];
            // 自动获取请求变量
            $vars = $this->app->config('app.url_param_type')
            ? $this->app['request']->route()
            : $this->app['request']->param();
        } elseif (is_callable([$instance, '_empty'])) {
            // 空操作
            $call = [$instance, '_empty'];
            $vars = [$actionName];
        } else {
            // 操作不存在
            throw new HttpException(404, 'method not exists:' . get_class($instance) . '->' . $action . '()');
        }

        $this->app['hook']->listen('action_begin', $call);

        return Container::getInstance()->invokeMethod($call, $vars);
    }
}
