<?php

use common\models\Book;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Book */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Books'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$data = \yii\helpers\Json::decode($model->data);
?>
<div class="book-view">
    <h2>《<?= $model->title ?>》</h2>
    <div class="media">
        <div class="media-left">
            <img src="<?= $model->image ?>" alt="<?= $model->title ?>" class="book-view-image">
        </div>
        <div class="media-body book-view-item">
            <ul>
                <li>
                    <b>豆瓣评分：</b><?= Html::a(ArrayHelper::getValue($data, 'rating.average'), ArrayHelper::getValue($data, 'alt')) ?>
                </li>
                <li><b>作者：</b><?= $model->author ?></li>
                <li><b>出版社：</b><?= ArrayHelper::getValue($data, 'publisher') ?></li>
                <li><b>出版时间：</b><?= ArrayHelper::getValue($data, 'pubdate') ?></li>
                <li><b>ISBN：</b><?= $model->isbn ?></li>
            </ul>
            <div class="book-view-action">
                <?php if ($model->status == Book::STATUS_ACTIVE) {
                    if (Yii::$app->user->id == $model->borrow_user_id) {
                        echo Html::a('还书', '', ['class' => 'btn btn-default']);
                    } else {
                        echo Html::a('已借出', '', ['class' => 'btn btn-warning']);
                    }
                } else {
                    echo Html::a('借阅', '', ['class' => 'btn btn-success']);
                } ?>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>


    <h2>作者简介</h2>
    <div><?= ArrayHelper::getValue($data, 'author_intro') ?></div>
    <h2>简介</h2>
    <div>
        <?= ArrayHelper::getValue($data, 'summary') ?>
    </div>

    <h2>目录</h2>
    <pre>
        <?= ArrayHelper::getValue($data, 'catalog') ?>
    </pre>
</div>
