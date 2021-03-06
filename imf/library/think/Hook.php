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

namespace think;

class Hook
{
    /**
     * 钩子行为定义
     * @var array
     */
    private $tags = [];

    /**
     * 绑定行为列表
     * @var array
     */
    protected $bind = [];

    /**
     * 入口方法名称
     * @var string
     */
    private static $portal = 'run';

    /**
     * 指定入口方法名称
     * @access public
     * @param  string  $name     方法名
     * @return $this
     */
    public function portal($name)
    {
        self::$portal = $name;
        return $this;
    }

    /**
     * 指定行为标识 便于调用
     * @access public
     * @param  string|array  $name     行为标识
     * @param  mixed         $behavior 行为
     * @return $this
     */
    public function alias($name, $behavior = null)
    {
        if (is_array($name)) {
            $this->bind = array_merge($this->bind, $name);
        } else {
            $this->bind[$name] = $behavior;
        }

        return $this;
    }

    /**
     * 动态添加行为扩展到某个标签
     * @access public
     * @param  string    $tag 标签名称
     * @param  mixed     $behavior 行为名称
     * @param  bool      $first 是否放到开头执行
     * @return void
     */
    public function add($tag, $behavior, $first = false)
    {
        isset($this->tags[$tag]) || $this->tags[$tag] = [];

        if (is_array($behavior) && !is_callable($behavior)) {
            if (!array_key_exists('_overlay', $behavior)) {
                $this->tags[$tag] = array_merge($this->tags[$tag], $behavior);
            } else {
                unset($behavior['_overlay']);
                $this->tags[$tag] = $behavior;
            }
        } elseif ($first) {
            array_unshift($this->tags[$tag], $behavior);
        } else {
            $this->tags[$tag][] = $behavior;
        }
    }

    /**
     * 批量导入插件
     * @access public
     * @param  array     $tags 插件信息
     * @param  bool      $recursive 是否递归合并
     * @return void
     */
    public function import(array $tags, $recursive = true)
    {
        if ($recursive) {
            foreach ($tags as $tag => $behavior) {
                $this->add($tag, $behavior);
            }
        } else {
            $this->tags = $tags + $this->tags;
        }
    }

    /**
     * 获取插件信息
     * @access public
     * @param  string $tag 插件位置 留空获取全部
     * @return array
     */
    public function get($tag = '')
    {
        if (empty($tag)) {
            //获取全部的插件信息
            return $this->tags;
        } else {
            return array_key_exists($tag, $this->tags) ? $this->tags[$tag] : [];
        }
    }

    /**
     * 监听标签的行为
     * @access public
     * @param  string $tag    标签名称
     * @param  mixed  $params 传入参数
     * @param  bool   $once   只获取一个有效返回值
     * @return mixed
     */
    public function listen($tag, $params = null, $once = false)
    {
        $results = [];
        $tags    = $this->get($tag);

        foreach ($tags as $key => $name) {
            $results[$key] = $this->execTag($name, $tag, $params);

            if (false === $results[$key]) {
                // 如果返回false 则中断行为执行
                break;
            } elseif (!is_null($results[$key]) && $once) {
                break;
            }
        }

        return $once ? end($results) : $results;
    }

    /**
     * 执行行为
     * @access public
     * @param  mixed     $class  行为
     * @param  mixed     $params 参数
     * @return mixed
     */
    public function exec($class, $params = null)
    {
        if ($class instanceof \Closure || is_array($class)) {
            $method = $class;
        } else {
            if (isset($this->bind[$class])) {
                $class = $this->bind[$class];
            }
            $method = [$class, self::$portal];
        }

        return Container::getInstance()->invoke($method, [$params]);
    }

    /**
     * 执行某个标签的行为
     * @access protected
     * @param  mixed     $class  要执行的行为
     * @param  string    $tag    方法名（标签名）
     * @param  mixed     $params 参数
     * @return mixed
     */
    protected function execTag($class, $tag = '', $params = null)
    {
        $app = Container::get('app');

        $app->isDebug() && $app['debug']->remark('behavior_start', 'time');

        $method = Loader::parseName($tag, 1, false);

        if ($class instanceof \Closure) {
            $call  = $class;
            $class = 'Closure';
        } elseif (strpos($class, '::')) {
            $call = $class;
        } else {
            $obj = Container::get($class);

            if (!is_callable([$obj, $method])) {
                $method = self::$portal;
            }

            $call  = [$class, $method];
            $class = $class . '->' . $method;
        }

        $result = Container::getInstance()->invoke($call, [$params]);

        if ($app->isDebug()) {
            $debug = $app['debug'];
            $debug->remark('behavior_end', 'time');
            $app->log('[ BEHAVIOR ] Run ' . $class . ' @' . $tag . ' [ RunTime:' . $debug->getRangeTime('behavior_start', 'behavior_end') . 's ]');
        }

        return $result;
    }

}
