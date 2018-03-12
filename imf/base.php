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

namespace think;

// 载入Loader类
require __DIR__ . '/library/think/Loader.php';

// 注册自动加载
Loader::register();

// 注册错误和异常处理机制
Error::register();

// 实现日志接口
if (interface_exists('Psr\Log\LoggerInterface')) {
    interface LoggerInterface extends \Psr\Log\LoggerInterface
    {
    }
} else {
    interface LoggerInterface
    {
    }
}

// 注册核心类到容器
Container::getInstance()->bind([
    'app' => App::class,
    'build' => Build::class,
    'cache' => Cache::class,
    'config' => Config::class,
    'cookie' => Cookie::class,
    'debug' => Debug::class,
    'env' => Env::class,
    'hook' => Hook::class,
    'lang' => Lang::class,
    'log' => Log::class,
    'request' => Request::class,
    'response' => Response::class,
    'route' => Route::class,
    'session' => Session::class,
    'url' => Url::class,
    'validate' => Validate::class,
    'view' => View::class,
    'middlewareDispatcher' => http\middleware\Dispatcher::class,
    // 接口依赖注入
    'think\LoggerInterface' => Log::class,
]);

// 注册核心类的静态代理
Facade::bind([
    facade\App::class => App::class,
    facade\Build::class => Build::class,
    facade\Cache::class => Cache::class,
    facade\Config::class => Config::class,
    facade\Cookie::class => Cookie::class,
    facade\Debug::class => Debug::class,
    facade\Env::class => Env::class,
    facade\Hook::class => Hook::class,
    facade\Lang::class => Lang::class,
    facade\Log::class => Log::class,
    facade\Request::class => Request::class,
    facade\Response::class => Response::class,
    facade\Route::class => Route::class,
    facade\Session::class => Session::class,
    facade\Url::class => Url::class,
    facade\Validate::class => Validate::class,
    facade\View::class => View::class,
]);

// 注册类库别名
Loader::addClassAlias([
    'App' => facade\App::class,
    'Build' => facade\Build::class,
    'Cache' => facade\Cache::class,
    'Config' => facade\Config::class,
    'Cookie' => facade\Cookie::class,
    'Db' => Db::class,
    'Debug' => facade\Debug::class,
    'Env' => facade\Env::class,
    'Facade' => Facade::class,
    'Hook' => facade\Hook::class,
    'Lang' => facade\Lang::class,
    'Log' => facade\Log::class,
    'Request' => facade\Request::class,
    'Response' => facade\Response::class,
    'Route' => facade\Route::class,
    'Session' => facade\Session::class,
    'Url' => facade\Url::class,
    'Validate' => facade\Validate::class,
    'View' => facade\View::class,
]);

// 加载惯例配置文件
facade\Config::set(include __DIR__ . '/convention.php');

// 加载composer autofile文件
Loader::loadComposerAutoloadFiles();
