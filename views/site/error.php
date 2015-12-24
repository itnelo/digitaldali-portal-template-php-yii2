<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = Yii::t('error', $name);
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <? if (!empty($message)): ?>
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <? endif ?>

    <p>
        <?= Yii::t('error', 'The above error occurred while the Web server was processing your request.') ?>
    </p>
    <p>
        <?= Yii::t('error', 'Please contact us if you think this is a server error: {0}. Thank you.', Yii::$app->params['adminEmail']) ?>
    </p>

</div>
