<?php

namespace app\commands;

use app\models\HotZone;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use linslin\yii2\curl;


class HotMapController extends AppConsoleController
{
    public function actionIndex()
    {
        $zones = HotZone::find()->all();

        foreach ($zones as $index => $zone){
            $address = './web/zones/'.$zone->lat.'_'.$zone->lng.'_'.$zone->w_day.'_'.$zone->act_time;
            file_put_contents($address,print_r(Json::encode(  $zone),true));
        }

        return ExitCode::OK;
    }


}
