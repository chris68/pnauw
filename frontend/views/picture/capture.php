<?php
/* @var $this yii\web\View */
/* @var $formmodel frontend\models\PictureCaptureForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use frontend\views\picture\assets\PictureLivemapAsset;

PictureLivemapAsset::register($this);

$this->title = 'Bild aufnehmen'.(Yii::$app->user->can('anonymous')?' (Anonym)':'');
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['manage']];
$this->params['breadcrumbs'][] = 'Aufnehmen'.(Yii::$app->user->can('anonymous')?' (Anonym)':'');
$this->params['help'] = Yii::$app->user->can('anonymous')?'picture-guestcapture':'picture-capture';
?>



<div class="picture-capture">
    <h1><?= $this->title ?></h1>

    <?php 
        /* @var $form yii\bootstrap\ActiveForm */
        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], ]); 
    ?>
        <?= $form->errorSummary([$formmodel],['class' => "alert alert-danger"]) ?>
        <?= $form->field($formmodel, 'file_name')->fileInput(['accept' => 'image/*', 'capture' => true, ])->hint('Drücken Sie hier, um die Kamera zu aktivieren') ?>
        <?= $form->field($formmodel, 'directEdit')->checkbox()->hint('Aktivieren Sie die Option, um nach dem Hochladen das Bild direkt zu verarbeiten ') ?>
        <div class="form-group">
            <?= Html::submitButton('Hochladen', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
        </div>
    <?php ActiveForm::end(); ?>
    <div id="livemap" style="height: 250px"></div>
    <div class="help-block">
        <p>Hier können Sie mit Ihrer Kamera auf der mobilen Einheit ein Bild aufnehmen, hochladen und dann gleich bearbeiten.</p>
        <p>Wenn Sie Probleme mit dem direkten Zugriff auf die Kamera haben, dann können Sie die Bilder auch aus dem Dateisystem <a href="<?=Url::to(['upload'])?>" >hochladen</a>.</p>
        <p>Und keine Angst: alle Bilder werden <b>öffentlich</b> immer nur <b>automatisch verschleiert</b> angezeigt! Nur Sie sehen die Originale.</p>
    </div>
</div>


