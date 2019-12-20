<?php

namespace app\commands;


use app\models\Parkings;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use linslin\yii2\curl;


class ScheduledController extends AppConsoleController
{
    public function actionIndex(){

        if (is_resource(STDIN)) {
            fclose(STDIN);
            $stdIn = fopen('/dev/null', 'r');
        }
        if (is_resource(STDOUT)) {
            fclose(STDOUT);
            $stdOut = fopen('/dev/null', 'ab');
        }
        if (is_resource(STDERR)) {
            fclose(STDERR);
            $stdErr = fopen('/dev/null', 'ab');
        }

        $pid = pcntl_fork();
        if ($pid == -1) {
            $this->halt(self::EXIT_CODE_ERROR, 'pcntl_fork() rise error');
        } elseif ($pid) {
            $this->halt(self::EXIT_CODE_NORMAL);
        } else {
            posix_setsid();
        }

        while (true) {

            $this->addLots();
            echo "takt - [Ok] \n";
            $this->writeLog("./scheduled.log","test","takt1 - [Ok] \n");
            sleep(1*10);
        }
        return ExitCode::OK;
    }

//    добавить лоты на активные парковки
    private function addLots(){
        $parkings = [];
        $parkings = Parkings::find()->where(['status'=>1])->andWhere(['>','price',0])->asArray()->all();
        $wdayNow = date("w",time());
//        file_put_contents('./test_sh.html',print_r($parkings,true), FILE_APPEND | LOCK_EX);
        if(!empty($parkings)){

            foreach ($parkings as $parking){
                $timeZone = $parking['time_zone']/60/60;
                $time = time();
                $localtime = (int)strtotime(date("H:i:s",$time + $timeZone * 3600));
                $stTime = (int)strtotime($parking['start_time']);
                $endTime = (int)strtotime($parking['end_time']);
                $wdParking = \yii\helpers\ArrayHelper::toArray(Json::decode($parking['w_days']));


                if(in_array($wdayNow, $wdParking, true)&&(int)$localtime >= (int)$stTime && (int)$localtime < (int)$endTime){
                    if($parking['busy'] > $parking['hold']){
                            $this->publish($parking['uid_squatter']);
                        }
                }else{
                   $this->cancel($parking);
                }


            }
        }
    }

//  закрыть
    private function cancel($parking){
        $myLots = $this->getLotsPark($parking['uid_squatter'])['get-lots-park']['lots'];
        foreach($myLots as $lot) {
            $this->cancelLot($parking['uid_squatter'], $lot['uid']);

        }
    }

//  получить открытые лоты
    private function getLotsPark($uid){

        $curl = new curl\Curl();
        $body = Json::encode(
            [
                //squatter
                'uid' => $uid,
                'get-lots-park' => [],
            ]
        );
        $response = $curl->setPostParams(['body' => $body,])->post(Yii::$app->params['api_url'].'/query-processor');

        $response = Json::decode($response);
        return $response;
    }

//  создать лот у сквоттера
    private function publish($uid){

        $parking = Parkings::find()->where(['uid_squatter'=>$uid])->one();

        $curl = new curl\Curl();
        $body = Json::encode(
            [
                //squatter
                'uid' => $uid,
                'publish-p' => [
                    'lat' => $parking->lat,
                    'lng' => $parking->lng,
                    'address' => $parking->address,
                    'price' => $parking->price,
                    'grey' => 2,
                    'currency'=>'rub'
                ],
            ]
        );

        $response = $curl->setPostParams(['body' => $body,])->post(Yii::$app->params['api_url'].'/query-processor');
//        file_put_contents('./test_sh.html',print_r( $response,true), FILE_APPEND | LOCK_EX);
        $response = Json::decode($response);

        if(isset($response['publish-p']['id'])){
            $parking->hold += 1;
            $parking->save();
//            file_put_contents('./test_sh.html',print_r( $parking,true), FILE_APPEND | LOCK_EX);die;
        }
    }

//    закрыть лот
    private function cancelLot($uid,$uidLot){
        $parking = Parkings::find()->where(['uid_squatter'=>$uid])->one();
        $curl = new curl\Curl();
        $body = Json::encode(
            [
                'uid' => $uid,
                'lot-cancel' => [
                            'uid_lot' => $uidLot,
                        ],
            ]
        );
        $response = $curl->setPostParams(['body' => $body,])->post(Yii::$app->params['api_url'].'/query-processor');

        $response = Json::decode($response);
        $parking->hold > 0? $parking->hold-- : '';
        $parking->save();

        return $response;
    }

//    очистка каталога с изображениями QR кодов
    public function actionClean(){
        if(exec("rm -rf ./web/upload/qrcode/*")){
            echo "QR codes clear - [Ok] \n";
        }else{
            echo "QR codes clear - [Ok] \n";
        }
    }






}
