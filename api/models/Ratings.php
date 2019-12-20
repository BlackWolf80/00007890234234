<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ratings".
 *
 * @property int $id
 * @property string $uid_user
 * @property int $client_completed
 * @property int $client_sum
 * @property int $client_cancel
 * @property int $squatter_completed
 * @property int $squatter_sum
 * @property int $squatter_cancel
 */
class Ratings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ratings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_completed', 'client_sum', 'client_cancel', 'squatter_completed', 'squatter_sum', 'squatter_cancel'], 'integer'],
            [['uid_user'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid_user' => 'Uid User',
            'client_completed' => 'Client Completed',
            'client_sum' => 'Client Sum',
            'client_cancel' => 'Client Cancel',
            'squatter_completed' => 'Squatter Completed',
            'squatter_sum' => 'Squatter Sum',
            'squatter_cancel' => 'Squatter Cancel',
        ];
    }

}
