<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $uid
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property int $promo
 * @property int $count_enter_promo
 * @property double $lat
 * @property double $lng
 * @property string $region
 * @property string $car_model
 * @property string $car_color
 * @property int $zone_id платежная зона
 * @property string $refuse_half
 * @property int $refuse
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['promo', 'count_enter_promo', 'zone_id', 'refuse','refuse_half'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['uid', 'name', 'region', 'car_model', 'car_color'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 100],
            [['promo'], 'unique'],
        ];
    }



    public function getLots(){
        return $this->hasMany(Lots::className(),['uid'=>'uid_lot']);
    }

    public function getOrdersCli(){
        return $this->hasMany(Orders::className(),['uid_client'=>'uid']);
    }

    public function getOrdersSq(){
        return $this->hasMany(Orders::className(),['uid_squatter'=>'uid']);
    }

    public function getZone(){
        return $this->hasOne(PaymentZone::className(),['id'=>'zone_id']);
    }



}
