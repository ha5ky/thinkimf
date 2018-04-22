<?php

namespace Swoole\Libs;

use \Redis;

class MyRedis extends Redis{

    protected static $_instance = null;
    protected $dbLink = null;
    protected $_error = '';

    /**
     * 单例模式
     *
     * @param mixed $params
     * @return object
     */
    public static function getInstance( $redis_config = array() ){
        if (!self::$_instance)	{
            $self_instance = new self();
            $self_instance->connect1($redis_config);
            self::$_instance = $self_instance;
        }
        return self::$_instance;
    }

    public function connect1( array $config = null ){
        try {
            $this->dbLink = parent::connect( $config['host'] , $config['port']);
        } catch (\Exception $e) {
            throw new \Exception( 'The Redis connection failed' );
        }

        if (!empty( $config['auth'] )){
            parent::auth( $config['auth'] );
        }
    }

    public function __construct( array $config = null ){
        if (! extension_loaded( 'Redis' )){
            throw new \Exception( 'Does not support the Redis extension' );
        }
        if(is_array($config)){
            $this->connect1($config);
        }
    }


    public function __destruct()
    {
        if($this->dbLink) parent::close();
    }
}