<?php

namespace app\controllers;

use app\models\Content;
use app\models\Meta;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Json;

class SiteController extends Controller{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action){

        if(!isset( $_SERVER['HTTP_ACCEPT_LANGUAGE'])|| empty( $_SERVER['HTTP_ACCEPT_LANGUAGE'])){
            \Yii::$app->language = 'ru-RU';
        }else{
            $defaultLang = explode(',',explode( ';', $_SERVER['HTTP_ACCEPT_LANGUAGE'])['0'])['0'];

            if( $_SERVER['HTTP_ACCEPT_LANGUAGE'] == 'ru' || $defaultLang == 'ru-RU'){
                \Yii::$app->language = 'ru-RU';
            }else{
                \Yii::$app->language = 'en-EN';
            }
        }



        if (in_array($action->id, ['message'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
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



    public function actionIndex(){

//        echo'<pre>'; print_r($meta);die;
        $content = [];
        $contentTable = Content::find()->asArray()->all();

        foreach ($contentTable as $ind=>$value){
            if(\Yii::$app->language == 'ru-RU'){
                $content[$value['name']] = $value['content_html'];
            }else{
                $content[$value['name']] = $value['content_html_en'];
            }

        }

        return $this->render('index',compact('content'));
    }

    public function actionMessage(){
        $model = new ContactForm();
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
//            $this->writeLog("./test.log",$post);die;
            $model->name = $post['name'];
            $model->email = $post['email'];
            $model->subject = $post['subject'];
            $model->message = $post['message'];
            $model->contact(Yii::$app->params['adminEmail']);
            Yii::$app->session->setFlash('contactFormSubmitted');

            return  json_encode(1);
        }

    }

    public function actionLogin()
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    //      запись лога
    public function writeLog($address,$value){
        file_put_contents($address,print_r($value,true), FILE_APPEND | LOCK_EX);
        file_put_contents($address,"\n", FILE_APPEND | LOCK_EX);
    }
}
