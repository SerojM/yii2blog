<?php use common\models\Category;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <?php

                foreach ($articles as $article) :?>
                    <article class="post post-list"  data-id="<?=$article->id?>">
<div>
                            <button class="btn btn_accept confirm_article"  data-id="<?=$article->id?>">Confirm</button>
                            <button class="btn btn_delete delete_article"   data-id="<?=$article->id?>">Delete</button>
</div>
                        <div class="row " >
                            <div class="col-md-6">
                                <div class="post-thumb">
                                    <a href="<?=Yii::$app->urlManagerFrontend->createUrl("site/view/$article->id")?>"><img src="<?=$article->getImage()?>" alt="" class="pull-left"></a>

                                    <a href="<?= Yii::$app->urlManagerFrontend->createUrl("site/view/$article->id")?>" class="post-thumb-overlay text-center">
                                        <div class="text-uppercase text-center">View Post</div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="post-content">
                                        <header class="entry-header text-uppercase">
                                        <h6><a href="<?= Yii::$app->urlManagerFrontend->createUrl( "site/category/".$article->category->id)?>"> <?=$article->category->title?></a></h6>

                                        <h1 class="entry-title"><a href="<?= Yii::$app->urlManagerFrontend->createUrl("site/view/$article->id")?>"><?=$article->title?></a></h1>
                                    </header>
                                    <div class="entry-content">
                                        <p><?= $article->description ?>
                                        </p>
                                    </div>
                                    <div class="social-share">
                                        <span class="social-share-title pull-left text-capitalize">By <?= $article->author['username'] ?> On <?= $article->date ?> </span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach;?>

                <?php echo LinkPager::widget([
                    'pagination' => $pagination,
                ]); ?>
            </div>

        </div>
    </div>
</div>
