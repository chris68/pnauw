/*
var map =	L.map('map', {
                layers: MQ.mapLayer(),
                center: [ 40.731701, -73.993411 ],
                zoom: 12
            });
*/
// var map = L.map('map').setView([51.505, -0.09], 16);
var map = L.map('map');
map.locate({setView: true, watch: true, maxZoom: 16});
L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery &copy; <a href="http://openstreetmap.org">OpenStreetMap</a>',
    maxZoom: 18
}).addTo(map);

var circle;
var marker;
function onLocationFound(e) {
    var radius = e.accuracy / 2;

	if (circle) {
		map.removeLayer(circle); 
	}
    circle = L.circle(e.latlng, radius, {opacity:0.2}).addTo(map);

	/*
	if (marker) {
		map.removeLayer(marker);
	}
    marker = L.marker(e.latlng).addTo(map)
        .bindPopup("You are within " + radius + " meters from this point");
	*/
}

map.on('locationfound', onLocationFound);

function onLocationError(e) {
    alert(e.message);
}

map.on('locationerror', onLocationError);