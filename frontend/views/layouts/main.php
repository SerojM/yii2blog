<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\assets\PublicAsset;
use frontend\widgets\WLang;

PublicAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<nav class="navbar main-menu navbar-default">
    <div class="container">
        <div class="menu-content">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div style="margin-right:70px">
                <a class="navbar-brand" href="<?= Url::toRoute(['site/index'])?>"><strong>My Blog</strong></a>
                </div>
            </div>


            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <?= WLang::widget();?>
<!--                <ul class="nav navbar-nav text-uppercase">-->
<!--                    <li><a data-toggle="dropdown" class="dropdown-toggle" href="#">Home</a>-->
<!---->
<!--                    </li>-->
<!--                </ul>-->
                <div class="i_con">
                    <ul class="nav navbar-nav text-uppercase">
                        <?php if(!Yii::$app->user->isGuest):?>
                        <li><a href="<?= Url::toRoute(['/user/articles'])?>"><?=Yii::t('main','my_articles')?></a></li>
                        <?php endif;?> <?php if(!Yii::$app->user->isGuest &&  Yii::$app->user->identity->isAdmin ):?>
                        <li><a href="<?= Yii::$app->urlManagerBackend->createUrl("")?>"><?=Yii::t('main','go_backend')?></a></li>
                        <?php endif;?>
                        <?php if(Yii::$app->user->isGuest):?>
                            <li><a href="<?= Url::toRoute(['/auth/login'])?>"><?=Yii::t('main','Login')?></a></li>
                            <li><a href="<?= Url::toRoute(['/auth/signup'])?>"><?=Yii::t('main','Register')?></a></li>
                        <?php else: ?>
                            <?= Html::beginForm(['/auth/logout'], 'post')
                            . Html::submitButton(
                                Yii::t('main','Logout').'(' . Yii::$app->user->identity->username . ')',
                                ['class' => 'btn btn-link logout', 'style'=>"padding-top:10px;"]
                            )
                            . Html::endForm() ?>
                        <?php endif;?>
                    </ul>
                </div>

            </div>
            <!-- /.navbar-collapse -->
        </div>
    </div>
    <!-- /.container-fluid -->
</nav>
<div class="container">
<?= $content ?>
</div>

<footer class="footer-widget-section">
    <div class="footer-copy">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">&copy;  My Blog 2018
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
