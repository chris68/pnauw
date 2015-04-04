<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 *
 * // Method using MQ plugin
 * MQ.mapLayer().addTo(map);
 * 
 * // Method using self constructed tile layer
 * L.tileLayer("http://otile{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png", {
 *   subdomains: "1234",
 *   attribution: "&copy; <a href='http://www.openstreetmap.org/'>OpenStreetMap</a> and contributors, under an <a href='http://www.openstreetmap.org/copyright' title='ODbL'>open license</a>. Tiles Courtesy of <a href='http://www.mapquest.com/'>MapQuest</a> <img src='http://developer.mapquest.com/content/osm/mq_logo.png'>"
 * }).addTo(map);
 *
 * See https://gist.github.com/mourner/1804938 for further tile layers
 * 
 */
class LeafletAsset extends AssetBundle
{
    public $css = [
        "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css",
    ];
    public $js = [
        "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js",
        "http://open.mapquestapi.com/sdk/leaflet/v1.s/mq-map.js?key=Fmjtd%7Cluurnu0znq%2Cal%3Do5-9w820a",
        "http://open.mapquestapi.com/sdk/leaflet/v1.s/mq-geocoding.js?key=Fmjtd%7Cluurnu0znq%2Cal%3Do5-9w820a",
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
