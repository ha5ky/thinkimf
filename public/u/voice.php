<?php
define('DEMO_CURL_VERBOSE', false);
# 填写网页上申请的appkey 如 $apiKey="g8eBUMSokVB1BHGmgxxxxxx"
$apiKey = "4E1BG9lTnlSeIf1NQFlrSq6h";
# 填写网页上申请的APP SECRET 如 $secretKey="94dc99566550d87f8fa8ece112xxxxx"
$secretKey = "544ca4657ba8002e3dea3ac2f5fdd241";
# text 的内容为"欢迎使用百度语音合成"的urlencode,utf-8 编码
# 可以百度搜索"urlencode"
//$_REQUEST['words']
$text = empty($_REQUEST['words'])?"你好，我叫尤妮莎 ,很高兴为你服务，你也可以叫我小U，":$_REQUEST['words'];

$text2 = mb_convert_encoding($text, "UTF-8", "GBK");
#echo "text length :" . mb_strlen($text2, "GBK") . "\n";

#发音人选择, 0为普通女声，1为普通男生，3为情感合成-度逍遥，4为情感合成-度丫丫，默认为普通女声
$per = 4;
#语速，取值0-15，默认为5中语速
$spd = 6;
#音调，取值0-15，默认为5中语调
$pit = 10;
#音量，取值0-9，默认为5中音量
$vol = 9;
// 下载的文件格式, 3：mp3(default) 4： pcm-16k 5： pcm-8k 6. wav
$aue = 3;
$formats = array(3 => 'mp3', 4 => 'pcm', 5 => 'pcm', 6 => 'wav');
$format = $formats[$aue];
$cuid = md5(uniqid(time()));

/** 公共模块获取token开始 */

$auth_url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id=" . $apiKey . "&client_secret=" . $secretKey;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $auth_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //信任任何证书
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 检查证书中是否设置域名,0不验证
curl_setopt($ch, CURLOPT_VERBOSE, DEMO_CURL_VERBOSE);
$res = curl_exec($ch);
if (curl_errno($ch)) {
    //print curl_error($ch);
}
curl_close($ch);

#echo "Token URL response is " . $res . "\n";
$response = json_decode($res, true);

if (!isset($response['access_token'])) {
    //echo "ERROR TO OBTAIN TOKEN\n";
    exit(json_encode([
        'code' => 2,
        'message' => "ERROR TO OBTAIN TOKEN",
    ]));
}
if (!isset($response['scope'])) {
    //echo "ERROR TO OBTAIN scopes\n";
    exit(json_encode([
        'code' => 2,
        'message' => "ERROR TO OBTAIN scopes",
    ]));


}

if (!in_array('audio_tts_post', explode(" ", $response['scope']))) {
    echo "DO NOT have tts permission\n";
    // 请至网页上应用内开通语音合成权限
    exit(json_encode([
        'code' => 2,
        'message' => "请至网页上应用内开通语音合成权限",
    ]));
}

$token = $response['access_token'];
#echo "token = $token ; expireInSeconds: ${response['expires_in']}\n\n";
/** 公共模块获取token结束 */

/** 拼接参数开始 **/
// tex=$text&lan=zh&ctp=1&cuid=$cuid&tok=$token&per=$per&spd=$spd&pit=$pit&vol=$vol
$params = array(
    'tex' => urlencode($text), // 为避免+等特殊字符没有编码，此处需要2次urlencode。
    'per' => $per,
    'spd' => $spd,
    'pit' => $pit,
    'vol' => $vol,
    'aue' => $aue,
    'cuid' => $cuid,
    'tok' => $token,
    'lan' => 'zh', //固定参数
    'ctp' => 1, // 固定参数
);
$paramsStr = http_build_query($params);
$url = 'http://tsn.baidu.com/text2audio';
$urltest = $url . '?' . $paramsStr;
#echo $urltest . "\n"; // 反馈请带上此url

/** 拼接参数结束 **/

$g_has_error = true;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $paramsStr);
function read_header($ch, $header)
{
    global $g_has_error;

    $comps = explode(":", $header);
    // 正常返回的头部 Content-Type: audio/*
    // 有错误的如 Content-Type: application/json
    if (count($comps) >= 2) {
        if (strcasecmp(trim($comps[0]), "Content-Type") == 0) {
            if (strpos($comps[1], "audio/") > 0) {
                $g_has_error = false;
            } else {
                //echo $header . " , has error \n";
                exit(json_encode([
                    'code' => 2,
                    'message' => $header,
                ]));
            }
        }
    }
    return strlen($header);
}

curl_setopt($ch, CURLOPT_HEADERFUNCTION, 'read_header');
$data = curl_exec($ch);
if (curl_errno($ch)) {
    #echo curl_error($ch);
    //exit(2);
    exit(json_encode([
        'code' => 2,
        'message' => curl_error($ch),
    ]));
}
curl_close($ch);
if (!file_exists('./voice')) {
    mkdir('./voice', 755);
}
$file = $g_has_error ? "error.txt" : './voice/' . date("Y_m_d_H_i_s") . '.' . $format;
file_put_contents($file, $data);
//echo "\n$file saved successed, please open it \n";
//header('content-type:application/json;charset=utf-8');
function is_https()
{
    if (!isset($_SERVER['HTTPS']))
        return true;
    if ($_SERVER['HTTPS'] === 1) { //Apache  
        return true;
    } elseif ($_SERVER['HTTPS'] === 'on') { //IIS  
        return true;
    } elseif ($_SERVER['SERVER_PORT'] == 443) { //其他  
        return true;
    }
    return true;
}

if (is_https()) {
    $pre = 'http://';
} else {
    $pre = 'https://';
}
if (!in_array($_SERVER['SERVER_PORT'], [80, 443])) {
    $urlPre = $pre . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . (dirname($_SERVER["REQUEST_URI"]) . ltrim($file, "."));
} else {
    $urlPre = $pre . $_SERVER['SERVER_NAME'] . (dirname($_SERVER["REQUEST_URI"]) . ltrim($file, "."));
}
header('content-type:application/json;charset=utf-8');
#array_map('unlink', glob("./voice/*.mp3"));
exit(json_encode([
    'code' => 1,
    'message' => 'ok',
    'src' => $urlPre
]));