<?php
namespace app\components;

use app\models\Blog;
use yii\base\Widget;
class BlogWindget extends Widget{

    public function init(){
        parent::init();
    }

    public function run(){
        $blogBgSt = Blog::find()->orderBy('id desc')->where(['status'=>1])->andWhere(['sm'=>0])->asArray()->all();

        if(\Yii::$app->language != 'ru-RU'){
            foreach ($blogBgSt as $item){
                $blogBg[] = [
                    'id' => $item['id'],
                    'title' => $item['title_en'],
                    'img' => $item['img'],
                    'post' => $item['post_en'],
                ];
            }
        }else{
            $blogBg = $blogBgSt;
        }

        $blogSmSt = Blog::find()->orderBy('id desc')->where(['status'=>1])->andWhere(['sm'=>1])->asArray()->all();

        if(\Yii::$app->language != 'ru-RU'){
            foreach ($blogSmSt as $item){
                $blogSm[] = [
                    'id' => $item['id'],
                    'title' => $item['title_en'],
                    'img' => $item['img'],
                    'post' => $item['post_en'],
                ];
            }
        }else{
            $blogSm = $blogSmSt;
        }

        return $this->render('blog',compact('blogBg','blogSm'));
    }
}
