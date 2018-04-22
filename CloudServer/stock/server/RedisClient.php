<?php
/**
 * 异步redis
 * 订阅频道，当有频道有数据发布时，把收到的数据推送到websocket服务器
 */

define('WEB_ROOT',__DIR__.'/..');

$autoLoadFilePath = WEB_ROOT.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
require_once $autoLoadFilePath;


use Swoole\Libs\socketClient\WebSocket;
//use Swoole\Libs\socketClient\WebSocketParser;
//use Swoole\Libs\socketClient\TCP;
//use Swoole\Libs\socketClient\Socket;
//use Swoole\Libs\socketClient\Parser;

class RedisClient{

    protected $swoole_redis;
    protected $redis_addr;
    protected $redis_port;
    protected $socket_server_addr;
    protected $socket_server_port;

    public function __construct(){

        $this->redis_addr= swooleConfig('REDIS_ADDR');
        $this->redis_port= swooleConfig('REDIS_PORT');
        $this->socket_server_addr= swooleConfig('SERVER_LISTEN_ADDR');
        $this->socket_server_port= swooleConfig('SERVER_LISTEN_PORT');

        $this->swoole_redis = new \swoole_redis;
        $this->swoole_redis->on('message',[$this,'onMessage']);
        $this->onConnect();
    }

    /**
     * 当频道有新消息发布时促发
     * @param swoole_redis $client
     * @param $result
     */
    public function onMessage(\swoole_redis $client, $result){
        if ($result[0] == 'message') {
//            print_r($result[2]);
//            echo PHP_EOL;
            $this->sockectConnect($result[2]);
        }

    }

    /**
     * 连接订阅的redis服务器
     */
    public function onConnect(){
        $this->swoole_redis->connect($this->redis_addr, $this->redis_port, function (\swoole_redis $client, $result) {
            if ($result == false){
                echo "connect to redis server failed." . PHP_EOL;
                var_dump($client->errCode);
                echo PHP_EOL;
                var_dump($client->errMsg);
            }


            $client->subscribe('msg_0');
            return true;
        });
    }


    /**
     * 向websocket服务器推送数据
     * @param $mess
     */
    public function sockectConnect($mess){
//        $res = '{"buy_deep":[{"price":"16.5","amount":971},{"price":"18.5","amount":862}],"match_orders":[],"order":{"deal_amount":0,"price":18.5,"argv_price":0,"current_frozen_amount":15947,"pair_id":1,"user_no":"293947485594845184","order_amount":862,"type":1,"fee_rate":"0.002","created_at":1522809691,"pair":"A\/INC","updated_at":1522809691,"fee_coin_code":"A","turnover":0,"order_no":"298648250502610944","weight":"1850000000.65668087477387","initial_frozen_amount":15947,"fee":0,"status":1},"sell_deep":[],"match_details":[],"pair_id":1,"order_book":[],"user_assets":[],"pair":[],"type":"push"}';

        $message['method'] = 'redisPushMessage';
        $message['data'] = json_decode($mess,true);

        //连接 需要权限
        $client = new WebSocket($this->socket_server_addr, $this->socket_server_port, '/VH4OKgcjVHZTPlFzBnVTYwExCS9RdFdwDX5VdwFiV3ADaFRjBio=');

        //连接失败
        if (!($temp = $client->connect())) {
            var_dump($temp);
            echo "失败" . "<br>";
            echo "connect to server failed.\n";
//            exit;
        }
//        $message = json_encode(array('type'=>'push','title' => '这是推送的消息', 'data' => [1, 2, 3, 4, 5, 6, 7, 8, 9]), JSON_UNESCAPED_UNICODE);

        if ($client->send(json_encode($message)) === false){
            echo "数据发送失败";
//            exit;
        };
        $res = $client->recv();

        //推送数据失败
        if ($res === false) {
            echo "数据接收失败";
//            exit;
        }

        echo "websocket返回信息: {$res}\n";   //服务端返回数据
    }



}



$redis_obj = new RedisClient();

