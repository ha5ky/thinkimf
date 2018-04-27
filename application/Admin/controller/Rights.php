<?php

namespace app\Admin\controller;

use app\Admin\model\UserType;
use think\Controller;
use app\Admin\controller\AdminBase;
use app\Admin\model\MenuModel;

class Rights extends AdminBase
{
    public function AddMenu()
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
            return $this->fetch('rights/menu-add',[
                'menus'=>$menus
            ]);
        }
    }

    public function EditMenu()
    {
        $data = $this->request->request();
        if($this->request->isPost()){
            $menu = new MenuModel();
            $f = $menu->save([
                'parent_id'=>$data['parent_id'],
                'url'=>$data['url'],
                'title' => $data['title'],
                'status' => $data['status']
            ],['id'=>(int)$data['mid']]);
            if($f){
                return json([
                    'code'=>200,
                    'msg'=>'修改成功'
                ]);
            }else{
                return json([
                    'code'=>400237,
                    'msg'=>'更新失败'
                ]);
            }
        }else{
            $Menu = new MenuModel();
            $mid  = $data['mid']??1;
            $oldMenu =$Menu
                ->where(['id'=>$mid])
                ->select()->toArray();
            $allParentMenu = MenuModel::getAllMenu();
            return $this->fetch('rights/menu-edit',[
                'oldMenu'=>$oldMenu[0],
                'allParentMenu'=>$allParentMenu,
                'mid'=>$mid
            ]);
        }
    }

    public function MenuList()
    {
        $data = $this->request->request();
        $currentPage = $this->request->request('page',1);
        $parentId = $this->request->request('parent_id',0);
        $Menu = new MenuModel();
        $page = $currentPage??1;
        $pageSize = $data['pageSize']??10;
        $offset = ($page - 1) * ($pageSize);
        $count = $Menu->where(['parent_id'=>$parentId])->count();
        $allPage = ceil($count/$pageSize);
        $menus = $Menu
            ->where(['parent_id'=>$parentId])
            ->limit($offset,$pageSize)
            ->select();
        $this->assign("menus",$menus);
        $this->assign("pageNation",[
            'total'=>$count,
            'currentPage'=>$currentPage,
            'allPage'=>$allPage
        ]);
        return $this->fetch('rights/menu-list');
    }

    public function DeleteMenu()
    {
        if($this->request->isPost()){
            $mid = $this->request->request('mid');
            $menu = new MenuModel();
            $f = $menu->find()
                ->where(['id'=>$mid])
                ->delete();
            if($f){
                return json([
                    'code'=>200,
                ]);
            }else{
                return json([
                    'code'=>400235,
                    'msg'=>'菜单删除失败'
                ]);
            }
        }
    }

    public function AddRole()
    {
        if($this->request->isPost()){
            $data = $this->request->request();
            $role = new UserType([
                'url'  =>  $data['url']??'',
                'title' => $data['title']??'',
                'status' => $data['status']
            ]);
            $f = $role->save();
            if($f){
                return json([
                    'code'=>200,
                    'msg'=>'用户组添加成功'
                ]);
            }else{
                return json([
                    'code'=>400234,
                    'msg'=>'用户组组添加失败'
                ]);
            }
        }else{
            return $this->fetch('rights/role-add');
        }
    }

    public function EditRole()
    {
        $data = $this->request->request();
        if($this->request->isPost()){
            $menu = new UserType();
            $f = $menu->save([
                'title' => $data['title'],
                'status' => $data['status'],
            ],['id'=>(int)$data['id']]);
            if($f){
                return json([
                    'code'=>200,
                    'msg'=>'修改成功'
                ]);
            }else{
                return json([
                    'code'=>400235,
                    'msg'=>'更新失败'
                ]);
            }
        }else{
            $Role = new UserType();
            $id  = $data['id']??1;
            $oldRole =$Role
                ->where(['id'=>$id])
                ->select()->toArray();
            return $this->fetch('rights/role-edit',[
                'oldRole'=>$oldRole[0],
                'id'=>$id
            ]);
        }
    }

    public function rolelist()
    {
        $data = $this->request->request();
        $currentPage = $this->request->request('page',1);
        $parentId = $this->request->request('parent_id',0);
        $Role = new UserType();
        $page = $currentPage??1;
        $pageSize = $data['pageSize']??10;
        $offset = ($page - 1) * ($pageSize);
        $count = $Role->count();
        $allPage = ceil($count/$pageSize);
        $roles = $Role
            ->limit($offset,$pageSize)
            ->select();
        $this->assign("roles",$roles);
        $this->assign("pageNation",[
            'total'=>$count,
            'currentPage'=>$currentPage,
            'allPage'=>$allPage
        ]);
        return $this->fetch('rights/role-list');
    }

    public function DeleteRole()
    {
        if($this->request->isPost()){
            $id = $this->request->request('id');
            $role = new UserType();
            $f = $role->find()
                ->where(['id'=>$id])
                ->delete();
            if($f){
                return json([
                    'code'=>200,
                    'msg'=>'用户组删除成功'
                ]);
            }else{
                return json([
                    'code'=>400235,
                    'msg'=>'用户组删除失败'
                ]);
            }
        }
    }

    public function EditRights()
    {
        $data = $this->request->request();
        $rid = (int)$data['rid'];
        if($this->request->isAjax()){
            $role = new UserType();
            $menuArr = $data['menu'];
            $dictStr = implode('|',$menuArr);
            $f = $role->save([
                'menu_dict' => $dictStr,
            ],['id'=>$rid]);
            if($f){
                return json([
                    'code'=>200,
                    'msg'=>'修改成功'
                ]);
            }else{
                return json([
                    'code'=>400235,
                    'msg'=>'更新失败'
                ]);
            }
        }else{
            //获取老的用户权限
            $UserType = new UserType();
            $oldRightsStr = $UserType->where([
                'id'=>$rid
            ])->field('menu_dict')->select()->toArray();
            if(isset($oldRightsStr[0]['menu_dict'])){
                $oldRightsArr = explode('|',$oldRightsStr[0]['menu_dict']);
            }else{
                $oldRightsArr = [];
            }
            $allMenu = MenuModel::AllList();
            $newMenu = [];
            foreach ($allMenu as $k=>$v){
                $v['checked'] = '';
                if(in_array($v['id'],$oldRightsArr)){
                    $v['checked'] = 'checked';
                }
                $v['submenu'] = '';
                $allMenu[$k] = $v;

            }
            foreach ($allMenu as $k=>$v){
                if($v['parent_id'] == 0){
                    $v['submenu'] = [];
                    foreach ($allMenu as $k2=>$v2){
                        if($v2['parent_id'] == $v['id']){
                            array_push($v['submenu'],$v2);
                        }
                    }
                    $newMenu[$k] = $v;
                }
            }

            return $this->fetch('rights/edit-rights',[
                'allMenu'=>$newMenu,
                'rid'=>$rid
            ]);
        }
    }
}
