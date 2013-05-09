var size = new OpenLayers.Size(21,25);
var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
var icon = new OpenLayers.Icon('http://www.openlayers.org/dev/img/marker.png', size, offset);
var id = 0;

function addMarker(lon, lat, name, desc) {
    var lonLatMarker = new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);
    var marker = new OpenLayers.Marker(lonLatMarker,icon.clone())
    marker.id = 'marker' + id++;
	marker.events.register("mousedown", marker, function() {
        popup = new OpenLayers.Popup("chicken",
           new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection),
           new OpenLayers.Size(200,200),
           '<strong>' + name + '</strong><p>' + desc + '</p>',
           true);

        map.addPopup(popup);
    });
    markers.addMarker(marker);
}

function processData(xml) {
    markers.clearMarkers();
    
    while( map.popups.length ) {
         map.removePopup(map.popups[0]);
    }
    
    $(xml).find('poi').each(function () {
        var lon = $(this).find('lon').text();
        var lat = $(this).find('lat').text();
        var txt = $(this).find('name').text();
        var desc = $(this).find('description').text();
        desc = desc + '</p><p><strong>Drucksachen:</strong>';
        
        $(this).find('document').each(function() {
            var title = $(this).find('title').text();
            var link = $(this).find('link').text();
            
            desc = desc + '<br /><a href="' + link + '" title="' + title + '" target="_blank">' + title.substring(0,title.indexOf(':')) + '</a>'
        });
        
        addMarker(lon, lat, txt, desc);
    });
}