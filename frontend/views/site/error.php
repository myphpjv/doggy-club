<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;
use common\models\Category;

$this->title = 'Страница не найдена (404)';
?>
<div class="not-found">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>В нашем блоге вы найдете много полезных статей в следующих категориях:</p>
    <ul class="not-found-list">
        <?php foreach (Category::getCategories() as $category): ?>
            <li><a href="<?= $category->getUrl() ?>"><?= $category->name ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
