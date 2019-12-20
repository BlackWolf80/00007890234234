<?php

namespace app\modules\write\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;


class DefaultController extends AppWriteController
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}
