<?php
/* @var $this yii\web\View */
/* @var $formmodel frontend\models\KMLUploadForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Collapse;

$this->title = 'KML-Daten hochladen';
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['manage']];
$this->params['breadcrumbs'][] = 'KML-Daten hochladen';
$this->params['help'] = 'picture-kmlupload';
?>



<div class="picture-kmlupload">
    <h1><?= $this->title ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], ]); ?>
        <?= $form->errorSummary([$formmodel,$defaultvalues],['class' => "alert alert-danger"]) ?>
        <?=
            Collapse::widget([
                'items' => [
                    [
                        'label' => '<span class="glyphicon glyphicon-collapse-down"></span> Vorgabewerte',
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
        <?= $form->field($formmodel, 'file_names[]')->fileInput(['multiple' => true, 'accept' => '.kml', ]) ?>
        <div class="form-group">
            <?= Html::submitButton('Hochladen', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
        </div>
    <?php ActiveForm::end(); ?>

    <div class="help-block">
        <p>Hier können Sie KML Daten hochladen und für jeden Punkt aus der KML-Datei wird dann ein Vorfall angelegt. <b>Es empfiehlt sich, Vorgabewerte zu setzen</b></p>
    </div>
</div>


