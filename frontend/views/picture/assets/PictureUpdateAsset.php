<?php
namespace frontend\views\picture\assets;
use yii\web\AssetBundle;

/**
 * The necessary files to update pictures
 */
class PictureUpdateAsset extends AssetBundle
{
	public $sourcePath = '@frontend/views/picture/assets';
	public $js = [
		'http://maps.googleapis.com/maps/api/js?sensor=false&language=de&libraries=places',
		'pnauw.picture.update.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
	];
}
