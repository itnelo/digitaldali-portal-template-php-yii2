<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $profile
 */

$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'id' => 'profile-form',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                    ],
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                ]); ?>

                <?= $form->field($model, 'name') ?>

                <?= $form->field($model, 'location') ?>

                <?= $form->field($uploadForm, 'imageFile')
                        ->label(Yii::t('user', 'Profile image'))
                        ->widget(\dosamigos\fileupload\FileUpload::className(), [
                            'model' => $uploadForm,
                            'attribute' => 'imageFile',
                            'url' => ['settings/profile-image-upload', 'user_id' => $model->user_id], // your url, this is just for demo purposes,
                            'options' => ['accept' => 'image/*'],
                            'clientOptions' => [
                                'maxFileSize' => 2000000
                            ],
                            'clientEvents' => [
                                'fileuploaddone' => 'function(e, data) {
                                        if (\'undefined\' != typeof data.result.image_url) {
                                            var profileImageElement = $(\'#profile-image\');
                                            profileImageElement.attr(\'src\', data.result.image_url).show();
                                            profileImageElement.removeClass(\'hidden\');
                                        }
                                    }',
                            ],
                ]) ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= \yii\helpers\Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?><br>
                    </div>
                </div>

                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
