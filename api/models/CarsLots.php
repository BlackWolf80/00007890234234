<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cars_lots".
 *
 * @property int $id
 * @property string $uid_lot
 * @property string $model
 * @property string $number
 * @property string $color
 */
class CarsLots extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cars_lots';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid_lot'], 'required'],
            [['uid_lot', 'model', 'number', 'color'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid_lot' => 'Uid Lot',
            'model' => 'Model',
            'number' => 'Number',
            'color' => 'Color',
        ];
    }


    public function getLot(){
        return $this->hasOne(Lots::className(),['uid'=>'uid_lot']);
    }
}
