<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string $uid
 * @property string $uid_client
 * @property string $uid_squatter
 * @property string $uid_lot
 * @property int $buyer_agrees
 * @property int $seller_agrees
 * @property string $final_cond
 * @property int $seller_full_cond
 * @property int $buyer_full_cond
 * @property string $created
 * @property int $close
 * @property int $secret_key
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['buyer_agrees', 'seller_agrees', 'seller_full_cond', 'buyer_full_cond', 'created', 'update', 'close', 'secret_key', 'type_payment'], 'integer'],
            [['final_cond'], 'string'],
            [['price'], 'number'],
            [['created', 'secret_key'], 'required'],
            [['uid', 'uid_client', 'uid_squatter', 'uid_lot'], 'string', 'max' => 50],
        ];
    }

    public function getLot(){
        return $this->hasOne(Lots::className(),['uid'=>'uid_lot']);
    }

    public function getPayment(){
        return $this->hasOne(Payments::className(),['uid_order'=>'uid']);
    }

}
