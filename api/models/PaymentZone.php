<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_zone".
 *
 * @property int $id
 * @property string $name
 * @property int $min_price минимальная цена
 * @property string $currency валюта
 * @property double $s_lat
 * @property double $s_lng
 * @property double $e_lat
 * @property double $e_lng
 */
class PaymentZone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_zone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['min_price'], 'integer'],
            [['s_lat', 's_lng', 'e_lat', 'e_lng'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['currency'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'min_price' => 'Min Price',
            'currency' => 'Currency',
            's_lat' => 'S Lat',
            's_lng' => 'S Lng',
            'e_lat' => 'E Lat',
            'e_lng' => 'E Lng',
        ];
    }
}
