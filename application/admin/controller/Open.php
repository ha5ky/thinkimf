<?php

use app\admin\controller\AdminBase;

/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/18
 * Time: 00:53
 */
class Open extends AdminBase {

    //应用列表
    public function AddApp()
    {
        $appid = numCode(32);
        $appsecret = imf_rand_str(32);
        $scope = $this->request->request('scope')??'api_base';

    }

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
}