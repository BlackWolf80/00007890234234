<?php

namespace app\components;

use app\models\Parkings;
use yii\base\Widget;
use Yii;
use yii\helpers\Html;


class ParkingActivationWidget extends Widget{
    public $type;

    public function init(){
        parent::init();
    }


    public function run(){
        $parkings = Parkings::find()->where(['status'=>0])->all();
        if($this->type!=1){
            return $this->render('activations',compact('parkings'));
        }else{
            return $this->render('indicator',compact('parkings'));
        }

    }

}