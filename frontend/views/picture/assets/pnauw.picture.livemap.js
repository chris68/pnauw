var map = L.map('livemap');
map.locate({setView: true, watch: true, maxZoom: 16});

var osm = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
   attribution: "&copy; <a href='https://www.openstreetmap.org/'>OpenStreetMap</a> and contributors, under an <a href='https://www.openstreetmap.org/copyright' title='ODbL'>open license</a>."
});
osm.addTo(map);

var positionLayerGroup = L.layerGroup([]);
positionLayerGroup.addTo(map);

L.control.layers({},{"Position": positionLayerGroup}).addTo(map);

map.on('locationerror', function(e) {
    alert(e.message);
});

map.on('locationfound', function(e) {
    positionLayerGroup.clearLayers();
    positionLayerGroup.addLayer(L.circle(e.latlng, e.accuracy / 2, {opacity:0.2}));
});

