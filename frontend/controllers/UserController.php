<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 16/4/10 下午7:39
 * description:
 */

namespace frontend\controllers;


use common\models\Book;
use common\traits\FlashTrait;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use Yii;

class UserController extends Controller
{

    use FlashTrait;

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl)->send();
        }
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // 默认只能 GET 方式访问
                    ['allow' => true, 'actions' => ['index'], 'verbs' => ['GET']],
                    // 登录用户 POST 操作
                    ['allow' => true, 'actions' => ['borrow', 'repay'], 'verbs' => ['POST'], 'roles' => ['@']],
                    // 登录用户才能操作
                    ['allow' => true, 'actions' => ['profile', 'show'], 'roles' => ['@']],
                ]
            ],
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionBorrow()
    {
        /** @var Book $model */
        // todo 待完成
        $model = Yii::createObject(Book::className());
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $this->flash('设置成功');
            } else {
                $this->flash('设置失败', 'error');
            }
            return $this->refresh();
        }
    }

    public function actionRepay()
    {

    }

}