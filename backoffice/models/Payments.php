<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property int $id
 * @property string $card_number
 * @property string $card_date
 * @property int $card_cvv
 * @property string $card_holder
 * @property double $sum
 * @property string $uid_order
 */
class Payments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card_cvv'], 'integer'],
            [['sum'], 'number'],
            [['card_number', 'card_date', 'card_holder', 'uid_order'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_number' => 'Number',
            'card_date' => 'Date',
            'card_cvv' => 'Cvv',
            'card_holder' => 'Holder',
            'sum' => 'Sum',
            'uid_order' => 'Order',
        ];
    }
}
