<?php
namespace app\components;

use app\models\Blog;
use app\models\Documents;
use app\models\Meta;
use yii\base\Widget;
class DoscWindget extends Widget{
    public $docNumber;

    public function init(){
        parent::init();
    }

    public function run()
    {
        $docsTab = Documents::find()->asArray()->all();
        $docs =[];

        if(\Yii::$app->language == 'ru-RU'){

            foreach ($docsTab as $index=>$value){
               $docs[$index]=[
                   'id'=> $value['id'],
                   'title' => $value['title'],
                   'content' => $value['content']
               ];
            }
        }else{
            foreach ($docsTab as $index=>$value){
                $docs[$index]=[
                    'id'=> $value['id'],
                    'title' => $value['title_en'],
                    'content' => $value['content_en']
                ];
            }
        }
        return $this->render('docs',compact('docs'));
    }
}
