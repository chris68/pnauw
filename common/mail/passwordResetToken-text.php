<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<?= \Yii::t('base','Hello') ?> <?= $user->username ?>,

<?= \Yii::t('base','Follow the link below to reset your password:') ?>

<?= $resetLink ?>
