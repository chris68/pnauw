<?php
/**
 * @var yii\web\View $this
 * @var frontend\models\Picture $model
 * @var yii\widgets\ActiveForm $form
 */
if (0) {	
	$form = new yii\widgets\ActiveForm();
	$model = new frontend\models\Picture();
}
?>

<div class=	"row">
	<div class ="col-lg-6">
		<?= $form->field($model, 'name')->textInput() ?>
		<?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
		<?= $form->field($model, 'visibility_id')->dropDownList(frontend\models\Visibility::dropDownList()) ?>
		<?= $form->field($model, 'campaign_id')->dropDownList(frontend\models\Campaign::dropDownList()) ?>
	</div>
</div>

