<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var frontend\models\Campaign $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?php echo Html::a('Delete', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data-confirm' => Yii::t('app', 'Are you sure to delete this item?'),
			'data-method' => 'post',
		]); ?>
	</p>

	<?php echo DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'owner_id',
			'name:ntext',
			'description:ntext',
			'running_from',
			'running_until',
			'visibility_id:ntext',
			'loc_path',
			'created_ts',
			'modified_ts',
			'released_ts',
			'deleted_ts',
		],
	]); ?>

</div>
