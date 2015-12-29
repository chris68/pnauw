<?php
namespace frontend\views\picture\assets;
use yii\web\AssetBundle;

class PictureOverviewmapAsset extends AssetBundle
{
    public $sourcePath = '@frontend/views/picture/assets';
    public $js = [
        'pnauw.picture.overviewmap.js',
    ];
    public $depends = [
        '\frontend\assets\LeafletAsset',
        '\frontend\assets\LeafletPluginGoogleTileAsset',
    ];
}
