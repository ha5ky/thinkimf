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
        return $this->fetch('rights/menu-edit');
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
        //$list = MenuModel::getList();
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
        return $this->fetch('rights/add_role');
    }

    public function EditRole()
    {
        return $this->fetch('rights/edit_role');
    }

    public function RoleList()
    {
        return $this->fetch('rights/edit_role');
    }

    public function DeleteRole()
    {

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
