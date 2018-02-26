<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = Yii::t('main','update_article') .' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 'selectedTags' => $selectedTags, 'tags' => $tags, 'items' => $items
    ]) ?>

</div>
