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
        <?= $form->field($model, 'type')->dropDownList(Citation::dropDownListForType())->hint('Geben Sie hier bitte an, ob Sie gegen das Gehwegparken eine richtige rechtsverbindliche Anzeige machen wollen oder nur eine unverbindliche Beschwerde. Alternativ können Sie auch eine der Blankovorlagen für andere Zwecke (z.B. das Melden von unsinnigen Verkehrszeichen, fehlenden Wanderzeichen, etc.) nutzen.') ?>
        </fieldset>
        <fieldset>
        <legend>Name und Zusatzinformationen</legend>
        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'description')->widget('\kartik\markdown\MarkdownEditor', 
            [
                'showExport' => false,
            ])->
            hint('Den Text können sie mit der '.Assist::help('Markdown Syntax', 'markdown-syntax').' formatieren. Sie sollten aber außer bei der Blankovorlage nur Fettmachungen, etc. einsetzen.') 
        ?>
        </fieldset>
    
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
