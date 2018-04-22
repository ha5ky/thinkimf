<?php
/**
 * 全局方法
 * Created by PhpStorm.
 * User: Echo
 * Date: 2018/4/9
 * Time: 14:16
 */


$configs = array();
$files = glob(WEB_ROOT.'/config/*.php');
if (is_array($files)){
    foreach ($files as $k =>$file){
        require_once $file;
        if (is_array($config) && isset($config[$k])){
            foreach ($config[$k] as $key => $value){
                $configs[$key] = $value;
            }
        }
    }
}

define('SWOOLE_CONFIG',$configs);


/**
 * 获取系统配置
 * @param $key
 */
function swooleConfig($key){
    $config = SWOOLE_CONFIG;
    if (isset($config[$key])){
        $return = is_array(SWOOLE_CONFIG[$key]) ? SWOOLE_CONFIG[$key] : trim(SWOOLE_CONFIG[$key]);
        return $return;
    }
    return false;
}


/**
 * 创建需要用到的table表
 * @param $object        Ws类的实例化
 * @param $table_array   Ws中定义的table数组，用于存放table表的实例
 */
function tableCreate($object){
    foreach (swooleConfig('table_object') as $table_object){
        foreach (swooleConfig($table_object) as $table_name => $table_field) {
//            array_push($table_array,$table_name);
            $object->{$table_name} = new swoole_table(1500000);
            $bool = tableColumn($object->{$table_name},$table_field);
            if (!$bool){
                return false;
            }


            if(!$object->{$table_name}->create()){
                return false;
            }

//            tableSet($object->{$table_name},$table_name,['fd'=>1111]);
//            foreach($object->{$table_name} as $k => $v){
//                var_dump($k);
//                echo PHP_EOL;
//                var_dump($v);
//            }

        }
    }
    return true;

}



/**
 * 数据表定义
 * @param     $name
 * @param     $type
 * @param int $len
 */
function tableColumn(\swoole_table $table, $arr){
    $allType = ['int' => \swoole_table::TYPE_INT, 'string' => \swoole_table::TYPE_STRING, 'float' => \swoole_table::TYPE_FLOAT];
    foreach ($arr as $row) {
        if (!isset($allType[$row['type']])) $row['type'] = 'string';
        $bool = $table->column($row['key'], $allType[$row['type']], $row['len']);
        if (!$bool){
            return false;
        }


    }
    return true;
}


/**
 * 存入【指定表】【行键】【行值】
 * @param       $key
 * @param array $array
 * @return bool
 */
function tableSet($table, $key, array $array){
    $table->set($key, checkArray($array));
    return true;
}


/**
 * 存入数据时，遍历数据，二维以上的内容转换JSON
 * @param array $array
 * @return array
 */
function checkArray(array $array){
    $value = [];
    foreach ($array as $key => $arr) {
        $value[$key] = is_array($arr) ? json_encode($arr, 256) : $arr;
    }
    return $value;
}



/**
 * 记录【某个表】所有记录的键值，或读取【某个表】
 * @param $table
 * @param null $key 不指定为读取
 * @param int $type 要获取的数据类型 0:返回所有key 1:返回所有value 2:返回所有key->value
 * @return array
 */
function tableGet($table, $key = null, $type = 0){

    $return = null;

    if ($key) {
        $return = $table->get($key);
    }else {
        $return = array();
        switch ($type) {
            case 0:
                foreach($table as $row => $v)
                {
                    array_push($return,$row);
                }
                break;
            case 1:
                foreach($table as $row => $v)
                {
//                    var_dump('k:');
//                    echo PHP_EOL;
//                    var_dump($row);
//                    echo PHP_EOL;
//                    var_dump('v:');
//                    echo PHP_EOL;
//                    var_dump($v);
                    array_push($return,$v['fd']);
                }
                break;
            case 2:
                foreach($table as $row)
                {
                    array_push($return,$row);
                }
                break;
            default:
                $return = false;
                break;
        }
    }

    return $return;

}



/**
 * 返回json格式数据
 * @param int $status
 * @param string $message
 * @param array $data
 * @return string
 */
function responseJson($status = 1, $message = '', $data = array(),$type=null) {
    $data = [
        'status' => $status,
        'message' => $message,
        'data' => $data,
        'type'  => $type
    ];
    return json_encode($data,JSON_UNESCAPED_UNICODE);
}

/**
 * 保留小数点后位数
 * @param $nums   被截取的数字
 * @param $num   保留小数点后位数
 */
function numberCut($nums,$num){
    $nu = $num+1;
    return substr(sprintf("%.".$nu."f", $nums),0,-1);
}


//获取token
function getToken($ws_object,$token){
    $userNo = decryptToken($token);
    if (!$userNo) {
        return false;
    }
//    var_dump($userNo);
    $key = swooleConfig('KEY_USER_INFO') . $userNo['user_no'];
    $filed = ['email'];
//    $redis = new Swoole\Libs\Predis(swooleConfig('REDIS_ADDR'),swooleConfig('REDIS_PORT'),swooleConfig('REDIS_AUTH'));
    $token = $ws_object->redis->hashGet($key,'',2);
//    $token = $redis->exists($key);
    if (!$token) {
        return false;
    }
    return $token;
}


//解析token
function decryptToken($token){
    try {
        $tokenJson = decrypt($token, swooleConfig('salt'));
    } catch (\Exception $e) {
        return false;
    }
    $userToken = json_decode($tokenJson, true);
    //login_status = -2  尚未通过手机或谷歌验证
    if (isset($userToken['login_status'])) {
        if ($userToken['login_status'] == -2) {
            return false;
        }
    }
    return $userToken;
}



//字符串加密
function encrypt($data, $key){
    $key = md5($key);
    $x = 0;
    $char = "";
    $str = "";
    $len = strlen($data);
    $l = strlen($key);
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) {
            $x = 0;
        }
        $char .= $key{$x};
        $x++;
    }
    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
    }
    return base64_encode($str);
}


//字符串解密
function decrypt($data, $key){
    $key = md5($key);
    $x = 0;
    $char = "";
    $str = "";
    $data = base64_decode($data);
    $len = strlen($data);
    $l = strlen($key);
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) {
            $x = 0;
        }
        $char .= substr($key, $x, 1);
        $x++;
    }
    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        } else {
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return $str;
}