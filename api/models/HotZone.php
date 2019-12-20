<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hot_zone".
 *
 * @property int $id
 * @property double $lat
 * @property double $lng
 * @property int $w_day
 * @property string $act_time
 * @property int $active
 */
class HotZone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hot_zone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lat', 'lng'], 'number'],
            [['w_day', 'active'], 'integer'],
            [['act_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'w_day' => 'День недели',
            'act_time' => 'Время',
            'active' => 'Активность',
        ];
    }
}
