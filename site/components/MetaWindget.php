<?php
namespace app\components;

use app\models\Blog;
use app\models\Meta;
use yii\base\Widget;
class MetaWindget extends Widget{
    public $metatag;

    public function init(){
        parent::init();
    }

    public function run(){
        $meta = Meta::get();
        switch ($this->metatag){
            case 'robots': return $meta['robots'];
            case 'description': return $meta['description'];
            case 'keywords': return $meta['keywords'];
        }
    }
}
