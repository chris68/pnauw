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

	<div class ="col-lg-4">
		<?php $form = ActiveForm::begin(); ?>
		
		<?= $form->field($model, 'owner_id')->textInput() ?>

		<?= $form->field($model, 'name')->textInput() ?>

		<?= $form->field($model, 'taken')->widget(\yii\jui\DatePicker::className(), ['clientOptions' => ['dateFormat' => 'yy-mm-dd']]) ?>

		<?= $form->field($model, 'clip_x')->textInput() ?>

		<?= $form->field($model, 'clip_y')->textInput() ?>

		<?= $form->field($model, 'clip_size')->textInput() ?>

		<?= $form->field($model, 'visibility_id')->dropDownList(frontend\models\Visibility::dropDownList()) ?>

		<?= $form->field($model, 'original_image_id')->textInput() ?>

		<?= $form->field($model, 'small_image_id')->textInput() ?>

		<?= $form->field($model, 'medium_image_id')->textInput() ?>

		<?= $form->field($model, 'thumbnail_image_id')->textInput() ?>

		<?= $form->field($model, 'blurred_small_image_id')->textInput() ?>

		<?= $form->field($model, 'blurred_medium_image_id')->textInput() ?>

		<?= $form->field($model, 'blurred_thumbnail_image_id')->textInput() ?>

		<?= $form->field($model, 'action_id')->dropDownList(frontend\models\Action::dropDownList()) ?>

		<?= $form->field($model, 'incident_id')->dropDownList(frontend\models\Incident::dropDownList()) ?>

		<?= $form->field($model, 'citation_id')->dropDownList(frontend\models\Citation::dropDownList()) ?>

		<?= $form->field($model, 'campaign_id')->dropDownList(frontend\models\Campaign::dropDownList()) ?>

		<?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

		<?= $form->field($model, 'org_loc_lat')->textInput() ?>

		<?= $form->field($model, 'org_loc_lng')->textInput() ?>

		<?= $form->field($model, 'loc_lat')->textInput() ?>

		<?= $form->field($model, 'loc_lng')->textInput() ?>

		<?= $form->field($model, 'loc_path')->textInput() ?>

		<?= $form->field($model, 'loc_formatted_addr')->textarea(['rows' => 3]) ?>

		<?= $form->field($model, 'vehicle_country_code')->dropDownList(frontend\models\VehicleCountry::dropDownList()) ?>

		<?= $form->field($model, 'vehicle_reg_plate')->textInput() ?>

		<?= $form->field($model, 'citation_affix')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'created_ts')->textInput() ?>

		<?= $form->field($model, 'modified_ts')->textInput() ?>

		<?= $form->field($model, 'deleted_ts')->textInput() ?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			<?= Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>
