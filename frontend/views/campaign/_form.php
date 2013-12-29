<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var frontend\models\Campaign $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="campaign-form">

<?php
/* See https://github.com/chris68/pnauw/issues/34
use kartik\markdown\MarkdownEditor;
// Works
$value1 = 'Hallo';
echo MarkdownEditor::widget([
	'name' => 'markdown1', 
	'value' => $value1,
]);
*/
?>

	
	<?php $form = ActiveForm::begin(); ?>

<?php
/* 
// Does not work
$value2 = 'Hallo';
echo MarkdownEditor::widget([
	'name' => 'markdown2', 
	'value' => $value2,
]);
 */
 ?>
		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'visibility_id')->dropDownList(frontend\models\Visibility::dropDownList()) ?>

		<?php /*$form->field($model, 'loc_path')->textInput() */ ?>

		<?= $form->field($model, 'running_from')->widget(\yii\jui\DatePicker::className(), ['clientOptions' => ['dateFormat' => 'yy-mm-dd']]) ?>

		<?= $form->field($model, 'running_until')->widget(\yii\jui\DatePicker::className(), ['clientOptions' => ['dateFormat' => 'yy-mm-dd']]) ?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
