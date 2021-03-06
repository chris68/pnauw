$(function() {

    $("div[data-map]").each(function(){
        var map = L.map($(this).attr('id'), { zoomControl:false });
        map.touchZoom.disable();
        map.doubleClickZoom.disable();
        map.scrollWheelZoom.disable();
        map.boxZoom.disable();
        map.keyboard.disable();
        map.dragging.disable();

        var osm = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
           attribution: "&copy; OpenStreetMap contributors, under an <a href='www.openstreetmap.org/copyright' title='ODbL'>open license</a>."
    });
    osm.addTo(map);

        var pointOptions = {
            radius: 10,
            fillColor: "#FF0000",
            color: "#000",
            weight: 1,
            opacity: 1,
            fillOpacity: 0.8
        };

        L.circleMarker([$(this).data('lat'), $(this).data('lng')], pointOptions).addTo(map);

        map.setView([$(this).data('lat'), $(this).data('lng')], $(this).data('zoom'));
    });
});
