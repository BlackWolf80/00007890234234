<?php
namespace app\components;

use app\models\Blog;
use app\models\ContactForm;
use yii\base\Widget;
class ContactFormWindget extends Widget{

    public function init(){
        parent::init();
    }

    public function run(){
        $model = new ContactForm();
        return $this->render('contact_form_html',compact('model'));
    }
}
