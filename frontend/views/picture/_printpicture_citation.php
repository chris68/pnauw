<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\views\picture\assets\PictureLocationmapAsset;

PictureLocationmapAsset::register($this);
?>

<div class="picture-print" style="page-break-after: always;">
    <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    
    <h1>
        <?=Html::encode($model->vehicle_reg_plate.' / '.date_format(date_create($model->taken),'d.m.Y'))?>
                    
    </h1>
        <?php \frontend\views\picture\assets\PicturePrintAsset::register($this); ?>
        <?=

        DetailView::widget(
            [
                'model' => $model,
                'attributes' => [
                    'taken',
                    [
                        'label' => 'Kennzeichen',
                        'value' => $model->vehicle_reg_plate,
                    ],
                    [
                        'label' => 'Kennzeichen (Ausschnitt)',
                        'value' =>     "<canvas data-image-id='picture-image-{$model->id}' data-clip-x='{$model->clip_x}' data-clip-y='{$model->clip_y}' data-clip-size='{$model->clip_size}' style='width:300px; heigth:200px;'>",
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Vorfall',
                        'value' => $model->incident->name,
                    ],
                    [
                        'label' => 'Details zum Vorfall',
                        'format' => 'raw',
                        'value' => nl2br(Html::encode($model->citation_affix)),
                    ],
                    'loc_formatted_addr',
                    [
                        'label' => 'Karte',
                        'format' => 'raw',
                        'value' => 
                            Html::tag('div','', [
                              'style' => 'height: 200px;',
                              'id' => "map-{$model->id}",
                              'data' => [
                                  'map' => 1,
                                  'lat' => $model->loc_lat,
                                  'lng' => $model->loc_lng,
                                  'zoom' => 17,
                              ]
                            ])
                    ],
                ]
            ]
        );
        ?>
        <?=
        frontend\widgets\ImageRenderer::widget(
            [
                'image' => $model->originalImage,
                'size' => 'medium',
                'options' => ['class'=>'img-responsive', 'style'=>'page-break-before: always;', 'id' => 'picture-image-'.$model->id],
            ]
        )
        ?>
    </div>
    </div>

</div>
