<?php

/* @var $this yii\web\View */
/* @var $models array */

$this->title = Yii::$app->params['siteName'] . ' - блог о собаках';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Полезная информация и советы по уходу, питанию, воспитанию и здоровью собак в блоге '
        . Yii::$app->params['siteName']
]);
?>

<h1 class="page-title">Сайт о наших любимых питомцах!</h1>
<?php foreach ($models as $model): ?>
    <div class="category-group-title">
        <a href=" <?= $model['category_url'] ?>"><?= $model['category_name'] ?></a>
    </div>

    <div class="card-deck">
        <?php foreach ($model['posts'] as $post): ?>
            <?= $this->render('_post', ['model' => $post]) ?>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

