var map = L.map('livemap');
map.locate({setView: true, watch: true, maxZoom: 16});
MQ.mapLayer().addTo(map);

var geocode = MQ.geocode().on('success', function(e) { 
	$('#livemap-nearest-address').html(geocode.describeLocation(e.result.best)); 
	//$('#livemap-nearest-address').html(e.result.best.postalcode + e.result.best.adminArea5); 
});

var circle;
map.on('locationfound', function(e) { 
	if (circle) {
		map.removeLayer(circle); 
	}
    circle = L.circle(e.latlng, e.accuracy / 2, {opacity:0.2}).addTo(map);
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
