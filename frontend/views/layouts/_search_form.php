<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
?>

<form action="<?= Url::to(['/site/search']); ?>" method="get">
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="q" value="<?= Yii::$app->request->get('q') ?>" placeholder="Поиск...">
        <div class="input-group-append">
            <button class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></button>
        </div>
    </div>
</form>