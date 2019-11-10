<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\views\picture\assets\PictureLocationmapAsset;

PictureLocationmapAsset::register($this);
?>

<div class="picture-print">
    <div class="row" style="page-break-inside: avoid;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    
    <h4>
        <?= Html::encode($model->loc_formatted_addr.' ['.date_format(date_create($model->taken),'d.m.Y').'] ') ?>
                    
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
                'image' => $model->smallImage,
                'size' => 'small',
                'options' => ['class'=>'img-responsive', 'id' => 'picture-image-'.$model->id],
            ]
        )
        ?>
        </p>
        <p><b><?= Html::encode($model->incident->name) ?> </b></p>
        <p><?= nl2br(Html::encode($model->citation_affix)) ?></p>
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
                  'zoom' => 17,
              ]
            ])
        ?> 
        <p><?= Html::encode($model->loc_formatted_addr) ?></p>
        </div>
        </div>
        <hr>
    </div>
    </div>

</div>
