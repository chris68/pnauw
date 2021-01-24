<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Citation */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\markdown\MarkdownEditor;
use frontend\helpers\Assist;
use frontend\models\Citation;

?>

<div class="citation-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->errorSummary($model) ?>
        <fieldset>
        <legend>Typ</legend>
        <?= $form->field($model, 'type')->dropDownList(Citation::dropDownListForType())->hint('Geben Sie hier bitte an, ob Sie gegen das Gehwegparken eine richtige rechtsverbindliche Anzeige machen wollen oder nur eine unverbindliche Beschwerde. Alternativ können Sie auch die Blankovorlage für andere Zwecke (z.B. das Melden von unsinnigen Verkehrszeichen, fehlenden Wanderzeichen, Müllablagerungen, Astbruch, etc.) nutzen.') ?>
        </fieldset>
        <fieldset>
        <legend>Name und Zusatzinformationen</legend>
        <?= $form->field($model, 'name')->hint('Geben Sie hier den Namen/Titel ein, der dann zur Überschrift wird und später beim Erzeugen des PDF als Dateiname verwendet wird.') ?>

        <?= $form->field($model, 'description')->widget('\kartik\markdown\MarkdownEditor', 
            [
                'showExport' => false,
            ])->
            hint('Den Text können sie mit der '.Assist::help('Markdown Syntax', 'markdown-syntax').' formatieren. Kursiv gesetzte Textteile werden beim verschleierten Drucken durch einen Hinweis auf die Verschleierung ersetzt.') 
        ?>
        </fieldset>
        <fieldset>
        <legend>Empfänger</legend>
        <?= $form->field($model, 'recipient_email')->hint('Geben Sie hier die Email des Empfängers an.') ?>
        <?= $form->field($model, 'recipient_address')->textarea(['rows' => 5])->hint('Geben Sie hier die postalische Adresse des Empfängers an.') ?>
        <?= $form->field($model, 'printout_url')->hint('Geben Sie hier die Freigabe-URL an, mit der man auf den Ausdruck kommt.') ?>

        </fieldset>
    
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
