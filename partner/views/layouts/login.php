<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\LoginAsset;

LoginAsset::register($this);
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

<nav class="navbar navbar-light navbar-expand-md">
    <div class="container-fluid"><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav text-uppercase">
                <li class="nav-item" role="presentation"><a class="nav-link" href="#">Как это работает?</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="#">Стать сквоттером</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="#">Блог</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="#">Контакты</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="#">О нас</a></li>
            </ul>
            <div class="row ml-auto navbar-text actions">
                <div class="col"><input type="search" id="search" style="padding-left: 12px;" placeholder="поиск"><button class="btn btn-primary search-button" type="button"><i class="fa fa-search"></i></button></div>
            </div>
        </div>
    </div>
</nav>
<div class="flash">
    <?=\app\components\FlashWidget::widget();?>
</div>

<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>