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

use yii\widgets\DetailView;

?>

<div class=	"row">
	<div class ="col-lg-6">

		<?=

		DetailView::widget(
			[
				'model' => $model,
				'attributes' => [
					'taken',
					'name',
					'description',
					[
						'label' => 'Kennzeichen',
						'value' => $model->vehicle_reg_plate . ($model->vehicleCountryCode ? (' [' . $model->vehicleCountryCode->name . ']') : ''),
					],
					[
						'label' => 'Vorfall',
						'value' => ($model->incident)?$model->incident->name:'(nicht gesetzt)',
					],
					[
						'label' => 'Maßnahme',
						'value' => ($model->action)?$model->action->name:'(nicht gesetzt)',
					],
					[
						'label' => 'Kampagne',
						'value' => ($model->campaign)?$model->campaign->name:'(nicht gesetzt)',
					],
					[
						'label' => 'Anzeige',
						'value' => ($model->citation)?$model->citation->name:'(nicht gesetzt)',
					],
					'loc_path',
					'loc_formatted_addr',
					[
						'label' => 'GPS (relevant)',
						'value' => $model->getLatLng(),
					],
					[
						'label' => 'GPS (original)',
						'value' => $model->getOrgLatLng(),
					],
					[
						'label' => 'Sichtbarkeit',
						'value' => ($model->visibility)?$model->visibility->name:'(nicht gesetzt)',
					],
					'created_ts',
					'modified_ts',
				]
			]
		);
		?>
	</div>
</div>

