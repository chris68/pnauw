<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var frontend\models\Campaign $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kampagnen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Bearbeiten', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
			'running_from',
			'running_until',
			[
				'label' => 'Sichtbarkeit',
				'value' => $model->visibility->name,
			],
			/*'loc_path',*/
			'created_ts',
			'modified_ts',
			'released_ts',
			'deleted_ts',
		],
	]); ?>

</div>
