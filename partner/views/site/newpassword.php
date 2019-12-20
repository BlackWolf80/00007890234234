<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>


<?php $form = ActiveForm::begin(['id' => 'contact-form']);?>


<?= $form->field($user, 'password')->passwordInput(['autofocus' => true]) ?>


<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
</div>

<?php ActiveForm::end(); ?>