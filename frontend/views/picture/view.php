<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Anzeigen von Bild: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="picture-view">
	<div class="row">
		<div class="col-sm-4 col-md-4 col-lg-4">
			<p><b><?=Html::encode($model->name)?></b></p>
			<p><?=(($model->incident_id != -1)?Html::encode($model->incident->name):'Das Bild wurde leider nicht klassizifiert')?></p>
			<?= frontend\widgets\ImageRenderer::widget(
				[
					'image' => $model->blurredMediumImage,
					'size' => 'medium',
					'options' => ['class' => 'img-responsive', 'style' => 'margin-bottom:10px'],
				])
			?>
			<p>Vorfall am <?=date_format(date_create($model->taken),'d.m.Y')?></p>
			<p><?=Html::encode($model->description)?></p>
			<p><?=Html::encode($model->loc_formatted_addr)?></p>
		</div>
	</div>
</div>
