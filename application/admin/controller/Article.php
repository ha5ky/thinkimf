<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/3/19
 * Time: 下午10:50
 */

namespace app\admin\controller;

use app\admin\controller\AdminBase;
use app\admin\controller\AuthAdminBase;
use app\admin\model\Post;



class Article extends AuthAdminBase
{
    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->request();
            $save = new Post([
                'title' => $data['title'] ?? '',
                'desc' => $data['content'] ?? '',
                'pic' => $data['pic'] ?? '',
                //'category_id' => $data['status'] ?? 1,
                //'parent_id' => $data['parent_id'] ?? 0,
            ]);
            $f = $save->save();
            if ($f) {
                return json([
                    'code' => 200,
                    'msg' => '文章添加成功'
                ]);
            } else {
                return json([
                    'code' => 400234,
                    'msg' => '文章添加失败'
                ]);
            }
        } else {
            return $this->fetch();
        }
    }

    public function index()
    {
        $data = $this->request->request();
        $currentPage = $this->request->request('page', 1);
        $parentId = $this->request->request('parent_id', 0);
        $post = new Post();
        $page = $currentPage ?? 1;
        $pageSize = $data['pageSize'] ?? 10;
        $offset = ($page - 1) * ($pageSize);
        $count = $post->count();
        $allPage = ceil($count / $pageSize);
        $list = $post->alias('p')->join('imf_category cate', 'p.category_id=cate.id', "LEFT")->where(["status" => 1])->field("p.*,cate.title as category_title")->limit($offset, $pageSize)
            ->select();
        $this->assign("articles", $list);
        $this->assign("pageNation", [
            'total' => $count,
            'currentPage' => $currentPage,
            'allPage' => $allPage
        ]);

        return $this->fetch();
    }


    public function edit()
    {
        $data = $this->request->request();


        if($this->request->isPost()){
            $post = new Post();
            $f = $post->save([
                'title' => $data['title'],
                'desc' => $data['content'],
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
            $post = new Post();
            $id  = $data['id']??1;
            $postInfo =$post
                ->where(['id'=>$id])
                ->select()->toArray();
            $this->assign("postInfo", $postInfo[0]);
            $this->assign("id", $id);
            return $this->fetch();
        }
    }

    public function delete()
    {
        if($this->request->isPost()){
            $id = $this->request->request('id');
            $post = new Post();
            $f = $post->find()
                ->where(['id'=>$id])
                ->delete();
            if($f){
                return json([
                    'code'=>200,
                    'msg'=>'删除成功'
                ]);
            }else{
                return json([
                    'code'=>400235,
                    'msg'=>'删除失败'
                ]);
            }
        }
    }
    public function upload()
    {

        $file = request()->file("file");
        //$file = request()->file('Filedata');
        if (!$file)
            return $this->json([
                'code' => 0,
                'msg' => '上传失败',
            ]);
        //$temp = $file->getInfo()["tmp_name"];
        //$img_info = getimagesize($temp);
        if ($this->request->get('type') == "pic") {
            $info = $file->rule('uniqid')->move(APP_ROOT . DS . 'uploads' . DS . 'pic');
            $fileName = '/pic' . DS . $info->getFileName();
        } else {
            $info = $file->rule('uniqid')->move(APP_ROOT . DS . 'uploads' . DS . 'text');
            $fileName = '/text' .  DS . $info->getFileName();
        }

        if ($info) {
            return $this->json([
                'url' => $fileName,
                'code' => 200,
                'msg' => '上传成功',
            ]);
        } else {
            return $this->json([
                'code' => 0,
                'msg' => '上传失败',
            ]);
            //return $this->result('', 0, '上传失败', 'json');
            //return $this->error('上传失败');
            //return $file->getError();
        }
    }
}