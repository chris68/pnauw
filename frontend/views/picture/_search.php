<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var frontend\models\PictureSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="picture-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'owner_id') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'description') ?>

		<?= $form->field($model, 'taken') ?>

		<?php // echo $form->field($model, 'org_loc_lat') ?>

		<?php // echo $form->field($model, 'org_loc_lng') ?>

		<?php // echo $form->field($model, 'loc_lat') ?>

		<?php // echo $form->field($model, 'loc_lng') ?>

		<?php // echo $form->field($model, 'loc_path') ?>

		<?php // echo $form->field($model, 'loc_formatted_addr') ?>

		<?php // echo $form->field($model, 'original_image_id') ?>

		<?php // echo $form->field($model, 'small_image_id') ?>

		<?php // echo $form->field($model, 'medium_image_id') ?>

		<?php // echo $form->field($model, 'thumbnail_image_id') ?>

		<?php // echo $form->field($model, 'blurred_small_image_id') ?>

		<?php // echo $form->field($model, 'blurred_medium_image_id') ?>

		<?php // echo $form->field($model, 'blurred_thumbnail_image_id') ?>

		<?php // echo $form->field($model, 'clip_x') ?>

		<?php // echo $form->field($model, 'clip_y') ?>

		<?php // echo $form->field($model, 'clip_size') ?>

		<?php // echo $form->field($model, 'visibility_id') ?>

		<?php // echo $form->field($model, 'vehicle_country_code') ?>

		<?php // echo $form->field($model, 'vehicle_reg_plate') ?>

		<?php // echo $form->field($model, 'citation_affix') ?>

		<?php // echo $form->field($model, 'action_id') ?>

		<?php // echo $form->field($model, 'incident_id') ?>

		<?php // echo $form->field($model, 'citation_id') ?>

		<?php // echo $form->field($model, 'campaign_id') ?>

		<?php // echo $form->field($model, 'created_ts') ?>

		<?php // echo $form->field($model, 'modified_ts') ?>

		<?php // echo $form->field($model, 'deleted_ts') ?>

		<div class="form-group">
			<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
