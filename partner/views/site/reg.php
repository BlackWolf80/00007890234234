<?php

use app\models\LoginForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<!--<script src="/js/jquery.min.js"></script>-->

<?php
for($i=0; $i<=10; $i++){
    $arr[]=$i;
}

for($i = 0, $a = 0; $i < 48; $i++){
    $timeClick = date("H:i", strtotime("today + $a minutes"));
    $time[$timeClick] = $timeClick;
    $a += 30;
}


?>
<div class=""row>
    <div class="col s2"></div>
    <div class="col s8">

        <div class="row" id="alert_box" style="display: none">
            <div class="col s12 m12">
                <div class="card red darken-1">
                    <div class="row">
                        <div class="col s12 m10">
                            <div class="card-content white-text">
                                <p class="message"></p>
                            </div>
                        </div>
                        <div class="col s12 m2">
<!--                            <i class="material-icons dp48 icon_style" id="alert_close" aria-hidden="true">close</i>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="a1" class="reg-block" style="display: block">
            Шаг первый
            <div class="progress"><div class="determinate" style="width: 0%"></div></div>
            <h5>Укажите название и тип вашей парковки. Затем выберите дополнительные опции</h5>

            <div class="row">
                <div class="input-field col s6">
                    <input id="name" type="text" class="validate" required>
                    <label for="name">Название парковки</label>
                </div>
                <div class="input-field col s6">

                    <input id="phone" type="text" class="validate" required>
                    <label for="phone">Телефон</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s4">
                    <div class="form-group ">
                        <label class="col-lg-1 control-label" >Тип парковки</label>
                        <div class="col-lg-3">
                            <select id="type" style="width: 300px; height: 25px; font-size: 12px" class="form-control" required>
                                <option value="0">Выберите тип</option>
                                <?php foreach ($parkings as $ind=>$parking):?>
                                    <option value="<?=$ind+1?>"><?=$parking?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="input-field col s4">
                    <ul class="type_parking_options"></ul>
                </div>
            </div>


        </div>
        <div id="a2" class="reg-block" style="display: none">
            Шаг  второй
            <div class="progress"><div class="determinate" style="width: 20%"></div></div>
            <h5>Сколько у вас парковочных мест?</h5>
            <div class="row">
                <div class="input-field col s6">
                    <div class="form-group ">
                        <label class="col-lg-1 control-label" >Общее количество мест</label>
                        <div class="col-lg-3">
                            <select id="size" style="width: 300px; height: 25px; font-size: 12px" class="form-control" >
                                <option value="0">Выберите количество мест</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5 и более</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="input-field col s6">
                    <div class="form-group ">
                        <label class="col-lg-1 control-label" >Количество парковочных мест для предоставления услуги </label>
                        <div class="col-lg-3">
                            <select id="hold" style="width: 300px; height: 25px; font-size: 12px" class="form-control"></select>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col s6">
                    <span class="label">Тип допустимого транспортного средства</span>
                    <label><input type="checkbox" id="v1" class="valid_vehicles"/><span>Легковой автомобиль</span></label>
                    <label><input type="checkbox" id="v2" class="valid_vehicles"/><span>Внедорожник</span></label>
                    <label><input type="checkbox" id="v3" class="valid_vehicles"/><span>Микроавтобуc</span></label><br>
                    <label><input type="checkbox" id="v4" class="valid_vehicles"/><span>Грузовой автомобиль (до 3.5 тонн)</span></label>
                    <label><input type="checkbox" id="v5" class="valid_vehicles"/><span>Грузовой автомобиль (свыше 3.5 тонн)</span></label>

                </div>

                <div class="col s6">
                        <label><input type="checkbox" id="seat_guarantee" class="seat_guarantee"/><span>Можете-ли вы гарантировать наличие парковочных мест?</span></label>
                        <label><input type="text" id="limit_heights" class="limit_heights" value="3"/><span>Каково ограничение по высоте на вашей парковке?</span></label>
                </div>
            </div>


        </div>
        <div id="a3" class="reg-block" style="display: none">
            Шаг третий
            <div class="progress"><div class="determinate" style="width: 40%"></div></div>
            <h5>Укажите расположения вашей парковки на карте.</h5>
            <input id="lat" type="hidden" class="validate" >
            <input id="lng" type="hidden" class="validate"">

            <div id="map" class="map" style="height: 250px; width: 100%; cursor: pointer;"></div>

                <div class="input-field col s6">
                    <input placeholder="Адрес" id="address" type="text" class="validate" required>
                </div>

        </div>
        <div id="a4" class="reg-block" style="display: none">
            Шаг четвертый
            <div class="progress"><div class="determinate" style="width: 60%"></div></div>
            <h5>Выберите рабочие дни недели и часы работы </h5>
            <div class="row">
                <div class="col s6">
                    <ul>
                        <li><label><input type="checkbox" id="d1" class="w_day"/><span>Понедельник</span></label> </li>
                        <li><label><input type="checkbox" id="d2" class="w_day"/><span>Вторник</span></label> </li>
                        <li><label><input type="checkbox" id="d3" class="w_day"/><span>Среда</span></label> </li>
                        <li><label><input type="checkbox" id="d4" class="w_day"/><span>Четверг</span></label> </li>
                        <li><label><input type="checkbox" id="d5" class="w_day"/><span>Пятница</span></label> </li>
                        <li><label><input type="checkbox" id="d6" class="w_day"/><span>Суббота</span></label> </li>
                        <li><label><input type="checkbox" id="d7" class="w_day"/><span>Воскресенье</span></label> </li>
                    </ul>
                </div>

                <div class="col s6">
                    <label><input type="checkbox" id="around_the_clock" class="around_the_clock"/><span>Круглосуточно</span></label>
                    <hr>
                    <select id="start_time" style="width: 300px; height: 25px; font-size: 12px" class="form-control" >
                        <option value="0">Выберите время начала рабочего дня</option>
                        <?php foreach ($time as $ind=>$val):?>
                            <option value="<?=$val?>"><?=$val?></option>
                        <?php endforeach;?>
                    </select>
                    <select id="end_time" style="width: 300px; height: 25px; font-size: 12px" class="form-control" >
                        <option value="0">Выберите время конца рабочего дня</option>
                        <?php foreach ($time as $ind=>$val):?>
                            <option value="<?=$val?>"><?=$val?></option>
                        <?php endforeach;?>
                    </select>

                </div>


            </div>

        </div>
        <div id="a5" class="reg-block" style="display: none">
            Шаг пятый
            <div class="progress"><div class="determinate" style="width: 80%"></div></div>
            <h5>Выберите валюту и цену </h5>
            <div class="row">
                <div class="col s6">
                    <select id="currency" style="width: 300px; height: 25px; font-size: 12px" class="form-control" >
                        <option value="0">Валюта</option>
                        <option value="1">rub</option>
                        <option value="2">usd</option>
                        <option value="3">eur</option>
                    </select>
                </div>

                <div class="col s6">
                    <select id="price" style="width: 300px; height: 25px; font-size: 12px" class="form-control" >
                        <option value="0">Выберите цену</option>
                        <?php for ($i=100; $i<=1000; $i+=100):?>
                            <option value="<?=$i?>"><?=$i?></option>
                        <?php endfor;?>
                    </select>
                </div>

            </div>

        </div>
        <div id="a6" class="reg-block" style="display: none">
            Шаг последний
            <div class="progress"><div class="determinate" style="width: 100%"></div></div>
            <h5>Верно ли указаны данные? Если все верно нажмите кнопку подтвердить.</h5>

            <div class="row report">
                <div class="col s4">
                    <label class="label_name" for="name" style="color: red">Название парковки:</label>
                    <div class="name"></div>
                </div>
                <div class="col s4">
                    <label class="label_phone" for="phone" style="color: red">Телефон:</label>
                    <div class="phone"></div>
                </div>
                <div class="col s4">
                    <label class="label_type" for="type" style="color: red">Тип парковки:</label>
                    <div class="type"></div>
                </div>
            </div>
            <div class="row report">
                <div class="col s12">
                    <label class="label_options" for="name" style="color: #262626">Доп. опции:</label>
                    <div class="options"></div>
                </div>
            </div>
            <div class="row report">
                <div class="col s12">
                    <label class="label_options" for="name" style="color: #262626">Допустимые ТС:</label>
                    <div class="ts"></div>
                </div>
            </div>
            <div class="row report">
                <div class="col s6">
                    <label class="label_size" for="size" style="color: red">Общее количество парковочных мест:</label>
                    <div class="size"></div>
                </div>
                <div class="col s6">
                    <label class="label_hold" for="hold" style="color: red">Количество резервируемых парковочных мест:</label>
                    <div class="hold"></div>
                </div>
            </div>
            <div class="row report">
                <div class="col s6">
                    <label class="label_address" for="size" style="color: red">Адрес:</label>
                    <div class="address"></div>
                </div>
                <div class="col s6">
                    <label class="label_coords" for="size" style="color: red">Укажите точку на карте:</label>
                    <div class="coords"></div>
                </div>
            </div>
            <div class="row report">
                <div class="col s6">
                    <label class="label_wdays" for="size" style="color: red">Рабочие дни:</label>
                    <div class="wdays"></div>
                </div>
                <span class="col s6">
                    <label class="label_time" for="size" style="color: red">Часы работы:</label>
                   <div> <span class="start_time"></span> - <span class="end_time"></span></div>
             </div>
            <div class="row report">
                <div class="col s6">
                    <label class="label_price" for="size" >Цена:</label>
                    <div class="price"></div>
                </div>
                <span class="col s6">
                     <label class="label_currency" for="size" >Валюта:</label>
                    <div class="currency"></div>
            </div>

        </div>
    </div>
</div>

<div class="progress sub-progress">
    <div class="indeterminate"></div>
</div>
    <div class="col s2"></div>
</div>
<div class="row" style="text-align: center;">
    <div class="col s2">
        <a href="#" id="fr-minus" style="display: none" class="btn">Назад</a>
    </div>
    <div class="col s8"> </div>
    <div class="col s2">
        <a href="#" id="fr-plus"  class="btn">Далее</a>
        <a href="#" id="submit"  style="display: none" class="btn">Разместить</a>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>


