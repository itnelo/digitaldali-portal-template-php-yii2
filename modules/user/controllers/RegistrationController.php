<?php

namespace app\modules\user\controllers;

use Yii;
use dektrium\user\controllers\RegistrationController as BaseRegistrationController;
use yii\web\NotFoundHttpException;
use app\modules\user\models\User;
use app\modules\user\models\RegistrationForm;
use yii\log\Logger;

class RegistrationController extends BaseRegistrationController
{
    /**
     * Displays the registration page.
     * After successful registration if enableConfirmation is enabled shows info message otherwise redirects to home page.
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionRegister()
    {
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }

        /** @var RegistrationForm $model */
        $model = Yii::createObject(RegistrationForm::className());

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->redirect(['settings/profile']);
        }

        return $this->render('register', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }

    /**
     * Confirms user's account. If confirmation was successful logs the user and shows success message. Otherwise
     * shows error message.
     *
     * @param int    $id
     * @param string $code
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionConfirm($id, $code)
    {
        $user = $this->finder->findUserById($id);

        if ($user === null || $this->module->enableConfirmation == false) {
            throw new NotFoundHttpException();
        }

        if ($user->attemptConfirmation($code)) {
            $redirect_url = ['settings/profile'];
        } else {
            $redirect_url = ['registration/resend'];
        }

        $this->redirect($redirect_url);
    }
}
