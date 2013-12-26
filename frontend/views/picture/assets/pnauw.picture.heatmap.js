$(function() {
	$.getJSON( heatmapSource, function( data ) {
		var map;
		var heatmap;
		var points = [];
		var bounds = new google.maps.LatLngBounds();

		$.each( data, function( key, val ) {
			var point = new google.maps.LatLng(val.lat,val.lng);
			points.push(point);
			bounds.extend(point);
		});
		
		var mapOptions = {
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		map = new google.maps.Map($('#picture-heatmap-map-canvas').get(0), mapOptions);
		map.fitBounds(bounds);

		var pointArray = new google.maps.MVCArray(points);

		heatmap = new google.maps.visualization.HeatmapLayer({
		   data: pointArray,
		   map: map,
		   // dissipating: true,
		   radius: 10,
		   opacity: 0.6
		});
	});		
});
