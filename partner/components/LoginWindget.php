<?php
namespace app\components;

use app\models\Blog;
use app\models\LoginForm;
use app\models\Meta;
use Yii;
use yii\base\Widget;
class LoginWindget extends Widget{
    public $metatag;

    public function init(){
        parent::init();
    }

    public function run(){
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
}
