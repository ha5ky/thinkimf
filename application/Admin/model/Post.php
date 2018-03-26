<?php
/**
 * Created by PhpStorm.
 * UserModel: Administrator
 * Date: 2018/3/12
 * Time: 17:17
 */

namespace app\Admin\model;

class Post extends Base
{
    protected $table = 'imf_post';


    public static function getList()
    {
        $post = self::alias('p')->join('imf_category cate','p.category_id=cate.id',"LEFT")->where(["status" => 1])->field("p.*,cate.title as category_title")->paginate(config("paginate"), false, ['query' => array()]);
        return $post;
    }

}