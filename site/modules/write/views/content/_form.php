<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use conquer\codemirror\CodemirrorWidget;
use conquer\codemirror\CodemirrorAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Content */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?= $form->field($model, 'id')->hiddenInput() ?>

    <?=$form->field($model, 'content_html')->widget(
    CodemirrorWidget::className(),
    [
        'preset'=>'php',
        'options'=>['rows' => 20],
        'assets'=>[
            CodemirrorAsset::MODE_CLIKE,
            CodemirrorAsset::KEYMAP_EMACS,
            CodemirrorAsset::ADDON_EDIT_MATCHBRACKETS,
            CodemirrorAsset::ADDON_COMMENT,
            CodemirrorAsset::ADDON_DIALOG,
            CodemirrorAsset::ADDON_SEARCHCURSOR,
            CodemirrorAsset::ADDON_SEARCH,
        ],
        'settings'=>[
            'lineNumbers' => true,
            'mode' => 'text/x-csrc',
            'keyMap' => 'emacs'
        ],
    ]
);?>

    <?=$form->field($model, 'content_html_en')->widget(
        CodemirrorWidget::className(),
        [
            'preset'=>'php',
            'options'=>['rows' => 20],
            'assets'=>[
                CodemirrorAsset::MODE_CLIKE,
                CodemirrorAsset::KEYMAP_EMACS,
                CodemirrorAsset::ADDON_EDIT_MATCHBRACKETS,
                CodemirrorAsset::ADDON_COMMENT,
                CodemirrorAsset::ADDON_DIALOG,
                CodemirrorAsset::ADDON_SEARCHCURSOR,
                CodemirrorAsset::ADDON_SEARCH,
            ],
            'settings'=>[
                'lineNumbers' => true,
                'mode' => 'text/x-csrc',
                'keyMap' => 'emacs'
            ],
        ]
    );?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
