$(function() {

    $("div[data-map]").each(function(){
        var map = L.map($(this).attr('id'));

        L.tileLayer("http://otile{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png", {
           subdomains: "1234",
           attribution: "&copy; <a href='http://www.openstreetmap.org/'>OpenStreetMap</a> and contributors, under an <a href='http://www.openstreetmap.org/copyright' title='ODbL'>open license</a>. Tiles Courtesy of <a href='http://www.mapquest.com/'>MapQuest</a> <img src='http://developer.mapquest.com/content/osm/mq_logo.png'>"
        }).addTo(map);

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
