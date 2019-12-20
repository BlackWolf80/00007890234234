<?php


namespace app\controllers;


use app\models\Parkings;
use kartik\mpdf\Pdf;
use Yii;

class ParkingsController extends AppController{

    public function actionIndex(){
        $parkings = Parkings::find()->all();
        return $this->render('index',compact('parkings'));
    }

    public function actionActivations(){
       if(isset($_GET['id'])){
           $parking = Parkings::findOne(Yii::$app->request->get('id'));
           $parking->status =1;
           $parking->save();
           return $this->redirect('/parkings/activations');
       }
        return $this->render('activations');
    }

    public function actionPrintContract($id){
        $parking = Parkings::findOne($id);
        $content = $this->renderPartial('print',compact('parking'));

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
}