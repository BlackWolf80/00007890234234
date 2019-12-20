<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\models\LoginForm;
use app\models\Parkings;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use yii\web\View;

$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;

//echo'<pre>'; print_r($model); die;
?>

<section id="login">
    <h1 class="text-uppercase text-center">Восстановление пароля</h1>
    <div class="row" id="group">
        <div class="col"></div>
        <div class="col" >
            <?php $form = ActiveForm::begin([
                'id' => 'restore-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
            ]);

            ?>



            <div class="form-group"><input type="text" id="restoreform-username" class="form-control" name="RestoreForm[username] aria-required="true" placeholder="Логин">
                <p class="help-block help-block-error "></p>
            </div>


            <div class="form-group" id="links">


                <?= Html::submitButton('Восстановить', ['class' => 'btn btn-primary text-uppercase restore-button', 'name' => 'restore-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col"></div>
    </div>
    <div class="row" id="group">
        <div class="col"></div>
        <div class="col"><img id="logo" src="ass/img/logo.png"></div>
        <div class="col"></div>
    </div>
</section>



