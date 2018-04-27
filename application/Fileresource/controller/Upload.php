<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/26
 * Time: 下午8:53
 */
use app\common\controller\Base;

class Upload extends Base{

    /*
     * 单文件上传
     */
    public function single()
    {
        /*
         * <form action="//index/upload" enctype="multipart/form-data" method="post">
            <input type="file" name="ifile" /> <br>
            <input type="submit" value="上传" />
            </form>
         */
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('ifile');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move( '../data');
        //上传验证
        //$info = $file->validate(['size'=>15678,'ext'=>'jpg,png,gif'])->move( '../uploads');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getFilename();
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }

    //多文件上传
    public function muti()
    {
        /*
         * <form action="/index/index/upload" enctype="multipart/form-data" method="post">
            <input type="file" name="image[]" /> <br>
            <input type="file" name="image[]" /> <br>
            <input type="file" name="image[]" /> <br>
            <input type="submit" value="上传" />
        </form>
         */

        // 获取表单上传文件
        $files = request()->file('image');
        foreach($files as $file){
            // 移动到框架应用根目录/uploads/ 目录下
            $info = $file->move( '../data');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                echo $info->getExtension();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getFilename();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }

    }


}