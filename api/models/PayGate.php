<?php

namespace app\models;


use Yii;
use yii\base\Model;
use linslin\yii2\curl;

class PayGate extends Model{

    static  $urlService=null;

    public function requestApi($typeRequest,$url,$params){
        $curl = new curl\Curl();
        $response ='';
        switch ($typeRequest){
            case 'get':
                $response = $curl->get($url.$params);
                break;
            case 'post':
                $response = $curl->setPostParams($params)->post($url);
                break;
        }

        return $response;
    }

    public function hold($clientCard, $sum){}

    public function pay($clientCard, $sum){}

    public function payReturn($clientCard, $sum){}
}