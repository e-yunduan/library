<?php

use common\models\Book;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Book */
/* @var $form yii\widgets\ActiveForm */

$users = \common\models\User::find()->all();
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'own_user_id')->dropDownList([0 => '公司'] + ArrayHelper::map($users, 'id', 'real_name')) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true, 'disabled' => !$model->isNewRecord]) ?>

    <?= $form->field($model, 'status')->dropDownList([Book::STATUS_INACTIVE => '上架', Book::STATUS_OFF => '下架']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
