<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 16/8/14 下午10:38
 * description:
 */

namespace common\components;

use Yii;
use yii\web\User;
use yii\di\Instance;

class AccessControl extends \yii\base\ActionFilter
{
    /**
     * @var User User for check access.
     */
    private $_user = 'user';

    /**
     * Get user
     * @return User
     */
    public function getUser()
    {
        if (!$this->_user instanceof User) {
            $this->_user = Instance::ensure($this->_user, User::className());
        }
        return $this->_user;
    }

    /**
     * Set user
     * @param User|string $user
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $user = $this->getUser();
        return $this->denyAccess($user);
    }

    /**
     * @param User|string $user
     * @return bool
     */
    protected function denyAccess($user)
    {
        if ($user->getIsGuest()) {
            $user->loginRequired();
        }
        return true;
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    protected function isActive($action)
    {
        $uniqueId = $action->getUniqueId();
        if ($uniqueId === Yii::$app->getErrorHandler()->errorAction) {
            return false;
        }
        $user = $this->getUser();
        if ($user->getIsGuest() && is_array($user->loginUrl) && isset($user->loginUrl[0]) && $uniqueId === trim($user->loginUrl[0], '/')) {
            return false;
        }
        return true;
    }
}