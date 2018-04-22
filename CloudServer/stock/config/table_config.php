<?php
/**
 * table表配置
 * Created by PhpStorm.
 * User: Echo
 * Date: 2018/4/11
 * Time: 10:44
 */

$config[] = [

    //交易对所有的在线人员表实例
    'table_object' => [
        'dealPairType',     //不同的交易对类别
        'dealPair',         //单个交易对信息
        'user',         //用户信息
    ],


    //交易对类别页面所有的在线人员表名和表结构
    'dealPairType' => [
        'all' => [
            ['key'=>'fd','type'=>'int','len'=>8],
        ],

        'sport' => [
            ['key'=>'fd','type'=>'int','len'=>8],
//            ['fd',Table::TYPE_INT,8],
        ],

        'star' => [
            ['key'=>'fd','type'=>'int','len'=>8],
        ]
    ],

    //单个交易对页面所有的在线人员表名和表结构
    'dealPair' => [
        'dealPair_1' => [
            ['key'=>'fd','type'=>'int','len'=>8],
            ['key'=>'period','type'=>'string','len'=>2],
        ],
        'dealPair_2' => [
            ['key'=>'fd','type'=>'int','len'=>8],
            ['key'=>'period','type'=>'string','len'=>2],
        ],
        'dealPair_3' => [
            ['key'=>'fd','type'=>'int','len'=>8],
            ['key'=>'period','type'=>'string','len'=>2],
        ],
        'dealPair_4' => [
            ['key'=>'fd','type'=>'int','len'=>8],
            ['key'=>'period','type'=>'string','len'=>2],
        ],
        'dealPair_5' => [
            ['key'=>'fd','type'=>'int','len'=>8],
            ['key'=>'period','type'=>'string','len'=>2],
        ],
        'dealPair_6' => [
            ['key'=>'fd','type'=>'int','len'=>8],
            ['key'=>'period','type'=>'string','len'=>2],
        ],
        'dealPair_7' => [
            ['key'=>'fd','type'=>'int','len'=>8],
            ['key'=>'period','type'=>'string','len'=>2],
        ],
        'dealPair_8' => [
            ['key'=>'fd','type'=>'int','len'=>8],
            ['key'=>'period','type'=>'string','len'=>2],
        ],
        'dealPair_9' => [
            ['key'=>'fd','type'=>'int','len'=>8],
            ['key'=>'period','type'=>'string','len'=>2],
        ],
        'dealPair_10' => [
            ['key'=>'fd','type'=>'int','len'=>8],
            ['key'=>'period','type'=>'string','len'=>2],
        ],
        'dealPair_11' => [
            ['key'=>'fd','type'=>'int','len'=>8],
            ['key'=>'period','type'=>'string','len'=>2],
        ],
        'dealPair_12' => [
            ['key'=>'fd','type'=>'int','len'=>8],
            ['key'=>'period','type'=>'string','len'=>2],
//            ['key'=>'minute','type'=>'int','len'=>2],
//            ['key'=>'hour','type'=>'int','len'=>2],
//            ['key'=>'day','type'=>'int','len'=>1],   //当切换到天时，值为1 ，默认为0
//            ['key'=>'week','type'=>'int','len'=>1],  //当切换到周时，值为1 ，默认为0
        ],

    ],

    'user' => [
        'user'  =>  [
            ['key'=>'fd','type'=>'int','len'=>8],
            ['key'=>'user_no','type'=>'int','len'=>18],
            ['key'=>'pair','type'=>'int','len'=>3],
        ]
    ]
];