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

namespace think\model\concern;

use think\Container;

/**
 * 模型事件处理
 */
trait ModelEvent
{
    /**
     * 模型回调
     * @var array
     */
    private static $event = [];

    /**
     * 注册回调方法
     * @access public
     * @param  string   $event    事件名
     * @param  callable $callback 回调方法
     * @param  bool     $override 是否覆盖
     * @return void
     */
    public static function event($event, $callback, $override = false)
    {
        $class = static::class;

        if ($override) {
            self::$event[$class][$event] = [];
        }

        self::$event[$class][$event][] = $callback;
    }

    /**
     * 触发事件
     * @access protected
     * @param  string $event  事件名
     * @return bool
     */
    protected function trigger($event)
    {
        $class = static::class;

        if (isset(self::$event[$class][$event])) {
            foreach (self::$event[$class][$event] as $callback) {
                $result = Container::getInstance()->invoke($callback, [$this]);

                if (false === $result) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * 模型before_insert事件快捷方法
     * @access protected
     * @param callable  $callback
     * @param bool      $override
     */
    protected static function beforeInsert($callback, $override = false)
    {
        self::event('before_insert', $callback, $override);
    }

    /**
     * 模型after_insert事件快捷方法
     * @access protected
     * @param callable  $callback
     * @param bool      $override
     */
    protected static function afterInsert($callback, $override = false)
    {
        self::event('after_insert', $callback, $override);
    }

    /**
     * 模型before_update事件快捷方法
     * @access protected
     * @param callable  $callback
     * @param bool      $override
     */
    protected static function beforeUpdate($callback, $override = false)
    {
        self::event('before_update', $callback, $override);
    }

    /**
     * 模型after_update事件快捷方法
     * @access protected
     * @param callable  $callback
     * @param bool      $override
     */
    protected static function afterUpdate($callback, $override = false)
    {
        self::event('after_update', $callback, $override);
    }

    /**
     * 模型before_write事件快捷方法
     * @access protected
     * @param callable  $callback
     * @param bool      $override
     */
    protected static function beforeWrite($callback, $override = false)
    {
        self::event('before_write', $callback, $override);
    }

    /**
     * 模型after_write事件快捷方法
     * @access protected
     * @param callable  $callback
     * @param bool      $override
     */
    protected static function afterWrite($callback, $override = false)
    {
        self::event('after_write', $callback, $override);
    }

    /**
     * 模型before_delete事件快捷方法
     * @access protected
     * @param callable  $callback
     * @param bool      $override
     */
    protected static function beforeDelete($callback, $override = false)
    {
        self::event('before_delete', $callback, $override);
    }

    /**
     * 模型after_delete事件快捷方法
     * @access protected
     * @param callable  $callback
     * @param bool      $override
     */
    protected static function afterDelete($callback, $override = false)
    {
        self::event('after_delete', $callback, $override);
    }

}
