<?php
/* @var $this yii\web\View */

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
?>

<div class="header-images">
    <div class="container">
        <div class="logo">
            <?php if($controller == 'post' && $action == 'index') : ?>
                <img src="/images/logo.jpg" alt="<?= Yii::$app->params['siteName'] ?>">
            <?php else: ?>
                <a href="/">
                    <img src="/images/logo.jpg" alt="<?= Yii::$app->params['siteName'] ?>">
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="main-menu container">
    <div class="row">
        <?= $this->render('_menu') ?>
    </div>
</div>