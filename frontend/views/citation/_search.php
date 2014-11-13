<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var frontend\models\CitationSearch $model
 * @var yii\bootstrap\ActiveForm $form
 */
?>

<div class="citation-search">

	<?php $form = ActiveForm::begin([
		'action' => [Yii::$app->controller->getRoute()],
		'method' => 'get',
	]); ?>

		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'owner_id') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'description') ?>

		<?php // echo $form->field($model, 'created_ts') ?>

		<?php // echo $form->field($model, 'modified_ts') ?>

		<?php // echo $form->field($model, 'released_ts') ?>

		<?php // echo $form->field($model, 'deleted_ts') ?>

		<div class="form-group">
			<?= Html::submitButton('Suchen', ['class' => 'btn btn-primary']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
