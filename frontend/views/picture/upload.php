<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var frontend\models\PictureForm $formmodel
 * @var frontend\models\Picture $picmodel
 */

$this->title = 'Bilder hochladen';
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Hochladen';
?>



<div class="picture-upload">
	<h1><?= Html::encode($this->title) ?></h1>

	<?php // @Todo: Check the display width options like class="col-lg-5" ?>
	<?php $form = ActiveForm::begin(['id' => 'picture-upload-form', 'options' => ['enctype' => 'multipart/form-data'], ]); ?>
		<?= $form->errorSummary([$formmodel,$picmodel]) ?>
		<?= $form->field($formmodel, 'file_names[]')->fileInput(['multiple' => 'multiple', ]) ?>
		<div class="form-group">
			<?= Html::submitButton('Hochladen', ['class' => 'btn btn-primary']) ?>
			<?= Html::button('Abbrechen', ['class' => 'btn btn-secondary', 'type' => 'reset']) ?>
		</div>
	<?php ActiveForm::end(); ?>

	<div class="help-block">
		<p>Hier können Sie <b>maximal <?php echo ini_get('max_file_uploads'); ?></b> Dateien auswählen, die Sie hochladen wollen. Es werden nur <b>JPG-Bilder</b> mit <b> maximal <?php echo ini_get('upload_max_filesize'); ?> </b> pro Bild akzeptiert. Wenn Ihre Bilder im Original größer sind, dann verkleinern Sie diese bitte vorher.</p>
		<p>Die Bilder sollten am besten dem <b>Format 3:4</b> entsprechen. Andernfalls werdem Sie eventuell verzerrt dargestellt.</p>
		<p>Die Bilder müssen ein <b>Exif-Aufnahmedatum</b> (Exif-Tag <i>DateTimeOriginal</i>) haben, sonst werden die Bilder abgelehnt.</p>
		<p>Es ist hilfreich, wenn die Bilder bereits <b>Exif-Geo/GPS-Informationen</b> (Exif-Tags <i>GPSLatitude</i>, <i>GPSLatitudeRef</i>, <i>GPSLongitude</i>, <i>GPSLongitudeRef</i>) beinhalten. Aber man kann die Position der Bilder auch später manuell nachdokumentieren.</p>
		<p>Die Bilder werden nicht gleich freigeschaltet, sondern müssen erst vom Ihnen <b>veröffentlicht</b> und teilweise dann auch noch von einem Moderator <b>freigegeben</b> werden.</p>
	</div>
</div>


