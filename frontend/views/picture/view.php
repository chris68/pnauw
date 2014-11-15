<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\helpers\Assist;

$this->title = 'Anzeigen von Bild: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Anzeigen';
$this->params['help'] = 'picture-view';
?>
<div class="picture-view">
	<div class="row">
		<div class="col-sm-4 col-md-4 col-lg-4">
			<p><b><?=Html::encode($model->name)?></b></p>
			<p><?=nl2br(Html::encode($model->description))?></p>
			<?= frontend\widgets\ImageRenderer::widget(
				[
					'image' => $model->blurredMediumImage,
					'size' => 'medium',
					'options' => ['class' => 'img-responsive', 'style' => 'margin-bottom:10px'],
				])
			?>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4">
			<p><?=(($model->incident_id != -1)?('<b>'.Html::encode($model->incident->name).'</b>'):'<i>Das Bild wurde leider nicht klassizifiert</i>')?></b></p>
			<p>Vorfall am <b><?=date_format(date_create($model->taken),'d.m.Y')?></b></p>
			<p><?=(($model->action_id != -1)?('<b>Maßnahme:</b> '.Html::encode($model->action->name)):'')?></p>
			<p><?=((isset($model->campaign_id))?('<b>Kampagne:</b> '.Html::a(Html::encode($model->campaign->name),['campaign/show','id' => $model->campaign_id], ['target' => '_blank'] )):'')?></p>
			<?php \frontend\views\picture\assets\PictureViewAsset::register($this); ?>
			<?= Html::activeHiddenInput($model,'loc_lat', ['id'=>'picture-map-loc-lat', ]) ?>
			<?= Html::activeHiddenInput($model,'loc_lng',['id'=>'picture-map-loc-lng', ]) ?>
			<!-- The Google maps canvas needs absolute coordinates -->
			<div style="width: 300px; height: 300px;" id="picture-map-canvas"></div>
			<p><?=(!empty($model->loc_formatted_addr)?Html::encode($model->loc_formatted_addr):'<i>Der Ort wurde leider noch nicht ermittelt</i>')?></p>
		</div>
	</div>
</div>
