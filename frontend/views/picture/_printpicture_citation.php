<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */
/* @var $printParameters frontend\models\PicturePrintForm */

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\PicturePrintForm;
use frontend\views\picture\assets\PictureLocationmapAsset;

PictureLocationmapAsset::register($this);
?>

<div class="picture-print" style="page-break-after: always;">
    <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    
    <h1>
        <?=Html::encode(($printParameters->visibility=='unchanged'?$model->vehicle_reg_plate:'{'.substr(hash('md5',$model->vehicle_reg_plate),0,8).'}').' / '.date_format(date_create($model->taken),'d.m.Y').' / #'.$model->id)?>
        <?=((yii::$app->user->can('isObjectOwner', array('model' => $model)))?('&nbsp;'.Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['picture/update','id'=>$model->id], ['class' => 'delete-before-printing', 'target' => '_blank'])):'')?>
            
    </h1>
        <?php \frontend\views\picture\assets\PicturePrintAsset::register($this); ?>
        <?=

        DetailView::widget(
            [
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Aufgenommen am',
                        'value' => $printParameters->visibility=='unchanged'?$model->taken:date_format(date_create($model->taken),'d.m.Y h'.' Uhr (Uhrzeit stundengenau'),
                    ],
                    [
                        'label' => 'Kennzeichen',
                        'value' => $printParameters->visibility=='unchanged'?$model->vehicle_reg_plate:'',
                    ],
                    [
                        'label' => 'Kennzeichen (Ausschnitt)',
                        'value' =>  $printParameters->visibility=='unchanged'?("<canvas data-image-id='picture-image-{$model->id}' data-clip-x='{$model->clip_x}' data-clip-y='{$model->clip_y}' data-clip-size='{$model->clip_size}' style='width:300px; heigth:200px;'>"):'',
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Vorfall',
                        'value' => $model->incident->name,
                    ],
                    [
                        'label' => 'Details zum Vorfall',
                        'format' => 'raw',
                        'value' => $printParameters->visibility=='unchanged'?nl2br(Html::encode($model->citation_affix)):'',
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
                'image' => $printParameters->visibility=='unchanged'?$model->originalImage:$model->blurredSmallImage,
                'size' => 'medium',
                'options' => ['class'=>'img-responsive', 'style'=>$printParameters->visibility=='unchanged'?'page-break-before: always;':'', 'id' => 'picture-image-'.$model->id],
            ]
        )
        ?>
    </div>
    </div>

</div>
