<?php
/* @var $this yii\web\View  */
/* @var $model frontend\models\Picture  */
/* @var $form yii\widgets\ActiveForm  */

use \yii\helpers\Html;

?>
<div class="row">
	<div class="col-lg-3">
		<?= $form->field($model, 'incident_id')->dropDownList(frontend\models\Incident::dropDownList()) ?>
		<?= $form->field($model, 'action_id')->dropDownList(frontend\models\Action::dropDownList()) ?>
		<?= $form->field($model, 'citation_id')->dropDownList(frontend\models\Citation::dropDownList()) ?>
		<?= $form->field($model, 'vehicle_country_code')->dropDownList(frontend\models\VehicleCountry::dropDownList()) ?>
		<?= $form->field($model, 'vehicle_reg_plate')->textInput() ?>
	</div>

	<div class ="col-lg-3">
		<div>
			<div class="form-group">
			<?= Html::label('Bildausschnitt (Nummernschild)','picture-clip-canvas') ?>
			<canvas id="picture-clip-canvas" class="img-responsive" style = "margin-bottom: 7px;">
			<?php
				$this->registerJs("updatePictureClipCanvas();", \yii\web\View::POS_READY);
			?>
			</div>
			<!-- Hidden fields are not reset upon a form reset; therefore, we need to use normal fields which we hide -->
			<?= Html::activeInput('text', $model, 'clip_x', ['id'=>'picture-clip-x', 'style' => 'display:none', ]) ?>
			<?= Html::activeInput('text', $model, 'clip_y', ['id'=>'picture-clip-y', 'style' => 'display:none', ]) ?>
			<div class="form-group">
			<?= Html::label('Zoom') ?>
			<!-- A range field seems not to be reset upon a form reset; but what can we do? -->
			<?= Html::activeInput('range', $model, 'clip_size', ['id'=>'picture-clip-size', 'min' => 5, 'max' => 70, ]) ?>
			</div>
			<?= $form->field($model,'citation_affix')->textarea(['rows' => 5, 'placeholder' => 'Hier können sie weitere Angaben für eine potentielle Anzeige machen (Nicht öffentlich, sondern nur für den Empfänger der Anzeige)']) ?>
		</div>
	</div>
	
	<div class="col-lg-3">
		<?=
		frontend\widgets\ImageRenderer::widget(
			[
				'image' => $model->mediumImage,
				'size' => 'medium',
				'options' => ['id' => 'picture-image', 'class' => 'img-responsive'],
			]
		);
		?>
	</div>
</div>

