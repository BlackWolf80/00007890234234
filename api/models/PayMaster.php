<?php


namespace app\models;

use yii\helpers\Json;

class PayMaster extends PayGate{

    static  $urlService='http://api.parkingsquatter.my/';

    public function hold($clientCard, $sum){
        /*
        $url =  self::$urlService.'reg';
        $string =  [
            'name' => 'Василий2',
            'phone' => '3453453534',
            'email' => 'vasya_pupkin@kakoetomilo.ru',
            'lat' => '45.03192099999999',
            'lng' => '38.91845039999999',
            'car_model' => 'крутой бентли',
            'car_color' => 'фиолетовый в ромашку',
        ];
        $resp = self::requestApi('post',$url,$string);

        */

        $source =[
            'type' => 'hold',
            'date' => time(),
            'client_card' => $clientCard,
            'sum' => $sum,
        ];

        $source = Json::encode($source);

        file_put_contents('./web/pays/card.json',print_r($source."\n",true), FILE_APPEND | LOCK_EX);

        return $source;
    }


    public function pay($clientCard, $sum){
        $source =[
            'type' => 'pay',
            'date' => time(),
            'client_card' => $clientCard,
            'sum' => $sum,
        ];

        $source = Json::encode($source);

        file_put_contents('./web/pays/card.json',print_r($source."\n",true), FILE_APPEND | LOCK_EX);
        return $source;
    }

    public function payReturn($clientCard, $sum){
        $source =[
            'type' => 'return',
            'date' => time(),
            'client_card' => $clientCard,
            'sum' => $sum,
        ];

        $source = Json::encode($source);

        file_put_contents('./web/pays/card.json',print_r($source."\n",true), FILE_APPEND | LOCK_EX);
        return $source;
    }


}