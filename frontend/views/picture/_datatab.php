<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class=    "row">
    <div class ="col-sm-6 col-md-6">
        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Optionale Überschrift (wird öffentlich)']) ?>
        <?= $form->field($model, 'description')->textarea(['rows' => 3, 'placeholder' => 'Optionale Beschreibung der Situation (wird öffentlich)']) ?>
        <?= $form->field($model, 'visibility_id')->dropDownList(frontend\models\Visibility::dropDownList()) ?>
        <?= (\Yii::$app->user->can('trusted')?$form->field($model, 'campaign_id')->dropDownList(frontend\models\Campaign::dropDownList())->hint('Kampagnen müssen Sie vorher anlegen'):'') ?>
    </div>
</div>

