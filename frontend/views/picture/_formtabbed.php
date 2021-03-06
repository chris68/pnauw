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
    <?php $form = $outerform?$outerform:ActiveForm::begin(); ?>
    
    <?= Html::activeHiddenInput($model, 'id' ) ?>

    <?= $form->errorSummary($model,['class' => "alert alert-danger"]);?>

    <div class="form-group">
        <?= $outerform?'':Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= $outerform?'':Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
        <?= $outerform||!$model->isNewRecord?'':Html::Button('Bild aufnehmen', ['class' => 'btn btn-secondary', 'onclick' => '$("#picture-image-upload").click();']) ?>
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
        // It is important, that the map is initialized when the tab is open!
        // See respective code in the js file

        Tabs::widget(
            [
                'id' => 'picture-tabs',
                'items' => [
                    [
                        'label' => 'Bild & Kfz-/Vorfallsdaten',
                        'content' => $this->render('_imagetab', array('model'=>$model,'form'=>$form)),
                        'headerOptions' => ['id' => 'picture-tab-image'],
                        'active' => true,
                     ],
                    [
                        'label' => 'Karte & Ort',
                        'content' => $this->render('_maptab', array('model'=>$model,'form'=>$form)),
                        'headerOptions' => ['id' => 'picture-tab-map'],
                     ],
                    [
                        'label' => 'Grunddaten',
                        'content' => $this->render('_datatab', array('model'=>$model,'form'=>$form)),
                        'headerOptions' => ['id' => 'picture-tab-data'],
                     ],
                    [
                        'label' => 'Übersicht & Drucken',
                        'content' => $this->render('_overviewtab', array('model'=>$model,'form'=>$form)),
                        'headerOptions' => ['id' => 'picture-tab-overview'],
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
    
    <?php 
        \frontend\views\picture\assets\PictureUpdateAsset::register($this); 
        // The baseUrl is needed in script; so output it into a variable
        $this->registerJs(
            "var baseUrl = '".Yii::$app->getUrlManager()->getBaseUrl()."';",
            \yii\web\View::POS_END
        );
     ?>
    
</div>
