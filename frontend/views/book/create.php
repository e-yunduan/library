<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Book */

$this->title = Yii::t('app', '共享图书');
?>
<div class="book-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <p>
        共享图书给大家借阅。共享后的书籍依然<b class="text-danger">归属于您</b>，您可以随时收回。
    </p>

    <div class="form-group">
        <?= Html::submitButton('共享', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
