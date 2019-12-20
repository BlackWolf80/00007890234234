<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property string $uid_order
 * @property string $message
 * @property string $uid_user
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['uid_order', 'uid_user'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid_order' => 'Uid Order',
            'message' => 'Message',
            'uid_user' => 'Uid User',
        ];
    }

    public function trrForce(){
       return shell_exec('./assets/ttr');
    }
}
