<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\PictureSearch */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\bootstrap\Collapse;
use yii\widgets\ActiveForm;


$this->title = 'Bilder veröffentlichen';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="picture-publish">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php 
		/* @var $form yii\widgets\ActiveForm */
		$form = ActiveForm::begin(); 
	?>
	
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'layout' => "{pager}\n{summary}\n{items}\n{pager}",
		'id' => 'picture-grid',
		// 'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\CheckboxColumn'],
			[            
				'label'=>'Bild',
				'filter'=>false,
				'format'=>'raw',
				'value'=>
					/**
					 * @param frontend\models\Picture $data The displayed row
					 */
					function($data, $row) {
						return frontend\widgets\ImageRenderer::widget(
							[
								'image' => $data->smallImage,
								'size' => 'small',
								'options' => ['id' => 'picture-image', 'class' => 'img-responsive'],
							]
						);
					},
			],        
			'name:ntext',
			'description:ntext',
			[            
				'label'=>'Sichtbarkeit',
				'filter'=>false,
				'format'=>'raw',
				'value'=>
					/**
					 * @param frontend\models\Picture $data The displayed row
					 */
					function($data, $row) {
						return 
							Html::hiddenInput("PicturePublishForm[$row][id]",$data->id).
							Html::dropDownList("PicturePublishForm[$row][visibility_id]", Yii::$app->user->checkAccess('trusted')?'public':'public_approval_pending', frontend\models\Visibility::dropDownList());
					},
			],        
		],
	]); ?>
	
	<div class="form-group">
		<?= Html::submitButton('Aktualisieren', ['class' => 'btn btn-primary']) ?>
		<?= Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
	</div>

	<?php ActiveForm::end(); ?>
</div>


