<?php
namespace app\models;

use Yii;
use yii\base\Model;

class UploadForm extends Model
{

    public $file;

    public function rules()
    {
        return [
            // username and password are both required

            [['file'], 'file', 'extensions' => 'png, jpg, jpeg',
                'skipOnEmpty' => false]];
    }

}