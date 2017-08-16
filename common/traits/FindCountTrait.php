<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 16/4/12 下午11:22
 * description:
 */

namespace common\traits;

trait FindCountTrait
{
    // 返回数量
    public static function findCount($condition, $q = '*')
    {
        return static::findByCondition($condition)->count($q);
    }

}