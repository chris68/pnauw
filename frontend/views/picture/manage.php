<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\PictureSearch */

use yii\helpers\Html;
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
				'Suchen und Filtern' => [
					'content' => $this->render('_search', ['model' => $searchModel]),
				],
			],
	   ]);
 ?>
	
<?= $this->render('_heatmap', ['private' => 1]) ?>
	
<div style="margin-top: 10px;">
<?php
	{
		// Generate the massupdate link by changing the route and throwing out sort/pagination
		
		$request = Yii::$app->getRequest();
		$params = $request instanceof yii\web\Request ? $request->get() : [];

		unset($params[$dataProvider->getPagination()->pageVar]);
		unset($params[$dataProvider->getSort()->sortVar]);
		$params[$dataProvider->getSort()->sortVar] = 'id';
		$route = Yii::$app->controller->getRoute();
		// todo: Somehow enable the user to massupdate the selected objects only
		echo Html::a('Bilder einzeln bearbeiten', Yii::$app->getUrlManager()->createUrl('picture/massupdate', $params), ['target' => '_blank']);
		echo ' | ';
		echo Html::a('Bilder veröffentlichen', Yii::$app->getUrlManager()->createUrl('picture/publish', $params), ['target' => '_blank']);
	}
?>
</div>
	
	<?php 
		/* @var $form yii\widgets\ActiveForm */
		$form = ActiveForm::begin(); 
	?>

	<?= ListView::widget([
		'dataProvider' => $dataProvider,
		'layout' => "{pager}\n{summary}\n{items}\n{pager}",
		'id' => 'picture-list',
		'itemView' => function ($model, $key, $index, $widget) use ($form) {
			return
			'<hr>'
			.
			'<div class="row form-group">
				<div class="col-sm-4 col-md-4 col-lg-4">
					<div class="form-inline">
						<div class="form-group">'
			.
						$form->field($model, "[$model->id]selected")->checkbox().'   '
			.
						$form->field($model, "[$model->id]deleted")->checkbox()
			.
						'</div>
					</div>'
			.
					frontend\widgets\ImageRenderer::widget(
						[
							'image' => $model->smallImage,
							'size' => 'small',
							'options' => ['class' => 'img-responsive', 'style' => 'margin-bottom:5px'],
						]
					)
			.
					Html::a('Bild im Detail bearbeiten', ['picture/update','id'=>$model->id], ['target' => '_blank'])
			.
					'<br>'
			.
					$model->taken
			.
					'<br>'
			.
					Html::encode($model->loc_formatted_addr)
			.
					'<br>'
			.
					'<b>'.Html::encode($model->vehicle_reg_plate).'</b>'
			.

			'	</div>
				<div class="col-sm-4 col-md-4 col-lg-4">'
			.
					$form->field($model, "[$model->id]name")->textInput()
			.
					$form->field($model, "[$model->id]description")->textarea(['rows' => 3])
			.
					$form->field($model, "[$model->id]incident_id")->dropDownList(frontend\models\Incident::dropDownList())
			.
					$form->field($model, "[$model->id]action_id")->dropDownList(frontend\models\Action::dropDownList())
			.
			'	</div>
				<div class="col-sm-4 col-md-4 col-lg-4">'
			.
					$form->field($model, "[$model->id]campaign_id")->dropDownList(frontend\models\Campaign::dropDownList())
			.
					$form->field($model, "[$model->id]citation_id")->dropDownList(frontend\models\Citation::dropDownList())
			.
					$form->field($model, "[$model->id]citation_affix")->textarea(['rows' => 3, ])
			.
					$form->field($model, "[$model->id]visibility_id")->dropDownList(frontend\models\Visibility::dropDownList())
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


