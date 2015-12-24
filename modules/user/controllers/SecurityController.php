<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\modules\user\controllers;

use Yii;
use app\modules\user\models\Profile;
use app\modules\user\models\LoginForm;
use dektrium\user\controllers\SecurityController as BaseSecurityController;

class SecurityController extends BaseSecurityController
{
    /**
     * Displays the login page.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            $this->goHome();
        }

        /** @var LoginForm $model */
        $model = Yii::createObject(LoginForm::className());

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            $profile = Profile::findOne(Yii::$app->user->id);
            if (empty($profile->name) || empty($profile->location)) {
                return $this->redirect(['settings/profile?complete=1']);
            } else {
                return $this->goBack();
            }
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }
}
