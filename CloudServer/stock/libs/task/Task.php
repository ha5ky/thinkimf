<?php
/**
 * 执行task任务
 * Created by PhpStorm.
 * User: Echo
 * Date: 2018/4/9
 * Time: 23:54
 */

namespace Swoole\Libs\task;

use Swoole\Controller\RedisMessageController;
use Swoole\Libs\Pdomysql;

class Task{
//    protected $redis = '';


//    public function __construct(){
//        $this->redis = new Predis(swooleConfig('REDIS_ADDR'),swooleConfig('REDIS_PORT'),swooleConfig('REDIS_AUTH'));
//    }

    public function index($object,$ws_object,$data){

    }


    /**
     * redis订阅消息
     * @param $object
     * @param $data
     * @return bool
     */
    public function redisPushMessage($object,$ws_object,$data){
        $RedisMessageController = new RedisMessageController();
        $RedisMessageController->dealPairType($object,$ws_object,$data['task_data']);
//        foreach($object->all as $k => $v){
//            $ws_object->push($k,responseJson(1,"all类型"));
//        }
        $ws_object->push($data['fd'],responseJson(1,"数据已接收"));
        return true;
    }


    /**
     * 获取不同类别的交易对
     * @param $object
     * @param $data
     */
    public function dealPairType($object,$ws_object,$data){

        $datas = json_decode($data['task_data']);
        $type = $datas->type;   //要获取的交易对的类型 all/运动员sport/红人star。。。。

        if (!isset($object->{$type})){
            return false;
        }
        tableSet($object->{$type},$data['fd'],['fd'=>$data['fd']]);
//        echo "所有交易对的在线用户：";
//        echo PHP_EOL;
//        var_dump(tableGet($object->{$type},'',2));

//        $dealPair = $this->redis->hMget((swooleConfig('pair'))['gather'].$type,(swooleConfig('pair'))['hash'],['id','icon','base_coin_code','pair_name','last_price','orderby','updated_at','volume','turnover','first_price','trend']);
        $dealPair = $ws_object->redis->hMget((swooleConfig('pair'))['gather'].$type,(swooleConfig('pair'))['hash'],['id','icon','base_coin_code','pair_name','last_price','orderby','updated_at','volume','turnover','first_price','trend']);
        foreach ($dealPair as $k => $v){
            $dealPair[$k]['icon'] = swooleConfig('oss') . $v['icon'];
            $dealPair[$k]['base_quote_code'] = (explode('_',$v['pair_name']))[1];
            $dealPair[$k]['trend'] = explode(',',$v['trend']);
//            $dealPair[$k]['pair_name'] = $v['base_coin_code'];
//            unset($dealPair[$k]['base_coin_code']);
//            $dealPair[$k]['last_price'] = numberCut($dealPair[$k]['last_price'],4);
//            $dealPair[$k]['orderby'] = numberCut($dealPair[$k]['orderby'],4);
//            $dealPair[$k]['volume'] = numberCut($dealPair[$k]['volume'],4);
//            $dealPair[$k]['turnover'] = numberCut($dealPair[$k]['turnover'],4);
            if (numberCut($dealPair[$k]['first_price'],4) == 0){
                $up_down = (string)(numberCut($v['last_price'],4) - numberCut($dealPair[$k]['first_price'],4));
            }else {
//                $up_down = (string)((numberCut($v['last_price'], 4) - numberCut($dealPair[$k]['first_price'], 4)) / numberCut($dealPair[$k]['first_price'], 4));
                $up_down = bcdiv(numberCut($v['last_price'], 4) - numberCut($dealPair[$k]['first_price'],4), numberCut($dealPair[$k]['first_price'], 4),4);
            }
                $dealPair[$k]['up_down'] = numberCut($up_down,4);
        }
        $return = responseJson(1,'dealPairType',$dealPair,'dealPairType');
        echo 'dealPairType' . PHP_EOL;
        var_dump($dealPair);
        return $ws_object->push($data['fd'],$return);


    }




    /**
     * 获取单个交易对的信息
     * @param $object
     * @param $ws_object
     * @param $data
     */
    public function dealPair($object,$ws_object,$data){

        $datas = json_decode($data['task_data']);
        $type = $datas->type;   //要获取的交易对的id  1/2/3/。。。。
        if (!isset($object->{('dealPair_'.$type)})){
            return false;
        }

        tableSet($object->{('dealPair_'.$type)},$data['fd'],['fd'=>$data['fd']]);
//        echo "具体交易对的在线用户：";
//        echo PHP_EOL;
//        var_dump(tableGet($object->{('dealPair_'.$type)},'',2));
//        $dealPair = $this->redis->hashGet((swooleConfig('pair'))['hash'].$type,
        $dealPair = $ws_object->redis->hashGet((swooleConfig('pair'))['hash'].$type,
            [
                'id',
                'icon',
                'base_coin_code','pair_name','last_price','orderby','updated_at',
                'volume','turnover','buy_fee_rate','sell_fee_rate','min_amount',
                'max_amount','price_decimal','amount_decimal','max_buy_pirce_rate',
                'min_sell_pirce_rate','trading_code','trade_open_time','first_price'
            ]);
            //处理数据
            $dealPair['icon'] = swooleConfig('oss') . $dealPair['icon'];

        if (numberCut($dealPair['first_price'],4) == 0){
            $up_down = (string)(numberCut($dealPair['last_price'],4) - numberCut($dealPair['first_price'],4));
        }else {
//                $up_down = (string)((numberCut($v['last_price'], 4) - numberCut($dealPair[$k]['first_price'], 4)) / numberCut($dealPair[$k]['first_price'], 4));
            $up_down = bcdiv(numberCut($dealPair['last_price'], 4) - numberCut($dealPair['first_price'],4), numberCut($dealPair['first_price'], 4),4);
        }
        $dealPair['up_down'] = numberCut($up_down,4);
        $dealPair['base_quote_code'] = (explode('_',$dealPair['pair_name']))[1];

        $return = responseJson(1,'dealPair',$dealPair,'dealPair');
        echo 'dealPair' . PHP_EOL;
        var_dump($dealPair);
        return $ws_object->push($data['fd'],$return);

    }


    /**
     * k线图数据
     * @param $object
     * @param $ws_object
     * @param $data
     */
    public function kLine($object,$ws_object,$data){
        $datas = json_decode($data['task_data']);
        $type = $datas->type;   //要获取的交易对的id  1/2/3/。。。。
        $period = $datas->period;   //时间  1m/1h/。。。
        tableSet($object->{('dealPair_'.$type)},$data['fd'],['fd'=>$data['fd'],'period'=>$period]);
//        $klines = $this->redis->listGet((swooleConfig('kLine'))['gather'].$type.':kline:period:'.$period,0,-1);
        $klines = $ws_object->redis->listGet((swooleConfig('kLine'))['gather'].$type.':kline:period:'.$period,0,-1);
        asort($klines);

//        $pipe = $this->redis->tranStart(\Redis::PIPELINE);
        $pipe = $ws_object->redis->tranStart(\Redis::PIPELINE);
        foreach ($klines as $v){
//    $pipe->hMget((swooleConfig('kLine'))['hash'].$type.':kline:period:'.$period.':startTime:'.$v,$field);
            $pipe->hGetAll((swooleConfig('kLine'))['hash'].$type.':kline:period:'.$period.':startTime:'.$v);
        }
        $return = $pipe->exec();

        var_dump($return);
        return $ws_object->push($data['fd'],responseJson(1,"",$return,'kLine'));


    }


    /**
     * 交易对深度数据
     * @param $object
     * @param $ws_object
     * @param $data
     */
    public function pairDeep($object,$ws_object,$data){
        $datas = json_decode($data['task_data']);
        $type = $datas->type;   //要获取的交易对的id  1/2/3/。。。。
//        $deep = $this->redis->get(swooleConfig('pair')['deep'].$type.':deep');
        $deep = $ws_object->redis->get(swooleConfig('pair')['deep'].$type.':deep');
        var_dump(json_decode($deep));
//        var_dump($deep);
        return $ws_object->push($data['fd'],responseJson(1,'',json_decode($deep),'pairDeep'));

    }


    /**
     * 交易对orderBook数据
     * @param $object
     * @param $ws_object
     * @param $data
     */
    public function orderBook($object,$ws_object,$data){
        $datas = json_decode($data['task_data']);
        $type = $datas->type;   //要获取的交易对的id  1/2/3/。。。。
//        $order_book = $this->redis->listGet(swooleConfig('pair')['orderBook'].$type.':orderBookHistory',0,-1);
        $order_book = $ws_object->redis->listGet(swooleConfig('pair')['orderBook'].$type.':orderBookHistory',0,-1);
        $order_book = array_reverse($order_book);
        foreach ($order_book as $k => $value){
            $order_book[$k] = json_decode($value);
        }
        var_dump(json_encode($order_book));
        return $ws_object->push($data['fd'],responseJson(1,'',$order_book,'orderBook'));

    }


    /**
     * 用户资产状况
     * @param $object
     * @param $ws_object
     * @param $data
     */
    public function userAssets($object,$ws_object,$data)
    {
        $datas = json_decode($data['task_data']);
//        $type = explode(',', $datas->type);   //要获取的交易对的id  1/2/3/。。。。
        $token = $datas->token;
        if (!$token) {
            $ws_object->push($data['fd'], responseJson(0, "请求有误"));
            return false;
        }
        $user_info = getToken($ws_object, $token);
        var_dump($user_info);
        if (!$user_info) {
            $ws_object->push($data['fd'], responseJson(-1, "非法请求"));
            return false;
        }

        tableSet($object->user, $data['fd'], ['fd' => $data['fd'], 'user_no' => $user_info['user_no']]);

        $user_assets_key = $ws_object->redis->hscanGet(swooleConfig('userAsset') . $user_info['user_no'] . ':coinId:*',50);

        $coins = $ws_object->redis->hMget((swooleConfig('coins'))['gather'],(swooleConfig('coins'))['hash'],
            ['recharge_min_confirms','updated_at','created_at','wallet_password_salt','rpc_host','coin_code','max_withdraw_amount','rpc_password','icon','tx_url_format','latest_block_number','orderby','is_deposit_enabled','name','rpc_user','day_max_withdraw_amount','min_withdraw_amount','status','withdraw_fee','rpc_port','is_withdraw_enabled']);

        var_dump($coins);


        if (!$user_assets_key){
            $ws_object->push($data['fd'], responseJson(-2, "未找到相关资产"));
            return false;
        }

        $user_assets = array();
        foreach($user_assets_key as $k){
            $user_assets[] = $ws_object->redis->hashGet($k,'',2);
        }
//        var_dump(swooleConfig('userAsset') . $user_info['user_no'] . ':coinId:1');
//        var_dump($user_assets);

        return $ws_object->push($data['fd'],responseJson(1,'',$coins,'userAssets'));

    }


    /**
     * 委托中的订单
     * @param $object
     * @param $ws_object
     * @param $data
     */
    public function orderPair($object,$ws_object,$data){
        $datas = json_decode($data['task_data']);
        $type = $datas->type;   //要获取的交易对的id  1/2/3/。。。。
        $token = $datas->token;
        if (!isset($type) || !isset($token)) {
            $ws_object->push($data['fd'], responseJson(0, "请求有误"));
            return false;
        }
        $user_info = getToken($ws_object, $token);
        var_dump($user_info);
        if (!$user_info) {
            $ws_object->push($data['fd'], responseJson(-1, "非法请求"));
            return false;
        }

        tableSet($object->user, $data['fd'], ['fd' => $data['fd'], 'user_no' => $user_info['user_no'],'pair'=>$type]);
        $mysql = Pdomysql::getInstance(swooleConfig('DB_CONNECTION'),swooleConfig('DB_HOST'),swooleConfig('DB_USER'),swooleConfig('DB_PASS'),swooleConfig('DB_DATABASE'),swooleConfig('DB_PORT'));
        $orderPair = $mysql->fetAll('inex_order_pairid_'.$type,
            'deal_amount,price,argv_price,current_frozen_amount,pair_id,user_no,order_amount,type,fee_rate,created_at,pair,updated_at,fee_coin_code,turnover,order_no,initial_frozen_amount,fee,status',
            'updated_at',
            'user_no='.$user_info['user_no'].' and pair_id=' . $type . ' and status=1');
        var_dump($orderPair);

        return $ws_object->push($data['fd'],responseJson(1,'',$orderPair,'orderPair'));
    }


    /**
     * 删除不需要类别中的fd
     * @param $object
     * @param $ws_object
     * @param $data
     */
    public function delTypeFd($object,$ws_object,$data){
        $datas = json_decode($data['task_data']);
        $type = $datas->type;
        if (!isset($type)){
            $ws_object->push($data['fd'],responseJson(0,"请求有误",'','delTypeFd'));
        }
        foreach ($type as $table_name){
            if (isset($object->{$table_name})){
                if ($object->{$table_name}->exist($data['fd'])){
                    $object->{$table_name}->del($data['fd']);
//                       return true;
                }
            }

        }

    }

}