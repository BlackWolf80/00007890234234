<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bids".
 *
 * @property int $id
 * @property string $uid_user
 * @property string $uid
 * @property double $lat
 * @property double $lng
 * @property string $address
 * @property double $price
 * @property string $bid_date
 * @property int $paid_parking
 */
class Bids extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bids';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid_user', 'lat', 'lng'], 'required'],
            [['lat', 'lng', 'price'], 'number'],
            [['bid_date'], 'safe'],
            [['paid_parking'], 'integer'],
            [['uid_user', 'uid'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 250],
        ];
    }

  public function getLot(){
        return $this->hasOne(Lots::className(),['uid_bid'=>'uid']);
  }
}
