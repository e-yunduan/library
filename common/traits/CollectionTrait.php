<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2016/4/7 15:25
 * description:
 */

namespace common\traits;


use Curl\Curl;
use Yii;
use yii\helpers\Console;

trait CollectionTrait
{
    /**
     * @var Curl
     */
    public $http;

    public function init()
    {
//        $this->http = Yii::createObject('hightman\http\Client');
        $this->http = Yii::createObject('Curl\Curl');
    }

    /**
     * @param $url
     * @param array $data
     * @param bool $console
     * @return mixed
     */
    protected function curlGet($url, $data = [], $console = true)
    {
        $console ? Console::output($url) : null;
        if ($data) {
            $url .= ((strpos($url, '?') === false) ? '?' . http_build_query($data) : '&' . http_build_query($data));
        }
        Yii::info($url, 'request - get 请求网址');
//        $this->http->setHeader('Content-Type', 'application/json');
        $response = $this->http->get($url, $data);
        Yii::info($response, 'request - 返回结果');
        return $response;
    }

    /**
     * @param $url
     * @param $data
     * @return string
     */
    protected function curlPost($url, $data)
    {
        Console::output($url);
        Yii::info('post 请求网址-' . $url, 'request');
        Yii::info('post 请求数据-' . json_encode($data), 'request');
        $this->http->setHeader('Content-Type', 'application/json');
        $response = $this->http->post($url, $data);
        Yii::info('返回结果-' . $response, 'request');
        return $response;
    }

    /**
     * @param $pattern string
     * @param $url
     * @return array
     */
    public function curlGetPregMatchAll($pattern, $url)
    {
        $html = $this->curlGet($url);
        preg_match_all($pattern, $html, $value);
        if (!empty($value[1])) {
            return $value[1];
        }
        return [];
    }

}