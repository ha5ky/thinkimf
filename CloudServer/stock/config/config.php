<?php
/**
 * Created by PhpStorm.
 * User: Echo
 * Date: 2018/4/3
 * Time: 14:08
 */

$config[]=[
    // socket服务端监听地址和端口
    'SERVER_LISTEN_ADDR'=> '0.0.0.0',
    'SERVER_LISTEN_PORT'=> 9501,

    //redis服务监听地址和端口
//    'REDIS_ADDR'   => '127.0.0.1',
//    'REDIS_PORT'   => 6379,

        //忠宝redis
    'REDIS_ADDR'   => '192.168.31.222',
    'REDIS_PORT'   => 6379,
    'REDIS_AUTH'   => 'ShUfFlE20170118',
    'REDIS_LIFE_TIME'   => 30*60,


    //测试服务器redis
//    'REDIS_ADDR'   => '106.14.114.102',
//    'REDIS_PORT'   => 6379,
//    'REDIS_AUTH'   => 'ShUfFlE20170118',
//    'REDIS_LIFE_TIME'   => 30*60,


    'redis' => array(
    'host'       => '106.14.114.102',
//        'host'        => '192.168.31.222',
    'port'       => 6379,
    'prefix'     => 'inex',
    'auth'       => 'ShUfFlE20170118',
    'persistent' => false,
    'lifetime'   => 30*60
    ),

//    'redis' => array(
//        'host'       => '192.168.31.222',
//        'port'       => 6379,
//        'prefix'     => 'inex',
//        'auth'       => 'ShUfFlE20170118',
//        'persistent' => false,
//        'lifetime'   => 30*60
//    ),

    //oss图片前缀
    'oss'   => 'http://inex.oss-cn-hongkong.aliyuncs.com',

    //redis中交易对的key值前缀
    'pair' => array(
        'gather' => 'inex:zset:pair:type:',         //集合中
        'hash'   => 'inex:hashTable:pair:pairId:',  //hash表中
        'deep'   => 'inex:string:pair:pairId:',
        'orderBook'  =>  'inex:list:pair:pairId:'
    ),
//    "inex:list:pair:pairId:" . $pairId . ":orderBookHistory";
    'kLine'  => array(
        'gather'  => 'inex:list:pair:pairId:',    //inex:list:pair:pairId:1:kline:period:1m
        'hash'    => 'inex:hashTable:pair:pairId:'   //inex:hashTable:pair:pairId:1:kline:period:1m:startTime:1523874360
    ),
    'userAsset' => 'inex:hashTable:userAsset:userNo:',
//    inex:hashTable:userAsset:userNo:234324:coinId:*

    'coins' => array(
        'gather' => 'inex:zset:coin',
        'hash'   => 'inex:hashTable:coin:coinId:'
    ),




     //解析token key
    'KEY_USER_INFO' => "inex:hashTable:userInfo:userNo:",

    //加密盐
    'salt'  => 'bhlgzvHLFWZUNq4p4eIsFfW8L3UmY7p1aTHnOgwdXMgWaPnaiXWh5W9qr0MOXTQk',

];