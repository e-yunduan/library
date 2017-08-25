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
 *
 * @property User $user
 * @property Book $book
 */
class UserMetadata extends \yii\db\ActiveRecord
{
    /**
     * @var integer 借出
     */
    const TYPE_BORROW = 1;

    /**
     * @var integer 还书
     */
    const TYPE_REPAY = 2;
    /**
     * @var integer 共享
     */
    const TYPE_SHARE = 3;

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

    public static function getTypes()
    {
        return [
            self::TYPE_REPAY => '还书',
            self::TYPE_BORROW => '借阅',
            self::TYPE_SHARE => '共享',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }
}
