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

use think\exception\HttpException;
use think\Loader;
use think\route\Dispatch;

class Url extends Dispatch
{
    public function run()
    {
        // 解析默认的URL规则
        $url    = str_replace($this->param['depr'], '|', $this->dispatch);
        $result = $this->parseUrl($url);

        return (new Module($result))->run();
    }

    /**
     * 解析URL地址
     * @access protected
     * @param  string    $url URL
     * @return array
     */
    protected function parseUrl($url)
    {
        $router = $this->app['route'];
        $bind   = $router->getBind();
        $depr   = $this->param['depr'];

        if (!empty($bind) && preg_match('/^[a-z]/is', $bind)) {
            $bind = str_replace('/', $depr, $bind);
            // 如果有模块/控制器绑定
            $url = $bind . ('.' != substr($bind, -1) ? $depr : '') . ltrim($url, $depr);
        }

        list($path, $var) = $this->parseUrlPath($url);
        if (empty($path)) {
            return [null, null, null];
        }

        // 解析模块
        $module = $this->app->config('app_multi_module') ? array_shift($path) : null;
        if ($this->param['auto_search']) {
            $controller = $this->autoFindController($module, $path);
        } else {
            // 解析控制器
            $controller = !empty($path) ? array_shift($path) : null;
        }

        // 解析操作
        $action = !empty($path) ? array_shift($path) : null;

        // 解析额外参数
        if ($path) {
            if ($this->app['config']->get('url_param_type')) {
                $var += $path;
            } else {
                preg_replace_callback('/(\w+)\|([^\|]+)/', function ($match) use (&$var) {
                    $var[$match[1]] = strip_tags($match[2]);
                }, implode('|', $path));
            }
        }

        $panDomain = $this->app['request']->panDomain();
        if ($panDomain && $key = array_search('*', $var)) {
            // 泛域名赋值
            $var[$key] = $panDomain;
        }

        // 设置当前请求的参数
        $this->app['request']->route($var);

        // 封装路由
        $route = [$module, $controller, $action];

        if ($this->hasDefinedRoute($route, $bind)) {
            throw new HttpException(404, 'invalid request:' . str_replace('|', $depr, $url));
        }

        return $route;
    }

    /**
     * 检查URL是否已经定义过路由
     * @access protected
     * @param  string    $route  路由信息
     * @param  string    $bind   绑定信息
     * @return bool
     */
    protected function hasDefinedRoute($route, $bind)
    {
        list($module, $controller, $action) = $route;

        // 检查地址是否被定义过路由
        $name = strtolower($module . '/' . Loader::parseName($controller, 1) . '/' . $action);

        $name2 = '';

        if (empty($module) || $module == $bind) {
            $name2 = strtolower(Loader::parseName($controller, 1) . '/' . $action);
        }

        $router = $this->app['route'];

        if ($router->getName($name) || $router->getName($name2)) {
            return true;
        }

        return false;
    }

    /**
     * 自动定位控制器类
     * @access protected
     * @param  string    $module 模块名
     * @param  array     $path   URL
     * @return string
     */
    protected function autoFindController($module, &$path)
    {
        $dir    = $this->app->getAppPath() . ($module ? $module . '/' : '') . $this->app->config('url_controller_layer');
        $suffix = $this->app->getSuffix() || $this->app->config('controller_suffix') ? ucfirst($this->app->config('url_controller_layer')) : '';

        $item = [];
        $find = false;

        foreach ($path as $val) {
            $item[] = $val;
            $file   = $dir . '/' . str_replace('.', '/', $val) . $suffix . '.php';
            $file   = pathinfo($file, PATHINFO_DIRNAME) . '/' . Loader::parseName(pathinfo($file, PATHINFO_FILENAME), 1) . '.php';
            if (is_file($file)) {
                $find = true;
                break;
            } else {
                $dir .= '/' . Loader::parseName($val);
            }
        }

        if ($find) {
            $controller = implode('.', $item);
            $path       = array_slice($path, count($item));
        } else {
            $controller = array_shift($path);
        }

        return $controller;
    }

    /**
     * 解析URL的pathinfo参数和变量
     * @access private
     * @param  string    $url URL地址
     * @return array
     */
    private function parseUrlPath($url)
    {
        // 分隔符替换 确保路由定义使用统一的分隔符
        $url = str_replace('|', '/', $url);
        $url = trim($url, '/');
        $var = [];

        if (false !== strpos($url, '?')) {
            // [模块/控制器/操作?]参数1=值1&参数2=值2...
            $info = parse_url($url);
            $path = explode('/', $info['path']);
            parse_str($info['query'], $var);
        } elseif (strpos($url, '/')) {
            // [模块/控制器/操作]
            $path = explode('/', $url);
        } elseif (false !== strpos($url, '=')) {
            // 参数1=值1&参数2=值2...
            parse_str($url, $var);
        } else {
            $path = [$url];
        }

        return [$path, $var];
    }
}
