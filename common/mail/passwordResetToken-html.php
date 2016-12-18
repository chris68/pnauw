<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <?= \Yii::t('common','Hello') ?> <?= Html::encode($user->username) ?>,

    <?= \Yii::t('common','Follow the link below to reset your password:') ?>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
