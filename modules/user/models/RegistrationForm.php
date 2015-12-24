<?php

namespace app\modules\user\models;

use dektrium\user\models\RegistrationForm as BaseRegistrationForm;

class RegistrationForm extends BaseRegistrationForm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace(parent::rules(), [
            'usernameRequired' => ['username', 'safe'],
            'usernameUnique'   => ['username', 'safe']
        ]);
    }
}