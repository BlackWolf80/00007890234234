
<?php

use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

//echo '<pre>';
//print_r($files);die;
?>




<div class="site-index">

    <div class="jumbotron">

            <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data']
            ]);
            ?>

                <div class = "row">
                    <div class = "file-field input-field col s6">
                        <div class = "btn">
                            <span>Обзор</span>
                            <?= $form->field($model, 'file')->fileInput(['class'=>'btn'])->label(false); ?>
                        </div>
                        <div class = "file-path-wrapper">
                            <input class = "file-path validate" type = "text"
                                   placeholder = "Выберите файл" />
                        </div>
                    </div>
                    <div class="col s6">
                        <button class="btn">Загрузить</button>
                    </div>
                </div>



            <?php ActiveForm::end(); ?>

        <div class="row">
            <div class="col s12">
                <div class="cssSlider">
                    <ul class="thumbnails">
                        <?php foreach ($files as $ind=>$file):?>
                            <li><a href="#slide<?=$ind?>"><img src="<?=$dirView.$file?>" style="height: 10em"/></a>
                                <a href=""></a>
                                <?=Html::a('<i class="material-icons dp48">highlight_off</i>',['/gallery','del'=>$file])?>
                            </li>

                        <?php endforeach;?>

                    </ul>
                    <ul class="slides">
                        <?php foreach ($files as $ind=>$file):?>
                            <li id="slide<?=$ind?>"><img src="<?=$dirView.$file?>" alt="" style="width: 100%"/></li>
                        <?php endforeach;?>
                    </ul>

                </div>
            </div>
        </div>
    </div>

</div>
