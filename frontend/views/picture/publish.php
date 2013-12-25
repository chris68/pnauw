<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\PictureSearch */

use yii\helpers\Html;
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
	
	<?= ListView::widget([
		'dataProvider' => $dataProvider,
		'layout' => "{pager}\n{summary}\n{items}\n{pager}",
		'itemView' => function ($model, $key, $index, $widget) use ($form) {
			return
			'<hr>'
			.
			'<div class="row">
				<div class="col-sm-4 col-md-4 col-lg-4">'
			.
				'<p><b>'
			.
				Html::encode($model->name)
			.
				'</p></b>'
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
				Html::encode($model->description)
			.
				'</p>'
			.
				'<p class="form-group">'
			.
					Html::dropDownList("PicturePublishForm[$key][visibility_id]", Yii::$app->user->checkAccess('trusted')?'public':'public_approval_pending', frontend\models\Visibility::dropDownList())
			.
				'</p>'
			.
			'	</div>
			</div>
			'
			.
			'<hr>'
			;
		},
	]); ?>
	
	<div class="form-group">
		<?= Html::submitButton('Aktualisieren', ['class' => 'btn btn-primary']) ?>
		<?= Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
	</div>

	<?php ActiveForm::end(); ?>
</div>


