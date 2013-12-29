<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\Collapse;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var frontend\models\CampaignSearch $searchModel
 */

$this->title = 'Kampagnen';
$this->params['breadcrumbs'][] = ['label' => 'Kampagnen', 'url' => ['index']];
?>
<div class="campaign-index">

	<h1><?= Html::encode($this->title) ?></h1>

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

	<p>
		<?= Html::a('Kampagne anlegen', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?php echo ListView::widget([
		'dataProvider' => $dataProvider,
		'itemOptions' => ['class' => 'item'],
		'itemView' => function ($model, $key, $index, $widget) {
			return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
		},
	]); ?>

</div>
