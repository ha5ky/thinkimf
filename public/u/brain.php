<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/28
 * Time: 14:41
 */

namespace root;
#http://docs.ruyi.ai/502931
$api_host = 'http://api.ruyi.ai/v1/message';
$app_key = '631e72e1-6867-49b9-af92-36d4c4c154de';
$uuid = "UNISSA00001";
$word = empty($_REQUEST['words']) ? '你好' : $_REQUEST['words'];
function httpRequest($url = null, $method = 'get', $headers = [], $params = [], $timeout = 60)
{
    if (is_array($params)) {
        $requestString = http_build_query($params);
    }
    if (empty($headers)) {
        $headers = ['Content-type: text/json'];
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 180);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    switch (strtoupper($method)) {
        case "GET" :
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            break;
        case "POST":
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestString);
            break;
        case "PUT" :
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestString);
            break;
        case "DELETE":
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestString);
            break;
    }
    $response = curl_exec($ch);
    $responseInfo = curl_getinfo($ch);
    /*var_dump($response);
    exit;*/
    if (200 != $responseInfo['http_code']) {
        return [
            'error' => curl_error($ch),
            'err_msg' => $response,
            'url' => $url,
        ];
    } else {
        return $response;
    }
    curl_close($ch);
}

$requestUrl = $api_host . '?app_key=' . $app_key . '&user_id=' . $uuid . '&q=' . urlencode($word);
$response = httpRequest($requestUrl);
$array = json_decode($response,true);
echo '<pre>';
var_dump($array);