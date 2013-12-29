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

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'owner_id')->textInput() ?>

		<?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'visibility_id')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'loc_path')->textInput() ?>

		<?= $form->field($model, 'created_ts')->textInput() ?>

		<?= $form->field($model, 'modified_ts')->textInput() ?>

		<?= $form->field($model, 'released_ts')->textInput() ?>

		<?= $form->field($model, 'deleted_ts')->textInput() ?>

		<?= $form->field($model, 'running_from')->textInput() ?>

		<?= $form->field($model, 'running_until')->textInput() ?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
