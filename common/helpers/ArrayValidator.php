<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 16/4/17 下午10:25
 * description:
 */

namespace common\helpers;

use yii\validators\Validator;

class ArrayValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if ($model->$attribute && !is_array($model->$attribute)) {
            $this->addError($model, $attribute, $attribute . '必须是一个数组');
        }
    }
}