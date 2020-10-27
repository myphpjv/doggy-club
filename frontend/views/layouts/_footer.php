<?php

use common\models\Post;
use frontend\widgets\RightSidebar;

/* @var $this yii\web\View */
/* @var $random Post[] */

?>

<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <div class="content-inner right-sidebar-section">
                <?= RightSidebar::widget(['postsType' => Post::RANDOM, 'postsTitle' => 'Интересные статьи']) ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="content-inner right-sidebar-section">
                <?= RightSidebar::widget(['postsType' => Post::RECENT, 'postsTitle' => 'Последние статьи']) ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="content-inner right-sidebar-section">
                <?= RightSidebar::widget(['postsType' => Post::POPULAR, 'postsTitle' => 'Популярные статьи']) ?>
            </div>
        </div>
    </div>
    <div class="footer-info">
        <?= date('Y') ?> © Doggy-club - блог о собаках! <a href="mailto:doggy-club1@yandex.ruSitemap.php">doggy-club1@yandex.ru</a>
    </div>
</div>