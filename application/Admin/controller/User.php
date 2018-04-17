<?php

namespace app\Admin\controller;

use app\Admin\controller\AdminBase;
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

    public function Logout()
    {
        //Session::clear();
        unset($_REQUEST);
        unset($_COOKIE);
        if (!$_SESSION['userid']) {
            header('Location:/admin/user/login');
        }
    }

    public function AddUser()
    {
        if($this->request->isPost()){
            $data = $this->request->request();
            $menu = new MenuModel([
                'url'  =>  $data['url']??'',
                'title' => $data['title']??'',
                'status' => $data['status']??1,
                'parent_id' => $data['parent_id']??0,
            ]);
            $f = $menu->save();
            if($f){
                return json([
                    'code'=>200,
                    'msg'=>'菜单添加成功'
                ]);
            }else{
                return json([
                    'code'=>400234,
                    'msg'=>'菜单添加失败'
                ]);
            }
        }else{
            $Menu = new MenuModel();
            $menus =$Menu
                ->where(['parent_id'=>0])
                ->select();
            return $this->fetch('user/user-add',[
                'menus'=>$menus
            ]);
        }
    }


    public function EditUser()
    {
        $data = $this->request->request();
        if($this->request->isPost()){
            $menu = new MenuModel();
            if(isset($data['status'])){
                $status = 6;
            }else{
                $status = 0;
            }
            $f = $menu->save([
                'url'  =>  $data['url'],
                'title' => $data['title'],
                'status' => $data['status'],
                'parent_id' => $data['parent_id']??0,
            ],['id'=>(int)$data['mid']]);
            if($f){
                return json([
                    'code'=>200,
                    'msg'=>'修改成功'
                ]);
            }else{
                return json([
                    'code'=>400234,
                    'msg'=>'菜单更新失败'
                ]);
            }
        }else{
            $Menu = new MenuModel();
            $mid  = $data['mid']??1;
            $oldMenu =$Menu
                ->where(['id'=>$mid])
                ->select()->toArray();
            $allParentMenu = MenuModel::getAllMenu();
            return $this->fetch('user/user-edit',[
                'oldMenu'=>$oldMenu[0],
                'allParentMenu'=>$allParentMenu,
                'mid'=>$mid
            ]);
        }
    }

    public function userlist()
    {
        $data = $this->request->request();
        $currentPage = $this->request->request('page',1);
        $parentId = $this->request->request('user_id',0);
        $User = new UserModel();
        $page = $currentPage??1;
        $pageSize = $data['pageSize']??10;
        $offset = ($page - 1) * ($pageSize);
        $count = $User->count();
        $allPage = ceil($count/$pageSize);
        $users = $User
            ->limit($offset,$pageSize)
            ->select();
        $this->assign("users",$users);
        $this->assign("pageNation",[
            'total'=>$count,
            'currentPage'=>$currentPage,
            'allPage'=>$allPage
        ]);
        return $this->fetch('user/user-list');
    }


}