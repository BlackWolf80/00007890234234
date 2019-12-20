<?php


namespace app\modules\write\controllers;


use app\models\Meta;
use Yii;
use yii\helpers\Json;

class MetaController extends AppWriteController{

    public  function actionIndex(){

        $metaList = Meta::get();
        $meta = new Meta();

        if (Yii::$app->request->post()) {

            $post = Yii::$app->request->post()['Meta'];
//            echo'<pre>'; print_r($post);die;
            Meta::set($post);
            return $this->redirect(['/write/meta']);
        }

        return $this->render('index',compact('metaList','meta'));
    }

}