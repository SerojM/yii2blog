<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'title',
            'description:ntext',
            'content:ntext',
            'date',
            [
                'attribute' => 'category_id',
                'value' => function ($data) {
                    $category = Category::find()->where(['id' => $data['category_id']])->one();
                    if (!empty($category) || $category != null) {
                        return $category->title;
                    }
                    return '';
                },
            ],
            [
                'attribute' => 'image',
                'format' => 'html',
                'label' => 'Image',
                'value' => function ($data) {
                    return Html::img(Yii::getAlias('@image_path/') . $data['image'],
                        ['width' => '500px']);
                },
            ],
        ],
    ]) ?>

</div>
