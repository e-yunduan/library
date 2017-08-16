<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2016/1/20 14:20
 * description:
 */

namespace common\helpers;


use yii\web\Response;

class Format
{
    /**
     * 人民币元转换成分
     * @param $data
     * @return mixed
     */
    public static function yuanToFen($data)
    {
        return $data * 100;
    }

    /**
     * 人民币分转换成元
     * @param $data
     * @return mixed
     */
    public static function fenToYuan($data)
    {
        return round(($data / 100), 2);
    }

    public static function price($price)
    {
        if ($price === null) {
            return null;
        }
        return $price ? '¥' . $price : '免费';
    }

    /**
     * @param null $data
     * @return array
     */
    public static function renderAjaxData($data = null)
    {
//        if (request()->isAjax) {
        response()->format = Response::FORMAT_JSON;
        return ['code' => 0, 'data' => $data];
//        }
    }


    /**
     * 返回查询条件（可以查询大于小于和IN）
     * @param $attributeName string 字段名
     * @param $value string|integer 值
     * @return array
     */
    public static function conditionTrans($attributeName, $value)
    {
        switch (true) {
            case is_array($value):
                return [$attributeName => $value];
            case stripos($value, '>=') !== false:
                return ['>=', $attributeName, substr($value, 2)];
                break;
            case stripos($value, '<=') !== false:
                return ['<=', $attributeName, substr($value, 2)];
                break;
            case stripos($value, '<') !== false:
                return ['<', $attributeName, substr($value, 1)];
                break;
            case stripos($value, '>') !== false:
                return ['>', $attributeName, substr($value, 1)];
                break;
            case stripos($value, ',') !== false:
                return [$attributeName => explode(',', $value)];
                break;
            default:
                return [$attributeName => $value];
                break;
        }
    }

    /**
     * 过滤所有的空白字符（空格、全角空格、换行等）
     * @param $str
     * @return mixed
     */
    public static function trim($str)
    {
        $search = [" ", "　", "\n", "\r", "\t"];
        $replace = ['', '', '', '', ''];
        return str_replace($search, $replace, $str);
    }
}