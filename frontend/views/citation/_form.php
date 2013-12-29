<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var frontend\models\Citation $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="citation-form">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
