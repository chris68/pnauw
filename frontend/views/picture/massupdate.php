<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\PictureSearch */
/* @var $updatedmodel frontend\models\Picture */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\Collapse;

?>
<div class="picture-massupdate">

	<?=
		Collapse::widget([
			'items' => [
				'Suchen und Filtern  <span class="badge">'.$searchModel->getFilterStatus().'</span>'  => [
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
		'itemView' => function ($model, $key, $index, $widget) use ($updatedmodel) {
			return $this->render('update', [
				'model' => isset($updatedmodel)?$updatedmodel:$model,
			]);
		},
	]); 
	?>
	
	<?php
		// Need to override the help setting from the detail update
		$this->params['help'] = 'picture-massupdate';
	?>
</div>


