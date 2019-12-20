<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "gadgets".
 *
 * @property int $id
 * @property int $parking
 * @property int $token
 */
class RegForm extends Model
{
    public $robots;
    public $description;
    public $keywords;

    protected $fileCfg = './reg_from.json';

    public function rules()
    {
        return [
            [['robots', 'description', 'keywords'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'robots' => 'Robots',
            'description' => 'Description',
            'keywords' => 'Keywords',
        ];
    }

    public function get(){
        $file = file_get_contents('./reg_from.json');
//        return Json::decode($file,TRUE);
        return $file;
    }

}
