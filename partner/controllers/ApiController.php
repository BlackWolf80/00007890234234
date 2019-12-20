<?php


namespace app\controllers;


use app\models\Gadgets;
use app\models\Parkings;
use app\models\Users;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use linslin\yii2\curl;

class ApiController extends Controller{

    public function beforeAction($action)
    {
        if ($action->id == 'add-gadget' || $action->id == 'query-processor'  || $action->id == 'get-pictures' ) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    private function excess($files){
        $result = array();
        for ($i = 0; $i < count($files); $i++) {
            if ($files[$i] != "." && $files[$i] != "..") $result[] = $files[$i];
        }
        return $result;
    }

//    получить список картинок
    public function actionGetPictures(){
        $files = [];

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $dir = Yii::getAlias('@webroot').'/images/upload/'.$post['uid'];
            $files = scandir($dir);
            $files = $this->excess($files);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $files;
    }

    public function actionAddGadget(){
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            $this->writeLog("./logs/api_debug.log","post",$post);

            $gadget = Gadgets::find()->where(['token' => $post['token']])->one();
            $gadget->parking = $post['parking'];
            $gadget->date = (string)time();

            if($gadget->save()){

                $gd = Gadgets::find($gadget->id)->asArray()->with('park')->one();
                $this->writeLog("./logs/api_debug.log","answer",$gd);
                return $this->jsonAnswer('all', $gd);

            }else{
                $this->writeLog("./logs/api_debug.log","answer",['saved'=> 'error']);
                return $this->jsonAnswer('all',['saved'=> 'error']);
            }
        }
        return 'is work';

    }

    public function actionQueryProcessor(){
        if (Yii::$app->request->post()) {

            $post = Json::decode(Yii::$app->request->post()['body']);
            $this->writeLog("./logs/api_debug.log","post",$post);
            if($this->checkToken($post['token'])){
                $answerQuery = [];

                foreach ($post as $item=>$value){

                    //выставить открытые парковки
                    if($item == 'set-parking-quantity'){
                        $result = $this->setParkingQuantity($post['token'],$value);
                        $answerQuery['set-parking-quantity']=$result;
                    }

                    //получить размер парковки
                    if($item == 'get-size'){
                        $result = $this->getSize($post['token']);
                        $answerQuery['get-size']=$result;
                    }

                    //проверка пинкода
                    if($item == 'pin'){
                        $result = $this->pin($post['token'],$value);
                        $answerQuery['pin']=$result;
                    }

                }
                $this->writeLog("./logs/api_debug.log","answer",$answerQuery);
                return $this->jsonAnswer($post['token'],$answerQuery);

            }else{
                $this->writeLog("./logs/api_debug.log","answer",['access' => 'deny']);
                return $this->jsonAnswer('all',['access' => 'deny']);
            }


        }
    }


//    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//      ответ приложению
    public function jsonAnswer($token, $data_mess){

        $action = '/'.$this->module->id.'/'.$this->id.'/'.$this->action->id;
        $data_session = [
            'action'=>$action,
            'for_gadget'=>$token,
        ];
        $data_mess = ArrayHelper::toArray($data_mess);
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

//      создаем пустой гаджет
    public function createGadget(){
        $gadgetEmpty = [];
        $gadgetEmpty = Gadgets::find()->where(['parking'=> 0])->one();

        if(!empty($gadgetEmpty)){
            return $gadgetEmpty->token;
        }

        $token = self::tokenGenerator();
        $gadget = new Gadgets();
        $gadget->token = $token;
        $gadget->save();
        file_put_contents('./test.log',print_r($gadget,true), FILE_APPEND | LOCK_EX);
        return $gadget->token;
    }

//    генерируем уникальный токен
    private function tokenGenerator(){
        $gadgetExist = [];
        $token  = rand(000000, 999999);
        $gadgetExist = Gadgets::find()->where(['token'=>$token])->one();
        if(!empty($gadgetExist)){
          return  $this->tokenGenerator();
        }else{
            return $token;
        }
    }

//    проверка токена
    private function checkToken($token){
        $gadget = [];
        $gadget = Gadgets::find()->where(['token'=>$token])->asArray()->one();
        if(!isset($token)|| empty($token)){

        }elseif(isset($gadget)|| !empty($gadget)){
            return true;
        }else{
            return false;
        }
    }

//    установка активных парковочных мест
    private function setParkingQuantity($token,$source){
        $gd = Gadgets::find()->where(['token'=>$token])->with('park')->one();

        $parking = $gd->park;

        $parking->busy = $source['busy'];
        $parking->save();

        if($parking->save()){
            return ['param'=>'set'];
        }else{
            return ['saved'=> 'error'];
        }


    }

//    количество мест на парковке
    private function getSize($token){
        $gd = Gadgets::find()->where(['token'=>$token])->with('park')->one();
        return [
            'size' => $gd->park->size,
            'busy' => $gd->park->busy,
        ];
    }

//    ввод пинкода
    private function pin($token,$source){
        $parking = Gadgets::find()->where(['token'=>$token])->with('park')->one()->park;
        return $this->checkPin($parking,$source);
    }


    public function checkPin($parking,$source){
        $curl = new curl\Curl();
        $body = Json::encode(['uid' => $parking->uid_squatter,'get-lots-park' => []]);

        $response = $curl->setPostParams(['body' => $body,])->post(Yii::$app->params['api_url'].'/query-processor');

        $lots = Json::decode($response)['get-lots-park']['lots'];
        if(empty($lots)) return ['secret_key' => 'wrong'];

//        $this->writeLog("./logs/test.html","post",$response );die;
        foreach ($lots as $lot){
            if(isset($lot['order'])){
                if($lot['order']['secret_key'] == $source['secret_key'] ){
                    $body = Json::encode([
                        'uid' => $parking->uid_squatter,
                        'check-pin' => [
                            'uid_order' => $lot['order']['uid'],
                            'pin' => $source['secret_key'],
                        ],
                    ]);
                    $response = $curl->setPostParams(['body' => $body,])->post(Yii::$app->params['api_url'].'/query-processor');
                    $response = Json::decode($response)['check-pin'];

//                    $parking->hold--;
//                    $parking->save();

                    return $response;
                }
            }

        }
        return ['secret_key' => 'wrong'];
    }


}