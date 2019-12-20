<?php


namespace app\commands;
use Yii;
use yii\console\Controller;

class AppConsoleController extends Controller{

    //      запись лога
    public function writeLog($address,$source,$value){
//        date_default_timezone_set(Yii::$app->params['time_zone']);
//        file_put_contents($address,"\n", FILE_APPEND | LOCK_EX);
//        file_put_contents($address,print_r("[".date('Y-m-d H:m:s')."] ".$source."\n",true), FILE_APPEND | LOCK_EX);
        file_put_contents($address,print_r($value,true), FILE_APPEND | LOCK_EX);
        file_put_contents($address,"\n", FILE_APPEND | LOCK_EX);
    }
}