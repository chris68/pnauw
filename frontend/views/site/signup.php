<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

// @chris68
use frontend\helpers\Assist;

$this->title = \Yii::t('base','Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= $this->title ?></h1>

    <p><?= \Yii::t('base','Please fill out the following fields to signup:') ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <p>
                    Ich habe die <?= Assist::linkNew('Nutzungsbedingungen',['site/terms']) ?> <b>und</b> <?= Assist::linkNew('Datenschutzregeln',['site/privacy']) ?> gelesen und akzeptiere <b>beide</b>.
                </p>
                <?= 
                $form->field($model, 'acceptTerms')->checkbox() ?>
                
                <div class="form-group">
                    <?= Html::submitButton(\Yii::t('base','Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <p>Oder registieren Sie sich über einen der externen OAuth-Provider:</p>
                <?= yii\authclient\widgets\AuthChoice::widget([
                     'baseAuthUrl' => ['site/auth'],
                     'popupMode' => false,
                ]) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
