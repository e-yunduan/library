<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2017/8/16 15:00
 * description:
 */


namespace common\components;


use common\traits\CollectionTrait;
use yii\base\Object;
use yii\helpers\Json;

class BookDataProvider extends Object
{
    use  CollectionTrait;

    /**
     * @param $isbn
     * @return array
     */
    public function getBookData($isbn)
    {
        $response = $this->curlGet('https://api.douban.com/v2/book/isbn/' . $isbn);
        return Json::decode($response);
    }
}