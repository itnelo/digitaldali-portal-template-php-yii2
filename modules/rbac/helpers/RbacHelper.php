<?php

namespace app\modules\rbac\helpers;

use Yii;

class RbacHelper
{
    const DEFAULT_USER_ROLE = 'Student';

    public static function getDefaultUserRole() {
        return Yii::createObject([
            'class' => 'yii\rbac\Role',
            'name' => self::DEFAULT_USER_ROLE]
        );
    }
}