<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\PictureSearch */

use yii;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\Collapse;


$this->title = 'Bilder';
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['index']];
?>
<div class="picture-index">

	<?=
		Collapse::widget([
			'items' => [
				'Suchen und Filtern <span class="badge">'.$searchModel->getFilterStatus().'</span>' => [
					'content' => $this->render('_search', ['model' => $searchModel]),
				],
			],
			'options' => 
			[
				'style' => 'margin-bottom: 10px'
			],
	   ]);
	?>

	<?= $this->render('_quicksearchbar') ?>
	
	<?= $this->render('_heatmap', ['private' => 0]) ?>
	
	<div style="margin-top: 10px;">
	<?php
		{
			// Generate the massview link by changing the route and throwing out sort/pagination

			$request = Yii::$app->getRequest();
			$params = $request instanceof yii\web\Request ? $request->get() : [];

			unset($params[$dataProvider->getPagination()->pageVar]);
			unset($params[$dataProvider->getSort()->sortVar]);
			$params[$dataProvider->getSort()->sortVar] = 'id';
			$route = Yii::$app->controller->getRoute();
			echo Html::a('Im Detail anschauen', Yii::$app->getUrlManager()->createUrl('picture/massview', $params), ['target' => '_blank']);
			if (!Yii::$app->user->isGuest) {
				echo ' | '.Html::a('Im Detail bearbeiten', Yii::$app->getUrlManager()->createUrl('picture/massupdate', $params), ['target' => '_blank']);
			}
		}
	?>
	</div>
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
				'</b></p>'
			.
				Html::encode($model->description)
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
				Html::a('Detail', ['picture/view','id'=>$model->id], ['target' => '_blank'])
			.
				((yii::$app->user->checkAccess('isObjectOwner', array('model' => $model)))?(' | '.Html::a('Bearbeiten', ['picture/update','id'=>$model->id], ['target' => '_blank'])):'')
			.
				'<p>'
			.
				(($model->incident_id != -1)?('<b>'.Html::encode($model->incident->name).'</b>'):'<i>Das Bild wurde leider nicht klassizifiert</i>')
			.
				'</b></p><p>'
			.
					'Vorfall am <b>'.date_format(date_create($model->taken),'d.m.Y').'</b>'
			.
				'<p>'
			.
				(($model->action_id != -1)?('<b>Maßnahme:</b> '.Html::encode($model->action->name)):'')
			.
				'</p><p>'
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