<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var frontend\models\CitationSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="citation-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'owner_id') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'description') ?>

		<?= $form->field($model, 'created_ts') ?>

		<?php // echo $form->field($model, 'modified_ts') ?>

		<?php // echo $form->field($model, 'released_ts') ?>

		<?php // echo $form->field($model, 'deleted_ts') ?>

		<div class="form-group">
			<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
