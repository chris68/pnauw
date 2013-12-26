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
		// Heatmaps requires '&libraries=visualization'
		// Geocoding requires ',places'
		'http://maps.googleapis.com/maps/api/js?sensor=false&language=de&libraries=visualization,places',
		'pnauw.picture.heatmap.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
	];
}
