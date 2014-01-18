<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\markdown\MarkdownEditor;

/**
 * @var yii\web\View $this
 * @var frontend\models\Citation $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="citation-form">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'name') ?>

		<?php // $form->field($model, 'description')->textarea(['rows' => 6]) ?>
		<div class="form-group">
			<?= Html::activeLabel($model, 'description') ?>
			<?=
				kartik\markdown\MarkdownEditor::widget(
				[
					'name' => Html::getInputName($model,'description'), 
					'value' => $model->description,
					'showExport' => false,
				]);
			 ?>
			<div class="hint-block">Den Text können sie mit der <a href="http://daringfireball.net/projects/markdown/syntax" target="_blank">Markdown syntax</a> formatieren. Sie sollten aber nur Fettmachungen, etc. einsetzen.</div>
		</div>
		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
