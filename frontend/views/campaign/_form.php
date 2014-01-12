<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\markdown\MarkdownEditor;

/**
 * @var yii\web\View $this
 * @var frontend\models\Campaign $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="campaign-form">


	
	<?php $form = ActiveForm::begin(); ?>

		<fieldset>
		<legend>Name und Beschreibung</legend>
		<?= $form->field($model, 'name')->hint('Geben Sie hier bitte einen kurzen und prägnanten Namen für die Kampagne ein, der dann auch in die Auswahlisten/Anzeige passt') ?>

		<div class="form-group">
			<?php // $form->field($model, 'description')->textarea(['rows' => 6]) ?>
			<?= Html::activeLabel($model, 'description') ?>
			<?=
				kartik\markdown\MarkdownEditor::widget(
				[
					'name' => Html::getInputName($model,'description'), 
					'value' => $model->description,
				]);
			 ?>
			<div class="hint-block">Geben Sie hier eine beliebig lange Beschreibung für die Kampagne an, die dann auf der Infoseite der Kampagne angezeigt wird. Den Text können Sie hierbei mit der <a href="http://daringfireball.net/projects/markdown/syntax" target="_blank">Markdown-Syntax</a> formatieren. Die Überschriftsebenen 1 und 2 sollten Sie jedoch nicht nutzen, sondern nur Ebene 3 und darunter.</div>
		</div>
		</fieldset>


		<fieldset>
		<legend>Zeitrahmen</legend>
		<div class="help-block">
			Sie müssen die Kampagne zeitlich einschränken, damit die Auswahllisten bei der Zuordnung der Bilder zu einer Kampagne über diesen Zeitrahmen beschränkt werden können (sonst werden die zu groß!).
		</div>
		<?= $form->field($model, 'running_from')->widget(\yii\jui\DatePicker::className(), ['clientOptions' => ['dateFormat' => 'yy-mm-dd']])->hint('Geben Sie hier ein Anfangsdatum an. Sie können dann keine Bilder, die vor diesem Anfangsdatum aufgenommen wurden, zur Kampagne hinzufügen.') ?>

		<?= $form->field($model, 'running_until')->widget(\yii\jui\DatePicker::className(), ['clientOptions' => ['dateFormat' => 'yy-mm-dd']])->hint('Geben Sie hier ein Endedatum an. Sie können dann keine Bilder, die nach diesem Endedatum aufgenommen wurden, zur Kampagne hinzufügen.') ?>
		</fieldset>

		<fieldset>
		<legend>Örtliche Beschränkungen</legend>
		<div class="help-block">
			Sie können bald die Kampagne auch örtlich einschränken, damit die Auswahllisten bei der Zuordnung der Bilder zu einer Kampagne über diesen Ortsbereich beschränkt werden können. Derzeit ist das jedoch leider noch nicht möglich.
		</div>
		<?php /*$form->field($model, 'loc_path')->textInput() */ ?>

		</fieldset>
		<fieldset>
		<legend>Sichtbarkeit und Verfügbarkeit</legend>
		<?= $form->field($model, 'visibility_id')->dropDownList(frontend\models\Visibility::dropDownList())->hint('Derzeit wird die Sichtbarkeitssteuerung noch nicht unterstützt, sondern alle Kampagnen sind immer voll sichtbar.') ?>
		<?= $form->field($model, 'availability_id')->dropDownList(['' => '', 'public' => 'Alle Nutzer dürfen Bilder zur der Kampagne hinzufügen', 'trusted' => 'Alle vertrauenswürdige Nutzer dürfen Bilder zur der Kampagne hinzufügen', 'private' => 'Nur ich selbst darf Bilder zur Kampagne hinzufügen'])->hint('Derzeit wird die Verfügbarkeitssteuerung noch nicht unterstützt, sondern alle Kampagnen können immer von allen <b>vertrauenswürdigen</b> Nutzern genutzt werden.') ?>
		</fieldset>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
