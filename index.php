<!DOCTYPE HTML>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <title>OpenLayers Demo</title>
    <style type="text/css">
      html, body, #basicMap {
          height: 100%;
          width: 100%;
          margin:0;
      }
      
      #mapControl {
          position:fixed;
          z-index:9999;
          width:150px;
          height:150px;
          left:100%;
          margin-left:-170px;
          top:10px;
          background-color:white;
          padding:5px;
      }
    </style>
    <script src="jquery.js"></script>
    <script src="OpenLayers.js"></script>
    <script>
      var markers = null;
      var map = null;
      var fromProjection = null;
      var toProjection = null;
      function init() {
        map = new OpenLayers.Map("basicMap");
        var mapnik         = new OpenLayers.Layer.OSM();
        fromProjection = new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
        toProjection   = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection
        var position       = new OpenLayers.LonLat(9.84,52.38).transform( fromProjection, toProjection);
        var zoom           = 13; 
 
        map.addLayer(mapnik);
        
            markers = new OpenLayers.Layer.Markers( "Markers" );
           map.addLayer(markers);
        
				map.setCenter(position, zoom );
				
			//addMarker(9.8623, 52.3936, 'test', 'abc');
            
        $.ajax({
           url: 'data.php',
           dataType: 'xml',
        }).done(function (xml) {
            processData(xml);
        });
        
        $('.mapControlCheckbox').change(function() {
            var pirates = $('input[name=pirates]:checked').size();
            var spd = $('input[name=spd]:checked').size();
            var cdu = $('input[name=cdu]:checked').size();
            var b90 = $('input[name=b90]:checked').size();
            var wfh = $('input[name=wfh]:checked').size();
            var admin = $('input[name=admin]:checked').size();
            
            $.ajax({
                url: 'data.php?pirates=' + pirates + '&spd=' + spd + '&cdu=' + cdu + '&b90=' + b90 + '&wfh=' + wfh + '&admin=' + admin,
                dataType: 'xml',
            }).done(function (xml) {
                processData(xml);
            });
        })
      }
    </script>
    <script src="data.js"></script>
  </head>
  <body onload="init();">
    <div id="mapControl">
        <input type="checkbox" name="pirates" class="mapControlCheckbox" value="1" checked="checked" /> Piraten<br />
        <input type="checkbox" name="spd" class="mapControlCheckbox" value="1" checked="checked" /> SPD<br />
        <input type="checkbox" name="cdu" class="mapControlCheckbox" value="1" checked="checked" /> CDU<br />
        <input type="checkbox" name="b90" class="mapControlCheckbox" value="1" checked="checked" /> B90 / Grüne<br />
        <input type="checkbox" name="wfh" class="mapControlCheckbox" value="1" checked="checked" /> WfH<br />
        <input type="checkbox" name="admin" class="mapControlCheckbox" value="1" checked="checked" /> Stadtverwaltung
    </div>
    <div id="basicMap"></div>
  </body>
</html>