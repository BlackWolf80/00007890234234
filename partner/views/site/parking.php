<?php

/* @var $this yii\web\View */

use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;
use yii\helpers\Html;

$this->title = 'Parking';
$this->params['breadcrumbs'][] = $this->title;

$i=0;
?>

<section id="content" class="pb-5">
    <div class="col pb-4">
        <h1 class="text-center" id="parking-title">Личный кабинет парковки</h1>
    </div>
    <div class="row pl-5">
        <div class="col col-6 left-1vw">
            <div class="row">
                <div class="col white-block left-1vw">
                    <h6 class="text-center table-label">Проверка пин-кода</h6><input type="text" class="left-1vw inp-pin"><button class="btn btn-primary text-center circle-btn mt-1" id="btn-pin-sub" type="button">Подтвердить</button></div>
                <div class="col white-block left-1vw right-1vw">
                    <h6 class="text-center table-label">Стоимость парковочного места</h6>
                    <h1 class="text-center price-label"><?=$price?>₽</h1>
                    <h6 class="text-center">установить стоимость</h6>
                </div>
            </div>
            <div class="row">
                <div class="col white-block left-1vw right-1vw top-1vh bottom-5vh mt-4">
                    <div class="row p-3">
                        <div class="col">
                            <h6 class="text-left">Установить минимальное количество свободных мест парковки</h6>
                        </div>
                        <div class="col">
                            <div  class="form-group mt-3 " >
<!--                                <button class="btn btn-primary circle-btn ml-1 mr-1">0</button>-->
<!--                                <button class="btn btn-primary circle-btn mr-1 on-btn" type="button">1</button>-->
<!--                                <button class="btn btn-primary circle-btn mr-1" type="button">2</button>-->
<!--                                <button class="btn btn-primary circle-btn mr-1" type="button">3</button>-->
<!--                                <button class="btn btn-primary circle-btn mr-1" type="button">4</button>-->
<!--                                <button class="btn btn-primary circle-btn" type="button">5+</button>-->
                                <?=$btns?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col"><button class="btn btn-primary mt-3 change-password white-block" type="button">Сменить пароль</button></div>
            </div>
        </div>
        <div class="col col-5 white-block">
            <h5 class="text-center table-label">Список привязанных устройств</h5><table id="table-gd" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Дата</th>

                </tr>
                </thead>
                <tbody>
                <?php if(!empty($gadgets)):?>
                    <?php foreach ($gadgets as $gadget):?>
                        <tr>
                            <td><?=$gadget['token']?></td>
                            <td><?=date("Y-m-d H:i:s", (int)$gadget['date'])?></td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<div class="site-index">

    <div class="jumbotron">
        <div class="row ">
            <div class="col s6 ">
                <h6>Проверка пин-кода</h6>
                <span id="pin-label"></span>
            </div>
            <div class="col s6 left-border">
                <h6>Стоимость парковочного места</h6>
                <span id="price-label"><h5><?=$price?> ₽</h5> </span>
            </div>

        </div>
        <div class="row">
            <div class="col s6 ">
                <div class="input-field">
                    <input id="pin" type="text" >
                    <label for="pin">введите пин-код</label>
                    <a href="#" id="set-pin" class="btn">Подвердить</a>
                </div>
            </div>
            <div class="col s6 left-border">
                <div class="input-field">
                    <input id="price" type="text" >
                    <label for="price">установить стоимость</label>
                    <a href="#" id="set-price" class="btn">Подвердить</a>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col s12">
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col s5">

                <h6>Список привязанных устройств</h6>
                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Дата</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php if(!empty($gadgets)):?>
                        <?php foreach ($gadgets as $gadget):?>
                            <tr>
                                <td><?=$gadget['token']?></td>
                                <td><?=date("Y-m-d H:i:s", (int)$gadget['date'])?></td>

                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>


                    </tbody>
                </table>
            </div>
            <div class="col s7 ">
                <h6>Установите минимальное количество свобоных мест парковки</h6>

                <p class="list">
                    <?=$btns?>
                </p>
                <div class="progress">
                    <?//=$progress?>
                </div>

            </div>
        </div>


    </div>

</div>

