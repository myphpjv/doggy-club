<?php

use common\models\Post;
use yii\data\Pagination;

/* @var $this yii\web\View */
/* @var $models Post[] */
/* @var $pages Pagination */
/* @var $q string */
/* @var $shortQuery bool */

$this->title = 'Поиск на сайте ' . Yii::$app->params['siteName'];
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Полезная информация и советы по уходу, питанию, воспитанию и здоровью собак'
]);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Yii::$app->urlManager->createAbsoluteUrl(['/site/search'])]);
?>

<div class="category-posts-wrap">
    <div class="search-page-title">
        <h1>Результаты поиска: <span class="search-query"><?= $q ?></span></h1>
        <?php if ($shortQuery) { ?>
            <div class="search-empty">Запрос слишком короткий. Введите минимум 3 символа.</div>
        <?php }
        if (empty($models)) { ?>
            <div class="search-empty">К сожалению, ничего не найдено. Попробуйте изменить
                запрос.
            </div>
        <?php } ?>
    </div>


    <?php foreach ($models as $model) { ?>
        <div class="card mb-3 category-post category-post-search">
            <div class="row no-gutters">
                <div class="col-md-4">

                    <a href="<?= $model->getUrl() ?>">
                        <img src="<?= $model->getImageUrl() ?>" class="card-img" alt="<?= $model->title ?>"
                             title="<?= $model->title ?>">
                    </a>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="post-categories category-group-title category-group-search">
                            <ul>
                                <?php foreach ($model->getCategories() as $category): ?>
                                    <li><a href="<?= $category->getUrl() ?>"># <?= $category->name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
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
    <?php } ?>

    <div class="posts-pagination">
        <?= $this->render('/helper/_pagination', ['pages' => $pages]) ?>
    </div>
</div>
