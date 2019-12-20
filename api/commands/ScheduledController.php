<?php

namespace app\commands;

use app\models\HotZone;
use app\models\Lots;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use linslin\yii2\curl;


class ScheduledController extends AppConsoleController
{
    public function actionIndex()
    {
        //если висит больше 8 часов и открыт
        $this->delGreyFrozenLots(8);
        //если висит больше суток
        $this->delGreyFrozenLots(24);

        return ExitCode::OK;
    }


    private  function delGreyFrozenLots($period){
        $timeNow = time();
        switch ($period){
            case 8: //если висит больше 8 часов и открыт
                $lots = Lots::find()->where(['grey'=>1])->andWhere(['close'=> 0])->all();
                foreach ($lots as $lot){
                    if($timeNow - $lot->created >= 28800 ){
                        $lot->delete();
                    }
                }
                break;
            case 24:  //если висит больше суток
                $lots =  Lots::find()->where(['grey'=>1])->andWhere(['close'=> 1])->andWhere(['order_close' => 0])->with('order')->all();
                foreach ($lots as $lot){
                    if($timeNow - $lot->created >= 86400 ){
                        $lot->order->delete();
                        $lot->delete();
                    }
                }
                break;
        }
    }


}
