<?php

namespace app\controllers;

use Yii;
use app\models\Payments;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class PaymentsController extends AppController{

    public function actionIndex(){
        Yii::$app->params['page'] = 91;
       return $this->render('index');
    }

}
