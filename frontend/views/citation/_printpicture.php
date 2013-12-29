<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<div class="picture-print">
	<div class="row">
	<div class="col-sm-10 col-md-10 col-lg-10">
	
	<h1 style="page-break-before: always;">
		<?=Html::encode($model->vehicle_reg_plate.' / '.date_format(date_create($model->taken),'d.m.Y'))?>
					
	</h1>
		<?php \frontend\views\picture\assets\PicturePrintAsset::register($this); ?>
		<?=

		DetailView::widget(
			[
				'model' => $model,
				'attributes' => [
					'taken',
					[
						'label' => 'Kennzeichen',
						'value' => $model->vehicle_reg_plate,
					],
					[
						'label' => 'Kennzeichen (Ausschnitt)',
						'value' => 	"<canvas data-image-id='picture-image-{$model->id}' data-clip-x='{$model->clip_x}' data-clip-y='{$model->clip_y}' data-clip-size='{$model->clip_size}' style='width:300px; heigth:200px;'>",
						'format' => 'raw',
					],
					[
						'label' => 'Vorfall',
						'value' => $model->incident->name,
					],
					[
						'label' => 'Maßnahme',
						'value' => $model->action->name,
					],
					'citation_affix',
					'loc_formatted_addr',
					[
						'label' => 'GPS (Korrigiert)',
						'value' => $model->getLatLng(),
					],
					[
						'label' => 'GPS (Original)',
						'value' => $model->getOrgLatLng(),
					],
					'created_ts',
					'modified_ts',
				]
			]
		);
		?>
		<?=
		frontend\widgets\ImageRenderer::widget(
			[
				'image' => $model->originalImage,
				'size' => 'medium',
				'options' => ['class'=>'img-responsive', 'style'=>'page-break-before: always;', 'id' => 'picture-image-'.$model->id],
			]
		)
		?>
	</div>
	</div>

</div>
