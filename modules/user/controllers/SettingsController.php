<?php

namespace app\modules\user\controllers;

use Yii;
use yii\web\Response;
use yii\web\UploadedFile;
use app\models\UploadForm;
use dektrium\user\controllers\SettingsController as BaseSettingsController;

class SettingsController extends BaseSettingsController
{
    /** @inheritdoc */
    public function behaviors()
    {
        return array_merge_recursive(parent::behaviors(), [
            'access' => [
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['profile-image-upload'],
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Shows profile settings form.
     *
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        $model = $this->finder->findProfileById(Yii::$app->user->identity->getId());

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $flash = ['success', Yii::t('user', 'Your profile has been updated')];
        } elseif (Yii::$app->getRequest()->get('complete')) {
            $flash = ['info', Yii::t('user', 'Please complete filling profile info')];
        }

        if (isset($flash)) {
            Yii::$app->getSession()->setFlash($flash[0], $flash[1]);
            return $this->redirect('profile');
        }

        return $this->render('profile', [
            'model' => $model,
            'uploadForm' => Yii::createObject(UploadForm::className())
        ]);
    }

    public function actionProfileImageUpload($user_id = null) {
        $result = 0;

        if (Yii::$app->request->isPost) {
            $profileModel = $this->finder->findProfileById($user_id);
            if ($profileModel != null && $profileModel->user_id == Yii::$app->user->identity->getId()) {
                $uploadForm = new UploadForm();
                $uploadForm->addSegments(['user', $user_id]);
                $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                if ($uploadForm->upload()) {
                    $profileModel->image_url = $uploadForm->uploadedUrl();
                    if ($profileModel->save()) {
                        $result = 1;
                    }
                }
            }
        }

        \Yii::$app->response->format = Response::FORMAT_JSON;
        \Yii::$app->response->data = [
            'result' => $result,
            'image_url' => $result ? $profileModel->image_url : ''
        ];
        \Yii::$app->end();
    }
}