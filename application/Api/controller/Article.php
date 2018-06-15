<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/26
 * Time: 上午2:30
 */

namespace app\Api\controller;

use app\Api\model\Article as ArticleModel;
use app\Api\model\Device;

class Article extends AuthBase
{
    /*
     * 获取文章列表
     */
    public function list()
    {
        $page = $this->request->get('page',1);
        $page_size = $this->request->get('page_size',20);
        $offset = ($page-1) *$page_size;
        $articles = ArticleModel::Where([])
            ->limit($offset,$page_size)
            ->order(['updated_at'=>'desc','created_at'=>'desc'])
            ->select()->toArray();
        if($articles){
            $result = [
                'code'=>200,
                'status'=>1,
                'msg'=>'ok',
                'msg_code'=>0,
                'data'=>$articles
            ];
        }else{
            $result = [
                'code'=>40012,
                'status'=>-1,
                'msg'=>'no article',
                'msg_code'=>0,
                'data'=>[]
            ];
        }
        return $this->json($result);
    }


}