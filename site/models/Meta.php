<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\Json;

class Meta extends Model {

    public $robots;
    public $description;
    public $keywords;

    protected $fileCfg = './metaconfig.json';

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
        $file = file_get_contents('./metaconfig.json');
        return Json::decode($file,TRUE);
    }

    public function set($value=[]){
        if(!empty($value)){
            file_put_contents('./metaconfig.json',Json::encode($value));
        }else{
            return 'no data';
        }

    }

}