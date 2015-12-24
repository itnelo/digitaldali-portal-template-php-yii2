<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;
use dektrium\user\models\LoginForm as BaseLoginForm;

class LoginForm extends BaseLoginForm
{
    public $email;

    /** @inheritdoc */
    public function attributeLabels()
    {
        return array_replace_recursive(parent::attributeLabels(), [
            'email' => Yii::t('user', 'Email'),
        ]);
    }

    /** @inheritdoc */
    public function beforeValidate()
    {
        if (Model::beforeValidate()) {
            $this->user = $this->finder->findUserByEmail($this->email);

            return true;
        } else {
            return false;
        }
    }

    /** @inheritdoc */
    public function rules()
    {
        return array_replace_recursive(parent::rules(), [
            'requiredFields' => [['email', 'password'], 'required'],
            'loginTrim' => ['email', 'trim'],
            'emailPattern'  => ['email', 'email'],
            'confirmationValidate' => [
                'email',
                function ($attribute) {
                    if ($this->user !== null) {
                        $confirmationRequired = $this->module->enableConfirmation && !$this->module->enableUnconfirmedLogin;
                        if ($confirmationRequired && !$this->user->getIsConfirmed()) {
                            $this->addError($attribute, Yii::t('user', 'You need to confirm your email address'));
                        }
                        if ($this->user->getIsBlocked()) {
                            $this->addError($attribute, Yii::t('user', 'Your account has been blocked'));
                        }
                    }
                }
            ],
            'rememberMe' => ['rememberMe', 'boolean'],
        ]);
    }
}