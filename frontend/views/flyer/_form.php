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
        <legend>Zeitliche Einschränkung</legend>
        <div class="help-block">
            Sie können den Zettel optional zeitlich einschränken, indem Sie ein Start- und Enddatum definieren, mit denen das Vorfallsdatum bei der Ermittlung der Verfälle eingeschrämkt wird.
        </div>
        <?= $form->field($model, 'running_from')->widget(\yii\jui\DatePicker::className())->hint('Geben Sie hier das Datum ein, an dem Sie angefangen haben, den Zettel zu verteilen') ?>

        <?= $form->field($model, 'running_until')->widget(\yii\jui\DatePicker::className())->hint('Geben Sie hier das Datum ein, an dem Sie aufgehört haben, den Zettel zu verteilen') ?>
        </fieldset>

        <fieldset>
        <legend>Örtliche Einschränkung</legend>
        <div class="help-block">
            Sie können den Zettel optional örtlich einschränken, indem Sie einen Suchausdruck definieren, mit dem in der Ortsangabe bei der Ermittlung der Verfälle gesucht werden soll.
        </div>
        <?= $form->field($model, 'loc_filter')->textInput()->hint('Geben Sie hier den Suchausdruck für den Ort ein, wobei das % hierbei für beliebig viele Zeichen steht, das | Alternativen trennt und Teilausdücke geklammert werden. Die Sonderzeichen <b>*+?{}</b> sind hingegen verboten. Bei der Suche ist die Unterscheidung zwischen Groß- und Kleinschreibung wichtig.')?>
        <div class="alert alert-info">
            <strong>Beispiele</strong><br/>
            <i>%(70173|70174)%Stuttgart%</i> findet zwei Postleitzahlen in Stuttgart<br/>
            <i>(Bolz|Stephan|König)%70173%Stuttgart%</i> findet die drei entsprechenden Straßen in Stuttgart Mitte

        </div>
        </fieldset>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
