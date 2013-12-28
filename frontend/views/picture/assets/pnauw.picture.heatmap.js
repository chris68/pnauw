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

	google.maps.event.addListener(map, 'idle', function() {
		var bounds = map.getBounds();
		searchBox.setBounds(bounds);
		$('#picture-search-map-bounds').val(bounds.toUrlValue());
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
		
		if ($('#picture-search-map-bounds').val() == '') {
			map.fitBounds(bounds);
		} else {
			var corners = $('#picture-search-map-bounds').val().split(',',4);
			var sw = new google.maps.LatLng(corners[0],corners[1]);
			var ne = new google.maps.LatLng(corners[2],corners[3]);
			map.fitBounds(new google.maps.LatLngBounds(sw,ne));
		}
		
		var pointArray = new google.maps.MVCArray(points);

		heatmap = new google.maps.visualization.HeatmapLayer({
		   data: pointArray,
		   map: map,
		   radius: 10,
		   opacity: 0.6
		});
	});		
	
	$('#picture-heatmap-goto-current-geolocation').on( 'click', function( event ) {
		function geolocation_initialize(position) {
			var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			map.setZoom(17);
			map.setCenter(pos);
			var bounds = map.getBounds();
			$('#picture-search-map-bounds').val(bounds.toUrlValue());
			$('#search-form').submit();
		  }

		function geolocation_fail(error){
		}

		event.preventDefault();
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(geolocation_initialize, geolocation_fail);
		}
		return false
	});
});

