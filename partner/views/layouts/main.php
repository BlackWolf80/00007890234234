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
<div>
    <nav class="navbar navbar-light navbar-expand-md">
        <div class="container"><a class="navbar-brand" href="#"><img id="logo" src="ass/img/logoDark.png"></a>
            <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                    class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto"><li class="nav-item" role="presentation"><?=Html::a('Устройства','/',['class'=>'nav-link active '])?></li>
                    <li class="nav-item" role="presentation"><?=Html::a('Управление парковкой','/parking',['class'=>'nav-link active '])?></li>
                    <li class="nav-item" role="presentation"><?=Html::a('Галерея','/gallery',['class'=>'nav-link active '])?></li>
                    <li class="nav-item" role="presentation"><?=Html::a('Выйти из профиля','/logout',['class'=>'nav-link active '])?></li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>