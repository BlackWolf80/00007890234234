<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parkings".
 *
 * @property int $id
 * @property string $uid_squatter
 * @property string $name
 * @property int $size
 * @property int $busy
 * @property int $hold
 * @property string $address
 * @property double $lat
 * @property double $lng
 * @property string $phone
 * @property int $type_of_payment
 * @property int $status
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property double $price
 * @property string $start_time
 * @property string $end_time
 * @property int $time_zone
 */
class Parkings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parkings';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_park');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'size', 'address', 'lat', 'lng', 'phone'], 'required'],
            [['size', 'busy', 'hold', 'type_of_payment', 'status', 'time_zone'], 'integer'],
            [['lat', 'lng', 'price'], 'number'],
            [['start_time', 'end_time'], 'safe'],
            [['uid_squatter', 'name', 'phone', 'username'], 'string', 'max' => 50],
            [['address', 'password', 'auth_key'], 'string', 'max' => 150],
            [['phone'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid_squatter' => 'Uid Squatter',
            'name' => 'Name',
            'size' => 'Size',
            'busy' => 'Busy',
            'hold' => 'Hold',
            'address' => 'Address',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'phone' => 'Phone',
            'type_of_payment' => 'Type Of Payment',
            'status' => 'Status',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'price' => 'Price',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'time_zone' => 'Time Zone',
        ];
    }
}
