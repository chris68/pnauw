<?php
/* @var $this \yii\web\View */
/* @var $model frontend\models\Picture */
/* @var $form yii\widgets\ActiveForm */

use yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use frontend\widgets\Alert;
?>

<div class="picture-form">
	<?php $form = ActiveForm::begin(); ?>
	
	<?= Html::activeHiddenInput($model, 'id' ) ?>

	<?= $form->errorSummary($model,['class' => "alert alert-danger"]);?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?= Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
	</div>

	<div>
		<?=
		// http://stackoverflow.com/questions/1428178/problems-with-google-maps-api-v3-jquery-ui-tabs        
		// It is important, that google maps is initialized when the tab is open!

		Tabs::widget(
			[
				'id' => 'picture-tabs',
				'items' => [
					[
						'label' => 'Übersicht',
						'content' => $this->render('_overviewtab', array('model'=>$model)),
						'headerOptions' => ['id' => 'picture-tab-overview'],
					 ],
					[
						'label' => 'Grunddaten',
						'content' => $this->render('_datatab', array('model'=>$model,'form'=>$form)),
						'headerOptions' => ['id' => 'picture-tab-data'],
					 ],
					[
						'label' => 'Karte & Ortsdaten',
						'content' => $this->render('_maptab', array('model'=>$model,'form'=>$form)),        
						'headerOptions' => ['id' => 'picture-tab-map'],
					 ],
					[
						'label' => 'Bild & Kfz-/Vorfallsdaten',
						'content' => $this->render('_imagetab', array('model'=>$model,'form'=>$form)),        
						'headerOptions' => ['id' => 'picture-tab-image'],
						'active' => true,
					 ],        
				],
				'itemOptions' => [
					'style' => 'margin-top:10px; margin-bottom:10px;',
				]
			]
		);
		?>
	</div>

	<?php ActiveForm::end(); ?>
	
	<?php \frontend\views\picture\assets\PictureUpdateAsset::register($this); ?>
</div>
