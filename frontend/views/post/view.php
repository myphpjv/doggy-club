<?php

use common\models\Post;
use frontend\widgets\RightSidebar;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model Post */
/* @var $random Post[] */

$this->title = $model->title;
$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->title . '. Полезная информацию об уходе, питанию, воспитанию и здоровью собак в блоге ' .
        Yii::$app->params['siteName']
]);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);
?>

<div class="single-post-wrap">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
            <div class="content-inner">
                <h1 class="single-post-title"><?= $this->title ?></h1>
                <div class="post-meta meta-single-page">
                    <span class="post-date published"><?= $model->getCreatedText() ?></span>
                    <span class="post-views">просмотры: <?= $model->views ?></span>
                </div>
                <div class="single-post-content">
                    <div class="single-post-main-image">
                        <img src="<?= $model->getImageUrl() ?>" alt="<?= $model->title ?>" title="<?= $model->title ?>">
                    </div>
                    <?= $model->content ?>
                </div>
                <div class="post-categories category-group-title">
                    <ul>
                        <?php foreach ($model->getCategories() as $category): ?>
                            <li><a href="<?= $category->getUrl() ?>"># <?= $category->name ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="post-resource">Источник: <?= $model->resource ?></div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 right-sidebar-wrap">
            <div class="content-inner right-sidebar-section">
                <?= RightSidebar::widget(['postsType' => Post::RECENT, 'postsTitle' => 'Последние статьи']) ?>
            </div>
            <div class="content-inner right-sidebar-section">
                <?= RightSidebar::widget(['postsType' => Post::POPULAR, 'postsTitle' => 'Популярные статьи']) ?>
            </div>
        </div>
    </div>
</div>


