<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */
/* @var $form yii\bootstrap\ActiveForm */

use yii\widgets\DetailView;
use yii\helpers\Html;
use \frontend\models\Picture;

?>

<div class=    "row">
    <div class ="col-lg-6">

    <?php if ($model->scenario == Picture::SCENARIO_DEFAULT) : ?>
    <div class="form-group">
        <?php
        if (!$model->isNewRecord ) {
            echo Html::a('In Druckansicht anzeigen', ['picture/print','id'=>$model->id], ['target' => '_blank']);
        } else {
        ?>
        <div class="alert alert-info">
         <p>
            <b>Zum Drucken müssen sie erst speichern.</b>
        </p>
        <p>
            Dann wird auch das Aufnahmedatum auf die 100% korrekte Zeit gesetzt.
        </p>
        </div>
        <?php
        }
        ?>
    </div>
    <?php endif;?>
        
    <?php if ($model->scenario == Picture::SCENARIO_DEFAULT) : ?>
        <?=

        DetailView::widget(
            [
                'model' => $model,
                'attributes' => [
                    'taken',
                    [
                        'label' => 'Korrektur Vorfallsdatum',
                        'format' => 'raw',
                        'value' => $form->field($model, 'taken_override')->label('')->widget(\yii\jui\DatePicker::className())
                    ],
                    'name',
                    [
                        'label' => 'Beschreibung',
                        'format' => 'raw',
                        'value' => nl2br(Html::encode($model->description)),
                    ],
                    [
                        'label' => 'Kennzeichen',
                        'value' => $model->vehicle_reg_plate .' [' . $model->vehicleCountryCode->name . ']',
                    ],
                    [
                        'label' => 'Vorfall',
                        'value' => $model->incident->name,
                    ],
                    [
                        'label' => 'Maßnahme',
                        'value' => $model->action->name,
                    ],
                    [
                        'label' => 'Kampagne',
                        'value' => ($model->campaign)?$model->campaign->name:'(nicht gesetzt)',
                    ],
                    [
                        'label' => 'Anzeige',
                        'value' => ($model->citation)?$model->citation->name:'(nicht gesetzt)',
                    ],
                    [
                        'label' => 'Anzeigenzusatz',
                        'format' => 'raw',
                        'value' => nl2br(Html::encode($model->citation_affix)),
                    ],
                    'loc_formatted_addr',
                    [
                        'label' => 'GPS (Relevant)',
                        'value' => $model->getLatLng(),
                    ],
                    [
                        'label' => 'GPS (Original)',
                        'value' => $model->getOrgLatLng(),
                    ],
                    [
                        'label' => 'Sichtbarkeit',
                        'value' => $model->visibility->name,
                    ],
                    'created_ts',
                    'modified_ts',
                ]
            ]
        );
        ?>
    <?php else: ?>
        <?=

        DetailView::widget(
            [
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Vorfallsdatum',
                        'format' => 'raw',
                        'value' => $form->field($model, 'taken_override')->label('')->widget(\yii\jui\DatePicker::className())
                    ],
                ]
            ]
        );
        ?>
        
    <?php endif;?>
    </div>
</div>

