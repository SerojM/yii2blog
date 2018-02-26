<?php

use common\models\Category;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                'attribute' => 'description',
                'contentOptions'=>['id'=>'td_width_wrap']
            ],
            [
                'attribute' => 'content',
                'contentOptions'=>['id'=>'td_width_wrap2']

            ],
            'date',
            [
                'attribute' => 'category_id',
                'value' => function ($data) {
                    $categories = Category::find()->where(['id' => $data['category_id']])->all();
                    $cat_name = '';
                    foreach ($categories as $category) {
                        $cat_name = $category->title;
                    }
                    return $cat_name;
                },
            ],
            [
                'attribute' => 'image',
                'format' => 'html',
                'label' => 'Image',
                'value' => function ($data) {
                    return Html::img(Yii::getAlias('@image_path/') . $data['image'],
                        ['width' => '150px']);
                },
            ],
            //'user_id',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

