<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\PictureSearch */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="picture-search">

	<div class ="col-md-4">
	<?php 
		/** @var yii\widgets\ActiveForm $form */
		$form = ActiveForm::begin([
		'method' => 'get',
	]); ?>
	
		<?= $form->field($model, 'id') ?>

		<?= $model->scenario == 'admin'?$form->field($model, 'owner_id'):'' ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'description') ?>

		<?php if ($model->scenario == 'private' || $model->scenario == 'admin' ): ?>
			<?= $form->field($model, 'taken')->widget(\yii\jui\DatePicker::className(), ['clientOptions' => ['dateFormat' => 'yy-mm-dd']]) ?>

			<?= $form->field($model, 'loc_formatted_addr') ?>
		
			<?= $form->field($model, 'created_ts')->widget(\yii\jui\DatePicker::className(), ['clientOptions' => ['dateFormat' => 'yy-mm-dd']]) ?>

			<?= $form->field($model, 'modified_ts')->widget(\yii\jui\DatePicker::className(), ['clientOptions' => ['dateFormat' => 'yy-mm-dd']]) ?>

			<?= $form->field($model, 'visibility_id')->dropDownList(frontend\models\Visibility::dropDownList()) ?>

			<?= $form->field($model, 'action_id')->dropDownList(frontend\models\Action::dropDownList()) ?>

			<?= $form->field($model, 'incident_id')->dropDownList(frontend\models\Incident::dropDownList()) ?>

			<?= $form->field($model, 'citation_id')->dropDownList(frontend\models\Citation::dropDownList()) ?>

			<?= $form->field($model, 'campaign_id')->dropDownList(frontend\models\Campaign::dropDownList()) ?>

			<?= $form->field($model, 'vehicle_country_code')->dropDownList(frontend\models\VehicleCountry::dropDownList()) ?>

			<?= $form->field($model, 'vehicle_reg_plate')->textInput() ?>
		<?php endif; ?>

		<div class="form-group">
			<?= Html::submitButton('Suchen', ['class' => 'btn btn-primary']) ?>
			<?= ''// @Todo: Implement reset of search Html::resetButton('Suche zurücksetzen', ['class' => 'btn btn-default']) ?>
		</div>
		
		<p class="help-block">
			Die Suche ist eine Teiltextsuche, bei der zwischen Groß- und Kleinschreibung unterschieden wird.<br>Eine Suche nach <em>straße</em> findet also <em>Kriegsstraße</em>, aber nicht <em>Straße des 17.Juni</em>
		</p>

	<?php ActiveForm::end(); ?>
	</div>
</div>
