<?php
/* @var $this yii\web\View */
/* @var $formmodel frontend\models\PictureUploadForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Collapse;

$this->title = 'Bilder hochladen'.(Yii::$app->user->can('anonymous')?' (Gastzugang)':'');
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['manage']];
$this->params['breadcrumbs'][] = 'Hochladen'.(Yii::$app->user->can('anonymous')?' (Gastzugang)':'');
$this->params['help'] = Yii::$app->user->can('anonymous')?'picture-guestupload':'picture-upload';
?>



<div class="picture-upload">
	<h1><?= $this->title ?></h1>

	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], ]); ?>
		<?= $form->errorSummary([$formmodel,$defaultvalues],['class' => "alert alert-danger"]) ?>
		<?=
			Collapse::widget([
				'items' => [
					[
						'label' => '<span class="glyphicon glyphicon-collapse-down"></span> Vorgabewerte setzen',
						'encode' => false,
						'content' => 
							$this->render('_formtabbed', [
								'model' => $defaultvalues,
								'outerform' => $form,
							]),
					],
				],
				'options' => 
				[
					'style' => 'margin-bottom: 10px'
				],
		   ]);
		?>
		<?= $form->field($formmodel, 'file_names[]')->fileInput(['multiple' => true, 'accept' => 'image/jpeg', ]) ?>
		<div class="form-group">
			<?= Html::submitButton('Hochladen', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
		</div>
	<?php ActiveForm::end(); ?>

	<div class="help-block">
		<p>Hier können Sie auf einen Rutsch <b>maximal ca. 50 JPEG-Bilder</b> auswählen, die Sie hochladen wollen. Bei heftigen <b>Massenuploads</b> sollten die Bilder <b>maximal ca. 1 MB</b> groß sein. Um Ihre und unsere Bandbreite zu schonen, sollten Sie die Bilder im Zweifel vorher verkleinern. Hochauflösende/große Bilder bringen wenig, denn diese Bilder werden serverseitig sowie auf eine angemessene Auflösung verkleinert.</p>
		<p>Die Bilder müssen ein <b>Exif-Aufnahmedatum</b> (Exif-Tag <i>DateTimeOriginal</i>) haben, sonst werden die Bilder auf den 1.1.1970 datiert. Es ist hilfreich, wenn die Bilder bereits <b>Exif-Geo/GPS-Informationen</b> (Exif-Tags <i>GPSLatitude</i>, <i>GPSLatitudeRef</i>, <i>GPSLongitude</i>, <i>GPSLongitudeRef</i>) beinhalten. Aber man kann die Position der Bilder auch später manuell nachdokumentieren.</p>
		<p>Die Bilder werden nicht gleich freigeschaltet, sondern müssen erst vom Ihnen <b>veröffentlicht</b> und teilweise dann auch noch von einem Moderator <b>freigegeben</b> werden.</p>
		<p>Und keine Angst: alle Bilder werden <b>öffentlich</b> immer nur <b>automatisch verschleiert</b> angezeigt! Nur Sie sehen die Originale.</p>
	</div>
</div>


