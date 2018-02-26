<?php use common\models\Category;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post post-list">
                    <?php foreach ($articles as $article) : ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="post-thumb">
                                    <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>"><img
                                                src="<?= $article->getImage() ?>" alt="" class="pull-left"></a>

                                    <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>"
                                       class="post-thumb-overlay text-center">
                                        <div class="text-uppercase text-center"><?= Yii::t('main', 'view_post') ?></div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="post-content">
                                    <header class="entry-header text-uppercase">
                                        <h6>
                                            <a href="<?= Url::toRoute(['site/category', 'id' => $article->category->id]) ?>"> <?= $article->category->title ?></a>
                                        </h6>

                                        <h1 class="entry-title"><a
                                                    href="<?= Url::toRoute(['site/view', 'id' => $article->id]) ?>"><?= $article->title ?></a>
                                        </h1>
                                    </header>
                                    <div class="entry-content">
                                        <p><?= $article->description ?>
                                        </p>
                                    </div>
                                    <div class="social-share">
                                        <span class="social-share-title pull-left text-capitalize">By <?= $article->author['username'] ?>
                                            On <?= $article->date ?> </span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </article>
                <?php echo LinkPager::widget([
                    'pagination' => $pagination,
                ]); ?>
            </div>
            <div class="create_article_div"><a class="btn btn-success"
                                               href="<?= Url::toRoute(['article/create']) ?>"><?= Yii::t('main', 'create_new_article') ?></a>
            </div>
            <?= $this->render('/partials/sidebar', [
                'parent_categories' => $parent_categories
            ]) ?>
        </div>
    </div>
</div>
