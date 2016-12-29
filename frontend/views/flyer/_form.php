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
            hint('Geben Sie hier eine beliebig lange Beschreibung für den Zettel an, der dann auf der Infoseite zu dem Zettel angezeigt wird.<br/>Den Text können Sie hierbei mit der '.Assist::help('Markdown Syntax', 'markdown-syntax').' formatieren. Die Überschriftsebenen 1 und 2 sollten Sie jedoch nicht nutzen, sondern nur Ebene 3 und darunter.')
        ?>
        </fieldset>

        <fieldset>
        <legend>Zetteltext und Zugangscode</legend>
        <?= $form->field($model, 'flyertext')->widget('\kartik\markdown\MarkdownEditor',
            [
                'showExport' => false,
            ])->
            hint('Geben Sie hier eine <strong>kurzen</strong> Text für den Zettel selbst an, der dann auf den Zettel gedruckt wird.<br/>Den Text können Sie hierbei mit der '.Assist::help('Markdown Syntax', 'markdown-syntax').' formatieren. Die Überschriftsebenen 1 und 2 sollten Sie jedoch nicht nutzen, sondern nur Ebene 3 und darunter.')
        ?>

        <?= $form->field($model, 'secret')->textInput(['style'=>'size:10','disabled' => !$model->isNewRecord])->hint('Hier können Sie bei der Anlage den vorgenerierten Zugangscode anpassen. Dieser wird im Link erscheinen und gibt den Zugang zu dem Zettel frei. In der Regel sollten Sie aber einfach den Code belassen') ?>

        </fieldset>

        <fieldset>
        <legend>Zeitrahmen</legend>
        <div class="help-block">
            Sie können den Zettel optional zeitlich einschränken, damit Sie selbst besser wissen, wann der Zettel aktuell ist/war.
        </div>
        <?= $form->field($model, 'running_from')->widget(\yii\jui\DatePicker::className()) ?>

        <?= $form->field($model, 'running_until')->widget(\yii\jui\DatePicker::className()) ?>
        </fieldset>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
