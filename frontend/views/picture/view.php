<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var frontend\models\Picture $model
 */

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="picture-view">

	<h1><?= $this->title ?></h1>

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
			'taken',
			'org_loc_lat',
			'org_loc_lng',
			'loc_lat',
			'loc_lng',
			'loc_path',
			'loc_formatted_addr:ntext',
			'original_image_id',
			'small_image_id',
			'medium_image_id',
			'thumbnail_image_id',
			'blurred_small_image_id',
			'blurred_medium_image_id',
			'blurred_thumbnail_image_id',
			'clip_x',
			'clip_y',
			'clip_size',
			'visibility_id:ntext',
			'vehicle_country_code:ntext',
			'vehicle_reg_plate:ntext',
			'citation_affix:ntext',
			'action_id',
			'incident_id',
			'citation_id',
			'campaign_id',
			'created_ts',
			'modified_ts',
			'deleted_ts',
		],
	]); ?>

</div>
