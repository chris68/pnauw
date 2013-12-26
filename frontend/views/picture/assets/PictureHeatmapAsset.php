<?php
namespace frontend\views\picture\assets;
use yii\web\AssetBundle;

/**
 * The necessary files to update pictures
 */
class PictureHeatmapAsset extends AssetBundle
{
	public $sourcePath = '@frontend/views/picture/assets';
	public $js = [
		// Heatmaps require '&libraries=visualization'
		'http://maps.googleapis.com/maps/api/js?sensor=false&language=de&libraries=visualization',
		//'http://maps.googleapis.com/maps/api/js?sensor=false&language=de&libraries=places',
		'pnauw.picture.heatmap.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
	];
}
