<?php

use yii\widgets\LinkPager;
use yii\data\Pagination;

/* @var $this yii\web\View */
/* @var $pages Pagination */

echo LinkPager::widget([
    'pagination' => $pages,
    'maxButtonCount' => 4
]);
?>