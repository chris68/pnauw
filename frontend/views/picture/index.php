<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\PictureSearch */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\Collapse;
use yii\widgets\ActiveForm;


$this->title = 'Bilder';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="picture-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<?=
		Collapse::widget([
			'items' => [
				'Suchen und Filtern' => [
					'content' => $this->render('_search', ['model' => $searchModel]),
				],
				'Karte' => [
					'content' => '',
				],
			],
	   ]);
	?>

	<?= $this->render('_heatmap', ['dataProvider' => $dataProvider]) ?>
	
	<?= ListView::widget([
		'dataProvider' => $dataProvider,
		'layout' => "{pager}\n{summary}\n{items}\n{pager}",
		'id' => 'picture-list',
		'itemView' => function ($model, $key, $index, $widget) {
			return
			'<div class="row">
				<div class="col-sm-4 col-md-4 col-lg-4">'
			.
				'<hr>'
			.
				'<p><b>'
			.
				Html::encode($model->name)
			.
				'</p></b>'
			.
				'<p>'
			.
				Html::encode($model->incident->name)
			.
				'</p>'
			.
					frontend\widgets\ImageRenderer::widget(
						[
							'image' => $model->blurredSmallImage,
							'size' => 'small',
							'options' => ['class' => 'img-responsive', 'style' => 'margin-bottom:10px'],
						]
					)
			.
				'<p>'
			.
				Html::encode($model->description)
			.
				'</p>'
			.
				'<hr>'
			.
				'</div>'
			.
			'</div>'
			;
		},
	]); ?>
</div>