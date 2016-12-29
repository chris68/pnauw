<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */
/* @todo: FORM IS CURRENTLY NOT USED */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="picture-form">

    <div class ="col-md-4">
        <?php 
            /* @var $form yii\bootstrap\ActiveForm */
            $form = ActiveForm::begin(); 
        ?>
        
        <?= $form->field($model, 'owner_id')->textInput() ?>

        <?= $form->field($model, 'name')->textInput() ?>

        <?= $form->field($model, 'taken')->widget(\yii\jui\DatePicker::className()) ?>

        <?= $form->field($model, 'clip_x')->textInput() ?>

        <?= $form->field($model, 'clip_y')->textInput() ?>

        <?= $form->field($model, 'clip_size')->textInput() ?>

        <?= $form->field($model, 'visibility_id')->dropDownList(frontend\models\Visibility::dropDownList()) ?>

        <?= $form->field($model, 'original_image_id')->textInput() ?>

        <?= $form->field($model, 'small_image_id')->textInput() ?>

        <?= $form->field($model, 'medium_image_id')->textInput() ?>

        <?= $form->field($model, 'thumbnail_image_id')->textInput() ?>

        <?= $form->field($model, 'blurred_small_image_id')->textInput() ?>

        <?= $form->field($model, 'blurred_medium_image_id')->textInput() ?>

        <?= $form->field($model, 'blurred_thumbnail_image_id')->textInput() ?>

        <?= $form->field($model, 'action_id')->dropDownList(frontend\models\Action::dropDownList()) ?>

        <?= $form->field($model, 'incident_id')->dropDownList(frontend\models\Incident::dropDownList()) ?>

        <?= $form->field($model, 'citation_id')->dropDownList(frontend\models\Citation::dropDownList()) ?>

        <?= (\Yii::$app->user->can('trusted')?$form->field($model, 'campaign_id')->dropDownList(frontend\models\Campaign::dropDownList()):'') ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

        <?= $form->field($model, 'org_loc_lat')->textInput() ?>

        <?= $form->field($model, 'org_loc_lng')->textInput() ?>

        <?= $form->field($model, 'loc_lat')->textInput() ?>

        <?= $form->field($model, 'loc_lng')->textInput() ?>

        <?= $form->field($model, 'loc_formatted_addr')->textarea(['rows' => 3]) ?>

        <?= $form->field($model, 'vehicle_country_code')->dropDownList(frontend\models\VehicleCountry::dropDownList()) ?>

        <?= $form->field($model, 'vehicle_reg_plate')->textInput() ?>

        <?= $form->field($model, 'citation_affix')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'created_ts')->textInput() ?>

        <?= $form->field($model, 'modified_ts')->textInput() ?>

        <?= $form->field($model, 'deleted_ts')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
