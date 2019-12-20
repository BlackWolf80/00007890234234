<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = 'ParkingSquatter';
?>

<section id="header" class="clean-block clean-hero" style="background-image: url(&quot;assets/img/tech/distracted-driving-adobestock.png&quot;);color: rgba(9,162,255,0.7);">
   <?=$content['header'] ?>
</section>

<section id="how_it_work" class="clean-block clean-info dark">
    <?=$content['how_it_work'] ?>
</section>

<section id="become_squatter" class="clean-block features">

    <div class="container">
        <div class="block-heading app">
            <h2 class="text-info"> <?= \Yii::$app->language == 'ru-RU'? 'Доступно для Android & iOS' : 'Available for Android & iOS'?></h2>
            <p><?= \Yii::$app->language == 'ru-RU'? 'Скачайте приложение на смартфон' : 'Download the app to your smartphone'?> </p>
            <br>
            <a href="https://play.google.com/store/apps/details?id=com.parking.squatter" target="_blank"><img style="background-size: 22em;background-position: -14px -15px;width: 160px;height: 48px;margin-top: -10px;margin-right: 0px;margin-left: -13px;padding-right: 0;" src="assets/img/gp.png"></a>
            <a href="https://apps.apple.com/us/app/parking-squatter/id1477714824?l=ru&ls=1" target="_blank"><img style="background-image: url(&quot;Both-1-1024x218.png&quot;);background-size: 22em;background-position: -177px -15px;width: 160px;height: 48px;margin-top: -10px;margin-right: 0px;margin-left: 9px;" src="assets/img/ap.png"></a>
            <div class="container">
                <?=\app\components\DoscWindget::widget();?>
                <?=$content['become_squatter'] ?>
            </div>
</section>

<section id="blog" class="clean-block features">
    <?=\app\components\BlogWindget::widget();?>
</section>

<section id="slider" class="clean-block slider dark">
    <?=$content['slider'] ?>
</section>

<section id="contacts" class="clean-block about-us" style="padding-bottom: 0px;padding-top: 50px;">
    <div class="container">
        <div><div class="jumbotron-contact jumbotron-contact-sm">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <h1 class="h1">
                                <?php
                                if(\Yii::$app->language == 'ru-RU'){
                                    echo('Свяжитесь с нами <small > не стесняйтесь обращаться к нам</small>');
                                }else{
                                    echo('Contact us <small>Feel free to contact us</small>');
                                }?>

                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="well well-sm">

                            <?=\app\components\ContactFormWindget::widget()?>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <form>
                            <?=$content['contacts'] ?>
                        </form>
                    </div>
                </div>
            </div></div>
    </div>
</section>

<section id="about" class="clean-block about-us" style="padding-bottom: 0px;margin-top: 0px;">
    <?=$content['about'] ?>


</section>



