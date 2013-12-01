<?php
/**
 * @var yii\web\View $this
 * @var frontend\models\Picture $model
 * @var yii\widgets\ActiveForm $form
 */
if (0) {	
	$form = new yii\widgets\ActiveForm();
	$model = new frontend\models\Picture();
}

use \yii\helpers\Html;

?>
<div class="row">
	<div class ="col-lg-3">
		<div class ="form-group">
			<?= $form->field($model, 'incident_id')->dropDownList(frontend\models\Incident::dropDownList()) ?>
			<?= $form->field($model, 'action_id')->dropDownList(frontend\models\Action::dropDownList()) ?>
			<?= $form->field($model, 'citation_id')->dropDownList(frontend\models\Citation::dropDownList()) ?>
			<?= $form->field($model, 'vehicle_country_code')->dropDownList(frontend\models\VehicleCountry::dropDownList()) ?>
			<?= $form->field($model, 'vehicle_reg_plate')->textInput() ?>
		</div>
	</div>

	<div class ="col-lg-3">
		<div class ="form-group">
			<div>
				<?= Html::label('Bildausschnitt (Nummernschild)','picture-clip-canvas') ?>
				<canvas id="picture-clip-canvas" class="img-responsive">
				<?php
					$this->registerJs("updatePictureClipCanvas();", \yii\web\View::POS_READY);
				?>
			</div>
			<?= Html::label('Zoom','picture-clip-size_slider') ?>
			<!-- Hidden fields are not reset upon a form reset; therefore, we need to use normal fields which we hide -->
			<?= Html::activeInput('text', $model, 'clip_x', ['id'=>'picture-clip-x', 'style' => 'display:none', ]) ?>
			<?= Html::activeInput('text', $model, 'clip_y', ['id'=>'picture-clip-y', 'style' => 'display:none', ]) ?>
			<?php
				// @Todo: See whether Yii fixes it
				// See https://github.com/yiisoft/yii2/pull/1213. https://github.com/yiisoft/yii2/issues/735
				//$form->field($model,'clip_x')->hiddenInput(['id'=>'picture-clip-x', ]) 
				//$form->field($model,'clip_y')->hiddenInput(['id'=>'picture-clip-y', ]) 
			?>
			<?=	\frontend\widgets\SliderInput::widget( 
					[
						'model'=> $model,
						'attribute' => 'clip_size',
						'id'=>'picture-clip-size',
						// additional javascript options for the slider plugin
						'clientOptions'=> [
							'orientation'=>"horizontal",
							'min'=>5,
							'max'=>70,
							'value'=>$model->clip_size,
						],
						'options'=> [
						]
					]
				);
			?>
			<?= $form->field($model,'citation_affix')->textarea(['rows' => 5, 'placeholder' => 'Hier können sie weitere Angaben für eine potentielle Anzeige machen (nicht öffentlich, sondern nur für den Empfänger der Anzeige)']) ?>
		</div>
	</div>
	
	<div class ="col-lg-3">
		<?=
		frontend\widgets\ImageRenderer::widget(
			[
				'image' => $model->originalImage,
				'options' => ['id' => 'picture-image', 'class' => 'img-responsive'],
			]
		);
		?>
	</div>
</div>

