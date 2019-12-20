<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\MetaWindget;
use lesha724\documentviewer\ViewerJsDocumentViewer;
use lesha724\documentviewer\GoogleDocumentViewer;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta name="yandex-verification" content="af11aea9c86275ce" />
    <meta name="google-site-verification" content="X7LferUNGfHGHB_OQSgCxAxbjtZyyskKmQpwZrmDSRc" />
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <meta name="robots" content="<?=MetaWindget::widget(['metatag'=>'robots'])?>">
    <meta name="keywords" content="<?=MetaWindget::widget(['metatag'=>'keywords'])?>" />
    <meta name="description" content="<?=MetaWindget::widget(['metatag'=>'description'])?>" />




    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<?php if (isset($_SERVER['HTTP_CF_CONNECTING_IP']))
    $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
?>




<body id="body">
<?php $this->beginBody() ?>

<nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar" id="navbar">
    <div class="container" >
        <span class="nav_menu">
            <a class="navbar-brand js-scroll-trigger" href="#body"><img src="assets/img/logo.png" style="height: 90px;"></a>
        </span>
        <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1">
            <span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-1">

            <ul class="nav navbar-nav ml-auto nav_menu">

                <?php if(\Yii::$app->language == 'ru-RU'):?>
                    <li class="nav-item" role="presentation"><a class="nav-link active js-scroll-trigger" href="#how_it_work">
                            Как это работает</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#become_squatter">
                            Стать сквоттером</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#blog">
                            Блог</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#contacts">
                            Контакты</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#about">
                            О нас</a></li>
                <?php else:?>
                    <li class="nav-item" role="presentation"><a class="nav-link active js-scroll-trigger" href="#how_it_work">
                            how it works</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#become_squatter">
                            become squatter</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#blog">
                            blog</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#contacts">
                            Contact Us</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#about">
                            About</a></li>
                <?php endif;?>

            </ul>


                <div id="soc_icons">
                    <a href="https://vk.com/parkingsquatter" class="nav-icons" target="_blank">
                        <i class="fab fa-vk"></i>
                    </a>
<!--                    <a href="#" class="nav-icons" target="_blank">-->
<!--                        <i class="fab fa-telegram-plane"></i>-->
<!--                    </a>-->
                    <a href="https://www.facebook.com/viacheslav.krikunenko" class="nav-icons" target="_blank">
                        <i class="fab fa-facebook-square"></i>
                    </a>
                    <a href="https://twitter.com/SquatterParking" class="nav-icons" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
<!--                    <a href="#" class="nav-icons" target="_blank">-->
<!--                        <i class="fab fa-reddit"></i>-->
<!--                    </a>-->
                    <a href="https://medium.com/@parkingsquatter" class="nav-icons" target="_blank">
                        <i class="fab fa-medium-m"></i>
                    </a>
                    <a href="https://www.instagram.com/parksquatter/" class="nav-icons" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>

        </div>
    </div>
</nav>
<main class="page landing-page">

    <?= Alert::widget() ?>
    <?= $content ?>
</main>

<footer class="page-footer dark">
    <div class="footer-copyright container-fluid">
        <p>
            <span class="pull-right">ООО "ПАРКИНГ СКВОТТЕР" ИНН 2308268967, ОГРН 1192375068973</span><br>
            <span class="pull-center"> © 2019 Copyright ParkingSquatter</span>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".nav_menu").on("click"," a", function (event) {
            event.preventDefault();
            var id  = $(this).attr('href'),
                top = $(id).offset().top;
            $('body,html').animate({scrollTop: top}, 700);
        });

    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').focus()
        })
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.myModal').on('shown.bs.modal', function () {
            $('#myInput').focus()
        })
    });
</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(55257643, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
    });
</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(55257643, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        ecommerce:"dataLayer"
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/55257643" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-JQ2JETT307"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-JQ2JETT307');
</script>
</body>
</html>
<?php $this->endPage() ?>