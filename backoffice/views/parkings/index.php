<?php

/* @var $this yii\web\View */
use app\components\ParkingActivationWidget;
use yii\helpers\Html;

$this->title = 'PSQ Manager';
$this->params['breadcrumbs'][] = 'Парковки';

?>
<section class="content">
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Список парковок</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <?php if(!empty($parkings)):?>
                        <table class="table table-bordered table-striped data_table">
                            <thead>
                            <th>#</th>
                            <th>Имя</th>
                            <th>Размер</th>
                            <th>Адрес</th>
                            <th>Телефон</th>
                            <th>Тип оплаты</th>
                            <th>Цена</th>
                            <th>Время начала</th>
                            <th>Время конца</th>
                            <th>Договор</th>
                            <th>Статус</th>
                            </thead>
                            <tbody>
                            <?php foreach ($parkings as $parking):?>
                                <tr><td><?=$parking->id?></td>
                                    <td><?=$parking->name?></td>
                                    <td><?=$parking->size?></td>
                                    <td><?=$parking->address?></td>
                                    <td><?=$parking->phone?></td>
                                    <td><?=$parking->type_of_payment?></td>
                                    <td><?=$parking->price?></td>
                                    <td><?=$parking->start_time?></td>
                                    <td><?=$parking->end_time?></td>
                                    <td><p data-placement="top" data-toggle="tooltip" title="Рапечатать договор">
                                            <a href="/parkings/print-contract?id=<?=$parking->id?>" target="_blank">
                                                <button class="btn btn-block btn-success" data-title="print" >Распечатать <span class="glyphicon glyphicon-pencil"></span></button>
                                            </a>
                                        </p>
                                    </td>
                                    <?php if($parking->status == 1):?>
                                        <td class="position-relative ">
                                            <div class="ribbon-wrapper ribbon-lg">
                                                <div class="ribbon bg-success">
                                                    Активировна
                                                </div>
                                            </div>
                                        </td>

                                    <?php else:?>
                                        <td class="position-relative ">
                                            <div class="ribbon-wrapper ribbon-lg">
                                                <div class="ribbon bg-danger">
                                                    Не активировна
                                                </div>
                                            </div>

                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>

                    <?php else:?>
                        <h4># В данный момент ни одной парковки не зарегистрировано...</h4>
                    <?php endif;?>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
