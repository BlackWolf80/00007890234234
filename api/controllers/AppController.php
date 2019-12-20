<?php


namespace app\controllers;


use app\models\Users;
use yii\web\Controller;
use YandexCheckout\Client;


use yii\web\Response;
use linslin\yii2\curl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii;

class AppController extends Controller{

    public $queryProcessorTimeout=3;

    //      отключение csrf валидации
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    //      email оповещение
    public function mailSender($view,$paramsForView,$fromEmail,$toEmail,$title){
        Yii::$app->mailer->compose ($view, $paramsForView)
            ->setFrom ([$fromEmail=>Yii::$app->params['senderName']])
            ->setTo ($toEmail)
            ->setSubject ($title)
            ->send ();
    }

//      смс оповещение
    public function smscSender($phone, $message){
        //Init curl
        $curl = new curl\Curl();

        $login = Yii::$app->params['senderEmail'];
        $password = Yii::$app->params['senderEmail'];
        $url = 'https://smsc.ru/sys/send.php';
        //get http://example.com/
        $response = $curl->get('https://smsc.ru/sys/send.php?login=Devdevdev&psw=djnnfrjqdjngfhjkm&phones='.$phone.'&mes='.$message);
    }

//      ответ приложению
    public function jsonAnswer($user_uid, $data_mess){
        $min_price = Yii::$app->params['min_price'];
        $currency = Yii::$app->params['currency'];
        $timeNow = time();
        $greyRefuse = 0;

        if($user_uid != 'all'){
            $user = Users::find()->where(['uid'=>$user_uid])->with('zone')->one();
//            $this->writeLog("./logs/test.log","answer",$user);die;
            //проверяем вхождение в платежную зону
            if($user->zone_id != 0){
                $min_price = $user->zone->min_price;
                $currency = $user->zone->currency;
            }
            //проверяем есть ли отказ от серых лотов на полгода
            if($user->refuse_half == 0){
                $greyRefuse = 0;
            }elseif($timeNow >= $user->refuse_half){
                //если есть проверяем закончился ли срок
                $greyRefuse = 1;
            }else{
                $greyRefuse = 0;
            }

        }

        $action = '/'.$this->module->id.'/'.$this->id.'/'.$this->action->id;
        $data_session = [
            'action'=>$action,
            'for_user_uid'=>$user_uid,
            'status_answer' => $this->queryProcessorTimeout,
            'min_price' => $min_price,
            'currency' => $currency,
            'grey_refuse' => $greyRefuse,
        ];
        $data = array_merge( $data_session,$data_mess);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
    }

//      запись лога
    public function writeLog($address,$source,$value){
        date_default_timezone_set(Yii::$app->params['time_zone']);
        file_put_contents($address,"\n", FILE_APPEND | LOCK_EX);
        file_put_contents($address,print_r("[".date('Y-m-d H:m:s')."] ".$source."\n",true), FILE_APPEND | LOCK_EX);
        file_put_contents($address,print_r($value,true), FILE_APPEND | LOCK_EX);
        file_put_contents($address,"\n", FILE_APPEND | LOCK_EX);
    }

//      валидация токена
    public function checkUid($uid){
//        return 1;
        $uid_tab= [];
        if($uid!=null ) {
            $uid_tab = Users::find()->where(['uid' => $uid])->one()['uid'];
            if (!empty($uid_tab)) {
                return 1;
            } else {return 0;}
        } else {return 0; }
    }

//      определение расстояния от клиента до водителя google
    public function getDistanseToLotGoo($drlat, $drlng,$ordlat ,$ordlng){
        $routeParam = $this->getRouteParam($drlat, $drlng,$ordlat ,$ordlng);
//        $this->writeLog("./logs/test2.log","test",$routeParam);
        $distance = json_decode($routeParam)->routes['0']->legs['0']->distance->value;
        return $distance;
    }

//      определение время поездки от клиента до водителя google
    public function getDurationToLotGoo($drlat, $drlng,$ordlat ,$ordlng){
        $routeParam = $this->getRouteParam($drlat, $drlng,$ordlat ,$ordlng);
//        $this->writeLog("./logs/test2.log","test",$routeParam);
        $distance = json_decode($routeParam)->routes['0']->legs['0']->distance->value;
        return $distance;
    }


//      определение расстояния от клиента досквоттера
    protected function getDistanseToLot($φA, $λA, $φB, $λB){

        /*
        * Расстояние между двумя точками
        * $φA, $λA - широта, долгота 1-й точки,
        * $φB, $λB - широта, долгота 2-й точки
        */

        // перевести координаты в радианы
        $lat1 = $φA * M_PI / 180;
        $lat2 = $φB * M_PI / 180;
        $long1 = $λA * M_PI / 180;
        $long2 = $λB * M_PI / 180;

        // косинусы и синусы широт и разницы долгот
        $cl1 = cos($lat1);
        $cl2 = cos($lat2);
        $sl1 = sin($lat1);
        $sl2 = sin($lat2);
        $delta = $long2 - $long1;
        $cdelta = cos($delta);
        $sdelta = sin($delta);

        // вычисления длины большого круга
        $y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
        $x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;

        $ad = atan2($y, $x);
        $dist = $ad * Yii::$app->params['EARTH_RADIUS'];

        return round($dist);

    }

//      получение маршрута
    public function getRouteParam($source){
        $slat = $source['slat'];
        $slng = $source['slng'];
        $dlat = $source['dlat'];
        $dlng = $source['dlng'];
        $curl = new curl\Curl();
        $response = $curl->get('https://maps.googleapis.com/maps/api/directions/json?origin='.$slat.','.$slng.'&destination='.$dlat.','.$dlng.'&key=AIzaSyAE5DZyaNRTooAB6QIwj8taz9D2i81Tc3g');
        return $response;
    }

//      обратное геокодирование
    public function getGeocod($lat,$lng){
        $curl = new curl\Curl();
        $response = $curl->get('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&key='.Yii::$app->params['google_key']);
        return $response;
    }

//      запрос к внешнему API
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

}