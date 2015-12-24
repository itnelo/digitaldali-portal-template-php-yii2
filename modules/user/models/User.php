<?php

namespace app\modules\user\models;

use Yii;
use dektrium\user\models\User as BaseUser;
use app\modules\rbac\helpers\RbacHelper;

class User extends BaseUser
{
    public function init()
    {
        parent::init();

        $this->on(self::AFTER_REGISTER, [$this, 'assignDefaultRole']);
        $this->on(self::AFTER_CREATE, [$this, 'assignDefaultRole']);
        if ($this->module->enableUnconfirmedLogin) {
            $this->on(self::AFTER_REGISTER, [$this, 'loginAfterRegister']);
        }
    }

    public function loginAfterRegister($event) {
        Yii::trace(__METHOD__);
        Yii::$app->user->login($this, $this->module->rememberFor);
    }

    public function assignDefaultRole($event) {
        Yii::trace(__METHOD__);
        Yii::$app->getAuthManager()->assign(RbacHelper::getDefaultUserRole(), $this->getId());
    }

    /** @inheritdoc */
    public function scenarios()
    {
        return array_replace_recursive(parent::scenarios(), [
            'register' => ['email', 'password'],
            'connect'  => ['username', 'email'],
            'create'   => ['email', 'password'],
            'update'   => ['email', 'password'],
            'settings' => ['username', 'email', 'password'],
        ]);
    }

    /** @inheritdoc */
    public function rules()
    {
        return array_replace_recursive(parent::rules(), [
            // username rules
            'usernameRequired' => ['username', 'required', 'on' => [/*'register', 'create', 'connect', 'update'*/]],
            'usernameUnique'   => ['username', 'safe', /* 'unique', 'message' => Yii::t('user', 'This username has already been taken') */],
        ]);
    }

    /**
     * @return bool Whether the user is an admin or not.
     */
    public function getIsAdmin()
    {
        return in_array($this->email, $this->module->admins);
    }
}
