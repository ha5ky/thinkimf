<?php
/**
 * Created by PhpStorm.
 * User: Echo
 * Date: 2018/4/9
 * Time: 17:36
 */

define('WEB_ROOT',__DIR__.'/..');
$autoLoadFilePath = WEB_ROOT.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
require_once $autoLoadFilePath;


use Swoole\Libs\Pdomysql;
$db = Pdomysql::getInstance(swooleConfig('DB_CONNECTION'),swooleConfig('DB_HOST'),swooleConfig('DB_USER'),swooleConfig('DB_PASS'),swooleConfig('DB_DATABASE'),swooleConfig('DB_PORT'));
$res = $db->fetAll('inc_app','id,secret','',"id=298315849712795648 or type=1");
var_dump($res);