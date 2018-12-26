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

namespace think;

use think\cache\Driver;

class Cache
{
    /**
     * 缓存实例
     * @var array
     */
    protected $instance = [];

    /**
     * 应用对象
     * @var App
     */
    protected $app;

    /**
     * 操作句柄
     * @var object
     */
    protected $handler;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * 连接缓存
     * @access public
     * @param  array         $options  配置数组
     * @param  bool|string   $name 缓存连接标识 true 强制重新连接
     * @return Driver
     */
    public function connect(array $options = [], $name = false)
    {
        $type = !empty($options['type']) ? $options['type'] : 'File';

        if (false === $name) {
            $name = md5(serialize($options));
        }

        if (true === $name || !isset($this->instance[$name])) {
            $class = false !== strpos($type, '\\') ? $type : '\\think\\cache\\driver\\' . ucwords($type);

            // 记录初始化信息
            $this->app->log('[ CACHE ] INIT ' . $type);

            if (true === $name) {
                $name = md5(serialize($options));
            }

            $this->instance[$name] = new $class($options);
        }

        return $this->instance[$name];
    }

    /**
     * 自动初始化缓存
     * @access public
     * @param  array         $options  配置数组
     * @return Driver
     */
    public function init(array $options = [])
    {
        if (is_null($this->handler)) {
            // 自动初始化缓存
            $config = $this->app['config'];

            if (empty($options) && 'complex' == $config->get('cache.type')) {
                $default = $config->get('cache.default');
                $options = $config->get('cache.' . $default['type']) ?: $default;
            } elseif (empty($options)) {
                $options = $config->pull('cache');
            }

            $this->handler = $this->connect($options);
        }

        return $this->handler;
    }

    /**
     * 切换缓存类型 需要配置 cache.type 为 complex
     * @access public
     * @param  string $name 缓存标识
     * @return Driver
     */
    public function store($name = '')
    {
        if ('' !== $name && 'complex' == $this->app['config']->get('cache.type')) {
            return $this->connect($this->app['config']->get('cache.' . $name), strtolower($name));
        }

        return $this->init();
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->init(), $method], $args);
    }

}
