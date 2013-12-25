<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\PictureSearch */

use yii\helpers\Html;
use yii\grid\GridView;
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
					'content' => 'Hier kommt dann bald die Heatmap',
				],
			],
	   ]);
 ?>
	<?= ListView::widget([
		'dataProvider' => $dataProvider,
		'layout' => "{pager}\n{summary}\n{items}\n{pager}",
		'id' => 'picture-list',
		// 'itemOptions' => ['class' => 'item'],
		'itemView' => function ($model, $key, $index, $widget) {
			return
			'<div class="row" style="margin:10px">
				<div class="col-lg-3">
			'
			.
					frontend\widgets\ImageRenderer::widget(
						[
							'image' => $model->blurredSmallImage,
							'size' => 'small',
							'options' => ['class' => 'img-responsive'],
						]
					)
			.
			'	</div>
				<div class="col-lg-3">'
			.
					Html::encode($model->name)
			.
			'<br>'
			.
					Html::encode($model->description)
			.
			'	</div>
			</div>
			';
		},
	]); ?>
	</div>
</div>