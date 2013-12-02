<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var frontend\models\PictureSearch $searchModel
 */

$this->title = 'Bilder';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="picture-index">

	<h1><?= $this->title ?></h1>

	<?php echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('Create Picture', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?php echo ListView::widget([
		'dataProvider' => $dataProvider,
		'itemOptions' => ['class' => 'item'],
		'itemView' => function ($model, $key, $index, $widget) {
			return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
		},
	]); ?>

</div>
