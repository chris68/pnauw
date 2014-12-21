<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * 
 * 
 * MQ.mapLayer().addTo(map);
 * 
 * L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
 *     attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery &copy; <a href="http://openstreetmap.org">OpenStreetMap</a>',
 *     maxZoom: 18
 * })addTo(map);
*/
class LeafletAsset extends AssetBundle
{
    public $css = [
        "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css",
    ];
    public $js = [
        "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js",
        "http://www.mapquestapi.com/sdk/leaflet/v1.s/mq-map.js?key=Fmjtd%7Cluurnu0znq%2Cal%3Do5-9w820a",
        "http://www.mapquestapi.com/sdk/leaflet/v1.s/mq-geocoding.js?key=Fmjtd%7Cluurnu0znq%2Cal%3Do5-9w820a",
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
