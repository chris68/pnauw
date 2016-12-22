$(function() {

    $("div[data-map]").each(function(){
        var map = L.map($(this).attr('id'));

    var osm = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
       attribution: "&copy; <a href='https://www.openstreetmap.org/'>OpenStreetMap</a> and contributors, under an <a href='https://www.openstreetmap.org/copyright' title='ODbL'>open license</a>."
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
