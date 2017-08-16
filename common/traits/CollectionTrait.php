<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2016/4/7 15:25
 * description:
 */

namespace common\traits;

trait CollectionTrait
{
    /**
     * @param $url
     * @return string
     */
    protected function curlGet($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        curl_close($ch);
        return $response;
    }

}