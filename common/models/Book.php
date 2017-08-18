<?php

namespace common\models;

use common\traits\FindCountTrait;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%book}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $author
 * @property integer $own_user_id
 * @property integer $borrow_user_id
 * @property string $image
 * @property string $isbn
 * @property string $data
 * @property integer $view_count
 * @property integer $borrow_count
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Book extends \yii\db\ActiveRecord
{
    use FindCountTrait;

    /**
     * @var integer 已经被借出
     */
    const STATUS_ACTIVE = 1;

    /**
     * @var integer 可以借
     */
    const STATUS_INACTIVE = 0;

    /**
     *  @var integer 被下架
     */
    const STATUS_OFF = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%book}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'author', 'image', 'isbn'], 'required'],
            [['own_user_id', 'borrow_user_id', 'view_count', 'borrow_count', 'status', 'created_at', 'updated_at'], 'integer'],
            [['data'], 'string'],
            [['title', 'author', 'image'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 20],
            [['isbn'], 'unique'],
        ];
    }


    public function behaviors()
    {
        return [TimestampBehavior::className()];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '书名'),
            'author' => Yii::t('app', '作者'),
            'own_user_id' => Yii::t('app', '此书拥有者'),
            'borrow_user_id' => Yii::t('app', '此书借阅者'),
            'image' => Yii::t('app', '书籍封面'),
            'isbn' => Yii::t('app', 'ISBN 号'),
            'data' => Yii::t('app', 'api json 数据'),
            'view_count' => Yii::t('app', '浏览次数'),
            'borrow_count' => Yii::t('app', '借阅次数'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => '已被借阅',
            self::STATUS_INACTIVE => '借阅',
            self::STATUS_OFF => '被下架',
        ];
    }

    /**
     * 获取可以被借出的书籍
     * @param $id
     * @return static
     */
    public static function getInactiveBook($id)
    {
        return self::findOne(['id' => $id, 'status' => self::STATUS_INACTIVE]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!$insert) {
                $this->borrow_user_id = $this->status ? Yii::$app->user->id : 0;
            }
            return true;
        } else {
            return false;
        }
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (!$insert && isset($changedAttributes['status']) && $this->status != $changedAttributes['status']) {
            $this->status ? $this->updateCounters(['borrow_count' => 1]) : null;
            $model = new UserMetadata();
            $model->setAttributes([
                'user_id' => Yii::$app->user->id,
                'type' => $this->status ? UserMetadata::TYPE_BORROW : UserMetadata::TYPE_REPAY,
                'book_id' => $this->id,
                'created_at' => time()
            ]);
            $model->save();
        }
    }
}
