<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\models\Parkings;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>


<section id="login">
    <h1 class="text-uppercase text-center">Авторизация</h1>
    <div class="row" id="group">
        <div class="col"></div>
        <div class="col" >
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
            ]);

            ?>



                <div class="form-group"><input class="form-control" id="loginform-username"  type="text" name="LoginForm[username]" aria-required="true" placeholder="Логин">
                    <p class="help-block help-block-error "></p>
                </div>

                <div class="form-group"><input type="password" id="loginform-password" class="form-control" name="LoginForm[password]" value="" aria-required="true" placeholder="Пароль">
                    <p class="help-block help-block-error "></p>
                </div>
                <div class="form-group" id="links">
                    <div class="form-row">
                        <div class="col"><a href="/restore-password">Забыли пароль?</a></div>
                        <div class="col"><a href="/reg">Зарегистрироваться</a></div>
                    </div>

                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary text-uppercase login-button', 'name' => 'login-button']) ?>
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