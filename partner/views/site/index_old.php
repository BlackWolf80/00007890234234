<?php

use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<div class="site-index">

    <div class="jumbotron">

        <?php if (Yii::$app->user->identity->status !=0):?>
            <h6>Скачайте наше приложение и управляйте вашей праковкой со смартфона</h6><br>
            <a href="#" target="_blank"><img style="background-size: 22em;background-position: -14px -15px;width: 160px;height: 48px;margin-top: -10px;margin-right: 0px;margin-left: -13px;padding-right: 0;" src="images/gp.png"></a>
            <a href="#" target="_blank"><img style="background-image: url(&quot;Both-1-1024x218.png&quot;);background-size: 22em;background-position: -177px -15px;width: 160px;height: 48px;margin-top: -10px;margin-right: 0px;margin-left: 9px;" src="images/ap.png"></a>
        <div class="row">
            <div class="col s12">

                <?php
                echo Text::widget([
                    'outputDir' => '@webroot/upload/qrcode',
                    'outputDirWeb' => '@web/upload/qrcode',
                    'ecLevel' => QRcode::QR_ECLEVEL_M,
                    'text' => '"token": "'.$token.'", "parking": "'.Yii::$app->user->identity->id.'"',
                    'size' => 6,
                ]);
                ?>

                <h6>Чтобы привязать новое устройство отсканируйте QR код в приложении</h6>
                <hr>
            </div>
            <div class="col s12">
                <h6>Список привязанных устройств</h6>

                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Дата</th>
                        <th>#</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php if(!empty($gadgets)):?>
                        <?php foreach ($gadgets as $gadget):?>
                            <tr>
                                <td><?=$gadget['token']?></td>
                                <td><?=date("Y-m-d H:i:s", (int)$gadget['date'])?></td>
                                <td><?=Html::a('Удалить',['/site/gadget-del','id'=>$gadget['token']],['class'=>' btn-sm btn'])?></td>

                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>


                    </tbody>
                </table>
            </div>

        </div>


        <?php else:?>

            <div class="row">
                <div class="col s12">

                    <h2>Ваша учетная запись создана. <br>Ожидайте подтверждения.</h2>
                    <?php if($login != null):?>
                    <p>
                        Ваш логин: <?=$login?><br>
                        Ваш пароль: <?=$password?>
                    </p><br>
                    (пожалуйста запишите ваши учетные данные в дальнейшем они не будут показаны )
                    <?php endif;?>
                    <hr>
                    <?= Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Распечатать договор', ['/print','id'=> Yii::$app->user->identity->id], [
                        'class'=>'btn btn-danger',
                        'target'=>'_blank',
                        'data-toggle'=>'tooltip',
                        'title'=>'Will open the generated PDF file in a new window',
                        'onclick' => 'window.location.reload(true)',
                    ]);
                    ?>
                </div>
            </div>


        <?php endif;?>

    </div>

</div>
