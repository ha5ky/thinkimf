<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/21
 * Time: 15:41
 */

$server = new swoole_websocket_server("0.0.0.0", 8811);
//$server->set([]);
$server->set(
    [
        'enable_static_handler' => true,
        'document_root' => "/Applications/MAMP/htdocs/web/CloudServer/iot/server/wwwroot",
    ]
);
//监听websocket连接打开事件
$server->on('open', 'onOpen');
function onOpen($server, $request) {
    print_r($server,$request);
}

// 监听ws消息事件
$server->on('message', function (swoole_websocket_server $server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd, "dyoung-push-secesss");
});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();