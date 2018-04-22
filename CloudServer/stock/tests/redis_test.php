<?php
/**
 * Created by PhpStorm.
 * User: Echo
 * Date: 2018/4/9
 * Time: 18:08
 */

define('WEB_ROOT',__DIR__.'/..');
$autoLoadFilePath = WEB_ROOT.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
require_once $autoLoadFilePath;

use Swoole\Libs\Predis;
//$redis = new Predis(swooleConfig('REDIS_ADDR'),swooleConfig('REDIS_PORT'));
$redis = new \Redis();
$redis->connect(swooleConfig('REDIS_ADDR'),swooleConfig('REDIS_PORT'));
$pairs = $redis->zRevRange('inex:zset:pair:type:all',0,-1);
//var_dump($pairs);
//echo PHP_EOL;
//$array = array();
//$field = ['last_price'];
$pipe = $redis->multi(\Redis::PIPELINE);
foreach ($pairs as $v){

//    $res = $pipe->hMget("inex:hashTable:pair:pairId:" . $v,$field);
    $res = $pipe->hGetAll("inex:hashTable:pair:pairId:" . $v);
////    array_push($array,$res);
}
$result = $pipe->exec();
var_dump($result);
//$redis->set('hello',121212,10);
//$redis->persist('hello');
//var_dump($redis->get('hello'));
//var_dump($redis->ping());


//$redis = new \Redis();
//$redis->connect(swooleConfig('REDIS_ADDR'),swooleConfig('REDIS_PORT'));
//$redis->flushAll();
//
//for ($i=1;$i<=10;$i++){
//    $redis->sAdd('inex:list:pair:pairId:1:kline:period:1m',$i,$i);
//    $redis->hMSet('inex:hashTable:orderBook:pair:pairId:1:time:'.$i,['pair_id'=>$i,'last_price'=>'hello'. ($i+$i)]);
//
//}
//
//$sort = array(
//    'BY' => 'inex:hashTable:orderBook:pair:pairId:1:time:*->pair_id',
//    'SORT'=>'DESC',
//    'GET' => 'inex:hashTable:orderBook:pair:pairId:1:time:*->last_price'
//);
//var_dump($redis->sort('inex:list:pair:pairId:1:kline:period:1m',$sort));
//for ($j=1;$j<=10;$j++){
//    var_dump($redis->hMGet('inex:hashTable:orderBook:pair:pairId:1:time:'.$i,array('pair_id','last_price')));
//}

