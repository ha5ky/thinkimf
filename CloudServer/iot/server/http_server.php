<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/21
 * Time: 15:01
 */
$http = new swoole_http_server("0.0.0.0", 8811);

$http->set(
    [
        'enable_static_handler' => true,
        'document_root' => "/Applications/MAMP/htdocs/web/CloudServer/iot/server/wwwroot",
    ]
);
$http->on('request', function($request, $response) {
    print_r($request->get);
    //$response->end();
    $content = [
        'date:' => date("Ymd H:i:s"),
        'get:' => $request->get,
        'post:' => $request->post,
        'header:' => $request->header,
    ];

    swoole_async_writefile(__DIR__."/access.log", json_encode($content).PHP_EOL, function($filename){
        // todo
    }, FILE_APPEND);
    $response->cookie("chenjianhua", "swoole cookie success", time() + 1800);
    $response->end("sss". json_encode($request->get));
});

$http->start();