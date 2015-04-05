<?php
namespace frontend\views\picture\assets;
use yii\web\AssetBundle;

/**
 * The necessary files to update pictures
 */
class PictureLocationmapAsset extends AssetBundle
{
    public $sourcePath = '@frontend/views/picture/assets';
    public $js = [
        'pnauw.picture.locationmap.js',
    ];
    public $depends = [
        'frontend\assets\LeafletAsset',
    ];
}
