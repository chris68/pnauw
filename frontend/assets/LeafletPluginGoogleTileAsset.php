<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * See https://gist.github.com/mourner/1804938 for further tile layers
 * 
 */
class LeafletPluginGoogleTileAsset extends AssetBundle
{
    public $sourcePath = '@bower/leaflet-plugins';
    public $js = [
        "http://maps.google.com/maps/api/js?v=3&libraries=places",
        "layer/tile/Google.js",
    ];
}
