<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/26
 * Time: 上午2:30
 */

namespace app\api\controller;

use app\api\model\Article as ArticleModel;
use app\api\model\Device;

class Article extends AuthBase
{
    /*
     * 获取文章列表
     */
    public function list()
    {
        $page      = $this->request->get('page', 1);
        $page_size = $this->request->get('page_size', 20);
        $offset    = ($page - 1) * $page_size;
        $articles  = ArticleModel::Where([])
            ->limit($offset, $page_size)
            ->order(['updated_at' => 'desc', 'created_at' => 'desc'])
            ->select()->toArray();
        $this->json(1, "成功", ['data' => $articles]);
    }


}