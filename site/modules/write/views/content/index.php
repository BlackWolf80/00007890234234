<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'edit',
                'value' => function($data){
                    return '<a href="/write/content/view?id=' .$data->id. '">' .$data->name. '</a>';
                },
                'format' => 'html',
            ],
            'content_html:html',
            'content_html_en:html',
//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>


