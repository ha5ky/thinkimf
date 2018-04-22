<?php
/**
 * 处理redis频道推送的消息
 * Created by PhpStorm.
 * User: Echo
 * Date: 2018/4/9
 * Time: 19:11
 */

namespace Swoole\Controller;

use Swoole\Controller\BaseController;

class RedisMessageController extends BaseController{

    public function __construct(){
        parent::__construct();
    }

    public static function index($object,$data){
        var_dump('controller--------------');
        echo PHP_EOL;
        var_dump($object->connections);
        foreach ($object->connections as $fd) {
            if ($fd !== $data['fd']){
                $object->push($fd, $data['task_data']);
            }else{
                $object->push($data['fd'],responseJson(1,"已接收到推送消息"));
            }

        }
        echo PHP_EOL;
        var_dump($data);
        return true;
    }


    /**
     * 交易对变化时候，向首页的所有交易对进行推送
     * @param $object
     * @param $ws_object
     * @param $data
     */
    public function dealPairType($object,$ws_object,$data){
        $datas = json_decode($data,true);
        $push_data = $datas['data'];
        $pair = $push_data['pair'];
        if (empty($pair)){
            return false;
        }
        if (numberCut($pair['first_price'],4) == 0){
            $pair['up_down'] = (string)((numberCut($pair['last_price'],4) - numberCut($pair['first_price'],4))*100);
        }else {
            $pair['up_down'] = (string)(((numberCut($pair['last_price'], 4) - numberCut($pair['first_price'], 4)) / numberCut($pair['first_price'], 4))*100);
        }
        $tage = explode(',',$push_data['pair']['tage']);
        foreach ($tage as $k){
            $fds = tableGet($object->{$k},'',1);    //当前分组内的所有fd
            if (!empty($fds)){
                foreach ($fds as $fd){
                    $ws_object->push($fd,responseJson(1,'',$pair,'dealPairType'));
                }
            }
        }

//        var_dump(tableGet($object->{$type},'',2));
//        var_dump($tage);
        return true;
    }


    /**
     * 单个交易对变化时候，向单个交易对的组进行推送
     * @param $object
     * @param $ws_object
     * @param $data
     */
    public function dealPair($object,$ws_object,$data){
        $datas = json_decode($data,true);
        $push_data = $datas['data'];
        $pair = $push_data['pair'];
        if (empty($pair)){
            return false;
        }
        if (numberCut($pair['first_price'],4) == 0){
            $pair['up_down'] = (string)((numberCut($pair['last_price'],4) - numberCut($pair['first_price'],4))*100);
        }else {
            $pair['up_down'] = (string)(((numberCut($pair['last_price'], 4) - numberCut($pair['first_price'], 4)) / numberCut($pair['first_price'], 4))*100);
        }

        $pair_id = $push_data['pair']['pair_id'];
        $fds = tableGet($object->{$pair_id},'',1);    //当前分组内的所有fd
        if (!empty($fds)){
            foreach ($fds as $fd){
                $ws_object->push($fd,responseJson(1,'',$pair,'dealPair'));
            }
        }

        return true;
    }


    public function userAssets($object,$ws_object,$data){

    }

}