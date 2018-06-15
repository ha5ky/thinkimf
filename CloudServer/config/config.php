<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/5/19
 * Time: 下午1:35
 */

return [
    //☁云配置
    'cloud' => [
        'worker_num' => 4,
        'task_worker_num' => 8,
        'host' => '0.0.0.0',
        'port' => 9621,
        //'ssl_cert_file'=>$key_dir.'/file.crt',
        //'ssl_key_file' =>$key_dir.'file.key'
        //var wsl = "wss://domain/path";
        //ws = new WebSocket(wsl);
    ],
    'sys_client' => [
        'host' => '127.0.0.1',
        'port' => 9621,
    ],
    //cmd 配置
    'cmd' => [
        'get_system_info',
        'get_system_version',
        'heartbeat_check',
        'broadcast_all',
        'broadcast_single',
        'upload_file',
        'device_on',
        'device_off',
        'device_add',
        'device_remove',
    ],
    //返回配置
    'protocol' => [
        'version' => 0.01,
        'response_type' => 'json'
    ],
    //兼容MySQL/MariaDB
    'db' => [
        'host' => '120.78.150.141',
        'port' => '3306',
        'user' => 'imf_dev',
        'password' => 'mWLs5caWr8',
        'database_name' => 'imf_dev',
    ],
    'redis' => [
        'host' => '120.78.150.141',
        'port' => 6379,
        'password' => 'passimfredis',
        'timeout' => 20,
        'persistent' => false,
        'prefix' => 'IMF:',
    ],
    //心跳检测
    //给单个设备广播
    //给全部广播
    //本地数据上推送至云端
    //设备上线
    //设备下线
    //文件上传
    'cmd' => [
        'cloud_init_connect',
        'api_auth',
        'get_system_info',
        'get_system_version',
        'heartbeat_check',
        'broadcast_all',
        'broadcast_single',
        'upload_file',
        'device_on',
        'device_off',
        'device_add',
        'device_remove',
        'device_list',
        'cloud_quit_close'
    ],
    'data_type' => [
        'bool',//true false nil null
        'int', //int int16 int32 int64 int128 int uint8 uint16
        'float',// float double
        'string',//string
        'enum',//enum color ['red','white','red','yellow','pink','blue'];[1,2,3,4,5,6]
    ],
    'device_list' => [
        [
            'icon' => '',
            'client_id' => '',
            'mark_icon' => '',
            'title' => '',
            'location' => '',//gps 经纬度
            'data' => [

            ]
        ],
    ],
    'requestProtocol' => [
        'app_id' => '',
        'app_secret' => '',
        'uuid' => '',
        'client_id' => '',
        'cmd' => '',
        'data' => [
            'key1' => [
                'type' => 'int',
                'value' => 4567,
            ],
            'key2' => [
                'type' => 'float',
                'value' => 3.1415667876565,
            ],
            'key3' => [
                'type' => 'double',
                'value' => 9345678907654232457.980766786456709855674877,
            ],
            'key4' => [
                'type' => 'range',
                'start' => 000001,
                'end' => 999999,
                'default_value' => 'hello IMF',
            ],
            'key5' => [
                'type' => 'bool',
                'value' => true
            ],
            'key6' => [
                'type' => 'string',//with infinity length
                'value' => "swith|on|json|{'key':'json'}"//json string or other string
            ]

        ]
    ],
    //定义响应数据结构
    'responseProtocol' => [
        'status' => 1,
        'msg' => '',
        'msg_code' => '',
        'data' => [
            'from' => 'clientid',
            'to' => 'clientid',
            'content' => ''
        ]
    ],

];