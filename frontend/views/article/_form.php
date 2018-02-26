<?php

use common\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(Yii::t('main', 'title')) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6])->label(Yii::t('main', 'description')) ?>
    <?= $form->field($model, 'content')->textarea(['rows' => 6])->label(Yii::t('main', 'content')) ?>
    <?php
    $params = [
        'prompt' => Yii::t('main', 'select_category'),
        'id' => 'category_id'
    ];
    echo $form->field($model, 'category_id')->dropDownList($items, $params)->label(Yii::t('main', 'category'))->label(Yii::t('main', 'select_sub_category'));
    ?>
    <!--  Second drop down -->
    <div class="second_select" style="display: none">
        <?php $second_params = [
            'prompt' => 'Select a Category ...',
            'id' => 'subcat_id'
        ]; ?>
        <?php echo $form->field($model, 'sub_category')->dropDownList([], $second_params)->label(Yii::t('main', 'subcategory')); ?>

    </div>
    <label> <?= Yii::t('main', 'tags_for_article') ?> </label>
    <?= Html::dropDownList('tags', $selectedTags, $tags, ['class' => 'form-control', 'multiple' => true, 'prompt' => Yii::t('main', 'no_tags')]) ?>

    <?= $form->field($model, 'image')->fileInput(['id' => 'img_inp']) ?>
    <?= $form->field($model, 'hidden_val')->hiddenInput(['value' => $model->image, 'class' => 'hidden_val'])->label(false) ?>
    <div class="brows_image_div">
        <img width="200px" style="<?= empty($model->image) ? 'display:none' : 'display:block' ?>" id="brows_image"
             src="<?= !empty($model->image) ? Yii::getAlias('@image_path/') . $model->image : '' ?>"
             alt="Image not found"/>
        <span class="close" style="<?= empty($model->image) ? 'display:none' : 'display:block' ?>"
              id="delete_img">X</span>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('main', 'save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
