<?php

namespace app\controllers;

use app\models\Gadgets;
use app\models\Parkings;
use app\models\RegForm;
use app\models\RestoreForm;
use app\models\UploadForm;
use kartik\mpdf\Pdf;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use linslin\yii2\curl;
use yii\helpers\Json;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','index','parking'],
                'rules' => [
                    [
                        'actions' => ['logout','index','parking'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'parking' || $action->id == 'change-price'|| $action->id == 'pin'|| $action->id == 'reg' || $action->id == 'geo') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $login =isset($_GET['login'])? $_GET['login'] : null;
        $password =isset($_GET['password'])? $_GET['password'] : null;


        $gadgets =[];
        $gadgets = Gadgets::find()->where(['parking'=>Yii::$app->user->id])->asArray()->all();
        $token = ApiController::createGadget();


        return $this->render('index',compact('token','gadgets','login','password'));
    }

    private function excess($files){
            $result = array();
            for ($i = 0; $i < count($files); $i++) {
                if ($files[$i] != "." && $files[$i] != "..") $result[] = $files[$i];
            }
            return $result;
    }

    public function actionGallery(){
        $filename = null;
       $parking = Parkings::findOne((int)Yii::$app->user->identity->getId());
       $dir = Yii::getAlias('@webroot').'/images/upload/'.$parking->uid_squatter;
       $dirView = '/images/upload/'.$parking->uid_squatter.'/';
        if(!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $files = scandir($dir);
        $files = $this->excess($files);


        //удаление файла
        if(isset($_GET['del'])){
            $filename = $dir.'/'.$_GET['del'];
            @unlink($filename);
            return $this->redirect('/gallery');
        }

        //загрузка файла
        $model = new UploadForm();
        if(Yii::$app->request->post()){
            $model->file = UploadedFile::getInstance($model, 'file');

//            echo '<pre>'; print_r($files);die;
            $filename = substr(md5(microtime() . rand(0, 9999)), 0, 20);


            if ($model->validate()) {
                $path = $dir .'/'.$filename.'.';
                $model->file->saveAs($path.$model->file->extension);
                return $this->refresh();
            }
        }


        return $this->render('gallery',compact('dirView','files','model'));
    }

    public function actionLogin()
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())  ) {
            $post = Yii::$app->request->post()['LoginForm'];
//            echo'<pre>'; print_r($post);die;
            $username = preg_replace("/[^,.0-9]/", '', $post['username']);

            if(str_split($username)[0]!= 9){
                $username = substr($username, 1);
            }

//            echo '<pre>'; print_r($username.' - '.$post['password']);die;
            $model->username = $username;
            $model->login();
            return $this->goBack();
        }

        $reg = new Parkings();
        if ($reg->load(Yii::$app->request->post())) {
            if($reg->size >= 5) $reg->size = 5;
            $reg->username = $reg->phone;
            $password = rand(000000, 999999);
            $curl = new curl\Curl();

            //регистриуемся на api сквоттера
                $reqPost =[
                    'name' => 'Парковка',
                    'phone' => $reg->phone,
                    'lat' =>  $reg->lat,
                    'lng' =>  $reg->lng,
                ];

            $response = $curl->setPostParams($reqPost)->post(Yii::$app->params['api_url'].'/reg');
            $reg->uid_squatter = Json::decode($response)['uid'];
            ApiController::writeLog("./logs/passwords.log",$reg->uid_squatter,'login: '.$reg->username.'  pass: '.$password);
            $reg->password = Yii::$app->getSecurity()->generatePasswordHash($password);

            $curl = new curl\Curl();
            $resp = $curl->get('http://geohelper.info/api/v1/phone-data?filter[phone]='.$reg->phone.'&locale[lang]=ru&locale[fallbackLang]=ru&apiKey=3DYoxN9X1laQdUPf2yQVJFMhvX2rgl0w');
            $reg->time_zone = Json::decode($resp)['result']['region']['timezoneOffset'];


//            echo '<pre>'; print_r($reg);die;
            $reg->save();

            $model->username = $reg->username;
            $model->password = (string)$password;
            $model->login();

            return $this->redirect('/');
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
            'reg' => $reg
        ]);
    }

    public function actionReg(){
        $this->layout = 'reg';
        $reg = new Parkings();

        $options = RegForm::get();
        $options =Json::decode($options);
        $parkings = $options['parkings'];
//        echo '<pre>'; print_r($parkings);die;

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            if(isset($post['change_options'])){
                return Json::encode($options['parking_type'][$post['change_options']['opt']]);
            }

            if(isset($post['saving'])){
                $post = $post['saving'];


                $username = preg_replace('/[^0-9]/', '', $post['phone']);
                $username = str_split($username)[0] != 9 ? substr($username, 1): $username;

//                file_put_contents('./test.html',print_r( $username,true), FILE_APPEND | LOCK_EX);

//                file_put_contents('./test.html',print_r( $post,true), FILE_APPEND | LOCK_EX);
//die;
                $parking = [];

//              $username = preg_replace("/[^,.0-9]/", '', $post['username']);
//
//                if(str_split($username)[0]!= 9){
//                    $username = substr($username, 1);
//                }
                $password = rand(000000, 999999);
                $curl = new curl\Curl();

                $parking = Parkings::find()->where(['phone'=>$post['phone']])->asArray()->one();
                if(!empty($parking)) return 'exist';
                $reg = new Parkings();
                $reg->name = $post['name'];
                $reg->phone = $post['phone'];
//                $reg->username = preg_replace('/[^0-9]/', '', $post['phone']);
                $reg->username = $username;
                $reg->size = $post['size'];
                $reg->busy = $post['busy'];
                $reg->address = $post['address'];
                $reg->price = $post['price'];
                $reg->lat = $post['lat'];
                $reg->lng = $post['lng'];
                $reg->start_time = $post['start_time'];
                $reg->end_time = $post['end_time'];
                $reg->w_days = Json::encode($post['w_days']);
                $reg->type = $post['type'];
                $reg->options = Json::encode($post['options']);

                $reg->seat_guarantee = $post['seat_guarantee'];
                $reg->limit_heights = $post['limit_heights'];
                $reg->valid_vehicles = Json::encode($post['valid_vehicles']);

                $reg->password = Yii::$app->getSecurity()->generatePasswordHash($password);

                //регистриуемся на api сквоттера
                $reqPost =[
                    'name' => 'Парковка ['.$reg->name.']',
                    'phone' => $reg->phone,
                    'lat' =>  $reg->lat,
                    'lng' =>  $reg->lng,
                ];

                $response = $curl->setPostParams($reqPost)->post(Yii::$app->params['api_url'].'/reg');
                $reg->uid_squatter = Json::decode($response)['uid'];
                ApiController::writeLog("./logs/passwords.log",$reg->uid_squatter,'login: '.$reg->username.'  pass: '.$password);
//                $curl = new curl\Curl();
//                $resp = $curl->get('http://geohelper.info/api/v1/phone-data?filter[phone]='.$reg->phone.'&locale[lang]=ru&locale[fallbackLang]=ru&apiKey=3DYoxN9X1laQdUPf2yQVJFMhvX2rgl0w');
//                $reg->time_zone = Json::decode($resp)['result']['region']['timezoneOffset'];
                    $reg->time_zone =10800;
                $reg->save();
//                file_put_contents('./test.html',print_r( $reg,true), FILE_APPEND | LOCK_EX);


                if(isset($reg->id)){
                    $model = new LoginForm();
                    $model->username = $reg->username;
                    $model->password = (string)$password;
                    $model->login();
                    return $this->redirect(['/','login'=>$reg->username,'password'=> $password]);
                }else{
                    return 'false';
                }

            }

        }

//            file_put_contents('./test.log',print_r($options,true), FILE_APPEND | LOCK_EX);

        return $this->render('reg',compact('reg','parkings'));
    }

    public function actionPrint(){

        // get your HTML raw content without any layouts or scripts
//        $content = $this->renderPartial('print', compact('operation'));
        $content = $this->renderPartial('print');


        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
//            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
//            'cssFile' => 'css/print.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Договор'],
            'marginTop' => 0 ,
            'marginLeft' => 0,
            'marginRight' => 0,
            'marginBottom' => 0,

            // call mPDF methods on the fly
            'methods' => [
                //'SetHeader'=>['Заголовок'],
                //'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        return $pdf->render();
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionParking(){
        $gadgets =[];
        $gadgets = Gadgets::find()->where(['parking'=>Yii::$app->user->id])->asArray()->all();

        $parkArr = $this->getParking(Yii::$app->user->id);
        $price = $parkArr['parking']->price;
        $btns = $parkArr['btns'];
//        $progress = $parkArr['progress'];


//        echo'<pre>'; print_r($parkArr);die;

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            $parkArr['parking']->busy = preg_replace('/a/', '', $post['btn']);
            $parkArr['parking']->save();
            file_put_contents('./test_sh.html',print_r($parkArr['parking'],true), FILE_APPEND | LOCK_EX);
            return $this->redirect('/parking');
        }

        return $this->render('parking',compact('btns','gadgets','price'));
    }

    private function getParking($id){
        $parking = Parkings::findOne($id);
        $btns = '';
        for ($i=0; $i <= $parking->size; $i++){
            $big =  $i == $parking->busy ? 'on-btn' : '';
            if($i <=4){
                $btns = $btns.'<a class=" bt btn btn-primary circle-btn ml-1 '.$big.'" href="#" id="a'.$i.'">'.$i.'</a> ';
            }elseif($i==5){
                $btns = $btns.'<a class="bt btn btn-primary circle-btn ml-1 '.$big.'" href="#" id="a5"> 5+ </a> ';
            }

        }
        $pr = ($parking->busy /$parking->size *100);
        $progress = '<div class="determinate" style="width: '.$pr.'%"></div>';

        return [
            'parking'=>$parking,
            'btns' => $btns,
//            'progress' => $progress
        ];
    }

    public function actionGadgetDel($id){
        $gatget = Gadgets::find()->where(['token'=>$id])->one();
        $gatget->delete();
        return $this->goBack();
    }

    public function actionChangePrice(){
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $parking = Parkings::findOne(Yii::$app->user->id);
            $parking->price = $post['price'];
            $parking->save();
            return $parking->price;
//            return $this->redirect('/parking');
        }

        echo 'is Work';
    }

    public function actionPin()
    {

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $parking =  Parkings::findOne(Yii::$app->user->id);
            $answer = ApiController::checkPin($parking,$post);
            return Json::encode($answer);
        }
        return 'ok';
    }

    public function actionGeo()
    {
        $request = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$_GET['lat'].','.$_GET['lng'].'&language=ru&key='.Yii::$app->params['googleKey'];
        $curl = new curl\Curl();
        $answer = $curl->get($request);
        return $answer;
    }

    //      смс оповещение
    public function smscSender($phone, $message){
        //Init curl
        $curl = new curl\Curl();
        $login = Yii::$app->params['senderEmail'];
        $password = Yii::$app->params['senderEmail'];
        $response = $curl->get('https://smsc.ru/sys/send.php?login='.$login.'&psw='.$password.'&phones='.$phone.'&mes='.$message);
        return $response;
    }

    public function actionInform($uid,$lat,$lng){

        if(empty($uid)|| empty($lat) || empty($lng)){
            return Json::encode(['error' => 'Отсутствует обязательный параметр']);
        }

        $report=[];
        $parking =  Parkings::find()->where(['uid_squatter'=>$uid])->one();
        $optionsList = Json::decode( RegForm::get());
        $optionsSet = Json::decode($parking->options);
        $options['type']= $optionsList['parkings'][$parking->type];
        foreach ($optionsList['parking_type'][$parking->type] as $ind=> $item){
            if(in_array($ind, $optionsSet)){
                $options['items'][] = $item;
            }
        }

        $distance = $this->getDistanseToLot($lat,$lng,$parking->lat,$parking->lng);

//        echo'<pre>'; print_r($distance); die;
        $report =[
            'uid_squatter' => $parking->uid_squatter,
            'name' => $parking->name,
            'price' => $parking->price,
            'currency' => $parking->currency,
            'address' => $parking->address,
            'distance' => $distance,
            'valid_vehicles' => Json::decode($parking->valid_vehicles),
            'seat_guarantee' => $parking->seat_guarantee,
            'limit_heights' => $parking->limit_heights,
            'options' => $options,
            'around_the_clock' => $parking->around_the_clock


        ];


//

        return Json::encode($report);
    }

    public function actionNewpassword(){
        $user = Yii::$app->user->identity;

        $password = $user->password;


        if ($user->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post()['User'];


            if(substr( $post['password'], 0, 3) != '$2y'){
                $user->password = Yii::$app->getSecurity()->generatePasswordHash($post['password']);
            }elseif ($post['password'] == ''){
                $user->password =$password;
            }else{
                $user->password = $post['password'];
            }


            $user->save();
//            echo'<pre>'; print_r($post);die;
            return $this->redirect('/');
        }


//$2y$13$u1E4JeDsfEeS2XuKv/fug.gu.hLK8lh.ZJjakppzwx6K7HHMkhAP2
//        echo'<pre>'; print_r($user); die;
        return $this->render('newpassword',compact('user'));
    }

    public function actionRestorePassword(){
        $this->layout = 'login';
        $model = new RestoreForm();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post()['RestoreForm'];

            $username = preg_replace("/[^,.0-9]/", '', $post['username']);
            if(str_split($username)[0]!= 9){
                $username = substr($username, 1);
            }

            $password = rand(000000, 999999);

            $user = Parkings::find()->where(['username'=>$username])->one();
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($password);
            ApiController::writeLog("./logs/passwords.log",$user->uid_squatter,'login: '.$user->username.'  pass: '.$password);
            $user->save();

            if(str_split($user->username)[0]== 9){
                $number = '+7'.$user->username;
            }elseif(str_split($user->username)[0] == 7){
                $number = '+'.$user->username;
            }else{
                $number = '+7'.substr($user->username, 1);
            }

            $message = 'Логин: '.$user->username.' Пароль: '.$password;
            $this->smscSender($number,$message);
            Yii::$app->session->setFlash('success','Данные приняты. Новый пароль выслан по СМС ');

            return $this->redirect('/login');

        }

        return $this->render('restore-password',compact('model'));
    }



    //      определение расстояния от клиента до сквоттера
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

}
