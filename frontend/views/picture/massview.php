<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\PictureSearch */

use yii\widgets\ListView;

?>
<div class="picture-massupdate">

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

</div>


