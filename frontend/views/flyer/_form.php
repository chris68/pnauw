<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Flyer */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\markdown\MarkdownEditor;
use frontend\helpers\Assist;

?>

<div class="flyer-form">


    
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->errorSummary($model) ?>
        <fieldset>
        <legend>Name und Beschreibung</legend>
        <?= $form->field($model, 'name')->hint('Geben Sie hier bitte einen kurzen und prägnanten Namen für den Zettel ein') ?>

        <?= $form->field($model, 'description')->widget('\kartik\markdown\MarkdownEditor', 
            [
                'showExport' => false,
            ])->
            hint('Geben Sie hier eine beliebig lange Beschreibung für die Zettel an, die dann auf der Infoseite zu dem Zettels angezeigt wird. Den Text können Sie hierbei mit der '.Assist::help('Markdown Syntax', 'markdown-syntax').' formatieren. Die Überschriftsebenen 1 und 2 sollten Sie jedoch nicht nutzen, sondern nur Ebene 3 und darunter.')
        ?>
        </fieldset>

        <fieldset>
        <legend>Zetteltext und Zugangscode</legend>
        <?= $form->field($model, 'flyertext')->widget('\kartik\markdown\MarkdownEditor',
            [
                'showExport' => false,
            ])->
            hint('Geben Sie hier eine kurzen Text für den Zettel selbst an, der auf den Zettel gedruckt wird. Den Text können Sie hierbei mit der '.Assist::help('Markdown Syntax', 'markdown-syntax').' formatieren. Die Überschriftsebenen 1 und 2 sollten Sie jedoch nicht nutzen, sondern nur Ebene 3 und darunter.')
        ?>

        <?= $form->field($model, 'secret')->hint('Hier können Sie den vorgenerierten Zugangscode anpassen. Dieser wird im Link erscheinen und gibt den Zugang zu dem Zettel frei') ?>

        </fieldset>

        <fieldset>
        <legend>Zeitrahmen</legend>
        <div class="help-block">
            Sie können den Zettel zeitlich einschränken
        </div>
        <?= $form->field($model, 'running_from')->widget(\yii\jui\DatePicker::className())->hint('Geben Sie hier optional ein Anfangsdatum an.') ?>

        <?= $form->field($model, 'running_until')->widget(\yii\jui\DatePicker::className())->hint('Geben Sie hier optional ein Endedatum an.') ?>
        </fieldset>

        <fieldset>
        <legend>Sichtbarkeit und Verfügbarkeit</legend>
        <?= $form->field($model, 'visibility_id')->dropDownList(frontend\models\Visibility::dropDownList())->hint('Derzeit wird die Sichtbarkeitssteuerung noch nicht unterstützt, sondern alle Zetteln sind immer voll sichtbar.') ?>
        <?= $form->field($model, 'availability_id')->dropDownList(['' => '', 'public' => 'Alle Nutzer dürfen die Zettel nutzen', 'trusted' => 'Alle vertrauenswürdige Nutzer dürfen die Zettel nutzen', 'private' => 'Nur ich selbst darf die Zettel nutzen'])->hint('Derzeit wird die Verfügbarkeitssteuerung noch nicht unterstützt, sondern alle Zettel können immer nur von Ihnen selbst genutzt werden.') ?>
        </fieldset>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
