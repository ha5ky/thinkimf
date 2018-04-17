<?php

namespace app\Admin\controller;

use function ceil;
use function dump;
use function intdiv;
use function json;
use think\Controller;
use app\Admin\controller\AdminBase;
use app\Admin\model\MenuModel;
use function var_dump;

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

    public function EditRole()
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
            return $this->fetch('rights/menu-edit',[
                'oldMenu'=>$oldMenu[0],
                'allParentMenu'=>$allParentMenu,
                'mid'=>$mid
            ]);
        }
    }

    public function RoleList()
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

    public function DeleteRole()
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
    

    public function AddRights()
    {
        return $this->fetch('rights/add_role');
    }

    public function EditRights()
    {
        return $this->fetch('rights/edit_role');
    }

    public function RightsList()
    {
        return $this->fetch('rights/edit_role');
    }

    public function DeleteRights()
    {
        return json([
            'code' => '',
            'msg' => '',
            'data' => [

            ]
        ]);
    }
}
