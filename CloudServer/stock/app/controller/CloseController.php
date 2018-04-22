<?php
/**
 * 处理连接关闭后的逻辑
 * Created by PhpStorm.
 * User: Echo
 * Date: 2018/4/11
 * Time: 18:45
 */

namespace Swoole\Controller;

use Swoole\Controller\BaseController;

class CloseController extends BaseController{


    /**
     * 当socket断开，查找当前分组中有没有要删除的fd，有即移除
     * @param $object  实例化的对象
     * @param $ws_object
     * @param $fd  要删除的fd
     * @return bool
     */
    public static function fdDel($object,$ws_object,$fd){
        foreach (swooleConfig('table_object') as $table_object){

            foreach (swooleConfig($table_object) as $table_name => $table_field) {

                   if ($object->{$table_name}->exist($fd)){
                            $object->{$table_name}->del($fd);
//                       return true;
                   }

                }
        }
        return true;


    }

/**
    //交易对类型组中删除当前fd
    public static function dealPairTypeDel(){

    }


    //单个交易对组中删除当前fd
    public static function dealPairDel(){

    }
 */
}