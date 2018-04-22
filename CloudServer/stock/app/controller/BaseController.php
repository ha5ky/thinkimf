<?php

/**
 * Created by PhpStorm.
 * User: Echo
 * Date: 2018/4/9
 * Time: 19:17
 */

namespace Swoole\Controller;

use Swoole\Libs\Pdomysql;

class BaseController{

    protected $db;

    public function __construct(){
        $this->db = Pdomysql::getInstance(swooleConfig('DB_CONNECTION'),swooleConfig('DB_HOST'),swooleConfig('DB_USER'),swooleConfig('DB_PASS'),swooleConfig('DB_DATABASE'),swooleConfig('DB_PORT'));
    }

}