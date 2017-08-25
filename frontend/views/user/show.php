<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2016/5/10 11:45
 * description:
 */
use yii\helpers\Html;
use yii\widgets\ListView;
use common\models\User;
use yii\widgets\Pjax;
use common\models\UserMetadata;

/** @var User $user */
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$targetType = request('target_type');
$this->title = Html::encode($user->username) . ' 订阅的 ' . ucfirst($targetType);
$username = Yii::$app->getRequest()->getQueryParam('username');
?>
<style>
    #tab {
        margin: 0 0 10px 0;
    }

    #tab > li.active > a {
        border-bottom: 1px solid #5CB85C;
        color: #5CB85C;
    }

    #tab {
        background-color: #f5f5f5;
        color: #333;
    }

    #tab > li > a {
        color: #333;
    }

    #tab > li {
        float: left;
    }

</style>
<div class="container">
    <div class="row">
        <ul class="nav" id="tab">
            <li class="<?= (request('type') == UserMetadata::TYPE_SHARE) ? 'active' : '' ?>">
                <?= Html::a(
                    Html::encode($user->username) . ' 共享的书籍',
                    ['/user/show', 'username' => $username, 'type' => UserMetadata::TYPE_SHARE]
                ) ?>
            </li>
            <li class="<?= (request('type') == UserMetadata::TYPE_BORROW) ? 'active' : '' ?>">
                <?= Html::a(
                    Html::encode($user->username) . ' 阅读的书籍',
                    ['/user/show', 'username' => $username, 'type' => UserMetadata::TYPE_BORROW]
                ) ?>
            </li>
        </ul>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class="section">
                <?php Pjax::begin([
                    'scrollTo' => 0,
                    'formSelector' => false,
                    'linkSelector' => '.pagination a'
                ]); ?>
                <div class="row section-body">
                    <?= ListView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => false,
                        'itemView' => '@frontend/views/book/_item.php',
                    ]) ?>
                </div>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
