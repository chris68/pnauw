/*
 * Google map functionality on picture view
 */

var geocoder;

function geocodePosition(pos) {
	if (!geocoder) {
		geocoder = new google.maps.Geocoder();
	}
	
	geocoder.geocode({
	  latLng: pos
	}, function(responses,status) {
	  if (status == google.maps.GeocoderStatus.OK) { 
		$('#picture-map-nearest-address').text (responses[0].formatted_address);
		// Only if something relevant has been found update the model!
		$('#picture-map-loc-formatted-addr').val (responses[0].formatted_address);
	  } else {
		$('#picture-map-nearest-address').text ("Keine Adresse gefunden (Fehlercode:" + status + ")"); 
	  }
	});
}


var map;
var marker;

function getlatLng() {
	return new google.maps.LatLng($('#picture-map-loc-lat').val(),$('#picture-map-loc-lng').val());
}

map = new google.maps.Map(document.getElementById('picture-map-canvas'), {
  zoom: 16,
  center: getlatLng(),
  mapTypeId: google.maps.MapTypeId.ROADMAP
});

marker = new google.maps.Marker({
  position: getlatLng(),
  title: 'Aufnahmeort',
  map: map
});

