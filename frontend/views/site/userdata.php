<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\UserdataForm */

$this->title = 'Nutzerdaten ändern';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-userdata">
    <h1><?= $this->title ?></h1>

    <p></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-userdata']); ?>
                <fieldset>
                <legend>Derzeitige Werte</legend>
                <p>Nutzername: <?= $model->getUser()->username ?></p>
                <p>Email: <?= $model->getUser()->email ?> </p>
                </fieldset>
                <fieldset>
                <legend>Neue Werte</legend>
                <p class="hint-block">Geben Sie hier neue Werte ein bzw. nichts, um die bestehenden Werte zu belassen</p>
                    <?= $form->field($model, 'new_username') ?>
                    <?= $form->field($model, 'new_email') ?>
                    <?= $form->field($model, 'new_password')->passwordInput() ?>
                </fieldset>
                <fieldset>
                <legend>Nutzer löschen</legend>
                <p class="hint-block">Hier können Sie den Nutzer mit allen Daten komplett löschen. Das ist nicht rückgängig zu machen!</p>
                    <?= $form->field($model, 'delete_user')->checkbox() ?>
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ])->hint('Geben Sie bei einer Löschung bitte zur Sicherheit den Prüfcode ein') ?>
                </fieldset>
                <fieldset>
                <legend>Authentifizierung</legend>
                    <?= $form->field($model, 'old_password')->passwordInput()->hint('Geben Sie hier das derzeitige Passwort ein, um sich für die gewollten Änderungen nochmal zu authentifizieren') ?>
                </fieldset>
                <div class="form-group">
                    <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
