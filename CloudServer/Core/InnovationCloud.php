<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/21
 * Time: 17:45
 */

namespace CloudServer\Core;

use CloudServer\Core\db\Predis;
use const JSON_UNESCAPED_UNICODE;
use \Swoole\Table;
use function is_null;
use function swoole_timer_add;
use function swoole_timer_tick;
use function var_dump;

class InnovationCloud extends baseClass
{

    CONST HOST = "0.0.0.0";
    CONST PORT = 9621;

    public $ws = null;
    private $config;
    private $dbConnection = null;
    private $redisConnection = null;
    private $tableCache = null;

    public function __construct($config = [])
    {

        $this->config = $config;

        $this->ws = new \Swoole\WebSocket\Server(self::HOST, self::PORT);
        $this->ws->set(
            [
                'worker_num' => 4,
                'task_worker_num' => 8,
                'max_connection'=>10000,//最大支持1000w 设备在线,max_connection最大不得超过操作系统ulimit -n的值，否则会报一条警告信息，并重置为ulimit -n的值
                'heartbeat_check_interval' =>3600,//启用心跳检测，此选项表示每隔多久轮循一次，单位为秒。如 heartbeat_check_interval => 60，表示每60秒，遍历所有连接，如果该连接在60秒内，没有向服务器发送任何数据，此连接将被强制关闭。
                'heartbeat_idle_time' => 600,//表示每60秒遍历一次，一个连接如果600秒内未向服务器发送任何数据，此连接将被强制关闭
            ]
        );
        $this->ws->on("open", [$this, 'onOpen']);
        $this->ws->on("WorkerStart", [$this, 'onWorkerStart']);
        $this->ws->on("message", [$this, 'onMessage']);
        $this->ws->on("task", [$this, 'onTask']);
        $this->ws->on("finish", [$this, 'onFinish']);
        $this->ws->on("close", [$this, 'onClose']);
    }

    public function onWorkerStart(\Swoole\WebSocket\Server $ws, int $worker_id)
    {
        global $argv;
        if ($worker_id >= $ws->setting['worker_num']) {
            swoole_set_process_name("php {$argv[0]} task worker");
        } else {
            swoole_set_process_name("php {$argv[0]} event worker");
        }
        $this->redisConnection = new \CloudServer\Core\db\ImfRedis($this->config['redis']);
        $this->dbConnection = new \CloudServer\Core\db\PdoMysql($this->config['db']);
    }

    public function setDbConnection($connection = null)
    {
        if (is_null($this->dbConnection)) {
            $this->dbConnection = $connection;
        }
    }

    public function setRedisConnection($connection = null)
    {
        if (is_null($this->redisConnection)) {
            $this->redisConnection = $connection;
        }
    }

    public function run()
    {
        $table = new \Swoole\Table(65536);

        $table->column('result', Table::TYPE_STRING, 65535);
        $table->create();

        $this->tableCache = $table;

        $this->ws->start();
    }

    /**
     * 监听ws连接事件
     *
     * @param $ws
     * @param $request
     */
    public function onOpen(\Swoole\WebSocket\Server $ws, $request)
    {
        echo '设备号为' . json_encode($request) . '临时编号为' . $request->fd . "连接到云......" . PHP_EOL;
        $fd = $request->fd;
        //校验 appid, 分配到 redis 云设备池子中
        $reqData = $request->data;
        $this->result['status'] = 1;
        $this->result['msg'] = '临时编号为' . $request->fd . "连接到云......";
        $ws->push($fd,$this->json($this->result));
    }

    /**
     * 监听ws消息事件
     *
     * @param $ws
     * @param $frame
     */
    public function onMessage(\Swoole\WebSocket\Server $ws, $frame)
    {
        //签名授权在这里
        $fid = $frame->fd;
        //echo '开始监听:' . $fid . "接收到的消息" . PHP_EOL;
        //echo "从" . $fid . "接收到的数据为:{$frame->data}" . PHP_EOL;
        //客户端使用 json 进行传输数据


        //客户端心跳检查
        if($frame->data == 'ping'){
            $ws->push($fid,'pong');
            return;
        }
        $requestData = json_decode($frame->data, true);
        if(!is_array($requestData)){
            $content = "接受" . $frame->data . "数据格式不正确" . PHP_EOL;
            //写入日志
            swoole_async_writefile(
                "./log" . date('Y-m-d') . '.logs'
                , $content
                , function () {
            }
                , 1
            );
        }
        $requestData['fid'] = $fid;
        //$taskID = $ws->task($requestData);
        $processData = [
            'status' => 2,
	        'msg' => '处理任务已经投递到了云服务器中,任务ID 为' . 9 . '请稍等......',
	        'msg_code' => 4236,
	        'data' => [],
        ];
        //写入日志
        swoole_async_writefile(
            "./process" . date('Y-m-d') . '.logs'
            , $this->json($processData)
            , function () {
        }, 1
        );
        if(!$this->tableCache->exist('data')){
            $ws->push($fid,$this->json($processData));
        }else{
            $response = $this->tableCache->get('data');
            $ws->push($fid,$response['result']);
        }
        //使用 table 做数据缓存池子
        //$info = $ws->connection_info($data['fid']);
        $ws->push($fid,$this->json($processData));
        swoole_timer_tick(1000, function () use($ws,$fid){
            $ws->push($fid,date('Y-m-d H:i:s'));
        });
    }

    /**
     * 处理任务
     *
     * @param $serv
     * @param $taskId
     * @param $workerId
     * @param $data
     */
    public function onTask(\Swoole\WebSocket\Server $ws, $taskId, $workerId, $data)
    {
        //var_dump($data['fid'],0000);
        $ws->finish($data);
        $controllerName = 'System';
        $action = 'index';
        if (!empty($data['cmd'])) {
            $routeArray = explode('/', $data['cmd']);
            // 获取控制器名
            $controllerName = ucfirst($routeArray[0]);
            // 获取动作名
            $action = empty($routeArray[1]) ? 'index' : $routeArray[1];
        }
        // 实例化控制器
        $controllerNameSpace = "\\CloudServer\\Controller\\" . $controllerName . 'Controller';
        // 如果控制器存和动作存在，这调用并传入参数
        if (class_exists($controllerNameSpace)) {
            $obj = new $controllerNameSpace();
            //实例化内容,传入参数
            $finishData = $obj->$action($ws,$data);
            $data['job_finish'] = $finishData;
            $ws->push($data['fid'],$this->json($data));
            $ws->finish($data);
        } else {
            $this->result['status'] = -1;
            $this->result['msg'] = $data['cmd'] . "相关命令不存在!";
            $ws->push($data['fid'],$this->json($this->result));
        }
    }

    /**
     * 任务结束的时候
     *
     * @param $ws
     * @param $taskId
     * @param $data
     */
    public function onFinish(\Swoole\WebSocket\Server $ws, $taskId, $data)
    {
        echo "任务 ID:{$taskId}\n";
        echo "finish-data-sucess:{$this->json($data)}\n";
        $result['status'] = 1;
        $result['msg'] = '任务 ID 为' . $taskId . "的任务处理完毕";
        $result['msg_code'] = 4237;
        $result['data'] = $data;
        $ws->push($data['fid'],$this->json($data));
    }

    /*
     *云平台关闭
     * @param $ws
     * @param $fd
     */
    public function onClose($ws, $fd)
    {
        echo "Finished:{$fd}\n";
        //$this->redisConnection->get();
        $clitenId = '6789';
        $this->result['status'] = 1;
        $this->result['msg'] = 'Cloud ID 为' . $fd . '设备号为' . $clitenId . '的设备退出';
        $this->result['msg_code'] = 4523;//设备退出
        $ws->push($fd,$this->json($this->result));
    }
}
