<?php

use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<?php if (Yii::$app->user->identity->status !=0):?>

    <section id="content" class="pb-5">
        <div class="row">
            <div class="col col-3"><img class="logo-dark" src="ass/img/logoPSQ.png"></div>
            <div class="col col-3">
                <h1 class="desc"><strong>Скачайте наше приложение и</strong><br><strong>и управляйте вашей парковкой&nbsp;</strong><br><strong>со смакртфона</strong><br><a href="#"><img id="ap" src="ass/img/ap.png"></a><a href="#"><img id="gp" src="ass/img/gp.png"></a><strong>&nbsp;</strong></h1>
            </div>
            <div class="col col-2"> <?php
                echo Text::widget([
                    'outputDir' => '@webroot/upload/qrcode',
                    'outputDirWeb' => '@web/upload/qrcode',
                    'ecLevel' => QRcode::QR_ECLEVEL_M,
                    'text' => '"token": "'.$token.'", "parking": "'.Yii::$app->user->identity->id.'"',
                    'size' => 5,
                ]);
                ?></div>
            <div class="col qr-des"><span class="text-left">Чтобы привязать новое <br>устройство отсканируйте <br>QR код в приложениии</span></div>
        </div>
        <div class="row gd-table-sect">
            <div class="col col-3"></div>
            <div class="col col-6 white-block gd-table">
                <h5 class="text-center table-label">Список привязанных устройств</h5><table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Дата</th>
                        <th></th>
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
                </table></div>
            <div class="col col-3"></div>
        </div>
    </section>

<?php else:?>


<?php endif;?>
