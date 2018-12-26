<?php
/**
 * phpredis扩展
 *
 */

namespace CloudServer\Core\db;


use function var_dump;

class ImfRedis extends \Redis
{
    //REDIS服务主机IP
    private $_HOST = null;

    //redis服务端口
    private $_PORT = null;

    //连接时长 默认为0 不限制时长
    private $_TIMEOUT = 0;

    //数据库名
    private $_DBNAME = null;

    //连接类型 1普通连接 2长连接
    private $_CTYPE = 2;

    //实例名
    public $_REDIS = null;

    private static $_instance = null;

    //初始化
    public function __construct($config = [])
    {
        $this->_HOST = $config['host'];
        $this->_PORT = $config['port'];
        $this->_TIMEOUT = $config['timeout'];
        if ($config['persistent'] == true) {
            $this->_CTYPE = 2;//2为长连接
        } else {
            $this->_CTYPE = 1;
        }
        if (is_null($this->_REDIS)) {
            $this->_REDIS = new \Redis();
            switch ($this->_CTYPE) {
                case 1:
                    $this->_REDIS->connect($this->_HOST, $this->_PORT, $this->_TIMEOUT);
                    break;
                case 2:
                    $this->_REDIS->pconnect($this->_HOST, $this->_PORT, $this->_TIMEOUT);
                    break;
            }
        }
        $this->_REDIS->auth($config['password']);
        $this->_REDIS->setOption(\Redis::OPT_PREFIX, $config['prefix']);

    }

    /**
     * 查看redis连接是否断开
     *
     * @return $return bool true:连接未断开 false:连接已断开
     */
    public function ping()
    {
        $return = null;

        $return = $this->_REDIS->ping();

        return $return === 'PONG' ? true : false;
    }

    /**
     * 单例模式
     *
     * @param mixed $params
     *
     * @return object
     */
    public static function getInstance($config = [])
    {
        if (!self::$_instance) {
            $selfInstance = new self();
            self::$_instance = $selfInstance;
        }
        return self::$_instance;
    }


    /**
     * 设置key
     *
     * @param string $key
     * @param string $value
     * @param int    $timeOut
     *
     * @return boolen
     */
    public function set($key, $value, $timeOut = 0)
    {
        if ($timeOut > 0) {
            $result = $this->_REDIS->setex($key, $timeOut, $value);
        } else {
            $result = $this->_REDIS->set($key, $value);
        }
        return $result;
    }

    public function get($key)
    {
        return $this->_REDIS->get($key);
    }

    public function keys($pattern)
    {
        return $this->_REDIS->keys($pattern);
    }

    //判断键值是否存在
    public function exists($key)
    {
        return $this->_REDIS->exists($key);
    }

    /*开启事务*/
    public function multi($type = \Redis::MULTI)
    {
        return $this->_REDIS->multi($type);
    }

    /*执行事务*/
    public function exec()
    {
        return $this->_REDIS->exec();
    }

    /*监听（乐观锁）
    */
    public function watch($key)
    {
        $this->_REDIS->watch($key);
        return true;
    }

    /*取消监听所有的key*/
    public function unwatch()
    {
        $this->_REDIS->unwatch();
        return true;
    }

    public function __destruct()
    {
        if (!$this->_REDIS) $this->_REDIS->close();
    }
}