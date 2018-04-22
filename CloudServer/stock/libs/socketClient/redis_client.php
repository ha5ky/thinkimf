<?php
/**
 * Created by PhpStorm.
 * User: Echo
 * Date: 2018/4/8
 * Time: 11:13
 */
namespace Swoole\Libs\socketClient;
//require('WebSocket.php');
//require_once('WebSocketParser.php');
//require_once('TCP.php');
//require_once('Socket.php');
//require_once('Parser.php');
use Swoole\Libs\WebSocket;
use Swoole\Libs\WebSocketParser;
use Swoole\Libs\TCP;
use Swoole\Libs\Socket;
use Swoole\Libs\Parser;
$client = new swoole_redis;

//$this->client->on('message', function (swoole_redis $client, $result) use ($server) {
$client->on('message', function (swoole_redis $client, $result){
//    var_dump($result);
//    static $more = false;
//    if (!$more and $result[0] == 'message') {
    if ($result[0] == 'message') {
        print_r($result[2]);
        echo PHP_EOL;
//        foreach ($server->connections as $fd) {
//            $server->push($fd, $result[2]);
//        }
//        $more = true;






        $res = '{"buy_deep":[{"price":"16.5","amount":971},{"price":"18.5","amount":862}],"match_orders":[],"order":{"deal_amount":0,"price":18.5,"argv_price":0,"current_frozen_amount":15947,"pair_id":1,"user_no":"293947485594845184","order_amount":862,"type":1,"fee_rate":"0.002","created_at":1522809691,"pair":"A\/INC","updated_at":1522809691,"fee_coin_code":"A","turnover":0,"order_no":"298648250502610944","weight":"1850000000.65668087477387","initial_frozen_amount":15947,"fee":0,"status":1},"sell_deep":[],"match_details":[],"pair_id":1,"order_book":[],"user_assets":[],"pair":[],"type":"push"}';
//var_dump(json_decode($res));
//die();

//for ($i=0;$i<=1000;$i++) {
//连接 需要权限
        $client = new WebSocket('127.0.0.1', 9501, '/VH4OKgcjVHZTPlFzBnVTYwExCS9RdFdwDX5VdwFiV3ADaFRjBio=');

//连接失败
        if (!($temp = $client->connect())) {
            var_dump($temp);
            echo "失败" . "<br>";
            echo "connect to server failed.\n";
            exit;
        }
        $message = json_encode(array('type'=>'push','title' => '这是推送的消息', 'data' => [1, 2, 3, 4, 5, 6, 7, 8, 9]), JSON_UNESCAPED_UNICODE);

        if ($client->send($res) === false){
            echo "数据发送失败";
            exit;
        };
        $message = $client->recv();

//推送数据失败
        if ($message === false) {
            echo "数据接收失败";
            exit;
        }

        echo "Received from server: {$message}\n";   //服务端返回数据







    }
});

//$client->connect('127.0.0.1', 6379, function (swoole_redis $client, $result) {
//    if ($result === false) {
//        echo "connect to redis server failed.\n";
//        return;
//    }
//    $client->set('key', 'swoole', function (swoole_redis $client, $result) {
//        var_dump($result);
//    });
//});


$client->connect('127.0.0.1', 6379, function (swoole_redis $client, $result) {
    if ($result == false){
        echo "connect to redis server failed." . PHP_EOL;
        var_dump($client->errCode);
        echo PHP_EOL;
        var_dump($client->errMsg);
    }

//    if ($this->atomic->get() == 0) {
//        $this->atomic->add(1);
        $client->subscribe('msg_0');
//    }
    return true;
});


//define('WEB_PATH', realpath(__DIR__ . '/../'));





//    echo "Closed by server.\n";
//}