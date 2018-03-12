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

/**
 * 自动时间戳
 */
trait TimeStamp
{
    /**
     * 是否需要自动写入时间戳 如果设置为字符串 则表示时间字段的类型
     * @var bool|string
     */
    protected $autoWriteTimestamp;

    /**
     * 创建时间字段 false表示关闭
     * @var false|string
     */
    protected $createTime = 'create_time';

    /**
     * 更新时间字段 false表示关闭
     * @var false|string
     */
    protected $updateTime = 'update_time';

    /**
     * 时间字段显示格式
     * @var string
     */
    protected $dateFormat;

    /**
     * 时间日期字段格式化处理
     * @access protected
     * @param  mixed $time      时间日期表达式
     * @param  mixed $format    日期格式
     * @param  bool  $timestamp 是否进行时间戳转换
     * @return mixed
     */
    protected function formatDateTime($time, $format, $timestamp = false)
    {
        if (false !== strpos($format, '\\')) {
            $time = new $format($time);
        } elseif (!$timestamp && false !== $format) {
            $time = date($format, $time);
        }

        return $time;
    }

    /**
     * 检查时间字段写入
     * @access protected
     * @return void
     */
    protected function checkTimeStampWrite()
    {
        // 自动写入创建时间和更新时间
        if ($this->autoWriteTimestamp) {
            if ($this->createTime && !isset($this->data[$this->createTime])) {
                $this->data[$this->createTime] = $this->autoWriteTimestamp($this->createTime);
            }
            if ($this->updateTime && !isset($this->data[$this->updateTime])) {
                $this->data[$this->updateTime] = $this->autoWriteTimestamp($this->updateTime);
            }
        }
    }
}
