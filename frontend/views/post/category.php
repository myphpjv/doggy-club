<?php

use common\models\Post;
use common\models\Category;
use yii\data\Pagination;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $models Post[] */
/* @var $category Category */
/* @var $pages Pagination */

$this->title = 'Категория: ' . $category->name;
$this->registerMetaTag([
    'name' => 'description',
    'content' => $this->title . '. Полезная информацию об уходе, питанию, воспитанию и здоровью собак в блоге ' . Yii::$app->params['siteName']
]);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);
?>
<h1 class="category-title"><?= $this->title ?></h1>
<div class="category-posts-wrap">
    <?php foreach ($models as $model): ?>
        <div class="card mb-3 category-post">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <a href="<?= $model->getUrl() ?>">
                        <img src="<?= $model->getImageUrl() ?>" class="card-img" alt="<?= $model->title ?>"
                             title="<?= $model->title ?>">
                    </a>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h2 class="card-title">
                            <a class="hover-red" href="<?= $model->getUrl() ?>"><?= $model->title ?></a>
                        </h2>
                        <p class="card-text"><?= $model->getPreviewText() ?></p>
                        <div class="post-meta">
                            <span class="post-date published"><?= $model->getCreatedText() ?></span>
                            <span class="post-views">просмотры: <?= $model->views ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="posts-pagination">
        <?= $this->render('/helper/_pagination', ['pages' => $pages]) ?>
    </div>
</div>
