<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?= $form->field($model, 'name')->textInput(['placeholder' => "Enter name"]) ?>
            </div>
            <div class="form-group">

                <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                </span>
                    <?= $form->field($model, 'email')->textInput(['placeholder' => "Enter email"]) ?></div>
            </div>
            <div class="form-group">

                <?= $form->field($model, 'subject')->dropDownList([
                    'service' => 'General Customer Service',
                    'suggestions' => 'Suggestions',
                    'product' => 'Product Support',
                ]) ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?= $form->field($model, 'message')->textarea(['rows' => 6,'cols'=>25,'placeholder' => "Message"]) ?>
            </div>
        </div>
        <div class="col-md-12">
            <?= Html::submitButton('Send Message', ['class' => 'btn btn-primary pull-right', 'name' => 'contact-button']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>