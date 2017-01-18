<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\UserappdataForm */

$this->title = 'Applikations&shy;einstellungen';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-userappdata">
    <h1><?= $this->title ?></h1>

    <p></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-userappdata']); ?>
                <legend>Automatische Kennzeichenerkennung</legend>
                    <div class="help-block">
                        Das Kfz-Kennzeichen in Deutschland besteht am Anfang in der Regel aus zwei Buchstabensegmenten, die unbedingt durch einen Leerraum getrennt werden müssen. 
                        Das schafft die automatische Erkennung derzeit nicht und daher muss man hier die Unterscheidungszeichen (d.h. die Stadt- und Kreiskennungen) als 
                        kommaseparierte Liste eingeben, damit diese sauber getrennt werden
                    </div>
                    <?= $form->field($model, 'reg_codes')
                        ->textarea(['rows' => 3, 'placeholder' => 'Beispiel für Großraum Karlsruhe: KA,PF,GER,SÜW,RP,LD,HD,RA,OG,S'])
                        ->hint('Geben Sie hier die für Sie wichtigen Kennungen immer zuerst in der Liste an (also KA vor K, wenn Ihnen Karlsruhe wichtiger als Köln ist)') ?>
                </fieldset>
                <fieldset>
                <div class="form-group">
                    <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
