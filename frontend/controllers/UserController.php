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
     * @param $book_id
     * @return \yii\web\Response
     */
    public function actionBorrow($book_id)
    {
        $model = Book::getInactiveBook($book_id);
        if (Yii::$app->request->isPost && $model) {
            $model->setAttributes(['status' => Book::STATUS_ACTIVE]);
            if ($model->save()) {
                $this->flash('借阅成功', 'success');
            } else {
                $this->flash('借阅失败', 'error');
            }
        }
        return $this->redirect(['/book/view', 'id' => $book_id]);
    }

    /**
     * @param $book_id
     * @return \yii\web\Response
     */
    public function actionRepay($book_id)
    {
        $model = Book::findOne(['id' => $book_id, 'status' => Book::STATUS_ACTIVE, 'borrow_user_id' => Yii::$app->user->id]);
        if (Yii::$app->request->isPost && $model) {
            $model->setAttributes(['status' => Book::STATUS_INACTIVE]);
            if ($model->save()) {
                $this->flash('还书成功', 'success');
            } else {
                $this->flash('还书失败', 'error');
            }
        }
        return $this->redirect(['/book/view', 'id' => $book_id]);
    }

}