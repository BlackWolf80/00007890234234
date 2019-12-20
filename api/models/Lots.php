<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lots".
 *
 * @property int $id
 * @property string $uid
 * @property string $uid_squatter
 * @property double $lat
 * @property double $lng
 * @property string $address
 * @property int $option1
 * @property int $option2
 * @property int $option3
 * @property double $price
 * @property int $currency
 * @property string $created
 * @property string $uid_bid
 * @property int $close
 */
class Lots extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lots';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lat', 'lng', 'price'], 'number'],
            [['address', 'currency'], 'required'],
            [['address'], 'string'],
            [['grey', 'option2', 'option3', 'close','order_close','created','update', 'type_payment'], 'integer'],
            [['uid', 'uid_squatter', 'uid_bid'], 'string', 'max' => 50],
            [['currency'], 'string', 'max' => 20],
        ];
    }



    public function getBid(){
        return $this->hasOne(Bids::className(),['uid'=>'uid_bid']);
    }

    public function getOrder(){
        return $this->hasOne(Orders::className(),['uid_lot'=>'uid']);
    }

    public function getCar(){
        return $this->hasOne(CarsLots::className(),['uid_lot'=>'uid']);
    }

    public function getSquatter(){
        return $this->hasOne(Users::className(),['uid'=>'uid_squatter']);
    }
}
