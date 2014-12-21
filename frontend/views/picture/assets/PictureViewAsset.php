<?php
namespace frontend\views\picture\assets;
use yii\web\AssetBundle;

/**
 * The necessary files to update pictures
 */
class PictureViewAsset extends AssetBundle
{
    public $sourcePath = '@frontend/views/picture/assets';
    public $js = [
        // Geocoding in maps requires '&libraries=places'
        'http://maps.googleapis.com/maps/api/js?sensor=false&language=de&libraries=places',
        'pnauw.picture.view.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
