<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2017/8/25 15:33
 * description:
 */
use common\helpers\Setup;
use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = t('app', '此刻正在发生');
$this->params['breadcrumbs'][] = $this->title;
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

?>
<div class="container">

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'itemOptions' => ['class' => 'list-group-item item'],
        'itemView' => function ($model, $key, $index, $widget) {
            $str = Html::a($model->user->username, ['/user/show', 'username' => $model->user->username, 'type' => \common\models\UserMetadata::TYPE_BORROW]);
            $str .= ' ' . \common\models\UserMetadata::getTypes()[$model->type];
            $str .= Html::a(" 《{$model->book->title}》", ['/book/view', 'id' => $model->book_id]);
            $str .= Html::tag('small', ' ' . Setup::relative($model->created_at));
            return $str;
        },
    ]) ?>
</div>
