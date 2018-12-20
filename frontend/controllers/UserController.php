<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 16/4/10 下午7:39
 * description:
 */

namespace frontend\controllers;


use common\models\Book;
use common\models\User;
use common\models\UserMetadata;
use common\traits\FlashTrait;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
                    [
                        'allow' => true,
                        'actions' => ['borrow', 'repay', 'retrieve', 'put'],
                        'verbs' => ['POST'],
                        'roles' => ['@']
                    ],
                    // 登录用户才能操作
                    ['allow' => true, 'actions' => ['profile', 'show'], 'roles' => ['@']],
                ]
            ],
        ]);
    }

    public function actionIndex()
    {
        return $this->redirect([
            'show',
            'username' => \Yii::$app->user->identity->username,
            'type' => UserMetadata::TYPE_BORROW
        ]);
    }


    /**
     * @param string $username
     * @param $type integer
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($username, $type)
    {
        $user = $this->user($username);

        return $this->render('show', [
            'user' => $user,
            'dataProvider' => $this->getList($username, $type),
        ]);
    }


    /**
     * @param $username string
     * @param $type integer
     * @return ActiveDataProvider
     * @throws NotFoundHttpException
     */
    protected function getList($username, $type)
    {
        if (!in_array($type, array_keys(UserMetadata::getTypes()))) {
            throw new NotFoundHttpException;
        }

        return new ActiveDataProvider([
            'query' => UserMetadata::find()->where([
                'type' => $type,
                UserMetadata::tableName() . '.user_id' => $this->user($username)->id
            ])->joinWith('book')->groupBy('book_id'),
            'pagination' => [
                'pageSize' => 24,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);
    }

    /**
     * @param $book_id
     */
    public function actionBorrow($book_id)
    {
        $model = Book::getInactiveBook($book_id);
        $url = ['/book/view', 'id' => $book_id];
        if (Yii::$app->request->isPost && $model) {
            $model->setAttributes(['status' => Book::STATUS_ACTIVE]);
            if ($model->save()) {
                $this->flash('借阅成功', 'success', $url);
            }
        }
        $this->flash('借阅失败', 'error', $url);
    }

    /**
     * @param $book_id
     */
    public function actionRepay($book_id)
    {
        $model = Book::find()->where([
            'id' => $book_id,
            'status' => Book::STATUS_ACTIVE,
            'borrow_user_id' => Yii::$app->user->id
        ])->one();
        $url = ['/book/view', 'id' => $book_id];
        if (Yii::$app->request->isPost && $model) {
            $model->setAttributes(['status' => Book::STATUS_INACTIVE]);
            if ($model->save()) {
                $this->flash('还书成功', 'success', $url);
            }
        }
        $this->flash('还书失败', 'error', $url);
    }

    /**
     * @param $book_id
     */
    public function actionRetrieve($book_id)
    {
        $model = Book::find()->where([
            'id' => $book_id,
            'status' => Book::STATUS_INACTIVE,
            'own_user_id' => Yii::$app->user->id
        ])->one();
        $url = ['/book/view', 'id' => $book_id];
        if (Yii::$app->request->isPost && $model) {
            $model->setAttributes(['status' => Book::STATUS_OFF]);
            if ($model->save()) {
                $this->flash('回收成功', 'success', $url);
            }
        }
        $this->flash('回收失败', 'error', $url);
    }


    /**
     * 上架
     * @param $book_id
     */
    public function actionPut($book_id)
    {
        $model = Book::find()->where([
            'id' => $book_id,
            'status' => Book::STATUS_OFF,
            'own_user_id' => Yii::$app->user->id
        ])->one();
        $url = ['/book/view', 'id' => $book_id];
        if (Yii::$app->request->isPost && $model) {
            $model->setAttributes(['status' => Book::STATUS_INACTIVE]);
            if ($model->save()) {
                $this->flash('上架成功', 'success', $url);
            }
        }
        $this->flash('上架失败', 'error', $url);
    }

    protected function user($username = '')
    {
        $user = User::find()->where(['username' => $username])->one();

        if ($user === null) {
            throw new NotFoundHttpException;
        }
        return $user;
    }
}