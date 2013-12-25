<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */
/* @var $form yii\widgets\ActiveForm */
?>

<div class=	"row">
	<div class ="col-sm-6 col-md-6">
		<?= $form->field($model, 'name')->textInput() ?>
		<?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
		<?= $form->field($model, 'visibility_id')->dropDownList(frontend\models\Visibility::dropDownList()) ?>
		<?= $form->field($model, 'campaign_id')->dropDownList(frontend\models\Campaign::dropDownList()) ?>
	</div>
</div>

