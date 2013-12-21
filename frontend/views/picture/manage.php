<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\PictureSearch */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\bootstrap\Collapse;
use yii\widgets\ActiveForm;


$this->title = 'Bilder bearbeiten';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="picture-manage">

	<h1><?= Html::encode($this->title) ?></h1>

	<?=
		Collapse::widget([
			'items' => [
				'Suche' => [
					'content' => $this->render('_search', ['model' => $searchModel]),
				],
				'Karte' => [
					'content' => 'Hier kommt dann bald die Heatmap',
				],
			],
	   ]);
 ?>
<?php
	{
		// Generate the massupdate link by changing the route and throwing out sort/pagination
		
		$request = Yii::$app->getRequest();
		$params = $request instanceof yii\web\Request ? $request->get() : [];

		unset($params[$dataProvider->getPagination()->pageVar]);
		unset($params[$dataProvider->getSort()->sortVar]);
		$params[$dataProvider->getSort()->sortVar] = 'id';
		$route = Yii::$app->controller->getRoute();
		echo Html::a('Massenbearbeiten (alle)',Yii::$app->getUrlManager()->createUrl('picture/massupdate', $params));
	}
?>
<?php if(0) { // todo: Somehow enable the user to massupdate the selected objects ?>
	<?php ActiveForm::begin(['id' => 'picture-action-form', 'action' => ['massedit'], ]); ?>
		<?= Html::hiddenInput('selected_ids','',['id' => 'picture-action-selected-id', ]) ?>
		<div class="form-group">
			<?= Html::submitButton('Bearbeiten', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
		</div>
	<?php ActiveForm::end(); ?>

	
	<?php
	{
$script = <<<'EOT'
$('#picture-action-form').
	submit(
		function(event) {
			$('#picture-action-selected-id').val($('#picture-grid').yiiGridView('getSelectedRows'));
		}
	);
EOT;
		$this->registerJs($script, \yii\web\View::POS_READY);
	}
	?>
<?php }; ?>
	
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'layout' => "{pager}\n{summary}\n{items}\n{pager}",
	'id' => 'picture-grid',
	'filterModel' => $searchModel,
	'columns' => [
		['class' => 'yii\grid\CheckboxColumn'],
		[            
			'label'=>'Bild',
			'filter'=>false, // if you do not want to filter, set it to false
			'format'=>'raw',
			'value'=>
				/**
				 * @param frontend\models\Picture $data The displayed row
				 */
				function($data, $row) {
					return frontend\widgets\ImageRenderer::widget(
						[
							'image' => $data->SmallImage,
							'options' => ['id' => 'picture-image', 'class' => 'img-responsive'],
						]
					);
				},
		],        
		'name:ntext',
		'description:ntext',
		'taken',
		'loc_formatted_addr:ntext',
		// 'vehicle_country_code:ntext',
		'vehicle_reg_plate:ntext',
		// 'org_loc_lat',
		// 'org_loc_lng',
		// 'loc_lat',
		// 'loc_lng',
		// 'loc_path',
		// 'original_image_id',
		// 'small_image_id',
		// 'medium_image_id',
		// 'thumbnail_image_id',
		// 'blurred_small_image_id',
		// 'blurred_medium_image_id',
		// 'blurred_thumbnail_image_id',
		// 'clip_x',
		// 'clip_y',
		// 'clip_size',
		// 'visibility_id:ntext',
		// 'citation_affix:ntext',
		// 'action_id',
		// 'incident_id',
		// 'citation_id',
		// 'campaign_id',
		// 'created_ts',
		// 'modified_ts',
		// 'deleted_ts',

		['class' => 'yii\grid\ActionColumn'],
	],
]); ?>
</div>


