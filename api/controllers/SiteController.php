<?php

namespace app\controllers;

use app\models\Bids;
use app\models\CarsLots;
use app\models\HotZone;
use app\models\Lots;
use app\models\Messages;
use app\models\Orders;
use app\models\Payments;
use app\models\PaymentZone;
use app\models\PayYandex;
use app\models\Ratings;
use app\models\Users;
use app\models\UploadForm;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use linslin\yii2\curl;



class SiteController extends AppController {

    public function actionIndex(){


        echo time()."<br>";
        echo time() + 30 * 24 * 60 * 60 * 6 ." + 6 мес";
        echo "<br>";
        echo time() - 8 * 60 * 60 ." - 8 часов";
        echo "<br>";
        echo time() - 24 * 60 * 60 ." - 24 часа";
        echo "<br>";
        $a = time();
        $b = time() - 24 * 60 * 60;
        echo  $a - $b ;
        echo "<br>";
        return 'Parking Squatter';
    }


    public function actionMap(){

        $model = new HotZone();

        if ($model->load(Yii::$app->request->post()) ) {
            $post =  Yii::$app->request->post()['HotZone'];

            $old = HotZone::find()->where(['w_day' => $post['w_day']])->
            andWhere(['act_time' => $model->act_time])->
            andWhere(['like','lat',45.03734])->
            andWhere(['like','lng',$post['lng']])->
            one();

            if(!empty($old)){
                $old->active = $post['active'];
                $old->save();
            }else{
                $model->save();
            }

//            return $this->redirect(['map']);
        }

        return $this->render('map',compact('model'));
    }

    public function actionTred(){

//        return \Yii::$app->params['yandex_return_url'].'?id=12';
//        return $this->redirect('map');
    }

    public function actionPaySuccess(){
        $payment = Payments::find()->where(['uid_order'=>$_GET['uid_order']])->one();

        $payment->status ='hold';
        if($payment->save()){
            return true;
        }else{
            return 'error';
        }

    }

//      регистрация нового пользователя
    public function actionReg(){
        $post = Yii::$app->request->post();
        $this->writeLog("./logs/api_debug.log","post",$post);
        $geocod = null;

        $lastUser = Users::find()->orderBy(['id' => SORT_DESC])->one();
        if(empty($lastUser)){
            $cod  = 0;
        }else{
            $cod = $lastUser->promo;
        }

        if(!empty($post['lat']) && !empty($post['lng'])){
            $geocod = ArrayHelper::toArray(Json::decode($this->getGeocod($post['lat'],$post['lng'])));

        }

            $user =  new Users();
            $user->name = isset($post['name'])? $post['name'] : 'User';
            $user->phone = isset($post['phone'])? $post['phone'] : '0';
            $user->email = isset($post['email'])? $post['email'] : '0';
            $user->promo = $cod != 0 ? $cod += 5:$cod = 1000;
            $user->lat = isset($post['lat'])? $post['lat'] : '0';
            $user->lng = isset($post['lng'])? $post['lng'] : '0';
            $user->region = $geocod['plus_code']['compound_code'];
            $user->car_model = isset($post['car_model'])? $post['car_model'] : '0';
            $user->car_color = isset($post['car_color'])? $post['car_color'] : '0';

            //проверяем вхождение в платежную зону
            $zones = PaymentZone::find()->asArray()->all();
            $user->zone_id = 0;
            foreach ($zones as $zone){
                if( ($post['lng']-$zone['s_lng'])*($post['lng']-$zone['e_lng']) <= 0 && ($post['lat']-$zone['s_lat'])*($post['lat']-$zone['e_lat'])){
                    $user->zone_id = $zone['id'];
                }
            }
            $user->save();

            if(isset($user->id) && !empty($user->id)){
                $user = Users::find()->where(['id'=>$user->id])->asArray()->one();
                $this->writeLog("./logs/api_debug.log","answer",$user);
                return $this->jsonAnswer('all',$user);

            }else{
                return $this->jsonAnswer('all', ['registration' => 'error']);
            }

    }

//      обрабочик запросов
    public function actionQueryProcessor(){

        if (Yii::$app->request->post()) {

            $post = Json::decode(Yii::$app->request->post()['body']);

            $this->writeLog("./logs/api_debug.log","post",$post);

            //валидация доступа
            if( !isset($post['uid']) || empty($post['uid'])) {
                $this->writeLog("./logs/api_debug.log","answer",['access' => 'deny']);
                return $this->jsonAnswer('all',['access' => 'deny']);
            }


            if($this->checkUid($post['uid']) == 1) {
                //массив ответа
                $answerQuery = [];

                foreach ($post as $item=>$value){
                    //новые заказы
                    if($item == 'get-new-orders'){
                        $result = $this->getNewOrders($post['uid'],$value);
                        $answerQuery['get-new-orders']=$result;
                    }

                    //поиск ближайших лотов
                    if($item == 'find'){
                        $result = $this->find($value);
                        $answerQuery['find']=$result;
                    }

                    //публикуем лот
                    if($item == 'publish'){
                        $publish = $this->publish($post['uid'],$post['lat'],$post['lng'],$value);
                        $answerQuery['publish']=$publish;
                    }

                    //публикуем лот для парковки
                    if($item == 'publish-p'){
                        $publish = $this->publishP($post['uid'],$value);
                        $answerQuery['publish-p']=$publish;
                    }

                    //делаем заказ
                    if($item == 'order'){
                        $order = $this->order($post['uid'],$value);
                        $answerQuery['order']=$order;
                    }

                    //одобряем заказ
                    if($item == 'accept'){
                        $accept = $this->accept($post['uid'],$value);
                        $answerQuery['accept']=$accept;
                    }

                    //проверяем статус заказа
                    if($item == 'order-status'){
                        $order = $this->orderStatus($value);
                        $answerQuery['order-status']=$order;
                    }

                    //проверяем пинкод
                    if($item == 'check-pin'){
                        $pinResult = $this->pin($value);
                        $answerQuery['check-pin']=$pinResult;
                    }

                    //отменяем заказ
                    if($item == 'order-cancel'){
                        $result = $this->oderCancel($post['uid'],$value);
                        $answerQuery['order-cancel']=$result;
                    }

                    //отменяем лот
                    if($item == 'lot-cancel'){
                        $result = $this->lotCancel($value);
                        $answerQuery['lot-cancel']=$result;
                    }

                    //оплата
                    if($item == 'payment'){
                        $result = $this->payment($value);
                        $answerQuery['payment']=$result;
                    }

                    //сообщение для торга
                    if($item == 'message'){
                        $result = $this->message($post['uid'],$value);
                        $answerQuery['message']=$result;
                    }

                    //запрос финальной цены
                    if($item == 'final-price'){
                        $result = $this->finalPrice($value);
                        $answerQuery['final-price']=$result;
                    }

                    //подача заявки
                    if($item == 'apply'){
                        $result = $this->apply($post['uid'],$value);
                        $answerQuery['apply']=$result;
                    }

                    //список заявок
                    if($item == 'bid-list'){
                        $result = $this->bidsList();
                        $answerQuery['bid-list']=$result;
                    }

                    //статус заявки
                    if($item == 'status-bid'){
                        $result = $this->statusBid($value['uid_bid']);
                        $answerQuery['status-bid']=$result;
                    }

                    //принять заявку
                    if($item == 'bid-accept'){
                        $result = $this->bidAccept($post['uid'],$value);
                        $answerQuery['bid-accept']=$result;
                    }

                    //статус заявки
                    if($item == 'cancel-bid'){
                        $result = $this->cancelBid($value);
                        $answerQuery['cancel-bid']=$result;
                    }

                    //получить маршрут
                    if($item == 'get-route'){
                        $result = $this->getRouteParam($value);
                        $answerQuery['get-route']=$result;
                    }

                    //сменить аватар
                    if($item == 'set-avatar'){
                        $result = $this->setAvatar($post['uid'],$value);
                        $answerQuery['set-avatar']=$result;
                    }

                    //получить информацию о лоте
                    if($item == 'get-lot'){
                        $result = $this->getLot($value);
                        $answerQuery['get-lot']=$result;
                    }

                    //отрисовка положения пользователей на статичной карте
                    if($item == 'get-static-map'){
                        $result = $this->getStaticMap($value);
                        $answerQuery['get-static-map']=$result;
                    }

                    //применение промокода
                    if($item == 'set-promo'){
                        $result = $this->setPromo($post['uid'],$value);
                        $answerQuery['set-promo']=$result;
                    }

                    //поиск лута
                    if($item == 'find-loot'){
                        $result = $this->findLoot($post['uid']);
                        $answerQuery['find-loot']=$result;
                    }

                    //отказ от серых лотов на полгода
                    if($item == 'refuse-grey-lots'){
                        $result = $this->refuseGreyLots($post['uid']);
                        $answerQuery['refuse-grey-lots']=$result;
                    }

                    //изменить цену заказа
                    if($item == 'set-price-order'){
                        $result = $this->setPriceOder($value);
                        $answerQuery['set-price-order']=$result;
                    }

                    //изменить никнейм
                    if($item == 'set-nikname'){
                        $result = $this->setNikname($post['uid'],$value);
                        $answerQuery['set-nikname']=$result;
                    }

                    //лоты для парковок
                    if($item == 'get-lots-park'){
                        $result = $this->getLotsPark($post['uid']);
                        $answerQuery['get-lots-park']=$result;
                    }

                    //получить картинки парковки
                    if($item == 'get-pictures'){
                        $result = $this->getPicture($value);
                        $answerQuery['get-pictures']=$result;
                    }
                }

                $this->writeLog("./logs/api_debug.log","answer",$answerQuery);
                return $this->jsonAnswer($post['uid'],$answerQuery);
            }else {
                $this->writeLog("./logs/api_debug.log","answer",['access' => 'deny']);
                return $this->jsonAnswer($post['uid'],['access' => 'deny']);
            }

        }
    }


/////////////lots//////////////////////////////////////////
    //поиск ближайших лотов
    private function find($source){
        $answer = [];
        $lots = Lots::find()->where(['close'=>'0'])->with('squatter')->asArray()->all();
        foreach ($lots as $lot){
            $distance = $this->getDistanseToLot($source['lat'], $source['lng'],$lot['lat'],$lot['lng']);
//            $this->writeLog("./logs/qwe.log","answer",$distance);die;

            if($distance <= 10*1000){
                $answer[] = $lot;
            }
        }
        return $answer;
    }

    //публикуем лот парковки
    private function publishP($uid,$source){

        $lot = new Lots();
        $lot->uid_squatter = Users::find()->where(['uid' => $uid])->one()['uid'];
        $lot->lat = $source['lat'];
        $lot->lng = $source['lng'];
        $lot->address = $source['address'];
        $lot->price = $source['price'];
        $lot->uid_bid = isset($source['uid_bid'])? (string)$source['uid_bid']: (string)0;
        $lot->currency = $source['currency'];
        $lot->created = time();
        $lot->update = time();
        $lot->grey = isset($source['grey'])? $source['grey'] : 2;
        $lot->type_payment =  isset($source['type_payment'])? $source['type_payment'] : 0;

        $lot->save();

        $lot = Lots::findOne($lot->id);

        if(isset($source['model']) && !empty($source['model'])){
            $car = new CarsLots();
            $car->uid_lot = $lot->uid;
            $car->model = $source['model'];
            $car->number = $source['number'];
            $car->color = $source['color'];
            $car->save();
        }

        if(isset($lot->id)){
            return  Lots::find()->where(['id'=>$lot->id])->with('car')->asArray()->one();
        }else{
            return ['status' => 'error'];
        }
    }

    //публикуем лот
    private function publish($uid,$slat,$slng,$source){
        //ищем лоты открытые по заявке
        $lotBid = Lots::find()->where(['uid_squatter'=> $uid])->andWhere(['order_close'=> '0'])->andWhere(['<>','uid_bid',0])->with('bid')->one();

        if(!empty($lotBid)){
            return ['bid_ready'=>$lotBid->uid];
        }

        $distance = $this->getDistanseToLot($source['lat'], $source['lng'],$slat,$slng);


        if($distance > 1000){
            return ['distance'=>'excess'];
        }

        $lot = new Lots();
        $lot->uid_squatter = Users::find()->where(['uid' => $uid])->one()['uid'];
        $lot->lat = $source['lat'];
        $lot->lng = $source['lng'];
        $lot->address = $source['address'];
        $lot->price = $source['price'];
        $lot->uid_bid = isset($source['uid_bid'])? (string)$source['uid_bid']: (string)0;
        $lot->currency = $source['currency'];
        $lot->created = time();
        $lot->update = time();
        $lot->grey = isset($source['grey'])? $source['grey'] : 2;
        $lot->type_payment =  isset($source['type_payment'])? $source['type_payment'] : 0;

        $lot->save();

        $lot = Lots::findOne($lot->id);

        if(isset($source['model']) && !empty($source['model'])){
            $car = new CarsLots();
            $car->uid_lot = $lot->uid;
            $car->model = $source['model'];
            $car->number = $source['number'];
            $car->color = $source['color'];
            $car->save();
        }

        if(isset($lot->id)){
        return  Lots::find()->where(['id'=>$lot->id])->with('car')->asArray()->one();
        }else{
            return ['status' => 'error'];
        }
    }

    //получение информации о лоте
    private function getLot($source){
        return Lots::find()->where(['uid'=>$source['uid_lot']])->with('car','squatter')->asArray()->one();
    }

    //отменяем лот
    private function lotCancel($source){
        $lot = Lots::find()->where(['uid'=>$source['uid_lot']])->one();

        if(empty($lot)){
            return ['lot'=>'notExist'];
        }

        $order = Orders::find()->where(['uid_lot'=>$source['uid_lot']])->with('payment')->one();


        if(!empty($order) && $order['close'] == 0){
            $order->close = 2;
            $answer = PayYandex::cancelPayment($order->payment->payment_id);
            $order->payment->status = $answer->status;
            $order->payment->save();

            $order->save();
            //рейтинг для сквоттера
            $this->ratings($order->uid_squatter, 0, 0, 0, 0, 0,1);
            //рейтинг дл клиента
            $this->ratings($order->uid_client, 0, 0,1);
        }

        $lot->update = time();
        $lot->close = 2;
        $lot->save();

        $this->dropCar($source['uid_lot']);

        $ans = $lot->close != 0 ? ['lot'=>'cancel']:['error'=>'cancelation'];
        return $ans;
    }

    //удаление временной инфы о лоте
    private function dropCar($uid_lot){
        $car=[];
        $car = CarsLots::find()->where(['uid_lot'=> $uid_lot])->one();
        if(!empty($car)){
            $car->delete();
        }
    }

    //отказ от серых лотов на полгода
    private function refuseGreyLots($uid){
        $user = Users::find()->where(['uid'=>$uid])->one();
        $user->refuse_half = time() + 30 * 24 * 60 * 60 * 6;
        $user->save();
        $lot = Lots::find()->where(['uid_squatter' => $uid])->andWhere(['order_close' => 0])->andWhere(['grey'=>1])->with('order')->one();
        $lot->order->delete();
        $lot->delete();
        $refuseDate =date('d-m-Y h:I:s',$user->refuse_half);
        return ['refuse_to' =>$refuseDate];
    }

    //изменяем цену лота
    private function setPriceLot($uid_lot, $price){
        $lot = Lots::find()->where(['uid'=>$uid_lot])->one();
        $lot->price = $price;
        $lot->update = time();
        if($lot->save()) return true;
    }

    //получить лоты парковок
    private function getLotsPark($uid){
        $lots = Lots::find()->where(['uid_squatter' => $uid])->andWhere(['order_close' => 0])->andWhere(['grey'=>2])->with('order')->asArray()->all();

        $this->writeLog("./logs/test.log","answer",$lots);
        return ['lots' => $lots];
    }

/////////////lots//////////////////////////////////////////
/////////////orders////////////////////////////////////////

    //новые заказы
    private function getNewOrders($uid,$source){
        $order = [];
        $lot =[];

        /*
        $squatter = Users::find()->where(['uid'=> $uid])->one();
        if($squatter->refuse == 1){
            //если есть полный отказ от серых лотов
            $lot = Lots::find()->where(['uid_squatter' => $uid])->andWhere(['order_close' => 0])->andWhere(['grey'=>1])->with('order')->one();
            $lot->order->delete();
            $lot->delete();
            return [];
        }
        */
        $order = Orders::find()->where(['uid_lot'=> $source['uid_lot']])->andWhere(['close'=>0])->with('lot')->asArray()->one();

        if(!empty($order)){
            return  $order;
        }else{
            $lot = Lots::find()->where(['uid'=> $source['uid_lot']])->asArray()->one();
            if(!empty($lot)){
                return ['lot' => $lot];
            }else{
                return ['lot_exist' => 'no'];
            }
        }
    }

    //делаем заказ
    private function order($uid,$source){
        //проверяем существование заказа
        $existOrder = Orders::find()->where(['uid_lot'=>$source['uid_lot']])->andWhere(['close'=>'0'])->one();

        if(isset($existOrder)){
            return ['order' => 'exist'];
        }

        //форуем заказ
        $lot = Lots::find()->where(['uid' => $source['uid_lot']])->one();
//        $this->writeLog("./logs/test.log","answer",$lot);die;
        $order = new Orders();
        $order->uid_client = Users::find()->where(['uid' => $uid])->one()['uid'];
        $order->uid_squatter = $lot->uid_squatter;
        $order->uid_lot = $lot->uid;
        $order->secret_key = rand(1111,9999);
        $order->created = time();
        $order->update = time();
        $order->price = isset($source['price'])? $source['price']: 0;

        if( $order->lot->uid_bid != (string)'0' || $order->lot->grey == 2){
            $order->seller_agrees = 1;
            $order->buyer_agrees = 1;

        }
//        $this->writeLog("./logs/test.log","answer",$order);
        $order->save();

        if(isset($order->id)){
            //закрываем лот
            $lot->close = 1;
            $lot->update = time();
            $lot->save();

            $orderAns = Orders::findOne($order->id);
            return ArrayHelper::toArray($orderAns);
        }else{
            return ['status' => 'error'];
        }

    }

    //одобряем заказ
    private function accept($uid,$source){
        $order = Orders::find()->where(['uid' => $source['uid_order']])->with('lot')->one();
        $answer = '';

        if($order->uid_squatter == $uid){
            $order->seller_agrees = 1;
            $answer = ['timeout' => 10];
        }else{
            $order->buyer_agrees = 1;
            $answer =  ['timeout' => 10, 'pin' => $order->secret_key];
        }

        $order->update = time();

        if($order->save()){
            //проверяем что все подписали и шлем цену в лот
            if($order->seller_agrees == 1 && $order->buyer_agrees == 1){
                $this->setPriceLot($order->lot,$order->price);
            }
            return $answer;
        }

    }

    //проверяем статус заказа
    private function orderStatus($source){
        $messages = [];
        $order = Orders::find()->where(['uid'=>$source['uid_order']])->one();
        $messages = Messages::find()->where(['uid_order'=>$source['uid_order'] ])->asArray()->all();
        $ans =  [
            'order' => $order->close,
            'buyer_agrees' => $order->buyer_agrees,
            'seller_agrees'=> $order->seller_agrees,
            'price' => $order->price,
            'messages' => $messages,
        ];
        return $ans;
    }

    //проверяем пинкод
    private function pin($source){
        //ищем оплату
        /*
        $payment = [];
        $payment = Payments::find()->where(['uid_order'=> $source['uid_order']])->one();

        //если нет  оплаты
        if(empty($payment)){
            return ['payment' => 'empty'];
        }
        */


        $order = Orders::find()->where(['uid' => $source['uid_order']])->with(['lot'])->one();
        if($order->secret_key == $source['pin']){


                if ($order->type_payment == 1){
                    $payment = Payments::find()->where(['uid_order'=> $order->uid])->one();
                    $answer = PayYandex::debitPart($payment->sum,$payment->payment_id);
                    if($answer['pyment']->status == 'succeeded'){
                    $payment->status = $answer->status;
                    $payment->save();

                    $order->close = 1;
                    $order->update = time();
                    $order->save();

                    $order->lot->update = time();
                    $order->lot->order_close = 1;
                    $order->lot->save();

                    $this->dropCar($order->lot->uid);

                    if($order->close == 1) {
                        //рейтинг для сквоттера
                        $this->ratings($order->uid_squatter, 0, 0, 0, 1, 0);
                        //рейтинг дл клиента
                        $this->ratings($order->uid_client, 1, 0);
                    }
                    return ['order' => 'close'];
                }else{
                        return ['order' => 'error_save'];
                    }
                }else{

                    $order->close = 1;
                    $order->update = time();
                    $order->save();

                    $order->lot->update = time();
                    $order->lot->order_close = 1;
                    $order->lot->save();

                    $this->dropCar($order->lot->uid);

                    if($order->close == 1) {
                        //рейтинг для сквоттера
                        $this->ratings($order->uid_squatter, 0, 0, 0, 1, 0);
                        //рейтинг дл клиента
                        $this->ratings($order->uid_client, 1, 0);
                    }
                    return ['order' => 'close'];
                }
            }




    }

    //изменить цену заказа
    private function setPriceOder($source){
        $order = [];
        $order = Orders::find()->where(['uid'=>$source['uid_order']])->one();
        if(!empty($order)){
            $order->price = $source['price'];
            $order->update = time();
            if($order->save()) return ArrayHelper::toArray($order);
        }else{
            return ['order_exist'=> 'no'];
        }
    }

    //отменяем заказ
    private function oderCancel($uid,$source){

        $order = Orders::find()->where(['uid' => $source['uid_order']])->with('lot','payment')->one();

        if($order->buyer_agrees == 1 && $order->seller_agrees == 1){
            //если договор подписан
            //сквоттер 20-, 21-, 22-
            //клиент 30-, 31-, 32-
            if($source['close']){
                $order->close = $source['close'];
            }else{
                return  ['order'=>'agrees'];
            }
        }

        if($order->uid_client == $uid){
            $order->close = 3;
        }else{
            $order->close = 2;
        }
        $order->update = time();
        $order->save();

        if($order->lot->uid_bid == 0){
            $order->lot->close = 0;
            $order->lot->update = time();
            $order->lot->save();
        }


        if ($order->type_payment == 1){
            $answer = PayYandex::cancelPayment($order->payment->payment_id);

            $order->payment->status = $answer->status;
            $order->payment->save();
        }


        //рейтинг для сквоттера
        $this->ratings($order->uid_squatter, 0, 0, 0, 0, 0,1);
        //рейтинг дл клиента
        $this->ratings($order->uid_client, 0, 0,1);

        $ans =  isset($order->id)? ['order'=>'cancel']:['error'=>'cancelation'];

        return $ans;
    }
/////////////orders////////////////////////////////////////
/////////////bids//////////////////////////////////////////
    //подача заявки
    private function apply($uid,$source){

        $bid =new Bids();

        $bid->uid_user = $uid;
        $bid->lat = $source['lat'];
        $bid->lng = $source['lng'];
        $bid->address = $source['address'];
        $bid->price = $source['price'];
        $bid->bid_date = $source['bid_date'];
        isset($source['paid_parking'])? $bid->paid_parking = $source['paid_parking']: '';
        $bid->save();
        if(isset( $bid->id)){

            $ans = Bids::findOne($bid->id);
            return ArrayHelper::toArray($ans);
        }else{
            return ['saved' => 'error'];
        }
    }

    //список заявок
    private function bidsList(){
        return Bids::find()->where(['status' => 0])->asArray()->all();
    }

    //статус заявки
    private function statusBid($uid_bid){
        $bid = Bids::find()->where(['uid' => $uid_bid])->with('lot')->one();

        if(isset($bid->lot)){
            return ['bid'=>ArrayHelper::toArray($bid), 'order'=> ArrayHelper::toArray($bid->lot->order) ];
        }else{
            return ['bid'=> ArrayHelper::toArray($bid)];
        }

    }

    //принятие заявки
    private function bidAccept($uid,$source){
        //ищем заявки занятые пользователем
        $bidBusy = Bids::find()->where(['uid_user'=>$uid])->with('lot')->all();
        foreach ($bidBusy as $item){

        }

        //меняем статус заявки на занято
        $bid = Bids::find()->where(['uid' => $source['uid_bid']])->one();

        if( $bid->status == 0){
            $bid->status = 1;
            $bid->save();
        }else{
            return ['bid' => 'busy'];
        }

        //создаем лот
        $sourceLot =[
            'lat' => $bid->lat,
            'lng' => $bid->lng,
            'address' => $bid->address,
            'price' => $bid->price,
            'uid_bid' => $bid->uid,
            'grey' =>  0,
            'currency'=>'rub',
            'model' => $source['model'],
            'number' => empty($source['number'])?'':$source['number'],
            'color' => $source['color'],
        ];
        $lot = $this->publishP($uid,$sourceLot);


        //создаем заказ
        $oder = $this->order($uid,['uid_lot' => $lot['uid']]);
//        $this->writeLog("./logs/test.log","test",$oder );die;
        return [
            'bid'=> ArrayHelper::toArray($bid),
            'lot' => $lot,
            'order' => $oder,
        ];
    }

    //отмена заявки
    private function cancelBid($source){
        $bid = Bids::find()->where(['uid' => $source['uid_bid']])->one();
        $bid->status = 3;
        $bid->save();

        return ['bid'=>'cancelled'];
    }
/////////////bids//////////////////////////////////////////

    //оплата
    private function payment($source){
        $payment = new Payments();
        $order = Orders::find()->where(['uid'=>$source['uid_order']])->one();

        //создаем платеж
        $answer = PayYandex::hold($source['sum'],$order->id,$order->uid);
//        $answer = PayYandex::cancelPayment('252fa732-000f-5000-a000-1ff05cd389b9');


        $payment->sum = $source['sum'];
        $payment->uid_order = $source['uid_order'];
        $payment->payment_id = $answer['pyment']->id;
        $payment->status = $answer['pyment']->status;
        $payment->save();

        return ['payment_id'=>$answer['pyment']->id];
    }

    //сообщение для торга
    private function message($uid,$source){
        if($source['message'] == 'ttr'){
            $message= Messages::trrForce();
            return ['message' => $message];
            }
        $message = new Messages();
        $message->uid_order = $source['uid_order'];
        $message->message = $source['message'];
        $message->uid_user = $uid;
        $message->save();

        if(is_numeric($source['message'])){
            $order = Orders::find()->where(['uid'=> $source['uid_order']])->one();
            $order->final_cond = $source['message'];
            $order->save();
        }

        if(isset($message->id)){
            return ['message' => 'saved'];
        }else{
            return ['message' => 'unsaved'];
        }
    }

    //запрос финальной цены
    private function finalPrice($source){
        $order = Orders::find()->where(['uid'=> $source['uid_order']])->one();
        return ['final_price' => $order->final_cond];
    }

    //рейтинги
    private function ratings($uid_user, $client_completed = 0, $client_sum = 0,$client_cancel = 0, $squatter_completed = 0, $squatter_sum = 0,$squatter_cancel = 0){
        $ratingOLd = [];
        $ratingOLd = Ratings::find()->where(['uid_user'=> $uid_user])->one();

        if(empty($ratingOLd)){
            $rating = new Ratings();
            $rating->uid_user =$uid_user;

        }else{
            $rating = &$ratingOLd;
        }

        $rating->client_completed = $rating->client_completed + $client_completed;
        $rating->client_sum = $rating->client_sum + $client_sum;
        $rating->client_cancel = $rating->client_cancel + $client_cancel;

        $rating->squatter_completed = $rating->squatter_completed + $squatter_completed;
        $rating->squatter_sum = $rating->squatter_sum + $squatter_sum;
        $rating->squatter_cancel = $rating->squatter_cancel + $squatter_cancel;

        $rating->save();
        return ArrayHelper::toArray($rating);
    }

    //смена аватара пользователя
    private  function setAvatar($uid,$source){
        $image='';
        $filename = $uid.'.'.explode('/',explode(';',$source['file'])[0])[1];

        if(Yii::$app->request->post()) {

            $tmpDir = './usimage/tmp/';
            $workDir = './usimage/';

            $encodedString = $source['file'];
            // Strip the crud from the front of the string [1]
            $encodedString = substr($encodedString,strpos($encodedString,",")+1);
            // Cleanup File [2]
            $encodedString = str_replace(' ','+',$encodedString);
            // Decode string
            $decoded = base64_decode($encodedString);

            // Save File
            file_put_contents($tmpDir.$filename,$decoded);


            $ext = (pathinfo($tmpDir.$filename, PATHINFO_EXTENSION));

            $new_width = $new_height = 300;

            // тип содержимого
            header('Content-Type: image/jpeg');

            // получение новых размеров
            list($width, $height) = getimagesize($tmpDir.$filename);

            if ($width <= $new_width || $height <= $new_height) {
                $src_x = 0;
            } else {
                $src_x = ($width / 6.4) - $new_width;
//                $this->writeLog("./logs/test.log","post",$width);
//                $src_x = ($width - $new_width);
            }

            if ($width != $height) {
                if ($width > $height) {
                    $width = $height;
                } else {
                    $height = $width;
                }
            }

            if (file_exists($workDir.$filename)) {
                unlink($workDir.$filename);
            }

            // ресэмплирование
            $image_p = imagecreatetruecolor($new_width, $new_height);
            switch ($ext) {
                case 'png':
                    $image = imagecreatefrompng($tmpDir.$filename);
                    break;
                case 'jpg':
                    $image = imagecreatefromjpeg($tmpDir.$filename);
                    break;
                case 'jpeg':
                    $image = imagecreatefromjpeg($tmpDir.$filename);
                    break;
            }

            $img = imagecopyresampled($image_p, $image, 0, 0, $src_x, 0, $new_width, $new_height, $width, $height);

            imagePNG($image_p, $workDir . $uid . '.png');
            imagedestroy($image_p);
            unlink($tmpDir.$filename);

            return ['file' => $uid . '.png'];
        }
    }

    //смена никнейма
    public function setNikname($uid,$source){
        $user = Users::find()->where(['uid'=>$uid])->one();
        $user->name = $source['username'];
        $user->save();
        return ['set-nikname' =>$user->name];
    }

    //отрисовка положения пользователей на статичной карте
    public function getStaticMap($source){
        $src_lat =  $source['sq_lat'];
        $src_lng =  $source['sq_lng'];
        $dst_lat =  $source['cl_lat'];
        $dst_lng =  $source['cl_lng'];

        $curl = new curl\Curl();

        $request = 'https://maps.googleapis.com/maps/api/staticmap?size=600x400&markers=color:blue|label:S|'.$src_lat.','.$src_lng.'&markers=color:red|label:C|'.$dst_lat.','.$dst_lng.'&key='.Yii::$app->params['google_key'];
        $response = $curl->get($request);
        $filename ="./usmap/".$source['uid_order'].".png";
        file_put_contents($filename,$response);
        if (file_exists($filename)) {
            return ['filename' => $filename ];
        } else {
            return ['save_filename' => 'error' ];
        }
    }

    //применение промокода
    public function setPromo($uid,$source){
        $user = Users::find()->where(['promo'=>$source['promo']])->one();
        $userPr = Users::find()->where(['uid'=>$uid])->one();
        if(empty($user)){
            return['promo' => 'not_exist'];
        }else{
            if($user->count_enter_promo >= Yii::$app->params['promo_count']){
                return['promo' => 'ended'];
            }
            $user->count_enter_promo ++;
            $user->save();
            return['promo' => 'success'];
        }
    }

    //поиск лута
    public function findLoot($uid){
        $user = Users::find()->where(['uid'=>$uid])->one();
        return ['loot' => 'not_find'];
    }

    //получить картинки парковки
    private function getPicture($source){
        $curl = new curl\Curl();
        $reqPost =[
            'uid' => $source['uid_squatter'],
        ];
        $response = $curl->setPostParams($reqPost)->post(Yii::$app->params['url_api_pr'].'/api/get-pictures');
        $response= Json::decode($response);
        return $response;
    }

}
