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

<div class="picture-print">
    <div class="row" style="page-break-inside: avoid;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    
    <h4>
        <?= Html::encode($model->loc_formatted_addr.' ['.date_format(date_create($model->taken),'d.m.Y').'] ') ?>
        <?=((yii::$app->user->can('isObjectOwner', array('model' => $model)))?('&nbsp;'.Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['picture/update','id'=>$model->id], ['class' => 'delete-before-printing', 'target' => '_blank'])):'')?> 
                    
    </h4>
        <?php \frontend\views\picture\assets\PicturePrintAsset::register($this); ?>
        <hr>
        <p><b><?= Html::encode($model->name) ?></b></p>
        <p><?= nl2br(Html::encode($model->description)) ?></p>
        <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p>
        <?=
        frontend\widgets\ImageRenderer::widget(
            [
                'image' => $printParameters->visibility=='unchanged'?$model->smallImage:$model->blurredSmallImage,
                'size' => 'small',
                'options' => ['class'=>'img-responsive', 'id' => 'picture-image-'.$model->id],
            ]
        )
        ?>
        </p>
        <p>
            <b><?= Html::encode($model->incident->name) ?> </b> 
        </p>
        <p><?= $printParameters->visibility=='unchanged'?'':nl2br(Html::encode($model->citation_affix)) ?></p>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <?=
            Html::tag('div','', [
              'style' => 'height: 200px;',
              'id' => "map-{$model->id}",
              'data' => [
                  'map' => 1,
                  'lat' => $model->loc_lat,
                  'lng' => $model->loc_lng,
                  'zoom' => 15,
              ]
            ])
        ?> 
        <a href="https://www.google.de/maps/@<?=$model->loc_lat?>,<?=$model->loc_lng?>,80m/data=!3m1!1e3" target="_blank">Satellitenkarte</a>
        <p><?= Html::encode($model->loc_formatted_addr) ?></p>
        </div>
        </div>
        <hr>
    </div>
    </div>

</div>
