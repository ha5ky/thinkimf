<?php
/**
 * Created by PhpStorm.
 * UserModel: chenjianhua
 * Date: 2018/3/18
 * Time: 下午11:47
 */

namespace app\auth\controller;

use app\common\Base;
use think\Controller;
use SplString;
use think\Session;
use think\Request;
use app\admin\model\UserModel;
use think\Validate;
use function uniqueString;


class Index extends Base
{
    public function login()
    {
        $data = $this->request->request();
        if (isset($data['redirect'])) {
            $redirectUrl = $data['redirect'];
        } else {
            $redirectUrl = $this->request->domain();
        }
        if ($this->request->isPost()) {
            if (!filter_var($redirectUrl, FILTER_VALIDATE_URL)) {

                $this->redirect($this->request->domain());
            }
            if (filter_var($data['username'], FILTER_VALIDATE_EMAIL)) {
                $email = $data['username'] ?? '';
            } else {
                $email = '';
            }
            if (preg_match('/^1([0-9]{9})/', $data['username'])) {
                $phone = $data['username'] ?? 0;
            } else {
                $phone = 0;
            }
            if (empty($email) && empty($phone)) {
                //$this->error('手机号或者邮箱格式不正确！');
            }
            if (strlen($data['password']) < 6 || strlen($data['password']) > 20) {
                $this->error('密码长度必须6-20位,允许使用字母,数字,或者下划线！');
            }
            if (!preg_match("/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/",
                $data['password'])) {
                $this->error('密码长度必须6-20位,允许使用字母,数字,或者下划线！');
            }
            $userModel = new UserModel();
            $user = $userModel->where(['phone' => $phone])
                ->whereOr(['email' => $email])
                ->find();
            //var_dump($data['username'],$email,$user['phone']);exit;
            if (md5($user['password_salt'] . $data['password']) == $user['password']) {


                //判断用户是否存在，如果存在直接登录,如果不存在则用户同步
                //登录XImf community
                //使用cookies登录
                session('uuid', $user['id']);
                session('userid', $user['id']);
                session('user_type', $user['user_type']);
                session('username', ($user['name'] ?? $user['id'] ?? $user['email'] ?? $user['phone'] ?? $user['nickname']));
                cookie('userid', $user['id']);
                cookie('username', $user['name']);

                $this->success('登录成功，正在前往', $redirectUrl);
            } else {
                $this->error('你的账号和密码不匹配！');
            }
        } else {
            return $this->fetch('index/login', [
                'redirect' => $redirectUrl
            ]);
        }
    }

    //扫码登录
    public function scanCodeLogin()
    {
        return $this->fetch('index/scancode_login');
    }

    public function reg(Request $request)
    {
        $data = $this->request->request();
        if (isset($data['redirect'])) {
            $redirectUrl = $data['redirect'];
        } else {
            $redirectUrl = $this->request->domain();
        }
        var_dump($redirectUrl);
        if ($request->isPost()) {
            $email = false;
            $phone = false;
            if (!filter_var($redirectUrl, FILTER_VALIDATE_URL)) {

                $this->redirect($this->request->domain());
            }
            if (filter_var($data['regname'], FILTER_VALIDATE_EMAIL)) {
                $email = $data['regname'] ?? '';
            }
            if (preg_match('/^1([0-9]{9})/', $data['regname'])) {
                $phone = $data['regname'] ?? 0;
            }
            if (empty($email) && empty($phone)) {
                $this->error('手机号或者邮箱格式不正确！');
            }
            if (strlen($data['password']) < 6 || strlen($data['password']) > 20) {
                $this->error('密码长度必须6-20位,允许使用字母,数字,或者下划线！');
            }
            if (!preg_match("/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/",
                $data['password'])) {
                $this->error('密码长度必须6-20位,允许使用字母,数字,或者下划线！');
            }
            $userModel = new UserModel();
            //var_dump($email,$phone,$data);exit;
            if ($phone) {
                $user = $userModel
                    ->where(['phone' => $phone])
                    ->find();
            }
            if ($email) {
                $user = $userModel
                    ->where(['email' => $email])
                    ->find();
            }
            if (is_object($user)) {
                if (property_exists($user, 'name')) {
                    $this->error('此账户已经被注册！');
                }
            }
            $passwordSalt = strtoupper(imf_rand_str(6));
            $userid = UserModel::insert([
                'email' => $email ?? '',
                'phone' => $phone ?? 0,
                'name' => ($email ?? $phone ?? ''),
                'password_salt' => $passwordSalt,
                'password' => md5($passwordSalt . $data['password'])
            ]);
            if ($userid) {
                $user = $userModel->where(['phone' => $phone])
                    ->whereOr(['email' => $email])
                    ->find();
                session('uuid', $user['id']);
                session('userid', $user['id']);
                session('user_type', $user['user_type']);
                session('username', ($user['name'] ?? $user['id'] ?? $user['email'] ?? $user['phone'] ?? $user['nickname']));
                cookie('userid', $user['id']);
                cookie('username', $user['name']);
                $this->success('注册成功，正在前往', $redirectUrl);
            };
        } else {
            return $this->fetch('index/reg', [
                'redirect' => $redirectUrl
            ]);
        }
    }

    public function Logout()
    {
        //Session::clear();
        session('username', null);
        session('userid', null);
        cookie('username', null);
        cookie('userid', null);
        $this->success('退出成功', '/auth/index/login');
    }
}