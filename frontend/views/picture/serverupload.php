<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Bilder vom Server hochladen'.(Yii::$app->user->can('anonymous')?' (Gastzugang)':'');
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['manage']];
$this->params['breadcrumbs'][] = 'Hochladen vom Server'.(Yii::$app->user->can('anonymous')?' (Gastzugang)':'');
$this->params['help'] = 'picture-serverupload';
?>



<div class="picture-serverupload">
	<h1><?= $this->title ?></h1>

	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], ]); ?>
		<div class="form-group">
			<?= Html::submitButton('Hochladen', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
		</div>
	<?php ActiveForm::end(); ?>

	<div class="help-block">
		<p>Hier können Sie Bilder direkt vom Server hochladen, welche Sie vorher via ftp dorthin gespielt haben. Die Bilder werden nach dem Hochladen vom Server gelöscht.</p>
	</div>
</div>


