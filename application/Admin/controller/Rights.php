<?php

namespace app\Admin\controller;

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
        $data = $this->request();
        $Menu = new MenuModel();
        $page = $data['page']??1;
        $offset = ($page-1)*($data['offsetNum']??20);
        $menus = $Menu->whereOr()
            ->whereOr()
            ->count();
        return $this->fetch('rights/menu-list',[

        ]);
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
            'code'=>'',
            'msg'=>'',
            'data'=>[

            ]
        ]);
    }
}
