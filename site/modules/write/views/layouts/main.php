<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\WriteAsset;

WriteAsset::register($this);
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

<div class="wrap">
    <?php
    NavBar::begin([

        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
            'target' => '_blank'
        ],
    ]);

    echo '<a href="/elfinder/manager" onclick="window.open(this.href, \'\', \'resizable=no,status=no,location=no,toolbar=no,menubar=no,fullscreen=no,scrollbars=no,dependent=no,width=1000px,height=400px\'); return false;"><button class="btn btn-primary">Files</button></a>';

    echo '
    <div class="navbar-nav navbar-right">
    <ul>
           <li> <a href="/write/content" class="btn btn-pimary">Content</a></li>
            <li><a href="/write/blog" class="btn btn-pimary">Blog</a></li>
            <li><a href="/write/docs" class="btn btn-pimary">Docs</a></li>
            <li><a href="/write/meta" class="btn btn-pimary">Meta tags</a></li>
        
    ';
    echo Yii::$app->user->isGuest ? (
    ['label' => 'Login', 'url' => ['/site/login']]
    ) : (
        '<li>'
        . Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-pimary logout']
        )
        . Html::endForm()
        . '</li>'
    );
    echo  '</ul>';




   /* echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Content', 'url' => ['/write/content'],'options' => ['class'=>'btn btn-pimary']],
            ['label' => 'Blog', 'url' => ['/write/blog'],'options' => ['class'=>'btn btn-pimary']],
            ['label' => 'Meta tags', 'url' => ['/write/meta'],'options' => ['class'=>'btn btn-pimary']],
            ['label' => 'Docs', 'url' => ['/write/docs'],'options' => ['class'=>'btn btn-pimary']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-pimary logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);*/
    NavBar::end();
    ?>


    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
