<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $real_name;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'real_name'], 'trim'],
            [['username', 'email', 'password', 'real_name'], 'required'],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i', 'message' => '用户名只能是数字和字母'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '此用户名已经存在'],
            [['username', 'real_name'], 'string', 'min' => 2, 'max' => 255],

            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '此邮箱已经被注册'],

            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->real_name = $this->real_name;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', '用户名'),
            'password' => Yii::t('app', '密码'),
            'email' => Yii::t('app', '邮箱'),
            'real_name' => Yii::t('app', '真实姓名'),
        ];
    }
}
