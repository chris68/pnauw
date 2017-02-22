<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 *
 * // Method using self constructed tile layer
 *   var osm = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
 *     attribution: "&copy; <a href='https://www.openstreetmap.org/'>OpenStreetMap</a> and contributors, under an <a href='https://www.openstreetmap.org/copyright' title='ODbL'>open license</a>."
 *    });
 *   map.addLayer(osm);
 *
 * See https://gist.github.com/mourner/1804938 for further tile layers
 * 
 */
class LeafletAsset extends AssetBundle
{
    public $css = [
        "https://unpkg.com/leaflet@1.0.3/dist/leaflet.css"
    ];
    public $js = [
        "https://unpkg.com/leaflet@1.0.3/dist/leaflet.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
