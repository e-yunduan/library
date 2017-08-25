<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2017/8/16 14:26
 * description:
 */
use common\models\Book;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Book */
$model = isset($model->book) ? $model->book : $model;
?>
<div class="col-sm-12 col-md-2 book-item">
    <div class="card">
        <a href="<?= \yii\helpers\Url::to(['/book/view', 'id' => $model->id]) ?>">
            <div class="book-image">
                <img src="<?= $model->image ?>" alt="<?= $model->title ?>">
            </div>
            <div class="container text-ellipsis">
                <p></p>
                <p><b title="<?= $model->title ?>"><?= $model->title ?></b></p>
                <p class="author" title="<?= $model->author ?>"><?= $model->author ?></p>
                <p>
                    <?php switch ($model->status) {
                        case Book::STATUS_INACTIVE:
                            echo Html::tag('span', '可借阅', ['class' => 'label label-success']);
                            break;
                        case Book::STATUS_ACTIVE:
                            echo Html::tag('span', '已被借阅', ['class' => 'label label-warning']);
                            break;
                        case Book::STATUS_OFF:
                            echo Html::tag('span', '已下架', ['class' => 'label label-default']);
                            break;
                        default:
                            break;
                    } ?>
                </p>
            </div>
        </a>
    </div>
</div>
