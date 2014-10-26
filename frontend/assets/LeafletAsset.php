<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LeafletAsset extends AssetBundle
{
	public $css = [
		"http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css",
	];
	public $js = [
		"http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js",
		// "http://www.mapquestapi.com/sdk/leaflet/v1.s/mq-map.js?key=Kmjtd%7Cluua2qu7n9%2C7a%3Do5-lzbgq",
	];
	public $depends = [
		'yii\web\YiiAsset',
	];
}
