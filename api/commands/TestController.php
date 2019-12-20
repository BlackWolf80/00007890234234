<?php


namespace app\commands;

use app\controllers\AppController;
use app\models\PayMaster;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Json;
use linslin\yii2\curl;
use Stripe\Stripe;


class TestController extends AppConsoleController{

    public function actionStripe(){

//        \Stripe\Stripe::setApiKey("sk_test_4QXonCo1M7TXgjzogElwJrAO00ADJSThPA");

//        $ch = \Stripe\Charge::retrieve([
//            'id' => 'ch_1FFbihGxDIeU7c0nbbLr5k9F',
//            'expand' => ['customer'],
//        ]);


//        $output = shell_exec('curl https://api.stripe.com/v1/charges \
//  -u sk_test_4QXonCo1M7TXgjzogElwJrAO00ADJSThPA:');

        $output = shell_exec('curl https://api.stripe.com/v1/charges/ch_1FFgQ4GxDIeU7c0nU7XiPSBG \
  -u sk_test_4QXonCo1M7TXgjzogElwJrAO00ADJSThPA: \
  -d expand[]=customer \
  -G');

        $this->writeLog("./web/logs/test.log","test", $output);

    }

    public function actionReg(){

        $reqPost =[

                    'name' => 'Василий',
                    'phone' => '3453453534',
                    'email' => 'vasya_pupkin@kakoetomilo.ru',
                    'lat' => '45.03192099999999',
                    'lng' => '38.91845039999999',
                    'car_model' => 'крутой бентли',
                    'car_color' => 'фиолетовый в ромашку',


            ];

        $response = AppController::requestApi('post',Yii::$app->params['test_url'].'/reg',$reqPost);

        $this->writeLog("./web/logs/test.html","test",$response);
    }

    public function actionIndex()
    {
        $curl = new curl\Curl();
        $body = Json::encode(
            [
                //squatter
                'uid' => '380732dd-f734-11e9-9ce5-ec5c684afa5d',
                'lat' => 45.0319317353941,
                'lng' => 38.918379592376844,
//                'uid' => 'd46bf13c-e105-11e9-896e-5a49f30468da',
                'get-pictures' => [
                            'uid_squatter' => '195062c5-df8b-11e9-896e-5a49f30468da',
                        ],
                //client
//                        'uid' => '7359e2c1-bd2f-11e9-b852-548ca0d98851',

//                'message' => [
//                    //killer
//                    'message' => 'ttr',
//                ],

//                        'ratings' => [],
//                'get-lots-park' => [],
//                        'get-new-orders' => ['uid_lot'=>'5dfaaece-c9a9-11e9-b31f-548ca0d98851'],
//
//                        'find' => [
//                            'lat' => 45.035470,
//                            'lng' => 38.975313,
//                            'zoom' => 13,
//                        ],
//                        'set-nikname' => [
//                            'username' => 'Вася1',
//                        ],

//                        'publish' => [
//                            'lat' => 45.03096965462,
//                            'lng' => 38.914975696744,
//                            'address' => 'хуй его знает',
//                            'price' => 200,
//                            'grey' => 1,
//                            'currency'=>'rub'
//                        ],

//                    'publish' => [
//                        'lat' => 45.031582,
//                        'lng' => 39.044063,
//                        'address' => 'Карасунский округ, Краснодар, Краснодарский край, 350075',
//                        'price' => 100,
//                        'uid_bid'=> 0,
//                        'grey' => 1,
//                        'currency'=>'rub'
//                    ],

//                'publish' => [
//                    'uid_bid'=> 0,
//                    'lat' => 45.031974353654,
//                    'lng' => 38.917298801243,
//                    'address' => 'Prospekt Chekistov, 36, Krasnodar',
//                    'number' => '',
//                    'color' => 'Orange',
//                    'model'=> 'Daewoo',
//                    'price' => 150,
//                    'currency'=>'₽',
//                    'grey' => 0,
//                    'type_payment' => 2
//
//                ],
//                    'get-lot' => ['uid_lot'=>'48965120-d0b6-11e9-ab7b-548ca0d98851'],

//                        'order' => [
//                            'uid_lot' => 'b7297582-daaf-11e9-9f7f-548ca0d98851',
//                            'price' => '300',
//                             'type_paymnet' ='1'
//                        ],

//                        'accept' => [
//                            'uid_order' => '5d46f1f3-ca4d-11e9-b499-548ca0d98851',
//                        ],

//                        'order-status' => [
//                            'uid_order' => 'bedef64c-bda0-11e9-b852-548ca0d98851',
//                        ],
//                        'check-pin' => [
//                            //client
//                            'uid_order' => 'e732e9bb-eb68-11e9-bb79-5a49f30468da',
//                            'pin' => '1795',
//                        ],

//                        'order-cancel' => [
//                            'uid_order' => '8cc8e7a0-eb3a-11e9-bb79-5a49f30468da',
//                            'close'=> 30,
//                        ],

//                        'lot-cancel' => [
//                            'uid_lot' => '7a57ce75-bd32-11e9-b852-548ca0d98851',
////                        ],
//                        'payment' => [
//                        'sum' => 100,
//                        'uid_order' => '9146f37f-ea86-11e9-bb79-5a49f30468da',
//                        ],

//                'payment' => [
//                    'uid_order' => '9b284e00-dbbd-11e9-896e-5a49f30468da',
//                    'card_number' => '',
//                    'card_date' => '',
//                    'card_holder' => '',
//                    'card_cvv' => '',
//                    'sum' => 80.0,
//
//
//                ],
//                        'message' => [
//                            'uid_order' => 'bedef64c-bda0-11e9-b852-548ca0d98851',
//                            'message' => '400',
//                        ],
//                        'final-price' => [
//                            'uid_order' => 'bedef64c-bda0-11e9-b852-548ca0d98851',
//                        ],
//                        'apply' => [
//                            'lat' => '45.029625',
//                            'lng' => '39.037891',
//                            'address' => 'ул. Волжская, 58, Краснодар, Краснодарский край, 350059',
//                            'price' => '100.0',
//                            'paid_parking' => 0,
//                            'bid_date' => '2019-09-13 17:00:00',
//                        ],
//                        'bid-list' => [],
//                         'status-bid' => ['uid_bid' =>'53d47840-c026-11e9-82cd-548ca0d98851'],
//                         'cancel-bid' => ['uid_bid' =>'53d47840-c026-11e9-82cd-548ca0d98851'],
//                        'bid-accept' => [
//                            'uid_bid' => '5e2f7242-f96f-11e9-bb79-5a49f30468da',
//                            'number' => '',
//                            'color' => 'Black',
//                            'model' => 'Bentley'
//                        ],
//
//                        'set-promo' => [
//                            'promo' => '11117',
//                        ],
//                        'refuse-grey-lots' => [],
//                        'set-price-order' => ['uid_order'=>'5d46f1f3-ca4d-11e9-b499-548ca0d98851','price'=> 400],
//                        'set-avatar' => ['file'=> 'data:image/jpeg;base64,/9j/4QLmRXhpZgAATU0AKgAAAAgACgEPAAIAAAAETEdFAAEQAAIAAAAIAAAAhgEaAAUAAAABAAAAjgEbAAUAAAABAAAAlgEoAAMAAAABAAIAAAExAAIAAAA5AAAAngEyAAIAAAAUAAAA2AITAAMAAAABAAEAAIdpAAQAAAABAAAA7IglAAQA'],


            ]
        );

        $response = $curl->setPostParams(['body' => $body,])->post(Yii::$app->params['test_url'].'/query-processor');
        $this->writeLog("./web/logs/test.html","test",$response);
    }

    public function actionPay(){
        $response =PayMaster::hold(34578787232,200);
        $response =PayMaster::pay(34578787232,200);
        $response =PayMaster::payReturn(34578787232,200);
        $this->writeLog("./web/logs/test.html","test",$response);
    }


}




