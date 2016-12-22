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
 * Leaflet map functionality on tab "_maptab"
 */

function getlatLng() {
    return L.latLng($('#picture-map-loc-lat').val(),$('#picture-map-loc-lng').val());
}
function getlatLngOrg() {
    return L.latLng($('#picture-map-loc-lat-org').val(),$('#picture-map-loc-lng-org').val());
}

var
    map = L.map('picture-map-canvas').setView(getlatLng(),16),
    geocoder = L.Control.Geocoder.nominatim(),
    control = L.Control.geocoder({
        geocoder: geocoder,
        defaultMarkGeocode: false // disable the default handler
    })
    .on('markgeocode', function(result) {
        // and define your own without the marker
			result = result.geocode || result;

			this._map.fitBounds(result.bbox);

			return this;
    })
    .addTo(map),
    marker,
    marker_org;

var osm = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
   attribution: "&copy; <a href='https://www.openstreetmap.org/'>OpenStreetMap</a> and contributors, under an <a href='https://www.openstreetmap.org/copyright' title='ODbL'>open license</a>."
});
map.addLayer(osm);

marker = L.marker(getlatLng(),{draggable:true}).addTo(map);
marker.on('dragend', function(e) {
    geocodePosition(e.target.getLatLng());
});

var cameraIcon = L.divIcon({className: 'glyphicon glyphicon-camera'});
marker_org = L.marker(getlatLngOrg(),{icon: cameraIcon}).addTo(map);

map.on('click', function(e) {
    geocodePosition(e.latlng);
});

if ($('#picture-map-loc-formatted-addr').val() == '') {
    // Of the orgiginal coordinates and the current coords are the same then geocode since then it is the first time
    geocodePosition(getlatLng());
}


function geocodePosition(pos) {

    // Update the model
    $('#picture-map-loc-lat').val(pos.lat);
    $('#picture-map-loc-lng').val(pos.lng);


    geocoder.reverse(pos, map.options.crs.scale(map.getZoom()), function(results) {
        console.debug(results);
        var r = results[0];
        if (r) {
            // Built up the 
            var address =  [
                [
                    r.properties.address.footway,
                    r.properties.address.road,
                    r.properties.address.house_number
                ].filter(val => val).join(' '),
                [
                    r.properties.address.postcode,
                    r.properties.address.suburb,
                    r.properties.address.city_district,
                    r.properties.address.town,
                    r.properties.address.city
                ].filter(val => val).join(' ')
            ].filter(val => val).join(', ');

            if (address=='')  {
                $('#picture-map-nearest-address').html("<div class='alert alert-warning'>Sie müssen näher reinzoomen, damit eine Adresse ermittelt werden kann</div>");
            } else{
                $('#picture-map-nearest-address').text (address);
                $('#picture-map-loc-formatted-addr').val(address);
            }
            
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(pos,{draggable:true}).addTo(map);
            marker.on('dragend', function(e) {
                geocodePosition(e.target.getLatLng());
            });
        } else {
            $('#picture-map-nearest-address').html("<div class='alert alert-warning'>Es konnte keine Adresse ermittelt werden</div>");
            $('#picture-map-loc-formatted-addr').val('');
        }
    });
}


$('#picture-tabs #picture-tab-map a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    // Refresh the map on active; otherwise, it will be mingled!
    map.invalidateSize(false);

    //adjustPosition();
});

$("form").bind("reset", function() {
    // After a form reset we need to update the position of the marker, etc. again
    // We need to wait a litte bit until the values in the form really have been reset.
    setTimeout(function(){
        // Set the marker, adjust the map 
        marker.setLatLng(getlatLng());
        map.panTo(getlatLng());
        
        // Update the clipping
        updatePictureClipCanvas();
    },'100');
});
