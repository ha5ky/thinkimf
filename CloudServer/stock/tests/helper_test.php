<?php
/**
 * Created by PhpStorm.
 * User: Echo
 * Date: 2018/4/9
 * Time: 14:21
 */

define('WEB_ROOT',__DIR__.'/..');
$autoLoadFilePath = WEB_ROOT.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
require_once $autoLoadFilePath;

//tableCreate('hello');
$token = 'tFeqppyoj57RVnJVl5NmlGpjaZliaG2UY56WmJViiJFboaSaoKSPo9aVrKjXhW+TY1Skyp+WW55km5WUmWCfnmxnsg==';
var_dump(getToken($token));