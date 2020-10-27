<?php

use common\models\Category;
use yii\helpers\Url;

/* @var $this yii\web\View */

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$query = Yii::$app->request->get('alias');
?>

<nav class="navbar navbar-dark navbar-expand-lg bg-dark">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <?php if($controller == 'post' && $action == 'index') : ?>
                    <span class="nav-link nav-main-page">Главная <span class="sr-only">(current)</span></span>
                <?php else: ?>
                        <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
                <?php endif; ?>

            </li>
            <?php foreach (Category::getCategories() as $category): ?>
                <li class="nav-item">
                    <?php
                    $class = "nav-link";
                    if ($action == 'category' && $query == $category->alias) {
                        $class = "nav-link active-menu-item";
                    }
                    ?>
                    <a class="<?= $class ?>" href="<?= $category->getUrl() ?>"><?= $category->name ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="search-form-wrap">
        <?= $this->render('_search_form') ?>
    </div>
</nav>