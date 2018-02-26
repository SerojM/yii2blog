<?php

use common\models\Category;
use \yii\widgets\LinkPager;
use yii\helpers\Url;
?>
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php foreach ($articles as $article): ?>
                    <article class="post">
                        <div class="post-thumb">
                            <a href="<?= Url::toRoute(['site/view','id'=>$article->id])?>"><img src="<?= Yii::getAlias('@image_path/') . $article['image'] ?>"
                                                     alt=""></a>

                            <a href="<?= Url::toRoute(['site/view','id'=>$article->id])?>" class="post-thumb-overlay text-center">
                                <div class="text-uppercase text-center"><?= Yii::t('main','view_post')?></div>
                            </a>
                        </div>
                        <div class="post-content">
                            <header class="entry-header text-center text-uppercase">
                                <h6><a href="<?= Url::toRoute(['site/category','id'=>$article->category->id])?>"> <?= $article->category->title ?></a></h6>

                                <h1 class="entry-title"><a href="<?= Url::toRoute(['site/view','id'=>$article->id])?>"><?= $article->title ?></a></h1>


                            </header>
                            <div class="entry-content">
                                <p><?= $article->description ?> </p>
                                <div class="btn-continue-reading text-center text-uppercase">
                                    <a href="<?= Url::toRoute(['site/view','id'=>$article->id])?>" class="more-link"><?= Yii::t('main','continue_reading')?></a>
                                </div>
                            </div>
                            <div class="social-sh are">
                                <span class="social-share-title pull-left text-capitalize">By <a
                                            href="#"><?= $article->author['username'] ?></a> On <?= $article->date ?></span>

                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>

                <?php echo LinkPager::widget([
                    'pagination' => $pagination,
                ]); ?>

            </div>
            <?= $this->render('/partials/sidebar',[
                'parent_categories'=>$parent_categories
            ]) ?>
        </div>
    </div>
</div>
<!-- end main content-->
<!--footer start-->