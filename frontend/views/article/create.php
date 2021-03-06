<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = Yii::t('main','create_article');
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'selectedTags' => $selectedTags, 'tags' => $tags,'items'=>$items
    ]) ?>

</div>
