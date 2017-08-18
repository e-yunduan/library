<?php

use common\models\Book;
use common\models\UserMetadata;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Book */
/* @var $userMetadata common\models\UserMetadata[] */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Books'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$data = \yii\helpers\Json::decode($model->data);
?>
<div class="book-view">
    <div class="row">
        <h2>《<?= $model->title ?>》</h2>
        <div class="col-md-9">
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
                        <li></li>
                        <li><small>本书归属于：<?= $model->ownUser ? $model->ownUser['real_name'] : '公司' ?></small></li>
                    </ul>

                    <div class="book-view-action">
                        <?php switch ($model->status) {
                            case Book::STATUS_ACTIVE:
                                if (Yii::$app->user->id == $model->borrow_user_id) {
                                    echo Html::a('还书', ['/user/repay', 'book_id' => $model->id], [
                                        'data-method' => 'post',
                                        'data-confirm' => '确定要还书吗？',
                                        'class' => 'btn btn-info'
                                    ]);
                                } else {
                                    echo Html::tag('span', '已借出', ['class' => 'btn btn-warning']);
                                }
                                break;
                            case Book::STATUS_OFF:
                                echo Html::tag('span', '已下架', ['class' => 'btn btn-default']);
                                break;
                            default:
                                echo Html::a('借阅', ['/user/borrow', 'book_id' => $model->id], [
                                    'data-method' => 'post',
                                    'data-confirm' => '确定要借阅吗？',
                                    'class' => 'btn btn-success'
                                ]);
                                break;
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

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">借阅/还书记录</div>
                <ul class="list-group">
                    <?php foreach ($userMetadata as $key => $value) {
                        echo Html::tag('div',
                            $value->user['real_name'] . Yii::$app->formatter->asRelativeTime($value->created_at) . UserMetadata::getTypes()[$value->type],
                            ['class' => 'list-group-item']);
                    } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
