<?php

namespace app\Admin\controller;

use function dump;
use think\Controller;
use app\Admin\controller\AdminBase;
use app\Admin\model\MenuModel;

class Rights extends AdminBase
{
    public function AddMenu()
    {
        $lastId = MenuModel::insert([

        ]);
        return $this->fetch('rights/add-menu');
    }

    public function EditMenu()
    {
        return $this->fetch('rights/edit-menu');
    }

    public function MenuList()
    {
        $data = $this->request->request();
        /*$Menu = new MenuModel();
        $page = $data['page'];//??1;
        $pageSize = $data['pageSize'];//??20;
        $offset = ($page - 1) * ($pageSize);
        $count = $Menu->count();
        $menus = $Menu->limit($offset, $pageSize)
            ->select();*/
        $list = MenuModel::getList();
        $this->assign("menus",$list);
        return $this->fetch('rights/menu-list');
    }

    public function DeleteMenu()
    {

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
