<?php
/*
 *
 * @auth chenjianhua <dyoung@qq.com>
 * @desc 短信发送
 * @link https://dyoung.unnnnn.com
 */
/*
 * 接口和代理地址：http://47.95.229.24:9008/
 * 报告地址 http://47.95.229.24:9003
 * @param $data array
 * @param $data['number'] 电话号码
 * @param $data['content'] 短信内容
 * @param $data['isLongSms'] 是否是长文本
 * @desc sendSms
 * @since v1.2.3
 * @date 2018年05月30日11:22:39
 */
function SendSms($data = []){
    $origin = [
        'number'=>'18721662013',
        'content'=>'Hello world',
        'isLongSms'=>0
    ];
    $sendData = array_merge($origin,$data);
    $url = 'http://47.95.229.24:9008/';//系统接口地址
    $content = urlencode(mb_convert_encoding($sendData['content'],'GBK','UTF-8'));
    $username = "1367784103";//用户名
    $password = base64_encode('mima123456');//密码百度BASE64加密后密文//bWltYTEyMzQ1Ng==
    $url = $url . "/servlet/UserServiceAPI?method=sendSMS&extenno=&isLongSms=".$sendData['isLongSms']."&username=" . $username . "&password=" . $password . "&smstype=1&mobile=".$sendData['number']."&content=" . $content;
    $result = file_get_contents($url);
    $encode = mb_detect_encoding($result, array('ASCII','GB2312','GBK','UTF-8'));
    $utf8Result = mb_convert_encoding($result,"UTF-8",$encode);
    file_put_contents('./smslog.txt',date('Y-m-d H:i:s').' 手机号码:'.$data['bumber'].'内容:'.$data['content'].' 发送状态:'.$utf8Result,FILE_APPEND);
    //var_dump(mb_strrpos($result,"success"));exit;
    if (!strpos($utf8Result,"success")) {
      echo  json_encode([
            'code'=>200,
            'msg'=>'ok'
        ]);
    }else{
        $reString = json_encode([
            'code'=>400,
            'msg'=>$utf8Result
        ]);
        echo $reString;
    }
    exit(0);
}

$data['number'] = '18721662013';
$data['content'] = '【中国移动】你的电话已缴费,充值1000086元成功,退订回T';

SendSms($data);