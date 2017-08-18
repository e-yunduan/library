<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = Yii::$app->name;
?>
<div class="site-index">
    <div id="carousel-myCarousel" data-ride="carousel" class="carousel slide">
        <ol class="carousel-indicators">
            <li data-target="#carousel-myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-myCarousel" data-slide-to="1"></li>
            <li data-target="#carousel-myCarousel" data-slide-to="2"></li>
        </ol>
        <div role="listbox" class="carousel-inner">
            <div class="item active"><img src="https://i.loli.net/2017/08/17/59953084e7c26.png"/>
                <div class="carousel-caption">
                    <h1>阅读，永远是对自己最好的投资</h1>
                    <p>阅读最大的收益，来自于获得知识后，应用于自己的工作和生活，获得品质的改善和提升，油然而生无限的满足感。 ​​​​</p>
                    <p>
                        <a href="<?= Url::to(['/book/index']) ?>" role="button" class="btn btn-lg btn-primary">浏览书籍</a>
                    </p>
                </div>
            </div>
            <div class="item"><img src="https://i.loli.net/2017/08/17/5995308502da4.png"/>
                <div class="carousel-caption">
                    <h1>终生阅读</h1>
                    <p>人丑就要多读书，阅读是很好的习惯，受益终生。</p>
                    <a href="<?= Url::to(['/book/index']) ?>" role="button" class="btn btn-lg btn-primary">浏览书籍</a>
                </div>
            </div>
            <div class="item"><img src="https://i.loli.net/2017/08/18/599653bd54924.png"/>
                <div class="carousel-caption">
                    <h1>与其用来垫显示器，不如让更多人收益</h1>
                    <p>共享图书给大家借阅。共享后的书籍依然<b class="text-danger">归属于您</b>，您可以随时收回。</p>
                    <a href="<?= Url::to(['/book/index']) ?>" role="button" class="btn btn-lg btn-primary">共享书籍</a>
                </div>
            </div>
        </div>
        <a href="#carousel-myCarousel" role="button" data-slide="prev" class="left carousel-control">
            <span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a href="#carousel-myCarousel" role="button" data-slide="next" class="right carousel-control">
            <span aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <div class="hero-widget well well-sm">
                <div class="icon">
                    <i class="glyphicon glyphicon-user"></i>
                </div>
                <div class="text">
                    <var><?= $count['allUser'] ?></var>
                    <label class="text-muted">注册用户</label>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="hero-widget well well-sm">
                <div class="icon">
                    <i class="glyphicon glyphicon-book"></i>
                </div>
                <div class="text">
                    <var><?= $count['allBook'] ?></var>
                    <label class="text-muted">全部书籍</label>
                </div>
<!--                <div class="options">-->
<!--                    <a href="javascript:;" class="btn btn-default btn-lg"><i class="glyphicon glyphicon-eye-open"></i> View traffic</a>-->
<!--                </div>-->
            </div>
        </div>
        <div class="col-sm-3">
            <div class="hero-widget well well-sm">
                <div class="icon">
                    <i class="glyphicon glyphicon-book"></i>
                </div>
                <div class="text">
                    <var><?= $count['canBorrowBook'] ?></var>
                    <label class="text-muted">可借书籍</label>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="hero-widget well well-sm">
                <div class="icon">
                    <i class="glyphicon glyphicon-stats"></i>
                </div>
                <div class="text">
                    <var><?= $count['borrowTimes'] ?></var>
                    <label class="text-muted">借阅次数</label>
                </div>
            </div>
        </div>
    </div>
</div>
