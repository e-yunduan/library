<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 16/8/27 下午10:46
 * description:
 */

namespace common\components;

use common\models\User;
use frontend\models\PasswordResetRequestForm;
use Yii;
use yii\base\BaseObject;

class Mailer extends BaseObject
{
    /**
     * @var string|array Default: `Yii::$app->params['adminEmail']` OR `no-reply@xxx.com
     */
    public $sender;

    /**
     * @var string 欢迎用户
     */
    protected $welcomeSubject;

    /**
     * @var string 验证用户
     */
    protected $confirmationSubject;

    /**
     * @var string 再次验证用户
     */
    protected $passwordResetSubject;

    /**
     * @var string 通知
     */
    protected $noticeSubject;

    /**
     * @return string
     */
    public function getWelcomeSubject()
    {
        if ($this->welcomeSubject == null) {
            $this->setWelcomeSubject(Yii::t('app', 'Welcome to {0}', Yii::$app->name));
        }
        return $this->welcomeSubject;
    }

    /**
     * @param string $welcomeSubject
     */
    public function setWelcomeSubject($welcomeSubject)
    {
        $this->welcomeSubject = $welcomeSubject;
    }

    /**
     * @return string
     */
    public function getConfirmationSubject()
    {
        if ($this->confirmationSubject == null) {
            $this->setConfirmationSubject(Yii::t('app', '欢迎使用{0}，请验证您的邮箱', Yii::$app->name));
        }
        return $this->confirmationSubject;
    }

    /**
     * @param string $confirmationSubject
     */
    public function setConfirmationSubject($confirmationSubject)
    {
        $this->confirmationSubject = $confirmationSubject;
    }

    /**
     * @return string
     */
    public function getPasswordResetSubject()
    {
        if ($this->passwordResetSubject == null) {
            $this->setPasswordResetSubject(Yii::t('app', '重置 {0} 密码', Yii::$app->name));
        }
        return $this->passwordResetSubject;
    }

    /**
     * @param string $passwordResetSubject
     */
    public function setPasswordResetSubject($passwordResetSubject)
    {
        $this->passwordResetSubject = $passwordResetSubject;
    }

    /**
     * Sends an email to a user after registration.
     *
     * @param User $user
     * @param bool $showPassword
     *
     * @return bool
     */
    public function sendWelcomeMessage(User $user, $showPassword = false)
    {
        return $this->sendMessage(
            $user->email,
            $this->getWelcomeSubject(),
            'welcome',
            ['user' => $user, 'module' => $this->module, 'showPassword' => $showPassword]
        );
    }

    /**
     * 验证邮箱邮件
     *
     * @param User $user
     * @return bool
     */
    public function sendConfirmationMessage(User $user)
    {
        PasswordResetRequestForm::setPasswordResetToken($user);
        return $this->sendMessage(
            $user->email,
            $this->getConfirmationSubject(),
            'confirmation',
            ['user' => $user]
        );
    }

    /**
     * 忘记密码邮件
     *
     * @param User $user
     * @return bool
     */
    public function sendPasswordResetMessage(User $user)
    {
        $email = $user->email;
        return $this->sendMessage(
            $email,
            $this->getPasswordResetSubject(),
            'passwordResetToken',
            ['user' => $user]
        );
    }

    /**
     *
     * @param $typeName
     * @return string
     */
    public function getNoticeSubject($typeName)
    {
        $this->setNoticeSubject(Yii::t('app', '您想要的应用和电子书{0}了 - {1}', [$typeName, Yii::$app->name]));
        return $this->noticeSubject;
    }


    /**
     * @param string $noticeSubject
     */
    public function setNoticeSubject($noticeSubject)
    {
        $this->noticeSubject = $noticeSubject;
    }


    /**
     * 发送 App 通知邮件
     *
     * @param $email string
     * @param $dataProvider string json
     * @param $typeName string
     * @return bool
     */
    public function sendNoticeMessage($email, $dataProvider, $typeName)
    {
        return $this->sendMessage(
            $email,
            $this->getNoticeSubject($typeName),
            'notice',
            ['dataProvider' => $dataProvider, 'typeName' => $typeName]
        );
    }


    /**
     * @param string $to
     * @param string $subject
     * @param string $view
     * @param array $params
     *
     * @return bool
     */
    protected function sendMessage($to, $subject, $view, $params = [])
    {
        $this->initMailer();
        /** @var \yii\mail\BaseMailer $mailer */
        $mailer = Yii::$app->mailer;
        $mailer->viewPath = '@common/mail';
        $mailer->getView()->theme = Yii::$app->view->theme;
        if ($this->sender === null) {
            $this->sender = isset(Yii::$app->params['supportEmail']) ? Yii::$app->params['supportEmail'] : 'no-reply@xxx.com';
        }
        return $mailer->compose(['html' => $view . '-html', 'text' => $view . '-text'], $params)
            ->setTo($to)
            ->setFrom([$this->sender => Yii::$app->name . '机器人'])
            ->setSubject($subject)
            ->send();
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    private function initMailer()
    {
        // 国内线路
        $this->sender = Yii::$app->params['email.sender'];
        Yii::$app->set('mailer', [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => Yii::$app->params['email.host'],
                'username' => Yii::$app->params['email.username'],
                'password' => Yii::$app->params['email.password'],
                'port' => Yii::$app->params['email.port'],
                'encryption' => 'tls',
            ],
        ]);
    }

}