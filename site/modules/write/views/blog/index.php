<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Blog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'title_en',
            'post:html',
            'post_en:html',
            [
                'attribute' => 'img',
                'value' => function($data){
                    return '<img src="/upload/blog/'.$data->img.'">';
                },
                'format' => 'html',
            ],
            'create',
            'status',
            'sm',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
