<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '书籍';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">
    <div class="row">
        <div class="col-md-12">
            <p>
                <?= Html::a('共享图书', ['create'], ['class' => 'btn btn-success ml15']) ?>
            </p>
            <?php Pjax::begin(); ?>
            <?= ListView::widget([
                'summary' => false,
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => '_item',
            ]) ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
