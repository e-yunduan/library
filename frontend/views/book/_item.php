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
?>
<div class="col-sm-12 col-md-2 book-item">
    <div class="card">
        <a href="<?= \yii\helpers\Url::to(['/book/view', 'id' => $model->id]) ?>">
            <img src="<?= $model->image ?>" alt="<?= $model->title ?>" class="book-image">
            <div class="container">
                <h4><b><?= $model->title ?></b></h4>
                <p><?= $model->author ?></p>
                <p>
                    <?php if ($model->status == Book::STATUS_INACTIVE) {
                        echo Html::tag('span', '可借阅', ['class' => 'label label-success']);
                    } else {
                        echo Html::tag('span', '已被借阅', ['class' => 'label label-warning']);
                    } ?>
                </p>
            </div>
        </a>
    </div>
</div>
