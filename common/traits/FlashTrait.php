<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 16/4/17 下午10:21
 * description:
 */

namespace common\traits;


use Yii;
use yii\web\Response;

trait FlashTrait
{
    /**
     * 显示flash信息
     * @param $message string 信息显示内容
     * @param string $type 信息显示类型, ['info', 'success', 'error', 'warning']
     * @param null $url 跳转地址
     * @return Response
     */
    public function flash($message, $type = 'info', $url = null)
    {
        Yii::$app->getSession()->setFlash($type, $message);
        if ($url !== null) {
            Yii::$app->end(0, $this->redirect($url));
        }
    }
}