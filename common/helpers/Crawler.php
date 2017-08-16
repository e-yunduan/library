<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 16/8/24 下午9:57
 * description:
 */

namespace common\helpers;

use common\components\ShowApi;
use common\traits\CollectionTrait;
use Curl\Curl;
use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\helpers\Json;

class Crawler extends Object
{
    const CACHE_KEY_PROXY_IP = 'crawler.proxy.ip';

    use CollectionTrait;

    /**
     * @param $url
     * @param string $pattern
     * @return int|null|string
     * @throws \yii\base\InvalidConfigException
     */
    public static function getTrackId($url, $pattern = '/<a.*?href="(https:\/\/itunes\.apple\.com.*?)"/')
    {
        /** @var Crawler $curl */
        $curl = \Yii::createObject(Crawler::className());
        $html = $curl->curlGet($url);
        preg_match_all($pattern, $html, $value);
        if (!empty($value[1])) {
            return isset(array_unique($value[1])[0]) ? Setup::getUrlNumber(array_unique($value[1])[0]) : null;
        }
        return '';
    }

    /**
     * 返回代理 IP
     * @return null|string
     */
    public static function getProxyIp()
    {
        $cacheKey = self::CACHE_KEY_PROXY_IP;
        if ($ipCache = cache($cacheKey)) {
            $ip = $ipCache;
        } else {
            $ip = null;
            $url = 'http://route.showapi.com/22-1';
            $res = ShowApi::getData($url);
            $items = ArrayHelper::getValue($res, 'pagebean.contentlist');
            foreach ($items as $item) {
                $proxy = "{$item->ip}:{$item->port}";
                if (self::getHttpStatusCode($proxy) == 200) {
                    $ip = $proxy;
                    break;
                }
            }
            cache()->set($cacheKey, $ip, 1800); // 半个小时
        }
        return $ip;
    }

    //代理IP验证方法
    public static function getHttpStatusCode($proxy)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_PROXY, $proxy);//使用代理访问
        curl_setopt($curl, CURLOPT_URL, "http://ip.chinaz.com/getip.aspx");//获取内容url
        curl_setopt($curl, CURLOPT_HEADER, 1);//获取http头信息
        curl_setopt($curl, CURLOPT_NOBODY, 1);//不返回html的body信息
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//返回数据流，不直接输出
        curl_setopt($curl, CURLOPT_TIMEOUT, 3); //超时时长，单位秒
        curl_exec($curl);
        $rtn = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return $rtn;
    }

    /**
     * 随机返回 User-Agent
     * @return string
     */
    public static function randomUA()
    {
        $ua = [
            "Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
            "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.16 Safari/537.36",
            "Mozilla/5.0 (Windows NT 6.1; Intel Mac OS X 10.6; rv:7.0.1) Gecko/20100101 Firefox/7.0.1",
            "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36 OPR/18.0.1284.68",
            "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)",
            "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)",
            "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:7.0.1) Gecko/20100101 Firefox/7.0.1",
            "Opera/9.80 (Macintosh; Intel Mac OS X 10.9.1) Presto/2.12.388 Version/12.16",
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36 OPR/18.0.1284.68",
            "Mozilla/5.0 (iPad; CPU OS 7_0 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) CriOS/30.0.1599.12 Mobile/11A465 Safari/8536.25",
            "Mozilla/5.0 (iPad; CPU OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4",
            "Mozilla/5.0 (iPad; CPU OS 7_0_2 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A501 Safari/9537.53"
        ];
        return array_rand($ua);
    }

    /**
     * 短地址还原
     * @param $url
     * @return null|string
     */
    public static function decodeUrl($url)
    {
        Console::output('短地址为 ' . $url);
        /** @var Curl $curl */
        $curl = \Yii::createObject('Curl\Curl');
        $response = $curl->post('https://www.howsci.com/dwz/expand.php', ['url' => $url]);
        $html = Json::decode($response);
        if ($html['code'] == 1) {
            // 短网址递归
            if (strpos($html['data'], 't.cn') !== false || strpos($html['data'], 'dwz.cn') !== false) {
                return self::decodeUrl($html['data']);
            }
            return $html['data'];
        }
        return null;
    }

}