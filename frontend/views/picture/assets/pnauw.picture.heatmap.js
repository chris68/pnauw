$(function() {
	var map;
	var mapOptions = {
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	map = new google.maps.Map($('#picture-heatmap-map-canvas').get(0), mapOptions);

	var input = (document.getElementById('picture-heatmap-search-address'));
	var searchBox = new google.maps.places.SearchBox(input);

	$('#picture-heatmap-search-address').on( 'keydown', function( e ) {
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

	google.maps.event.addListener(map, 'bounds_changed', function() {
	  var bounds = map.getBounds();
	  searchBox.setBounds(bounds);
	});

	$.getJSON( heatmapSource, function( data ) {
		var heatmap;
		var points = [];
		var bounds = new google.maps.LatLngBounds();

		$.each( data, function( key, val ) {
			var point = new google.maps.LatLng(val.location.lat, val.location.lng);
			// Construct a weighted location
			points.push({location:point, weight:val.severity+1});
			bounds.extend(point);
		});
		
		map.fitBounds(bounds);
		var pointArray = new google.maps.MVCArray(points);

		heatmap = new google.maps.visualization.HeatmapLayer({
		   data: pointArray,
		   map: map,
		   radius: 10,
		   opacity: 0.6
		});
	});		
});
