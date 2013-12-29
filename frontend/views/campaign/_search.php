<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var frontend\models\CampaignSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="campaign-search">

	<?php $form = ActiveForm::begin([
		'method' => 'get',
	]); ?>

		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'description') ?>

		<?= $form->field($model, 'running_from') ?>

		<?= $form->field($model, 'running_until') ?>

		<?= $form->field($model, 'visibility_id') ?>

		<?php // echo $form->field($model, 'loc_path') ?>

		<?php // echo $form->field($model, 'created_ts') ?>

		<?php // echo $form->field($model, 'modified_ts') ?>

		<?php // echo $form->field($model, 'released_ts') ?>

		<?php // echo $form->field($model, 'deleted_ts') ?>

		<div class="form-group">
			<?= Html::submitButton('Suchen', ['class' => 'btn btn-primary']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
