<?php

/**
 * author     : forecho <caizh@chexiu.cn>
 * createTime : 2015/12/29 18:37
 * description:
 */
namespace common\helpers;

class Security
{
    /**
     *  创建一个随机字符串
     * @param string $type the type of string
     * @param int $length the number of characters
     * @return int|string the random string
     */
    public static function random($type = 'alnum', $length = 16)
    {
        switch ($type) {
            case 'basic':
                return mt_rand();
                break;

            default:
            case 'alnum':
            case 'numeric':
            case 'nozero':
            case 'alpha':
            case 'distinct':
            case 'hexdec':
                switch ($type) {
                    case 'alpha':
                        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;

                    default:
                    case 'alnum':
                        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;

                    case 'numeric':
                        $pool = '0123456789';
                        break;

                    case 'nozero':
                        $pool = '123456789';
                        break;

                    case 'distinct':
                        $pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
                        break;

                    case 'hexdec':
                        $pool = '0123456789abcdef';
                        break;
                }

                $str = '';
                for ($i = 0; $i < $length; $i++) {
                    $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
                }
                return $str;
                break;

            case 'unique':
                return md5(uniqid(mt_rand()));
                break;

            case 'sha1' :
                return sha1(uniqid(mt_rand(), true));
                break;
        }
    }


    /**
     * 简单对称加密算法之加密
     * @param String $string 需要加密的字串
     * @param String $key 加密EKY
     * @return String
     */
    public static function encode($string = '', $key = 'echo')
    {
        $strArr = str_split(base64_encode($string));
        $strCount = count($strArr);
        foreach (str_split($key) as $k => $value)
            $k < $strCount && $strArr [$k] .= $value;
        return str_replace(['=', '+', '/'], ['', '', ''], join('', $strArr));
    }

    /**
     * 简单对称加密算法之解密
     * @param String $string 需要解密的字串
     * @param String $key 解密KEY
     * @return String
     */
    public static function decode($string = '', $key = 'echo')
    {
        $strArr = str_split(str_replace(['', '', ''], ['=', '+', '/'], $string), 2);
        $strCount = count($strArr);
        foreach (str_split($key) as $k => $value)
            $k <= $strCount && isset($strArr [$k]) && $strArr [$k][1] === $value && $strArr [$k] = $strArr [$k][0];
        return base64_decode(join('', $strArr));
    }
}