<?php

/* @var $this yii\web\View */
use app\components\ParkingActivationWidget;
use yii\web\View;

$this->title = 'PSQ Manager';
$this->params['breadcrumbs'][] =  ['label' => 'Парковки', 'url' => ['/parkings']];
$this->params['breadcrumbs'][] = 'Запросы на активацию';

?>

<div class="site-index">

    <div class="body-content">
        <?=ParkingActivationWidget::widget() ?>
    </div>
</div>
