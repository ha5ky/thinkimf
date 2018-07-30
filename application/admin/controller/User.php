<?php

namespace app\admin\controller;

use app\admin\model\UserModel;
use app\admin\model\UserType;
use function strtoupper;
use function var_dump;

/**
 * Created by PhpStorm.
 * UserModel: chenjianhua
 * Date: 2018/3/18
 * Time: 下午11:47
 */
class User extends AdminBase
{

    public function AddUser()
    {
        if ($this->request->isPost()) {
            $data = $this->request->request();
            $email = false;
            $phone = false;

            if (filter_var($data['regname'], FILTER_VALIDATE_EMAIL)) {
                $email = $data['regname'] ?? '';
            }
            if (preg_match('/^1([0-9]{9})/', $data['regname'])) {
                $phone = $data['regname'] ?? 0;
            }
            if (empty($email) && empty($phone)) {
                return json([
                    'code'=>400456,
                    'msg'=>'手机号或者邮箱格式不正确！'
                ]);
            }
            if (strlen($data['password']) < 6 || strlen($data['password']) > 20) {
                return json([
                    'code'=>400456,
                    'msg'=>'密码长度必须6-20位,允许使用字母,数字,或者下划线！'
                ]);
            }
            if (!preg_match("/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/",
                $data['password'])) {
                return json([
                    'code'=>400456,
                    'msg'=>'密码长度必须6-20位,允许使用字母,数字,或者下划线！'
                ]);
            }
            $userModel = new UserModel();
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
            //var_dump($user,$email,$phone);exit;
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
                'nickname' => $data['nickname'],
                'password_salt' => $passwordSalt,
                'password' => md5($passwordSalt . $data['password']),
                'status'=>$data['status'],
                'user_type'=>$data['status'],
                'verify'=>$data['verify'],
                'id_card'=>$data['id_card'],
                'user_type'=>$data['user_type'],
            ]);
            if ($userid) {
                return json([
                    'code'=>200,
                    'msg'=>'注册成功！'
                ]);
            }else{
                return json([
                    'code'=>400458,
                    'msg'=>'注册失败'
                ]);
            }
        } else {
            $roles = new UserType();
            $roleChoose = $roles
                ->where(['status' => 1])
                ->select();
            return $this->fetch('user/user-add', ['roles' => $roleChoose]);
        }
    }


    public
    function EditUser()
    {
        $data = $this->request->request();
        if ($this->request->isPost()) {
            $email = false;
            $phone = false;
            $uid = $this->request->request('uid');
            if (filter_var($data['regname'], FILTER_VALIDATE_EMAIL)) {
                $email = $data['regname'] ?? '';
            }
            if (preg_match('/^1([0-9]{9})/', $data['regname'])) {
                $phone = $data['regname'] ?? 0;
            }
            if (empty($email) && empty($phone)) {
                return json([
                    'code'=>400456,
                    'msg'=>'手机号或者邮箱格式不正确！'
                ]);
            }

            if(empty($data['password'])){
                $data = [
                    'email' => $email ?? '',
                    'phone' => $phone ?? 0,
                    'name' => ($email ?? $phone ?? ''),
                    'nickname' => $data['nickname'],
                    'status'=>$data['status'],
                    'verify'=>$data['verify'],
                    'id_card'=>$data['id_card'],
                    'user_type'=>$data['user_type']
                ];
            }else{
                if (strlen($data['password']) < 6 || strlen($data['password']) > 20) {
                    return json([
                        'code'=>400456,
                        'msg'=>'密码长度必须6-20位,允许使用字母,数字,或者下划线！'
                    ]);
                }
                if (!preg_match("/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/",
                    $data['password'])) {
                    return json([
                        'code'=>400456,
                        'msg'=>'密码长度必须6-20位,允许使用字母,数字,或者下划线！'
                    ]);
                }
                $passwordSalt = strtoupper(imf_rand_str(6));
                $data = [
                    'email' => $email ?? '',
                    'phone' => $phone ?? 0,
                    'name' => ($email ?? $phone ?? ''),
                    'nickname' => $data['nickname'],
                    'password_salt' => $passwordSalt,
                    'password' => md5($passwordSalt . $data['password']),
                    'status'=>$data['status'],
                    'verify'=>$data['verify'],
                    'id_card'=>$data['id_card'],
                    'user_type'=>$data['user_type'],
                ];

            }
           // var_dump($data);exit;
            $user = new UserModel();
            $f = $user->save($data,['id'=>$uid]);
            if ($f) {
                return json([
                    'code'=>200,
                    'msg'=>'修改成功！'
                ]);
            }else{
                return json([
                    'code'=>56677,
                    'msg'=>'修改失败！'
                ]);
            }
        } else {
            $user = new UserModel();
            $uid = $data['uid'] ?? 1;
            $oldUser = $user
                ->where(['id' => $uid])
                ->select()->toArray();
            $roles = new UserType();
            $roleChoose = $roles
                ->where(['status' => 1])
                ->select();
            return $this->fetch('user/user-edit', [
                'oldUser' => $oldUser[0],
                'roles' => $roleChoose,
                'uid' => $uid
            ]);
        }
    }

    public
    function userlist()
    {
        $data = $this->request->request();
        $currentPage = $this->request->request('page', 1);
        $parentId = $this->request->request('user_id', 0);
        $User = new UserModel();
        $page = $currentPage ?? 1;
        $pageSize = $data['pageSize'] ?? 10;
        $offset = ($page - 1) * ($pageSize);
        $count = $User->count();
        $allPage = ceil($count / $pageSize);
        $users = $User
            ->limit($offset, $pageSize)
            ->select()->toArray();
        foreach ($users as $k => $v) {
            $users[$k]['role'] = UserType::getRoleById($v['user_type']);
        }
        $this->assign("users", $users);
        $this->assign("pageNation", [
            'total' => $count,
            'currentPage' => $currentPage,
            'allPage' => $allPage
        ]);
        return $this->fetch('user/user-list');
    }

    public
    function DeleteUser()
    {
        if ($this->request->isPost()) {
            $uid = $this->request->request('uid');
            $User = new UserModel();
            $f = $User->find()
                ->where(['id' => $uid])
                ->delete();
            if ($f) {
                return json([
                    'code' => 200,
                    'msg' => '删除成功'
                ]);
            } else {
                return json([
                    'code' => 400238,
                    'msg' => '菜单失败'
                ]);
            }
        }
    }


}