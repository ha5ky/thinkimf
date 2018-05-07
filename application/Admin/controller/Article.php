<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/3/19
 * Time: 下午10:50
 */

namespace app\Admin\controller;

use app\Admin\controller\AdminBase;
use app\Admin\controller\AuthAdminBase;
use app\Admin\model\Post;


class Article extends AuthAdminBase
{
    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->request();
            $save = new Post([
                'title' => $data['title'] ?? '',
                'desc' => $data['content'] ?? '',
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
}