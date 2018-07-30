<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/26
 * Time: 上午2:30
 */

namespace app\api\controller;

use app\admin\model\UserModel;
use function json_decode;
use PHPQRCode\QRcode;
use const JSON_UNESCAPED_UNICODE;
use function json_encode;
use function RedisInstance;
use function uniqueString;
use function var_dump;

class User extends Base
{

    /*
     * 扫码登录
     */
    public function Qrcode()
    {
        $qrcodeUid = uniqueString(32);
        //给前端
        cookie('qid', $qrcodeUid);
        //给后端服务器
        ob_end_clean();
        header("Content-type: image/png");
        QRcode::png($qrcodeUid, false, 3, 5, 1);

    }

    public function checkScanCode()
    {
        $qrcodeUid = $this->request->request('qid');

        $userInfo = RedisInstance()->get('info' . $qrcodeUid);

        if(is_null($userInfo)){
            $this->json([
                'code'=>400124,
                'msg'=>json_decode($userInfo,true)
            ]);

        }else{

            $userInfoArr = json_decode($userInfo,true);

            session('userid',$userInfoArr['id']);
            session('user_type',$userInfoArr['user_type']);
            session('username',($userInfoArr['name']??$userInfoArr['id']??$userInfoArr['email']??$userInfoArr['phone']??$userInfoArr['nickname']));
            cookie('userid',$userInfoArr['id']);
            cookie('username',$userInfoArr['name']);

            $this->json([
                'code'=>200,
                'msg'=>'扫码登录成功'
            ]);
        }


    }

    public function appQrcodeLogin()
    {
        $uuid = $this->request->post('uuid');
        $qid =  $this->request->post('qid');
        if (empty($qid)) {
            $this->json([
                'icode' => 40001,
                'msg' => '缺少参数 qid'
            ]);

        }
        if (empty($uuid)) {
            $this->json([
                'icode' => 40002,
                'msg' => '缺少参数 uuid'
            ]);

        }

        //查找用户信息写入redis
        $userModel = new UserModel();
        $userInfo = $userModel->where(['id'=>$uuid])
            ->find();

        $userInfoJson = json_encode($userInfo, JSON_UNESCAPED_UNICODE);

        //userinfo写入用户信息
        $f = RedisInstance()->set('info' . $qid, $userInfoJson);

        if ($f) {
            $this->json([
                'code' => 200,
                'msg' => '扫码成功'
            ]);
        } else {

            $this->json([
                'code' => 40003,
                'msg' => '扫码失败'
            ]);
        }
    }

}