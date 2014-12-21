<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */
/* @var $form yii\bootstrap\ActiveForm */

use yii\widgets\DetailView;
use yii\helpers\Html;

?>

<div class=    "row">
    <div class ="col-lg-6">

        <?=

        DetailView::widget(
            [
                'model' => $model,
                'attributes' => [
                    'taken',
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
                    'loc_path',
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
    </div>
</div>

