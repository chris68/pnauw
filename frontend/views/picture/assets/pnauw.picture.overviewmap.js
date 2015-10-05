$(function() {
    var map = L.map('overviewmap');

    L.tileLayer("http://otile{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png", {
       subdomains: "1234",
       attribution: "&copy; <a href='http://www.openstreetmap.org/'>OpenStreetMap</a> and contributors, under an <a href='http://www.openstreetmap.org/copyright' title='ODbL'>open license</a>. Tiles Courtesy of <a href='http://www.mapquest.com/'>MapQuest</a> <img src='http://developer.mapquest.com/content/osm/mq_logo.png'>"
    }).addTo(map);

    var incidentGroup = L.featureGroup([]);
    incidentGroup.addTo(map);

    var positionLayerGroup = L.layerGroup([]);
    positionLayerGroup.addTo(map);

    L.control.layers({},{"Position": positionLayerGroup, "Vorfälle": incidentGroup}).addTo(map);

    map.on('moveend', function(e) {
         $('#search-map-bounds').val(map.getBounds().toBBoxString());
         var mapstate = {center:map.getCenter(), zoom:map.getZoom()};
         $('#search-map-state').val(JSON.stringify(mapstate));
         //console.debug('#search-map-bounds updated ('+$('#search-map-bounds').val()+')');
         //console.debug('#search-map-state updated ('+$('#search-map-state').val()+')');
    });

    map.on('locationerror', function(e) {
        alert(e.message);
    });

    map.on('locationfound', function(e) {
        positionLayerGroup.clearLayers();
        positionLayerGroup.addLayer(L.circle(e.latlng, e.accuracy / 2, {opacity:0.2}));
    });

    if ($('#search-map-gps').val() == 'locate-once') {
        $('#search-map-gps').val('');
        
        map.locate({setView: true, watch: false, maxZoom: 16}); 
    }

    if ($('#search-map-bounds').val() != '') {
        // 
        if ($('#search-map-state').val() != '') {
            // Restore previous map state if set
            // console.debug('#search-map-state restored ('+$('#search-map-state').val()+')');
            var mapstate = JSON.parse($('#search-map-state').val());
            map.setView(mapstate.center, mapstate.zoom);
        }
    }

    $("#search-map").on ( 'click', "a", function( event ) {
        // If we use a <b> etc. in the <a> element then the event.target is sometimes the <b>.
        //  We need to navigate up then to the actual <a>
        realtarget = $(event.target).closest('a');

        if (realtarget.data('value') == 'bind') {
            event.preventDefault();
            $('#search-map-bind').prop('checked',true);
            $('#search-form')[0].submit();
        } 
        else if (realtarget.data('value') == 'dynamic') {
            event.preventDefault();
            $('#search-map-bind').prop('checked',false);
            $('#search-form')[0].submit();
        }
        else if (realtarget.data('value') == 'gps') {
            // Do not call event.preventDefault to ensure the menue is closed again!
            map.locate({setView: true, watch: false, maxZoom: 16});
        }
        else {
            // Uupps. That one we don't know...
        }
        
    });
    
    $("#search-time").on ( 'click', "a", function( event ) {
        event.preventDefault();
        $('#search-time-range').val($(event.target).closest('a').data('value'));
        $('#search-form')[0].submit();
    });

    $('#search-refresh').on( 'click', function( event ) {
        event.preventDefault();
        $('#search-form')[0].submit();
        return false;
    });

    $('#search-cancel').on( 'click', function( event ) {
        event.preventDefault();
        // It is important that we use $('#search-cancel') and not $(event.target).data('value') 
        // since the event target is the span in the button and not the button itself!
        window.location.assign($('#search-cancel').data('url'));
        return false;
    });

    $.getJSON(overviewmapSource, function( data ) {
        var pointDefaultOptions = {
            radius: 6,
            fillColor: "#FF0000", // red
            color: "#000",
            weight: 1,
            opacity: 1,
            fillOpacity: 0.8
        };
        incidentGroup.addLayer(L.geoJson(data, {
            onEachFeature: function (feature, layer) {
                if (feature.properties && feature.properties.incident_name) {
                    layer.bindPopup('<a href="/picture/view?id='+feature.properties.picture_id+
                            '" target="_blank">'+feature.properties.incident_name+'</a>');
                }
            },
            pointToLayer: function (feature, latlng) {
                var pointOptions = pointDefaultOptions;
                if (feature.properties && feature.properties.incident_id) {
                    switch (feature.properties.incident_id) {
                        case -1:
                        case 19:
                        case 8:
                            pointOptions.radius = 6;
                            pointOptions.fillColor = '#808080'; // grey
                            break;
                        case 12:
                        case 13:
                            pointOptions.radius = 9;
                            pointOptions.fillColor = '#FFA500'; // orange
                            break;
                        case 1:
                        case 16:
                            pointOptions.radius = 6;
                            pointOptions.fillColor = '#FFA500'; // orange
                            break;
                        case 14:
                        case 15:
                            pointOptions.radius = 9;
                            pointOptions.fillColor = '#FF0000'; // red
                            break;
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                        case 7:
                        case 18:
                            pointOptions.radius = 6;
                            pointOptions.fillColor = '#FF0000'; // red
                            break;
                        case 11:
                            pointOptions.radius = 9;
                            pointOptions.fillColor = '#228B22'; // ForestGreen
                            break;
                        case 9:
                        case 10:
                            pointOptions.radius = 6;
                            pointOptions.fillColor = '#228B22'; // ForestGreen
                            break;
                        case 17:
                            pointOptions.radius = 6;
                            pointOptions.fillColor = '#0000FF'; // Blue
                            break;
                        default: 
                            ;
                    }
                }
                return L.circleMarker(latlng, pointOptions);
            }
        }));

        if ($('#search-map-bounds').val() == '') {
            // If we do not have any other information about the map state, we need to calculate the bounds from the data
            if (data.length > 0) {
                map.fitBounds(incidentGroup.getBounds());
            } else {
                map.fitWorld();
            }
        }
    });

});
