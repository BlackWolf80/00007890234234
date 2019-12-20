<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Meta tags';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-1 control-label'],
    ],
]); ?>

        <?= $form->field($meta, 'robots')->textInput(['value'=>$metaList['robots']]) ?>
            управляет индексацией конкретной web-страницы (
    NOINDEX — запрещает индексирование документа;
    NOFOLLOW — запрещает проход по ссылкам, имеющимся в документе;
    INDEX — разрешает индексирование документа;
    FOLLOW — разрешает проход по ссылкам. )
        <br />
        <?= $form->field($meta, 'description')->textarea(['value'=>$metaList['description']]) ?>
        <?= $form->field($meta, 'keywords')->textarea(['value'=>$metaList['keywords']]) ?>


    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>