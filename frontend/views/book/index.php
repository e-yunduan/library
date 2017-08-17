<?php

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
