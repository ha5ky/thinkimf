<?php
/**
 * Created by PhpStorm.
 * User: Echo
 * Date: 2018/4/9
 * Time: 12:38
 */

namespace Swoole\Controller;
use Swoole\Libs\Pdomysql;

class TestController{
    protected $db = '';
    public function __construct(){
        $this->db = Pdomysql::getInstance(swooleConfig('DB_CONNECTION'),swooleConfig('DB_HOST'),swooleConfig('DB_USER'),swooleConfig('DB_PASS'),swooleConfig('DB_DATABASE'),swooleConfig('DB_PORT'));
    }

    public function index(){
//        $res = responseJson(1,"成功",["hello"=>"hello"]);
//        return $res;
        var_dump($this->db->fetOne('inc_app','id'));
//        var_dump($this->db);
        return swooleConfig('SERVER_LISTEN_ADDR');
    }
}