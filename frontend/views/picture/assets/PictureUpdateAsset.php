<?php
namespace frontend\views\picture\assets;
use yii\web\AssetBundle;

/**
 * The necessary files to update pictures
 */
class PictureUpdateAsset extends AssetBundle
{
    public $sourcePath = '@frontend/views/picture/assets';
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/perliedman-leaflet-control-geocoder/1.5.4/Control.Geocoder.css',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/perliedman-leaflet-control-geocoder/1.5.4/Control.Geocoder.js',
        'pnauw.picture.update.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'frontend\assets\LeafletAsset'
    ];
}
