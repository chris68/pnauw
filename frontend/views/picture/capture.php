<?php
/* @var $this yii\web\View */
/* @var $formmodel frontend\models\PictureCaptureForm */

use yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Bild aufnehmen'.(Yii::$app->user->checkAccess('anonymous')?' (Gastzugang)':'');
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['manage', 'sort'=>'modified_ts-desc', ]];
$this->params['breadcrumbs'][] = 'Aufnehmen'.(Yii::$app->user->checkAccess('anonymous')?' (Gastzugang)':'');
$this->params['help'] = Yii::$app->user->checkAccess('anonymous')?'picture-guestcapture':'picture-capture';
?>



<div class="picture-capture">
	<h1><?= $this->title ?></h1>

	<?php 
		/* @var $form yii\widgets\ActiveForm */
		$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], ]); 
	?>
		<?= $form->errorSummary([$formmodel],['class' => "alert alert-danger"]) ?>
		<?= $form->field($formmodel, 'file_name')->fileInput(['accept' => 'image/*', 'capture' => 'camera', ]) ?>
		<div class="form-group">
			<?= Html::submitButton('Hochladen&Bearbeiten', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
		</div>
	<?php ActiveForm::end(); ?>

	<div class="help-block">
		<p>Hier können Sie mit Ihrer Kamera auf der mobilen Einheit ein Bild aufnehmen, hochladen und dann gleich bearbeiten.</p>
		<p>Wenn Sie Probleme mit dem direkten Zugriff auf die Kamera haben, dann können Sie die Bilder auch aus dem Dateisystem <a href="<?=Html::URL(['upload'])?>" >hochladen</p>.
	</div>
</div>


