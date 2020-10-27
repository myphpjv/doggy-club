<?php

use common\models\Post;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить статью', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Сбросить', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['style' => 'table-layout:fixed;'],
        'columns' => [
            'id',
            'title',
            [
                'attribute' => 'content',
                'value' => function (Post $data) {
                    return strip_tags(StringHelper::truncateWords($data->content, 5));
                }
            ],
            'resource',
            'alias',
            [
                'attribute' => 'active',
                'filter' => [0 => 'нет', 1 => 'да']
            ],
            [
                'attribute' => 'created_at',
                'value' => function (Post $data) {
                    return $data->getCreated(true);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function (Post $data) {
                    return $data->getUpdated(true);
                }
            ],
            [
                'class' => 'backend\components\ActionColumnCustom',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>


</div>
