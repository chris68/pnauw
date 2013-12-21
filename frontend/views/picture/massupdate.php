<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\PictureSearch */
/* @var $updatedmodel frontend\models\Picture */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;


$this->title = 'Massenbearbeitung';
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['manage', 'sort'=>'modified_ts-desc']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="picture-massupdate">

	<?= ListView::widget([
		'dataProvider' => $dataProvider,
		'layout' => "{pager}\n{items}",
		'itemView' => function ($model, $key, $index, $widget) use ($updatedmodel) {
			return $this->render('_formtabbed', [
				'model' => isset($updatedmodel)?$updatedmodel:$model,
			]);
		},
	]); 
	?>

</div>


