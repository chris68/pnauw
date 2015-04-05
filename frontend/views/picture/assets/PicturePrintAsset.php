<?php
namespace frontend\views\picture\assets;
use yii\web\AssetBundle;

/**
 * The necessary files to update pictures
 */
class PicturePrintAsset extends AssetBundle
{
    public $sourcePath = '@frontend/views/picture/assets';
    public $js = [
        'pnauw.picture.print.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
