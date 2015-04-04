<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\PictureSearch */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="picture-search">

    <div class ="col-sm-4 col-md-4 form-group">
    <?php 
        /** @var yii\bootstrap\ActiveForm $form */
        $form = ActiveForm::begin([
        'action' => [Yii::$app->controller->getRoute()],
        'method' => 'get',
        'id' => 'search-form', 
    ]); ?>
        <div class="form-group">
            <?= Html::submitButton('Suchen', ['class' => 'btn btn-primary']) ?>
        </div>
        
            <?= $form->errorSummary($model,['class' => "alert alert-danger"]);?>

            <fieldset>
            <legend>Generell</legend>
            <?= $form->field($model, 'map_bind')->checkBox(['id'=>'search-map-bind', ]) ?>
            <?= $form->field($model, 'map_limit_points')->checkBox() ?>
            <?= Html::activeHiddenInput($model, 'map_bounds', ['id'=>'search-map-bounds', ]) ?>
            <?= Html::activeHiddenInput($model, 'map_state', ['id'=>'search-map-state', ]) ?>
            <?= Html::activeHiddenInput($model, 'map_gps', ['id'=>'search-map-gps', ]) ?>
            <?= $form->field($model, 'time_range')->dropDownList(frontend\models\PictureSearch::dropDownListTimeRanges(), ['id'=>'search-time-range', ]) ?>
            </fieldset>
        
            <fieldset>
            <legend>Ort &amp; Zeit</legend>
            
            <?= $form->field($model, 'taken')->widget(\yii\jui\DatePicker::className()) ?>

            <?= $form->field($model, 'loc_formatted_addr')->hint('Eine Suche nach der Adresse ist eher unzuverlässig, da die Adresse nur sporadisch ausgefüllt ist. Suchen Sie am besten über die Karte.') ?>
            </fieldset>
        
            <fieldset>
            <legend>Vorfall  &amp; Aktionen</legend>
            <?= $form->field($model, 'incident_id')->listBox(frontend\models\Incident::dropDownList(), ['multiple' => true, 'unselect' => '', ]) ?>

            <?= $form->field($model, 'action_id')->listBox(frontend\models\Action::dropDownList(), ['multiple' => true, 'unselect' => '', ]) ?>

            <?= $form->field($model, 'campaign_id')->dropDownList(frontend\models\Campaign::dropDownList()) ?>
            </fieldset>

        <?php if ($model->scenario == 'private' || $model->scenario == 'admin' || $model->scenario == 'moderator') : ?>
            <fieldset>
            <legend>Verarbeitung</legend>
            <?= $form->field($model, 'created_ts')->widget(\yii\jui\DatePicker::className()) ?>

            <?= $form->field($model, 'modified_ts')->widget(\yii\jui\DatePicker::className()) ?>
            
            <?= $form->field($model, 'visibility_id')->listBox(frontend\models\Visibility::dropDownList(), ['multiple' => true, 'unselect' => '', ]) ?>
            </fieldset>

        <?php endif; ?>
        <?php if ($model->scenario == 'private' || $model->scenario == 'admin' ): ?>
            <fieldset>
            <legend>Kfz &amp; Anzeigen</legend>
            <?= $form->field($model, 'vehicle_country_code')->listBox(frontend\models\VehicleCountry::dropDownList(), ['multiple' => true, 'unselect' => '', ]) ?>

            <?= $form->field($model, 'vehicle_reg_plate')->textInput() ?>
            
            <?= $form->field($model, 'citation_id')->dropDownList(frontend\models\Citation::dropDownList()) ?>

            </fieldset>
        <?php endif; ?>

        <fieldset>
            <legend>Texte &amp; Referenzen</legend>
        <?= $form->field($model, 'id') ?>

        <?= $model->scenario == 'admin'?$form->field($model, 'owner_id'):'' ?>

        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'description') ?>
        </fieldset>

        <div class="form-group">
            <?= Html::submitButton('Suchen', ['class' => 'btn btn-primary']) ?>
        </div>
        
        <p class="help-block">
            Die Suche in den Textfeldern ist eine Teiltextsuche, bei der zwischen Groß- und Kleinschreibung unterschieden wird.<br>Eine Suche nach <em>straße</em> findet also <em>Kriegsstraße</em>, aber nicht <em>Straße des 17.Juni</em>
        </p>

    <?php ActiveForm::end(); ?>
    </div>
</div>
