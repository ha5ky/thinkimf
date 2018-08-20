<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/5/19
 * Time: 下午7:14
 */
define("APP_ROOT",__DIR__);
define("APP_VERSION","V".date('Y-m'));
define("APP_AUTHOR","chenjianhua");
define("APP_AUTHOR_EMAIL","dyoungchen@gmail.com");
define("APP_AUTHOR_BLOG","https://dyoung.unnnnn.com");
define("DS",DIRECTORY_SEPARATOR);
error_reporting(E_ALL);
require_once APP_ROOT . DS . 'autoloader.php';
CloudServer\autoloader::register();
$config = require_once APP_ROOT.DS.'config'.DS.'config.php';
//生成 redis,mysql连接资源
$dbConnection = new CloudServer\Core\db\PdoMysql($config['db']);

$redisConnection = new CloudServer\Core\db\ImfRedis($config['redis']);

//var_dump($dbConnection->where([
//    '_id'=>[
//        2,'>','and'
//    ]
//])->select("imf_app"));
//$redisConnection->set("chenjianhua","chenjianhua")

$cloud = new CloudServer\Core\InnovationCloud($config);

$cloud->setDbConnection($dbConnection);
$cloud->setRedisConnection($redisConnection);

$cloud->run();


