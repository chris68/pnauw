<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var frontend\models\FlyerSearch $model
 * @var yii\bootstrap\ActiveForm $form
 */
?>

<div class="flyer-search">

    <?php $form = ActiveForm::begin([
        'action' => [Yii::$app->controller->getRoute()],
        'method' => 'get',
    ]); ?>

        <?= $form->field($model, 'id') ?>

        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'description') ?>

        <?= $form->field($model, 'flyertext') ?>

        <?= $form->field($model, 'secret') ?>

        <?= $form->field($model, 'running_from') ?>

        <?= $form->field($model, 'running_until') ?>

        <div class="form-group">
            <?= Html::submitButton('Suchen', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
