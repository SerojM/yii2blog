<?php use common\models\Category;
use yii\helpers\Url;
?>
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <?php if (Yii::$app->user->id == $article->user_id):?>
                    <p>
                        <a class="btn btn-warning" href="<?= Url::toRoute(['article/update','id'=>$article->id])?>"><?= Yii::t('main','update')?></a>
                        <a class="btn btn-danger" href="<?= Url::toRoute(['article/delete','id'=>$article->id])?>"><?= Yii::t('main','delete')?></a>
                    </p>
                    <?php endif; ?>
                    <div class="post-thumb">
                        <a href="<?= Url::toRoute(['site/view','id'=>$article->id])?>"><img src="<?=
                            $article->getImage() ?>" alt=""></a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="<?= Url::toRoute(['site/category','id'=>$article->category->id])?>"> <?=$article->category->title?></a></h6>

                            <h1 class="entry-title"><a href="<?= Url::toRoute(['site/view','id'=>$article->id])?>"> <?=$article->title?></a></h1>


                        </header>
                        <div class="entry-content">
                          <?= $article->content ?>
                        </div>
                        <div class="decoration">
                            <?php foreach ($tagModel as $item): ?>
                            <a href="#" class="btn btn-default"><?=$item->title?></a>
                            <?php endforeach; ?>
                        </div>

                        <div class="social-share">
							<span
                                class="social-share-title pull-left text-capitalize"><?= Yii::t('main','by') ?> <?= $article->author['username'] ?> <?= Yii::t('main','on') ?> <?=$article->date?></span>

                        </div>
                    </div>
                </article>

            </div>
            <?= $this->render('/partials/sidebar',[
                'parent_categories'=>$parent_categories
            ]) ?>
        </div>
    </div>
</div>
