<?php

use common\models\Post;

/* @var $this yii\web\View */
/* @var $model Post */

?>

<div class="card card-post">
    <a href="<?= $model->getUrl() ?>">
        <img src="<?= $model->getThumbUploadUrl('image') ?>" class="card-img-top"
             alt="<?= $model->title ?>" title="<?= $model->title ?>">
    </a>
    <div class="card-body">
        <h2 class="card-title">
            <a class="hover-red" href="<?= $model->getUrl() ?>"><?= $model->title ?></a>
        </h2>
        <div class="post-meta">
        <span class="post-date published"><?= $model->getCreatedText() ?></span>
            <span class="post-views">просмотры: <?= $model->views ?></span>
        </div>
        <p class="post-preview"><?= $model->getPreviewText(10) ?></p>
    </div>
</div>