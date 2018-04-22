<?php
/**
 * Websocket优化基础类库
 * Created by PhpStorm.
 * User: Echo
 * Date: 2018/4/1
 * Time: 23:15
 */
//if (!empty(getopt('c:'))){
//    $opt = getopt('c:');
//    define("WEB_LOADS",$opt['c']);
//    var_dump(WEB_LOADS);
//}
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:token,lang,Origin, Content-Type, Cookie, Accept, multipart/form-data, application/json');
header('Access-Control-Allow-Methods:*');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Expose-Headers:token,lang');
define('WEB_ROOT',__DIR__.'/..');
$autoLoadFilePath = WEB_ROOT.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
require_once $autoLoadFilePath;

use Swoole\Controller\CloseController;
use Swoole\Libs\Predis;
class Ws{
    protected $socket_server_addr;
    protected $socket_server_port;
    public $ws =null;
    public $table = array();
    public $taskObj;

    public function __construct(){

        $this->taskObj = new \Swoole\Libs\task\Task;

        if (!tableCreate($this)){
            echo "建表失败";
            return false;
        }


        $this->ws = new swoole_websocket_server(swooleConfig('SERVER_LISTEN_ADDR'), swooleConfig('SERVER_LISTEN_PORT'));
        $this->ws->set([
            'worker_num' => 4,
            'task_worker_num' => 4,
            'enable_static_handler'   => true,
            'document_root'      =>  '/Applications/MAMP/htdocs/swool/mook/data',  //静态文件根目录
//            'daemonize' => true
        ]);
        $this->ws->on('open',[$this,'onOpen']);
        $this->ws->on('workerStart',[$this,'onWorkerStart']);
        $this->ws->on('task',[$this,'onTask']);
        $this->ws->on('finish',[$this,'onFinish']);
        $this->ws->on('request',[$this,'onRequest']);
        $this->ws->on('message',[$this,'onMessage']);
        $this->ws->on('close',[$this,'onClose']);


        $this->ws->start();

    }

    public function onWorkerStart( $serv , $worker_id) {
        $serv->redis = new Predis(swooleConfig('REDIS_ADDR'),swooleConfig('REDIS_PORT'),swooleConfig('REDIS_AUTH'));

        ini_set('default_socket_timeout',-1);
    }


    /**
     * 客户端连接成功
     * @param $ws
     * @param $request
     */
    public function onOpen($ws,$request){
        echo "新加入链接id:  ".$request->fd . PHP_EOL;


//        if ($request->fd == 300){
//            //设置每两秒执行一次
//            swoole_timer_tick(2000,function ($timer_id){
//                echo "2秒 timer_id: {$timer_id} \n";
//            });
//        }
    }


    /**
     * http请求
     * @param swoole_http_request $request
     * @param swoole_http_response $response
     */
    public function onRequest(swoole_http_request $request, swoole_http_response $response){
        // 接收http请求从get获取message参数的值，给用户推送
//         var_dump($this->ws);
//        $response->end();
        // 遍历所有websocket连接用户的fd，给所有用户推送
//        foreach ($this->ws->connections as $fd =>$key) {
//            var_dump($fd . '-----' . $key  );
//            $this->ws->push($fd, "这是通过http接口调用产生的主动推送数据".json_encode($request->post));
//        }
//        $response->end("完成");
        $requests = $request->get;
//        var_dump($requests['method']);
        if (isset($requests) && !empty($requests['method'])){
            $method = $requests['method'];
//            var_dump($method);

            switch ($method){
                case 'reload':
                    $this->ws->reload();
                    $response->end(json_encode($method,JSON_UNESCAPED_UNICODE));
                    break;
                case 'stop':
                    break;
                case 'start':
                    break;
                default:
                    break;
            }
        }


    }


    /**
     * 接收到来自客户端的消息
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws ,$frame){
//        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";

        //todo 10s
        $data=[
            'task_id'=>1,
            'fd'  =>$frame->fd,
            'task_data' => $frame->data,
        ];
        var_dump($frame->data);
        $ws->task($data);   //会去执行onTask方法

        //设置5秒后执行
//        swoole_timer_after(5000,function () use($ws,$frame){
//            echo "5s 之后\n";
//            $ws->push($frame->fd,"这是收到消息后5秒回复的");
//
//        });


    }



    /**
     * 投递的task任务
     * @param $serv    对象
     * @param $taskId  task Id
     * @param $workId  work进程Id
     * @param $data    数据
     */
    public function onTask($serv,$taskId,$workId,$data){

        //连接关闭处理
        if ($data['task_id'] === 2){
            if (!(CloseController::fdDel($this,$this->ws,$data['fd']))){
                return "未找到";
            }else{
                return "删除成功";
            }

        }else {

            //处理接收到的消息

            $rev_data = json_decode($data['task_data'], true);   //接收到的消息

            $method = isset($rev_data['method']) ? $rev_data['method'] : '';   //消息的类型
            if (empty($method)) {
                $this->ws->push($data['fd'], responseJson(-2, "参数有误"));
            }


            //做task任务
            $flag = $this->taskObj->$method($this, $this->ws, $data);
            if (!$flag) {
                echo "task:" . $taskId . "执行失败";
            }
        }

        //模拟一个耗时场景
//        sleep(10);
        return "on task finish";   //任务完成，执行finish


    }


    /**
     * task任务完成后触发
     * @param $serv
     * @param $taskId
     * @param $data   此处data为  onTask()返回的值
     */
    public function onFinish($serv,$taskId,$data){

//        echo "taskId:{$taskId}\n";
        echo "task任务完成,返回数据:{$data}" . PHP_EOL;
    }


    /**
     * 客户端连接关闭
     * @param $ws
     * @param $fd
     */
    public function onClose($ws,$fd){
        $data = [
            'task_id' => 2,
            'fd'      => $fd,
        ];
        $ws->task($data);
        echo "client {$fd} closed\n";

    }
}

$obj = new Ws();