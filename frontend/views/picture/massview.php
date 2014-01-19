<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\PictureSearch */

use yii\widgets\ListView;
use yii\bootstrap\Collapse;

?>
<div class="picture-massview">

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

	<?= ListView::widget([
		'dataProvider' => $dataProvider,
		'layout' => "{pager}\n{items}",
		'itemView' => function ($model, $key, $index, $widget)  {
			return $this->render('view', [
				'model' => $model,
			]);
		},
	]); 
	?>

	<?php
		// Need to override the help setting from the detail view
		$this->params['help'] = 'picture-massview';
	?>
</div>


