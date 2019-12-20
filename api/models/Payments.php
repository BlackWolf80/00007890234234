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
 * @property int $status
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
            [['sum'], 'number'],
            [['payment_id', 'uid_order'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment_id' => 'Payment ID',
            'sum' => 'Sum',
            'uid_order' => 'Uid Order',
            'status' => 'Status',
        ];
    }
}
