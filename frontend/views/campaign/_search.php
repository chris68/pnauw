<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CampaignSearch */
/* @var $form yii\bootstrap\ActiveForm */
 
?>

<div class="campaign-search">

    <?php $form = ActiveForm::begin([
        'action' => [Yii::$app->controller->getRoute()],
        'method' => 'get',
    ]); ?>

        <?= $form->field($model, 'id') ?>

        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'description') ?>

        <?= $form->field($model, 'running_from') ?>

        <?= $form->field($model, 'running_until') ?>

        <?= $form->field($model, 'visibility_id') ?>

        <?php // echo $form->field($model, 'created_ts') ?>

        <?php // echo $form->field($model, 'modified_ts') ?>

        <?php // echo $form->field($model, 'released_ts') ?>

        <?php // echo $form->field($model, 'deleted_ts') ?>

        <div class="form-group">
            <?= Html::submitButton('Suchen', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
