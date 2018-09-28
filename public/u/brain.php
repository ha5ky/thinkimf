<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/28
 * Time: 14:41
 */
#http://docs.ruyi.ai/502931
$api_host = 'http://api.ruyi.ai/v1/message';
$app_key = '631e72e1-6867-49b9-af92-36d4c4c154de';
$uuid = "UNISSA00001";
$word = empty($_REQUEST['words'])?'你好':$_REQUEST['words'];
trait  Tools
{
    static function Request($url = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //信任任何证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 检查证书中是否设置域名,0不验证
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        $res = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        }
        curl_close($ch);
        return $res;
    }
}

$requestUrl = $api_host . '?app_key=' . $app_key . '&user_id=' . $uuid . '&q=' . $word;
$response = file_get_contents($requestUrl);

var_dump($response,$requestUrl);