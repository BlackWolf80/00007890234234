<?php


namespace app\models;

use app\controllers\AppController;
use yii\base\Model;
use YandexCheckout\Client;


class PayYandex extends Model{
/////////////////////////////////////////////////////////////////////////////////////////
//  двухэтапный платеж///////////////////////////////////////////////////////////////////
    public function hold($sum,$order_id,$uid_order){
        $client = new Client();
        $client->setAuth(\Yii::$app->params['yandex_shop_id'], \Yii::$app->params['yandex_shop_secret_key']);
        $payment = $client->createPayment(
            [
                'amount' => array(
                    'value' => $sum,
                    'currency' => 'RUB',
                ),
                'confirmation' => array(
                    'type' => 'redirect',
                    'return_url' => \Yii::$app->params['yandex_return_url'].'?uid_order='.$uid_order,
                ),
                'capture' => false,
                'description' => 'Заказ №'.$order_id,
                'metadata' => array(
                    'order_id' => $order_id,
                )
            ],
            uniqid('', true)
        );

        return [
            'client'=> $client,
            'pyment' => $payment
            ];
    }

//  полное списание
    public function debitAll($notification){
        $client = new Client();
        $client->setAuth(\Yii::$app->params['yandex_shop_id'], \Yii::$app->params['yandex_shop_secret_key']);
        $payment = $notification->getObject();
        $client->capturePayment(['amount' => $payment->amount],$payment->id,uniqid('', true));
        return $client;
    }

//    частичное списание
    public function debitPart($sum,$paymentId){
        $client = new Client();
        $client->setAuth(\Yii::$app->params['yandex_shop_id'], \Yii::$app->params['yandex_shop_secret_key']);
//        $paymentId = '215d8da0-000f-50be-b000-0003308c89be';
        $idempotenceKey = uniqid('', true);
        $response = $client->capturePayment(
            [
                'amount' => [
                    'value' => $sum,
                    'currency' => 'RUB',
                ],
            ],
            $paymentId,
            $idempotenceKey
        );
        return $response;
    }

//  отмена оплаты
    public function cancelPayment($paymentId){
        $client = new Client();
        $client->setAuth(\Yii::$app->params['yandex_shop_id'], \Yii::$app->params['yandex_shop_secret_key']);
//        $paymentId = '215d8da0-000f-50be-b000-0003308c89be';
        $idempotenceKey = uniqid('', true);
        $response = $client->cancelPayment($paymentId,$idempotenceKey);
        return $response;
    }

//  двухэтапный платеж///////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
}