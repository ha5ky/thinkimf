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

namespace think\facade;

use think\Facade;

/**
 * @see \think\Debug
 * @mixin \think\Debug
 * @method void remark(string $name, mixed $value = '') static 记录时间（微秒）和内存使用情况
 * @method int getRangeTime(string $start, string $end, mixed $dec = 6) static 统计某个区间的时间（微秒）使用情况
 * @method int getUseTime(int $dec = 6) static 统计从开始到统计时的时间（微秒）使用情况
 * @method string getThroughputRate(string $start, string $end, mixed $dec = 6) static 获取当前访问的吞吐率情况
 * @method string getRangeMem(string $start, string $end, mixed $dec = 2) static 记录区间的内存使用情况
 * @method int getUseMem(int $dec = 2) static 统计从开始到统计时的内存使用情况
 * @method string getMemPeak(string $start, string $end, mixed $dec = 2) static 统计区间的内存峰值情况
 * @method mixed getFile(bool $detail = false) static 获取文件加载信息
 * @method mixed dump(mixed $var, bool $echo = true, string $label = null, int $flags = ENT_SUBSTITUTE) static 浏览器友好的变量输出
 */
class Debug extends Facade
{
}
