<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var frontend\models\Citation $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Anzeigen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citation-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Aktualisieren', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?php echo Html::a('Löschen', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data-confirm' => 'Sind Sie sich mit dem Löschen sicher?',
			'data-method' => 'post',
		]); ?>
	</p>

	<?php echo DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'name:ntext',
			'description:ntext',
			'created_ts',
			'modified_ts',
			'released_ts',
			'deleted_ts',
		],
	]); ?>

</div>
