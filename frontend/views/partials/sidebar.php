<?php
use common\models\Category;
use yii\helpers\Url;
?>
<div class="col-md-4" data-sticky_column>
    <div class="primary-sidebar">
        <aside class="widget border pos-padding">

            <h3 class="widget-title text-uppercase text-center"><?= Yii::t('main','Categories')?></h3>
            <ul>
                <?php foreach ($parent_categories as $parent_category): ?>
                    <?php $sub_cat = Category::getSubCategory($parent_category->id)?>
                    <li class="dropdown-submenu">
                        <a class="test" href="<?= Url::toRoute(['site/category','id'=>$parent_category->id])?>" style="font-size: 16px"><?= $parent_category->title ?></a>
                        <span class="post-count pull-right"> (<?= $parent_category->getArticlesCountInParent() ?>)</span>
                    </li>
                    <ul style="margin-left: 15px;font-size: 11px">
                        <?php foreach ($sub_cat as $item): ?>
                            <li><a href="<?= Url::toRoute(['site/category','id'=>$item->id])?>"><?= $item->title ?></a>
                                    <span class="post-count pull-right"> (<?= $item->getArticlesCount() ?>)</span>
                            </li>

                        <?php endforeach; ?>

                    </ul>

                <?php endforeach; ?>
            </ul>
        </aside>
    </div>
</div>
