<?php

namespace app\Admin\controller;

use app\Admin\controller\AdminBase;
use const FILTER_FLAG_EMAIL_UNICODE;
use function filter_var;
use function imf_rand_str;
use function json;
use SplString;
use function strtoupper;
use think\Session;
use think\Request;
use app\Admin\model\UserModel;

/**
 * Created by PhpStorm.
 * UserModel: chenjianhua
 * Date: 2018/3/18
 * Time: 下午11:47
 */
class User extends AdminBase
{
    public function login()
    {
        if ($this->request->isPost()) {
            $data = $this->request->request();
            if (filter_var($data['username'], FILTER_FLAG_EMAIL_UNICODE)) {
                $email = $data['username'] ?? '';
            }else{
                $email = '';
            }
            if (preg_match('/^1([0-9]{9})/', $data['username'])) {
                $phone = $data['username']??0;
            }else{
                $phone = 0;
            }
            if(empty($email)&&empty($phone)){
                $this->error('手机号或者邮箱格式不正确！');
            }
            if (strlen($data['password']) < 6) {
                $this->error('密码长度必须6位以上！');
            }
            $userModel = new UserModel();
            $user = $userModel->where('phone', 'like', $phone)
                ->whereOr('email', 'like', $email)
                ->find();
            //var_dump($user['phone']);exit;
            if(md5($user['password_salt'].$data['password']) == $user['password']){
                session('userid',$user['id']);
                session('username',($user['name']??$user['id']??$user['email']??$user['phone']??$user['nickname']));
                $this->success('登录成功！','/admin/index/index');
            }else{
                $this->error('你的账号和密码不匹配！');
            }
        } else {
            return $this->fetch('user/login');
        }
    }

    public function reg(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->request();
            if (filter_var($data['username'], FILTER_FLAG_EMAIL_UNICODE)) {
                $email = $data['username'] ?? '';
            }
            if (preg_match('/^1([0-9]{9})/', $data['username'])) {
                $phone = $data['username']??0;
            }
            if(empty($email)&&empty($phone)){
                $this->error('手机号或者邮箱格式不正确！');
            }
            if (strlen($data['password']) < 6) {
                $this->error('密码长度必须6位以上！');
            }
            $passwordSalt = strtoupper(imf_rand_str(6));
            $userid =  UserModel::insert([
                'email' => $email ?? '',
                'phone' => $phone ?? 0,
                'name'=>($email??$phone??''),
                'password_salt'=>$passwordSalt,
                'password' => md5($passwordSalt.$data['password'])
            ]);
            if($userid){$this->success('注册成功，正在前往登录页面','/admin/user/login');};
        } else{
            return $this->fetch('user/reg');
        }
    }

    public function Logout():Null
    {
        Session::clear();
        unset($_REQUEST);
        unset($_COOKIE);
        if (!$_SESSION['userid']) {
            header('Location:/admin/auth/login');
        }
    }
}