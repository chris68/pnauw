<?php
/* @var $this yii\web\View */
/* @var $defaultvalues frontend\models\Picture */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Collapse;

$this->title = 'Bilder von FTP übernehmen';
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['manage']];
$this->params['breadcrumbs'][] = 'Bilder von FTP übernehmen';
$this->params['help'] = 'picture-serverupload';
?>



<div class="picture-serverupload">
    <h1><?= $this->title ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], ]); ?>
        <?= $form->errorSummary([$defaultvalues],['class' => "alert alert-danger"]) ?>
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
        <div class="form-group">
            <?= Html::submitButton('Hochladen', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
        </div>
    <?php ActiveForm::end(); ?>

    <div class="help-block">
        <p>Hier können Sie Bilder direkt vom Server hochladen, welche Sie vorher via ftp dorthin gespielt haben. Die Bilder werden nach dem Hochladen vom Server gelöscht.</p>
    </div>
</div>


