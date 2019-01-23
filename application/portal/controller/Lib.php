<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/26
 * Time: 13:39
 */

namespace app\portal\controller;

use app\portal\controller\Base;

class Lib extends Base
{
    public function index()
    {

        $this->assign('title', '实验室');
        return $this->fetch('lib/index');
    }

    /**
     * 信息救助
     */
    public function infoHelpOrg()
    {

    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function tv(){
         $this->assign('title', 'TV UNISSAIMF - UNISSAIMF TV电视台 - IMF研究院');
        return $this->fetch('lib/tv');
    }

    public function renshengjiagou(){
        //人生架构学，知识方案
        //按照中国职业大典分类，收集原始党政军民学人物数据，AI人工智能模型
        //web,微平台（BATQ小程序），各个云应用市场，
        //人生数据指数，对接人生数据使用，培训班，数据api，商品服务，职业介绍，信息推荐，信息审核
        $this->assign('title', '华人都在用的人生架构参考神器 - IMF研究院');
        return $this->fetch('lib/rsjg');
    }

}