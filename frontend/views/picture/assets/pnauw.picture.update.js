/*
 * Update the picture-clip-canvas on tab "_imagetab"
 */

// http://www.w3schools.com/tags/canvas_drawimage.asp
function updatePictureClipCanvas() {
    // http://stackoverflow.com/questions/10076031/naturalheight-and-naturalwidth-property-new-or-deprecated
    var c=$("#picture-clip-canvas")[0];
    var ctx=c.getContext("2d");
    var img=$("#picture-image")[0];
    var size_x = $('#picture-clip-size').val()/100*img.naturalWidth;
    var size_y = size_x /2;
    var x = Math.max($('#picture-clip-x').val()/100*img.naturalWidth-size_x/2,0);
    var y = Math.max($('#picture-clip-y').val()/100*img.naturalHeight-size_y/2,0);
    ctx.drawImage(img,x,y,size_x,size_y,0,0,300,150);
};

$('#picture-image').click(function (e) {
	// Calcuation of offsetX/offsetY according to http://www.jacklmoore.com/notes/mouse-position/

	e = e || window.event;
    var target = e.target || e.srcElement,
        rect = target.getBoundingClientRect(),
        offsetX = e.clientX - rect.left,
        offsetY = e.clientY - rect.top;
	
	//    Even more W3C compliant way to calc offsetX/Y but currently it does not make a difference anyway
    //    style = target.currentStyle || window.getComputedStyle(target, null),
    //    borderLeftWidth = parseInt(style['borderLeftWidth'], 10),
    //    borderTopWidth = parseInt(style['borderTopWidth'], 10),
    //    rect = target.getBoundingClientRect(),
    //    offsetX = e.clientX - borderLeftWidth - rect.left,
    //    offsetY = e.clientY - borderTopWidth - rect.top;


    //console.log([offsetX, offsetY]);
	
    var img = $(this)[0];
    $('#picture-clip-x').val (Math.round((offsetX)/img.width*100));
    $('#picture-clip-y').val (Math.round((offsetY)/img.height*100));

	//console.log([$('#picture-clip-x').val(), $('#picture-clip-y').val()]);
	
    updatePictureClipCanvas();
});

$("#picture-clip-size").on( "change", function( event, ui ) { 
	updatePictureClipCanvas(); return true; 
} );


/*
 * Google map functionality on tab "_maptab"
 */

var geocoder;
var map;
var marker;
var marker_org;

function geocodePosition(pos) {
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

geocoder = new google.maps.Geocoder();

function getlatLng() {
	return new google.maps.LatLng($('#picture-map-loc-lat').val(),$('#picture-map-loc-lng').val());
}
function getlatLngOrg() {
	return new google.maps.LatLng($('#picture-map-loc-lat-org').val(),$('#picture-map-loc-lng-org').val());
}


/*
 * Adjusts the position of the map to the markers position (centered)
 */
function adjustPosition() {
	geocodePosition(marker.getPosition());
	map.setCenter(marker.getPosition());
	if (map.getZoom() < 16) {
		map.setZoom(16);
	}
}

map = new google.maps.Map(document.getElementById('picture-map-canvas'), {
  zoom: 16,
  center: getlatLng(),
  mapTypeId: google.maps.MapTypeId.ROADMAP
});

marker = new google.maps.Marker({
  position: getlatLng(),
  title: 'Korrigiert',
  map: map,
  draggable: true
});

marker_org = new google.maps.Marker({
  position: getlatLngOrg(),
  title: 'Original',
  map: map,
  icon: {
	  url: 'http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/blank.png',
  },
  draggable: false
});

adjustPosition();

// Add dragging event listeners.
google.maps.event.addListener(map, 'click', function(event) {
	// Set the new position of the marker
	marker.setPosition(event.latLng);
	
	// Update the model
	$('#picture-map-loc-lat').val(marker.getPosition().lat());
	$('#picture-map-loc-lng').val(marker.getPosition().lng());
	
	// Adjust the map
	adjustPosition();
});

// Add dragging event listeners.
google.maps.event.addListener(marker, 'dragend', function() {
	// Update the model
	$('#picture-map-loc-lat').val(marker.getPosition().lat());
	$('#picture-map-loc-lng').val(marker.getPosition().lng());
	
	// Adjust the map
	adjustPosition();
});

var input = (document.getElementById('picture-map-search-address'));
var searchBox = new google.maps.places.SearchBox(input);

$('#picture-map-search-address').on( 'keydown', function( e ) {
    if ( e.keyCode === 13 ) {
        // You can disable the form submission this way:
        return false
    }
});

google.maps.event.addListener(searchBox, 'places_changed', function() {
	var places = searchBox.getPlaces();

	var bounds = new google.maps.LatLngBounds();
	for (var i = 0, place; place = places[i]; i++) {
	  bounds.extend(place.geometry.location);
	  if (place.geometry.viewport !== undefined) {
		bounds.union(place.geometry.viewport);
	  }
	}

	map.fitBounds(bounds);
	map.setZoom(map.getZoom()+2);
	if (map.getZoom() > 17) {
		map.setZoom(17);
	}
});

google.maps.event.addListener(map, 'idle', function() {
  var bounds = map.getBounds();
  searchBox.setBounds(bounds);
});

$('#picture-tabs #picture-tab-map a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	// Refresh the map on active; otherwise, it will be mingled!
	google.maps.event.trigger(map, 'resize'); 
	adjustPosition();
}); 

$("form").bind("reset", function() {
	// After a form reset we need to update the position of the marker, etc. again
	// We need to wait a litte bit until the values in the form really have been reset.
	setTimeout(function(){
		// Set the marker and then adjust the map
		marker.setPosition(getlatLng());
		adjustPosition();
		
		// Update the clipping
		updatePictureClipCanvas();
	},'100');
});
