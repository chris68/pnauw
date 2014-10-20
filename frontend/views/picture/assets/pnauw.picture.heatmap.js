$(function() {
	var map;
	var mapOptions = {
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		center: new google.maps.LatLng(0, 0),
		zoom: 10,
	};

	map = new google.maps.Map($('#picture-heatmap-map-canvas').get(0), mapOptions);

	if ($('#search-map-bounds').val() != '') {
		// Restore previous bounds if set
		var corners = $('#search-map-bounds').val().split(',',4);
		var sw = new google.maps.LatLng(corners[0],corners[1]);
		var ne = new google.maps.LatLng(corners[2],corners[3]);
		bounds = new google.maps.LatLngBounds(sw,ne);
		// console.debug('Bounds restored - Target ('+bounds.toUrlValue()+')');
		map.fitBounds(bounds); 

		var listener = google.maps.event.addListener(map, 'idle', function(){
			// Google zooms just one zoom level lower - so we need to zoom in again!
			// But we have to wait for the idle event, i.e. until the fitBounds is completed
			google.maps.event.removeListener(listener);
			map.setZoom(map.getZoom()+1); 
		});

		// console.debug('Bounds restored - Actual ('+map.getBounds().toUrlValue()+')');
	}

	$('#picture-heatmap-search-address').on( 'keydown', function( e ) {
		if ( e.keyCode === 13 ) {
			// You can disable the form submission this way:
			return false
		}
	});

	$("#search-time li").on ( 'click', function( event ) {
		event.preventDefault();
		$('#search-time-range').val($(event.target).data('value'));
		$('#search-form').submit();
	});
	
	$("#search-map li").on ( 'click', function( event ) {
		if ($(event.target).data('value') == 'bind') {
			event.preventDefault();
			$('#search-map-bind').prop('checked',true);
			$('#search-form').submit();
			return false;
		} 
		else if ($(event.target).data('value') == 'dynamic') {
			event.preventDefault();
			$('#search-map-bind').prop('checked',false);
			$('#search-form').submit();
			return false;
		}
		else if ($(event.target).data('value') == 'gps') {
			function geolocation_initialize(position) {
				// console.debug('Geolocation: Got it');
				var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				map.setCenter(pos);
				map.setZoom(16);
				var bounds = map.getBounds();
				$('#search-map-bounds').val(bounds.toUrlValue());
				$('#search-map-bind').prop('checked',true);
				$('#search-form').submit();
			  }

			function geolocation_fail(error) {
				// console.debug('Geolocation: Failed');
			}

			// console.debug('Geolocation: Trigger');
			
			if (navigator.geolocation) {
				event.preventDefault();
				// console.debug('Geolocation: Yep');
				navigator.geolocation.getCurrentPosition(geolocation_initialize, geolocation_fail);
				return false;
			}
			else
			{
				// console.debug('Geolocation: Nope');
			
				return true;
			}
		}
		else {
			// Uupps. That on we do'nt know
		}
		
	});
	
	$('#search-refresh').on( 'click', function( event ) {
		event.preventDefault();
		$('#search-form').submit();
		return false;
	});

	$('#search-cancel').on( 'click', function( event ) {
		event.preventDefault();
		// It is important that we use $('#search-cancel') and not $(event.target).data('value') 
		// since in chrome the target is the span in the button and not the button itself!
		window.location.assign($('#search-cancel').data('url'));
		return false;
	});

	var input = (document.getElementById('picture-heatmap-search-address'));
	var searchBox = new google.maps.places.SearchBox(input);

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
		var listener = google.maps.event.addListener(map, 'idle', function(){
			// Google zooms a little bit to far out - so we need to zoom in again!
			// But we have to wait for the idle event, i.e. until the fitBounds is completed
			google.maps.event.removeListener(listener);
			if (map.getZoom() > 16) {
				map.setZoom(16);
			} else {
				map.setZoom(map.getZoom()+1);
			}
		});
	});

	// Idle is better than bounds_changed since it fires only once at the end
	google.maps.event.addListener(map, 'idle', function() {
		var bounds = map.getBounds();
		if (bounds) {
			// console.debug('Bounds updated ('+bounds.toUrlValue()+')');
			$('#search-map-bounds').val(bounds.toUrlValue());
			searchBox.setBounds(bounds);
		}
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
		
		if ($('#search-map-bounds').val() == '') {
			map.fitBounds(bounds);
			// console.debug('Bounds calculated ('+bounds.toUrlValue()+')');
		}
		
		var pointArray = new google.maps.MVCArray(points);

		heatmap = new google.maps.visualization.HeatmapLayer({
		   data: pointArray,
		   map: map,
		   radius: 10,
		   opacity: 0.6
		});
	});		
	
});

