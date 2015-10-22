<?php
/* @var $this \yii\web\View */
/* @var $model frontend\models\Picture */
/* @var $outerform yii\bootstrap\ActiveForm If an outer form exists pass it here */

/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;
use frontend\widgets\Alert;
?>

<div class="picture-form">
    <?php $form = $outerform?$outerform:ActiveForm::begin(
[
    'enableClientScript' => false, // See https://github.com/chris68/pnauw/issues/88
]
        ); ?>
    
    <?= Html::activeHiddenInput($model, 'id' ) ?>

    <?= $form->errorSummary($model,['class' => "alert alert-danger"]);?>

    <div class="form-group">
        <?= $outerform?'':Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= $outerform?'':Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
        <?php if (!isset($outerform) && !$model->isNewRecord ) : ?>
        <button type="submit"
            formaction="<?=Url::to(['delete', 'id' => $model->id, 'returl' => Yii::$app->getRequest()->getUrl()])?>"
            formmethod="post"
            class="btn btn-danger"
        >
            Löschen
        </button>
        <?php endif ?>
        
    </div>

    <div>
        <?=
        // http://stackoverflow.com/questions/1428178/problems-with-google-maps-api-v3-jquery-ui-tabs        
        // It is important, that google maps is initialized when the tab is open!

        Tabs::widget(
            [
                'id' => 'picture-tabs',
                'items' => [
                    [
                        'label' => 'Übersicht',
                        'content' => $this->render('_overviewtab', array('model'=>$model,'form'=>$form)),
                        'headerOptions' => ['id' => 'picture-tab-overview'],
                     ],
                    [
                        'label' => 'Grunddaten',
                        'content' => $this->render('_datatab', array('model'=>$model,'form'=>$form)),
                        'headerOptions' => ['id' => 'picture-tab-data'],
                     ],
                    [
                        'label' => 'Karte & Ortsdaten',
                        'content' => $this->render('_maptab', array('model'=>$model,'form'=>$form)),        
                        'headerOptions' => ['id' => 'picture-tab-map'],
                     ],
                    [
                        'label' => 'Bild & Kfz-/Vorfallsdaten',
                        'content' => $this->render('_imagetab', array('model'=>$model,'form'=>$form)),        
                        'headerOptions' => ['id' => 'picture-tab-image'],
                        'active' => true,
                     ],        
                ],
                'itemOptions' => [
                    'style' => 'margin-top:10px; margin-bottom:10px;',
                ]
            ]
        );
        ?>
    </div>

    <?php $outerform?'':ActiveForm::end(); ?>
    
    <?php \frontend\views\picture\assets\PictureUpdateAsset::register($this); ?>
</div>
