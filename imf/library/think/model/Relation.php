<?php
/**
 *
 * ============================================================================
 * [UD DataMap BigData System] Copyright (c) 1995-2028 www.unnnnn.com
 * 版权所有 1995-2028 UD数据信息有限公司【中国】，并保留所有权利。
 * This is not  free soft ware, use is subject to license.txt
 * 网站地址: http://www.unnnnn.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: 陈建华 $
 * $Create Time: 2018/2/9 0009 $
 * email:unnnnn@foxmail.com
 * function:Auth.php
 */

namespace think\model;

use think\db\Query;
use think\Exception;
use think\Model;

/**
 * Class Relation
 * @package think\model
 *
 * @mixin Query
 */
abstract class Relation
{
    // 父模型对象
    protected $parent;
    /** @var  Model 当前关联的模型类 */
    protected $model;
    /** @var Query 关联模型查询对象 */
    protected $query;
    // 关联表外键
    protected $foreignKey;
    // 关联表主键
    protected $localKey;
    // 基础查询
    protected $baseQuery;
    // 是否为自关联
    protected $selfRelation;

    /**
     * 获取关联的所属模型
     * @access public
     * @return Model
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * 获取当前的关联模型类的实例
     * @access public
     * @return Model
     */
    public function getModel()
    {
        return $this->query->getModel();
    }

    /**
     * 设置当前关联为自关联
     * @access public
     * @param  bool $self 是否自关联
     * @return $this
     */
    public function selfRelation($self = true)
    {
        $this->selfRelation = $self;
        return $this;
    }

    /**
     * 当前关联是否为自关联
     * @access public
     * @return bool
     */
    public function isSelfRelation()
    {
        return $this->selfRelation;
    }

    /**
     * 封装关联数据集
     * @access public
     * @param  array $resultSet 数据集
     * @return mixed
     */
    protected function resultSetBuild($resultSet)
    {
        return (new $this->model)->toCollection($resultSet);
    }

    protected function getQueryFields($model)
    {
        $fields = $this->query->getOptions('field');
        return $this->getRelationQueryFields($fields, $model);
    }

    protected function getRelationQueryFields($fields, $model)
    {
        if ($fields) {

            if (is_string($fields)) {
                $fields = explode(',', $fields);
            }

            foreach ($fields as &$field) {
                if (false === strpos($field, '.')) {
                    $field = $model . '.' . $field;
                }
            }
        } else {
            $fields = $model . '.*';
        }

        return $fields;
    }

    protected function getQueryWhere(&$where, $relation)
    {
        foreach ($where as $key => $val) {
            if (is_string($key)) {
                $where[] = [false === strpos($key, '.') ? $relation . '.' . $key : $key, '=', $val];
                unset($where[$key]);
            }
        }
    }

    /**
     * 执行基础查询（仅执行一次）
     * @access protected
     * @return void
     */
    protected function baseQuery()
    {}

    public function __call($method, $args)
    {
        if ($this->query) {
            // 执行基础查询
            $this->baseQuery();

            $result = call_user_func_array([$this->query->getModel(), $method], $args);

            return $result === $this->query ? $this : $result;
        } else {
            throw new Exception('method not exists:' . __CLASS__ . '->' . $method);
        }
    }
}
