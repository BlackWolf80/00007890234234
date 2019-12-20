<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>

</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap ">
    <div class=" navbar-fixed">
    <nav>
        <div class="nav-wrapper">
            <a href="/" class="brand-logo" style="height: 100%;"><img src="/images/logo.png" alt=""></a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <?php if (Yii::$app->user->identity->status !=0):?>
                <li><a class="btn btn-primary" href="/">Устройства</a></li>
                <li><a class="btn btn-primary" href="/parking">Управление парковкой</a></li>
                <li><a class="btn btn-primary" href="/gallery">Галерея</a></li>
                <li><a class="btn btn-primary" href="/newpassword">Сменить пароль</a></li>

                <?php endif;?>
                <li><a class="btn btn-primary" href="/logout">Выход(<?=Yii::$app->user->identity->username?>)</a></li>
            </ul>
        </div>
    </nav>
</div>
    <ul class="sidenav" id="mobile-demo">
        <a href="#!" class="brand-logo"><img src="/images/logo.png" alt=""></a>
        <li><a href="/parking">Управление парковкой</a></li>
    </ul>

    <div class="container">
        <?php  print_r(Yii::$app->user->isGuest)?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
