var map = L.map('livemap');
map.locate({setView: true, watch: true, maxZoom: 16});

var osm = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
   attribution: "&copy; <a href='https://www.openstreetmap.org/'>OpenStreetMap</a> and contributors, under an <a href='https://www.openstreetmap.org/copyright' title='ODbL'>open license</a>."
});
osm.addTo(map);

var positionLayerGroup = L.layerGroup([]);
positionLayerGroup.addTo(map);

L.control.layers({},{"Position": positionLayerGroup}).addTo(map);

var geocode = MQ.geocode().on('success', function(e) { 
    $('#livemap-nearest-address').html(geocode.describeLocation(e.result.best)); 
    //$('#livemap-nearest-address').html(e.result.best.postalcode + e.result.best.adminArea5); 
});

map.on('locationfound', function(e) { 
    positionLayerGroup.clearLayers();
    positionLayerGroup.addLayer(L.circle(e.latlng, e.accuracy / 2, {opacity:0.2}));
    geocode.reverse(e.latlng);
});

map.on('locationerror', function(e) { 
    var message;
    switch(e.code) {
        case 1:
            message = 'Sie haben den Zugriff auf die Geolocation verweigert';
            break;
        case 2:
            message = 'Es ist keine Geolocation verfügbar';
            break;
        case 3:
            message = 'Die Ermittlung der Geolocation dauerte zu lange';
            break;
        default:
            message = 'Bei der Ermittlung der Geolocation ist ein unbekannter Fehler aufgetreten';
            break;
    }
    $('#livemap-nearest-address').html('<i>'+message+'</i>'); 
    // alert(e.message);
});
