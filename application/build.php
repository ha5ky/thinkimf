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
return [
    // 生成应用公共文件
    '__file__' => ['common.php'],

    // 定义App模块的自动生成 （按照实际定义的文件名生成）
    'Portal'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['behavior', 'controller', 'model', 'view'],
        'controller' => ['Index'],
        'model'      => ['User'],
        'view'       => ['/default'],
    ],
    // 其他更多的模块定义
    'Admin'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['behavior', 'controller', 'model', 'view'],
        'controller' => ['Index'],
        'model'      => ['User'],
        'view'       => ['default/default'],
    ],
    'Service'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['behavior', 'controller', 'model', 'view'],
        'controller' => ['Index'],
        'model'      => ['User'],
        'view'       => ['default/default'],
    ],
    'Api'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['behavior', 'controller', 'model', 'view'],
        'controller' => ['Index'],
        'model'      => ['User'],
        'view'       => ['default/default'],
    ],
    'statistics'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['behavior', 'controller', 'model', 'view'],
        'controller' => ['Index'],
        'model'      => ['User'],
        'view'       => ['default/default'],
    ],
    'statistics'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['behavior', 'controller', 'model', 'view'],
        'controller' => ['Index'],
        'model'      => ['User'],
        'view'       => ['default/default'],
    ],
];
