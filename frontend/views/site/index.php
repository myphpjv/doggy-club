<?php

use common\models\Post;

/* @var $this yii\web\View */
/* @var $models Post[] */
/* @var $popular Post[] */
/* @var $recent Post[] */

$this->title = 'Главная';

?>

<div class="widget-area-inner" style="transform: none;">
    <div class="gc-container" style="transform: none;">
        <div class="row" style="transform: none;">
            <div class="col-lg-8 col-md-12 sticky-portion" style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">

                <div class="theiaStickySidebar" style="padding-top: 0px; padding-bottom: 1px; position: static; transform: none;"><div id="primary" class="content-area">
                        <main class="site-main">
                            <div class="gc-blog-lists gc-blog-list-s1">

                                <?php foreach ($models as $model): ?>
                                    <?= $this->render('_post', ['model' => $model]) ?>
                                <?php endforeach; ?>

                                <div class="gc-pagination">
                                    <div class="pagination-entry">
                                        <nav class="navigation pagination" role="navigation" aria-label="Posts">
                                            <h2 class="screen-reader-text">Posts navigation</h2>
                                            <div class="nav-links"><span aria-current="page" class="page-numbers current">1</span>
                                                <span class="page-numbers dots">…</span>
                                                <a class="page-numbers" href="https://demo.everestthemes.com/gucherry/page/4/">4</a>
                                                <a class="next page-numbers" href="https://demo.everestthemes.com/gucherry/page/2/">Next</a></div>
                                        </nav> </div>
                                </div>
                            </div>
                        </main>
                    </div></div></div>
            <div class="col-lg-4 col-md-12 sticky-portion" style="position: relative; overflow: visible; box-sizing: border-box; min-height: 5746.58px;">

                <div class="theiaStickySidebar" style="padding-top: 0px; padding-bottom: 1px; position: absolute; transform: translateY(3319.58px); top: 0px; width: 360px;"><aside id="secondary" class="secondary-widget-area">
                        <div class="widget gc-post-widget recent-s1">
                            <div class="widget-title">
                                <h3>Новые статьи</h3>
                            </div>
                            <div class="widget-container">
                                <?php foreach ($popular as $model): ?>
                                    <?= $this->render('_post_right', ['model' => $model]) ?>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="widget gc-post-widget popular-s1">
                            <div class="widget-title">
                                <h3>Популярные статьи</h3>
                            </div>
                            <div class="widget-container">
                                <?php foreach ($recent as $model): ?>
                                    <?= $this->render('_post_right', ['model' => $model]) ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </aside></div></div> </div>
    </div>
</div>