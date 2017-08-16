<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2016/4/8 14:47
 * description:
 */

namespace common\helpers;

class Setup
{
    /**
     * @var integer 所有分类 缓存键值
     */
    const CACHE_KEY_APP_CATEGORY_GET_ALL = 'cache.model.AppCategory.getAll';

    const DATE_FORMAT = 'php:Y-m-d';
    const DATETIME_FORMAT = 'php:Y-m-d H:i:s';
    const TIME_FORMAT = 'php:H:i:s';

    public static function convert($dateStr, $type = 'datetime', $format = null)
    {
        if ($type === 'datetime') {
            $fmt = ($format == null) ? self::DATETIME_FORMAT : $format;
        } elseif ($type === 'time') {
            $fmt = ($format == null) ? self::TIME_FORMAT : $format;
        } else {
            $fmt = ($format == null) ? self::DATE_FORMAT : $format;
        }
        return \Yii::$app->formatter->asDate($dateStr, $fmt);
    }

    /**
     * 相对时间
     * @param $dateStr
     * @return string
     */
    public static function relative($dateStr)
    {
        return \Yii::$app->formatter->asRelativeTime($dateStr);
    }

    /**
     * 获取某天/当前天 最开始的时间戳
     * @param string $time 时间戳 或者 2016-7-25 11:02:21
     * @return int
     */
    public static function beginTimestamp($time = '')
    {
        $time = ($time) ?: time();
        $time = is_numeric($time) ? $time : strtotime($time);

        return strtotime(date('Y-m-d', $time));
    }


    /**
     * 获取某天/当前天 结束的时间戳 23:59:59
     * @param string $time 时间戳 或者 2016-7-25 11:02:21
     * @return int
     */
    public static function endTimestamp($time = '')
    {
        return self::beginTimestamp($time) + 24 * 3600 - 1;
    }


    /**
     * 获取请求头
     * @return string
     */
    public static function getUserAgent()
    {
        $userAgent = strtolower($_SERVER["HTTP_USER_AGENT"]);
        // iphone
        $isIphone = strripos($userAgent, 'iphone');
        if ($isIphone) {
            return 'iphone';
        }
        // android
        $isAndroid = strripos($userAgent, 'android');
        if ($isAndroid) {
            return 'android';
        }
        // 微信
        $isWeixin = strripos($userAgent, 'micromessenger');
        if ($isWeixin) {
            return 'weixin';
        }
        // ipad
        $isIpad = strripos($userAgent, 'ipad');
        if ($isIpad) {
            return 'ipad';
        }
        // ipod
        $isIpod = strripos($userAgent, 'ipod');
        if ($isIpod) {
            return 'ipod';
        }
        // pc电脑
        $isPc = strripos($userAgent, 'windows nt');
        if ($isPc) {
            return 'pc';
        }
        return 'other';
    }


    /**
     * 根据 URL 返回数字部分
     * @param $url
     * @param $pattern
     * @return int
     */
    public static function getUrlNumber($url, $pattern = '/id(\d+)/')
    {
        preg_match($pattern, $url, $value);
        return isset($value[1]) ? $value[1] : 0;
    }
}