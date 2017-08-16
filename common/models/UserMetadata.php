<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_metadata}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property integer $book_id
 * @property integer $created_at
 */
class UserMetadata extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_metadata}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'book_id'], 'required'],
            [['user_id', 'type', 'book_id', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'type' => Yii::t('app', '类型：1借阅 2还书'),
            'book_id' => Yii::t('app', '书籍ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
}
