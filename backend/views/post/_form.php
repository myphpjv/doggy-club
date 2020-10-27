<?php

use common\models\Post;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categoriesIds')->dropDownList(Category::getCategoriesAdmin(), ['multiple' => true]) ?>

    <?= $form->field($model, 'content')->widget(Widget::className(), [
        'settings' => [
            'lang'      => 'ru',
            'minHeight' => 200,
            'plugins'   => [
                'clips',
                'fullscreen',
                'fontcolor',
                'fontsize'
            ]
        ]
    ]); ?>

    <?= $form->field($model, 'resource')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_ext')->textInput() ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<img src="<?= $model->image_ext ?>" alt="">
