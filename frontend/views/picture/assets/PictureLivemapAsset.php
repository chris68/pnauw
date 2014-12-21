<?php
namespace frontend\views\picture\assets;
use yii\web\AssetBundle;

class PictureLivemapAsset extends AssetBundle
{
    public $sourcePath = '@frontend/views/picture/assets';
    public $js = [
        'pnauw.picture.livemap.js',
    ];
    public $depends = [
        '\frontend\assets\LeafletAsset',
    ];
}
