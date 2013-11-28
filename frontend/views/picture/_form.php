<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var frontend\models\Picture $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="picture-form">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'owner_id')->textInput() ?>

		<?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'taken')->textInput() ?>

		<?= $form->field($model, 'clip_x')->textInput() ?>

		<?= $form->field($model, 'clip_y')->textInput() ?>

		<?= $form->field($model, 'clip_size')->textInput() ?>

		<?= $form->field($model, 'visibility_id')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'original_image_id')->textInput() ?>

		<?= $form->field($model, 'small_image_id')->textInput() ?>

		<?= $form->field($model, 'medium_image_id')->textInput() ?>

		<?= $form->field($model, 'thumbnail_image_id')->textInput() ?>

		<?= $form->field($model, 'blurred_small_image_id')->textInput() ?>

		<?= $form->field($model, 'blurred_medium_image_id')->textInput() ?>

		<?= $form->field($model, 'blurred_thumbnail_image_id')->textInput() ?>

		<?= $form->field($model, 'action_id')->textInput() ?>

		<?= $form->field($model, 'incident_id')->textInput() ?>

		<?= $form->field($model, 'citation_id')->textInput() ?>

		<?= $form->field($model, 'campaign_id')->textInput() ?>

		<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'org_loc_lat')->textInput() ?>

		<?= $form->field($model, 'org_loc_lng')->textInput() ?>

		<?= $form->field($model, 'loc_lat')->textInput() ?>

		<?= $form->field($model, 'loc_lng')->textInput() ?>

		<?= $form->field($model, 'loc_path')->textInput() ?>

		<?= $form->field($model, 'loc_formatted_addr')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'vehicle_country_code')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'vehicle_reg_plate')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'citation_affix')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'created_ts')->textInput() ?>

		<?= $form->field($model, 'modified_ts')->textInput() ?>

		<?= $form->field($model, 'deleted_ts')->textInput() ?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
