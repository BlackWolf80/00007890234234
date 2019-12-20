<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>



<?php
for($i=0; $i<=10; $i++){
    $arr[]=$i;
}

for($i = 0, $a = 0; $i < 48; $i++){
    $timeClick = date("H:i", strtotime("today + $a minutes"));
    $time[$timeClick] = $timeClick;
    $a += 30;
}
?>


<div id="map" class="map" style="height: 450px; width: 100%; cursor: pointer;"></div>

    <?php $form = ActiveForm::begin(['options'=>["class" => "form-horizontal",'id' => 'callForm']]) ?>


<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <?=$form->field($model,'w_day')->dropDownList([
                '1' => 'Понедельник',
                '2' => 'Вторник',
                '3' => 'Среда',
                '4' => 'Четверг',
                '5' => 'Пятница',
                '6' => 'Суббота',
                '7' => 'Воскресенье',
                ]) ?>
            <?=$form->field($model,'lat') ?>
        </div>
        <div class="col-sm-4">

            <?=$form->field($model,'act_time')->dropDownList($time) ?>
            <?=$form->field($model,'lng') ?>
        </div>
        <div class="col-sm-4">

            <?=$form->field($model,'active')->dropDownList($arr) ?>
            <?=Html::submitButton('Отправить', ['class'=> 'btn btn-success', 'style'=> 'position: relative; top: 1.9em; width: 100%; left: 0.5em;'])?>
        </div>
    </div>
</div>

    <?php ActiveForm::end() ?>



