<?php

namespace frontend\controllers;

use common\models\UserMetadata;
use common\models\Book;
use common\traits\FlashTrait;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{

    use FlashTrait;

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // 默认只能 GET 方式访问
                    ['allow' => true, 'actions' => ['index', 'view'], 'verbs' => ['GET']],
                    // 登录用户才能操作
                    ['allow' => true, 'actions' => ['create'], 'roles' => ['@']],
                ]
            ],
        ]);
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find()->filterWhere(['or',
                ['like', 'title', request('keyword')],
                ['like', 'author', request('keyword')]
            ]),
            'pagination' => [
                'pageSize' => 24,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Book();
        $model->own_user_id = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post())) {
            if (!$model->save()) {
                $this->flash('共享失败', 'error', ['view', 'id' => $model->id]);
            }
            $this->flash('共享成功', 'success', ['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->updateCounters(['view_count' => 1]);
        $userMetadata = UserMetadata::find()->joinWith('user')->where(['book_id' => $id])->orderBy('created_at DESC')->all();
        return $this->render('view', [
            'model' => $model,
            'userMetadata' => $userMetadata,
        ]);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
