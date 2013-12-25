<?php
/* @var $this yii\web\View */
/* @var $formmodel frontend\models\PictureUploadForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Bilder hochladen';
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['manage', 'sort'=>'modified_ts-desc', ]];
$this->params['breadcrumbs'][] = 'Hochladen';
?>



<div class="picture-upload">
	<h1><?= $this->title ?></h1>

	<?php $form = ActiveForm::begin(['id' => 'picture-upload-form', 'options' => ['enctype' => 'multipart/form-data'], ]); ?>
		<?= $form->errorSummary([$formmodel],['class' => "alert alert-danger"]) ?>
		<?= $form->field($formmodel, 'file_names[]')->fileInput(['multiple' => true, 'accept' => 'image/*', ]) ?>
		<div class="form-group">
			<?= Html::submitButton('Hochladen', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
		</div>
	<?php ActiveForm::end(); ?>

	<div class="help-block">
		<p>Hier können Sie auf einen Rutsch <b>maximal ca. 50 Dateien</b> auswählen, die Sie hochladen wollen. Es werden nur <b>JPG-Bilder</b> mit <b>maximal ca. 1 MB</b> pro Bild akzeptiert. Wenn Ihre Bilder im Original größer sind, dann verkleinern Sie diese bitte vorher.</p>
		<p>Die Bilder sollten am besten dem <b>Format 3:4</b> entsprechen. Andernfalls werdem Sie eventuell verzerrt dargestellt.</p>
		<p>Die Bilder müssen ein <b>Exif-Aufnahmedatum</b> (Exif-Tag <i>DateTimeOriginal</i>) haben, sonst werden die Bilder auf den 1.1.1970 datiert.</p>
		<p>Es ist hilfreich, wenn die Bilder bereits <b>Exif-Geo/GPS-Informationen</b> (Exif-Tags <i>GPSLatitude</i>, <i>GPSLatitudeRef</i>, <i>GPSLongitude</i>, <i>GPSLongitudeRef</i>) beinhalten. Aber man kann die Position der Bilder auch später manuell nachdokumentieren.</p>
		<p>Die Bilder werden nicht gleich freigeschaltet, sondern müssen erst vom Ihnen <b>veröffentlicht</b> und teilweise dann auch noch von einem Moderator <b>freigegeben</b> werden.</p>
	</div>
</div>


