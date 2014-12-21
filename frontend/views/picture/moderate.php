<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\PictureSearch */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\Collapse;
use yii\bootstrap\ActiveForm;


$this->title = 'Bilder moderieren';
$this->params['breadcrumbs'][] = $this->title;
$this->params['help'] = 'picture-moderate';
?>
<div class="picture-moderate">

	<h1><?= Html::encode($this->title) ?></h1>

	<?=
		Collapse::widget([
			'items' => [
				[
					'label' => '<span class="glyphicon glyphicon-collapse-down"></span> Suchen und Filtern <span class="badge">'.$searchModel->getFilterStatus().'</span>' ,
					'encode' => false,
					'content' => $this->render('_search', ['model' => $searchModel]),
				],
			],
			'options' => 
			[
				'style' => 'margin-bottom: 10px'
			],
	   ]);
	?>
	
	<?= $this->render('_quicksearchbar') ?>
	
	<?= $this->render('_heatmap', ['private' => 0]) ?>
	
	<?php 
		/* @var $form yii\bootstrap\ActiveForm */
		$form = ActiveForm::begin(); 
	?>
	
	<?= ListView::widget([
		'dataProvider' => $dataProvider,
		'layout' => "{pager}\n{summary}\n{items}\n{pager}",
		'itemView' => function ($model, $key, $index, $widget) use ($form) {
			return
			'<div class="row">
				<div class="col-sm-4 col-md-4 col-lg-4">'
			.
				'<hr>'
			.
				'<p><b>'
			.
				Html::encode($model->name)
			.
				'</b></p>'
			.
					frontend\widgets\ImageRenderer::widget(
						[
							'image' => $model->blurredSmallImage,
							'size' => 'small',
							'options' => ['class' => 'img-responsive', 'style' => 'margin-bottom:10px'],
						]
					)
			.
				'<p>'
			.
				nl2br(Html::encode($model->description))
			.
				'</p>'
			.
				'<p>'
			.
				(!empty($model->loc_formatted_addr)?Html::encode($model->loc_formatted_addr):'<i>Der Ort wurde leider noch nicht ermittelt</i>')
			.
				'</p>'
			.
				'<p>'
			.
				Html::a('Details', ['picture/view','id'=>$model->id], ['target' => '_blank'])
			.
				'</p>'
			.
				'<p class="form-group">'
			.
					Html::dropDownList("PictureModerateForm[$key][visibility_id]", 'public', frontend\models\Visibility::dropDownList())
			.
				'</p>'
			.
				'<hr>'
			.
			'	</div>
			</div>'
			;
		},
	]); ?>
	
	<div class="form-group">
		<?= Html::submitButton('Aktualisieren', ['class' => 'btn btn-primary']) ?>
		<?= Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
	</div>

	<?php ActiveForm::end(); ?>
</div>


