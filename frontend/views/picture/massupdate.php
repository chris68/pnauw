<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\PictureSearch */
/* @var $updatedmodel frontend\models\Picture */

use yii\helpers\Html;
use yii\widgets\ListView;

?>
<div class="picture-massupdate">

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

</div>


