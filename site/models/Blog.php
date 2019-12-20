<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property string $post
 * @property string $post_en
 * @property string $img
 * @property int $create
 * @property int $status
 * @property int $sm
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post', 'post_en'], 'string'],
            [['create'], 'required'],
            [['create', 'status', 'sm'], 'integer'],
            [['title', 'title_en', 'img'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'title_en' => 'Title En',
            'post' => 'Post',
            'post_en' => 'Post En',
            'img' => 'Img',
            'create' => 'Create',
            'status' => 'Status',
            'sm' => 'Sm',
        ];
    }
}
