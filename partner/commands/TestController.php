<?php


namespace app\commands;



use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Json;
use linslin\yii2\curl;



class TestController extends AppConsoleController{



    public function actionGetPictures(){
        $curl = new curl\Curl();
        $reqPost =[
            'uid' => '9c6ef6f8-da21-11e9-9f7f-548ca0d98851',
        ];

        $response = $curl->setPostParams($reqPost)->post(Yii::$app->params['test_url'].'/get-pictures');

        $this->writeLog("./web/logs/test.html","test",$response);
    }

    public function actionAdd(){
        $curl = new curl\Curl();
        $reqPost =[

            'token' => '263958',
            'parking' => '1',

        ];


        $response = $curl->setPostParams($reqPost)->post(Yii::$app->params['test_url'].'/add-gadget');

        $this->writeLog("./web/logs/test.html","test",$response);
    }

    public function actionIndex()
    {
        $curl = new curl\Curl();
        $body = Json::encode(
            [
                //squatter
                'token' => '791890',
//                'set-parking-quantity' => ['busy' => 1],
                'pin' => ['secret_key' => 1239],


            ]
        );

        $response = $curl->setPostParams(['body' => $body,])->post(Yii::$app->params['test_url'].'/query-processor');
        $this->writeLog("./web/logs/test.html","test",$response);
    }

}




