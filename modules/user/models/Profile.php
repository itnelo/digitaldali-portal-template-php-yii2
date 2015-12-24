<?php

namespace app\modules\user\models;

use Yii;
use dektrium\user\models\Profile as BaseProfile;

class Profile extends BaseProfile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(), [
            'ImageUrlLength' => ['image_url', 'string', 'max' => 255],
        ]);
    }

    public function attributeLabels() {
        return array_replace_recursive(parent::attributeLabels(), [
            'location' => Yii::t('user', 'City'),
            'image_url' => Yii::t('user', 'Profile image'),
        ]);
    }

}