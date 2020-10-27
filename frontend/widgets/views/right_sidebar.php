<?php

use common\models\Post;

/* @var $this yii\web\View */
/* @var $models Post[] */
/* @var $postsType string */
/* @var $postsTitle string */

?>

<div class="widget-content PopularPosts">
    <div class="right-sidebar-widget-title">
        <?= $postsTitle ?>
    </div>
    <div class="widget-posts-wrap">
        <?php if (!empty($models)): ?>
            <?php foreach ($models as $model): ?>

                <div class="widget-post-content">
                    <a class="widget-image-link" href="<?= $model->getUrl() ?>">
                        <img src="<?= $model->getThumbUploadUrl('image') ?>"
                             alt="<?= $model->title ?>"
                             title="<?= $model->title ?>">
                    </a>
                    <div class="widget-post-info">
                        <h2 class="widget-post-title">
                            <a class="hover-red" href="<?= $model->getUrl() ?>"><?= $model->title ?></a>
                        </h2>
                        <div class="post-meta">
                            <span class="post-date"><?= $model->getCreatedText() ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>