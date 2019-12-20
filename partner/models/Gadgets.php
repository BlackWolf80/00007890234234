<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gadgets".
 *
 * @property int $id
 * @property int $parking
 * @property int $token
 */
class Gadgets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gadgets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parking', 'token'], 'integer'],
            [['date'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parking' => 'Parking',
            'token' => 'Token',
            'date' => 'Date'
        ];
    }

    public function getPark(){
        return $this->hasOne(Parkings::className(),['id'=>'parking']);
    }
}
