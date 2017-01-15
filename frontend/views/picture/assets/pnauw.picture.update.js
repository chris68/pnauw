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

function updateMarkerOrg() {
    if (marker_org) {
        map.removeLayer(marker_org);
    }

    var cameraIcon = L.divIcon({className: 'glyphicon glyphicon-camera'});
    marker_org = L.marker(getlatLngOrg(),{icon: cameraIcon}).addTo(map);
}

updateMarkerOrg();

map.on('click', function(e) {
    geocodePosition(e.latlng);
});

function toggleLocate(map,isOn) {
    $('#picture-map-geopositioning').prop('checked',isOn);
    if (isOn) {
        map.locate({setView: true, watch: true, enableHighAccuracy: true, maxZoom: 18});
    } else {
        map.stopLocate();
    }
}

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

/*
 * Execute the alpr ajax call and set the respective fields
 */
function excuteAlpr() {
    $.ajax({
        method: "POST",
        url: baseUrl+'/picture/alpr',
        data: {
            image: $("#picture-image").attr("src").split(',')[1], // Need to split of the mime type
            country_code: $('#picture-vehicle_country_code').val() 
        },
        dataType:'json'
    })
    .done(function( data ) {
        //alert(JSON.stringify(data));
        $('#picture-vehicle_reg_plate').val(data.plate); 
        $('#picture-clip-x').val(data.clip_x); 
        $('#picture-clip-y').val(data.clip_y); 
        $('#picture-clip-size').val(data.clip_size); 
        updatePictureClipCanvas();
    });
}

/*
 * Aquire image directly ob the client side
 */

/*
 * Taken from https://github.com/dejanstojanovic/jQuery-ImageResize and heavily adapted
 */
(function($) {
    $.fn.ImageResize = function(options) {
        var defaults = {
            maxWidth: Number.MAX_VALUE,
            maxHeight: Number.MAX_VALUE,
            longestEdge: Number.MAX_VALUE,
            onImageResized: null,
            onFailure: null
    };

        var settings = $.extend({}, defaults, options);
        var selector = $(this);
        selector.each(function(index) {
            var control = selector.get(index);
            control.addEventListener('change', function(event) {
                // First retrieve the exif orientation
                getOrientation(event.target.files[0], function(orientation) {
                    // And then resize
                    handleResize(event.target.files[0],orientation);
                    // Reset the file input; otherwise the files might be uploaded
                    selector.val("");
                })
            });
        });

        /*
         * Resize the uploadedFile and flip/rotate it according the the given exif orientation
         * @param {type} uploadedFile
         * @param {type} orientation
         * @returns {undefined}
         */
        function handleResize(uploadedFile,orientation) {
            //Check File API support
            if (window.File && window.FileList && window.FileReader) {
                var reader = new FileReader();

                if (!uploadedFile.type.match('image/jpeg')) {
                    // Only jpeg pics
                    reader.addEventListener("load", function(event) {
                        selector.each(function () {
                            if ($(this).val() !== "") {
                                settings.onFailure("Sie dürfen nur JPEG Bilder hochladen");
                                return;
                            }
                        });
                    });
                } else {
                    reader.addEventListener("load", function(event) {
                        var file = event.target;
                        var fileData = file.result;

                        var canvasSettings = {
                            width: 0,
                            height: 0,
                            adjustedHeight: Number.MAX_VALUE,
                            adjustedWidth: Number.MAX_VALUE,
                            img: new Image()
                        };
                        canvasSettings.img.src = fileData;
                        canvasSettings.img.onload = function() {
                            canvasSettings.height = canvasSettings.img.height;
                            canvasSettings.width = canvasSettings.img.width;

                            if (settings.longestEdge == Number.MAX_VALUE) {
                                if (canvasSettings.img.width > settings.maxWidth || canvasSettings.img.height > settings.maxHeight) {

                                    if (canvasSettings.img.width > settings.maxWidth) {
                                        setBasedOnWidth(settings.maxWidth, canvasSettings);
                                    }

                                    if (canvasSettings.height > settings.maxHeight) {
                                        setBasedOnHeight(settings.longestEdge, canvasSettings);
                                    }
                                }
                            } else {
                                var widthIsLongest = (canvasSettings.img.width > canvasSettings.img.height) ? true : false;
                                if (widthIsLongest) {
                                    if (canvasSettings.img.width > settings.longestEdge) {
                                        setBasedOnWidth(settings.longestEdge, canvasSettings);
                                    }
                                } else {
                                    if (canvasSettings.img.height > settings.longestEdge) {
                                        setBasedOnHeight(settings.longestEdge, canvasSettings);
                                    }
                                }
                            }

                            var canvas = $("<canvas/>").get(0);
                            
                            if (orientation > 4 && orientation <= 8) {
                                canvas.width = canvasSettings.height;
                                canvas.height = canvasSettings.width;
                            } else {
                                canvas.width = canvasSettings.width;
                                canvas.height = canvasSettings.height;
                            }

                            var context = canvas.getContext('2d');

                            // Taken from  http://stackoverflow.com/questions/19463126/how-to-draw-photo-with-correct-orientation-in-canvas-after-capture-photo-by-usin
                            switch (orientation){

                                case 2:
                                    // horizontal flip
                                    context.translate(canvasSettings.width, 0);
                                    context.scale(-1, 1);
                                    break;
                                case 3:
                                    // 180° rotate left
                                    context.translate(canvas.width, canvasSettings.height);
                                    context.rotate(Math.PI);
                                    break;
                                case 4:
                                    // vertical flip
                                    context.translate(0, canvasSettings.height);
                                    context.scale(1, -1);
                                    break;
                                case 5:
                                    // vertical flip + 90 rotate right
                                    context.rotate(0.5 * Math.PI);
                                    context.scale(1, -1);
                                    break;
                                case 6:
                                    // 90° rotate right
                                    context.rotate(0.5 * Math.PI);
                                    context.translate(0, -canvasSettings.height);
                                    break;
                                case 7:
                                    // horizontal flip + 90 rotate right
                                    context.rotate(0.5 * Math.PI);
                                    context.translate(canvasSettings.width, -canvasSettings.height);
                                    context.scale(-1, 1);
                                    break;
                                case 8:
                                    // 90° rotate left
                                    context.rotate(-0.5 * Math.PI);
                                    context.translate(-canvasSettings.width, 0);
                                    break;
                            }

                            context.drawImage(canvasSettings.img, 0, 0, canvasSettings.width, canvasSettings.height);
                            
                            fileData = canvas.toDataURL('image/jpeg', 0.9);

                            if (settings.onImageResized !== null && typeof (settings.onImageResized) == "function") {
                                settings.onImageResized(fileData);
                            }
                        };
                        canvasSettings.img.onerror = function() {
                            settings.onFailure("Bitte laden Sie eine Datei hoch");
                        };
                    });
                }
                //Read the file
                reader.readAsDataURL(uploadedFile);
            } else {
                settings.onFailure("Ihr Browser unterstützt die File API nicht. Bitte nutzen Sie einen aktuellen HTML5 fähigen Browser für diese Funktionen");
            }

        }

        /*
         * Helper function
         * @param {type} adjustedWidth
         * @param {type} canvasSettings
         * @returns {undefined}
         */
        function setBasedOnWidth(adjustedWidth, canvasSettings) {
            canvasSettings.width = adjustedWidth;
            var ration = canvasSettings.width / canvasSettings.img.width;
            canvasSettings.height = Math.round(canvasSettings.img.height * ration);
        }

        /*
         * Helper function
         * @param {type} adjustedHeight
         * @param {type} canvasSettings
         * @returns {undefined}
         */
        function setBasedOnHeight(adjustedHeight, canvasSettings) {
            canvasSettings.height = adjustedHeight;
            var ration = canvasSettings.height / canvasSettings.img.height;
            canvasSettings.width = Math.round(canvasSettings.img.width * ration);
        }

        /*
         * Taken from http://stackoverflow.com/questions/7584794/accessing-jpeg-exif-rotation-data-in-javascript-on-the-client-side/18912902 and adapted 
         * @param {type} uploadedFile The file from the <input>
         * @param {type} callback The function to be called when done; parameter is the orientation
         * @returns {undefined}
         */
        function getOrientation(uploadedFile, callback) {
            if (window.File && window.FileList && window.FileReader && window.DataView) {
                var reader = new FileReader();
                reader.onload = function(e) {

                  var view = new DataView(e.target.result);
                  if (view.getUint16(0, false) != 0xFFD8) return callback(-2);
                  var length = view.byteLength, offset = 2;
                  while (offset < length) {
                    var marker = view.getUint16(offset, false);
                    offset += 2;
                    if (marker == 0xFFE1) {
                      if (view.getUint32(offset += 2, false) != 0x45786966) return callback(-1);
                      var little = view.getUint16(offset += 6, false) == 0x4949;
                      offset += view.getUint32(offset + 4, little);
                      var tags = view.getUint16(offset, little);
                      offset += 2;
                      for (var i = 0; i < tags; i++)
                        if (view.getUint16(offset + (i * 12), little) == 0x0112)
                          return callback(view.getUint16(offset + (i * 12) + 8, little));
                    }
                    else if ((marker & 0xFF00) != 0xFF00) break;
                    else offset += view.getUint16(offset, false);
                  }
                  return callback(-1);
                };
                reader.readAsArrayBuffer(uploadedFile);
            } else {
                  return callback(-3);
            }
        }
    };
}(jQuery));

