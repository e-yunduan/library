<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2017/8/16 14:26
 * description:
 */
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
            </div>
        </a>
    </div>
</div>
