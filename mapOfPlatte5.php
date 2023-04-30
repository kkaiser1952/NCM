<!DOCTYPE html>
<html>
<head>
  <title>Leaflet Map Example</title>
  
  <!-- Include Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  
<!-- Include Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  
<!-- Include Graticule plugin JavaScript -->
<!--<script src="https://ha8tks.github.io/Leaflet.Maidenhead/src/L.Maidenhead.js"></script>-->
<!--<script src="js/maidenhead8.js"></script>-->
 

  <style>
    html, body, #map {
      height: 100%;
      margin: 0;
      padding: 0;
    }
  </style>
  
</head>
<body>
  <div id="map"></div>
  
  
  <script>
    // Create a new map instance
    var map = L.map('map', {zoom:13, tileSize: 512});
    // Set the bounds to the bounding box of Platte and Clay Counties
    var bounds = L.latLngBounds([[39.3477, -94.7273], [39.3996, -94.4471]]);
    map.fitBounds(bounds);

    // Add the OpenStreetMap tile layer to the map
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
      maxZoom: 18,
      tileSize: 512,
      zoomOffset: -1
    }).addTo(map);
    
    // Add the county boundaries
    var countyStyle = {
      "color": "#ff7800",
      "weight": 2,
      "opacity": 1,
      "fillOpacity": 0,
    };

    // Load the GeoJSON data for Platte County from OpenStreetMap
    fetch('https://nominatim.openstreetmap.org/search.php?q=Platte+County+Missouri&polygon_geojson=1&format=geojson')
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        // Create a new GeoJSON layer with the county boundary data
        var countyLayer = L.geoJSON(data, {
          style: {
            color: 'blue',
            opacity: 1,
            fillOpacity: 0,
            weight: 3
          },
          onEachFeature: function(feature, layer) {
            layer.bindTooltip(feature.properties.display_name, {
              sticky: true
            });
          }
        });

        // Add the county layer to the map
        countyLayer.addTo(map);
      });

    // Load the GeoJSON data for Clay County from OpenStreetMap
    fetch('https://nominatim.openstreetmap.org/search.php?q=Clay+County+Missouri&polygon_geojson=1&format=geojson')
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        // Create a new GeoJSON layer with the county boundary data
        var countyLayer = L.geoJSON(data, {
          style: {
            color: 'blue',
            opacity: 1,
            fillOpacity: 0,
            weight: 3
          },
          onEachFeature: function(feature, layer) {
            layer.bindTooltip(feature.properties.display_name, {
              sticky: true
            });
          }
        });

        // Add the county layer to the map
        countyLayer.addTo(map);
      });
      
      /*
      // Add a Maidenhead grid overlay with 4 levels of precision
      var gridLevels = [2, 4, 6, 8]; // Define the levels of precision
      var gridPrecisions = gridLevels.map(level => Math.pow(10, -level / 2)); // Calculate the grid precisions
      var minLat = -90;
      var maxLat = 90;
      var minLng = -180;
      var maxLng = 180;

      for (var i = 0; i < gridLevels.length; i++) {
        var level = gridLevels[i];
        var precision = gridPrecisions[i];
        var lat = minLat;
        while (lat < maxLat) {
          var lng = minLng;
          while (lng < maxLng) {
            var maidenhead = toMaidenhead(lat, lng, level);
            var label = toMaidenheadLabel(maidenhead, level);
            var bounds = [[lat, lng], [lat + precision, lng + precision]];
            L.rectangle(bounds, { color: 'blue', weight: 1, fillOpacity: 0, attribution: label }).addTo(map);
            lng += precision;
          }
          lat += precision;
        }
      }
      
      L.rectangle(bounds, {color: 'blue', weight: 2, fillOpacity: 0, attribution: label }).addTo(map);
      
      function toMaidenhead(maidenhead, level, precision) {
  // Maidenhead to lat/lon
  const { lat, lon } = maidenheadToLatLon(maidenhead);

  // Lat/Lon to Maidenhead
  const coords = toMaidenheadString(lat, lon, level);
  const label = toMaidenheadLabel(lat, lon, precision);
  
  console.log('coords');
  return { coords, label };
}
*/
      
   /*   function toMaidenhead(lat, lng, level) {
          var maidenhead = '';
          var latCoord = (lat + 90) / 180;
          var lngCoord = (lng + 180) / 360;
          var latDiv = 1;
          var lngDiv = 1;
        
          for (var i = 0; i < level; i++) {
            latDiv *= 2;
            lngDiv *= 2;
            var latIndex = Math.floor(latCoord * latDiv);
            var lngIndex = Math.floor(lngCoord * lngDiv);
            maidenhead += String.fromCharCode(65 + (lngIndex * 2) + (latIndex % 2));
            maidenhead += String.fromCharCode(65 + (latIndex * 1) + ((lngIndex % 2) * 24));
            latCoord -= latIndex / latDiv;
            lngCoord -= lngIndex / lngDiv;
          }
            console.log(maidenhead);
          return maidenhead;
        }
*/
/*
    function toMaidenheadLabel(lat, lon, precision) {
      const coords = toMaidenhead(lat, lon, precision);
      const labelLat = `${Math.abs(lat).toFixed(precision)}${lat >= 0 ? 'N' : 'S'}`;
      const labelLon = `${Math.abs(lon).toFixed(precision)}${lon >= 0 ? 'E' : 'W'}`;
      return `${coords} (${labelLat}, ${labelLon})`;
    }

 
      // Convert latitude and longitude to Maidenhead grid square
      function toMaidenhead(lat, lng, level) {
        var precision = Math.pow(10, -level / 2);
        var latIndex = Math.floor((lat + 90) / precision);
        var lngIndex = Math.floor((lng + 180) / (2 * precision));
        var latSubIndex = Math.floor(((lat + 90) % precision) / (precision / 10));
        var lngSubIndex = Math.floor(((lng + 180) % (2 * precision)) / (precision / 5));
        return String.fromCharCode(65 + lngIndex) +
               String.fromCharCode(65 + latIndex) +
               latSubIndex.toString() +
               lngSubIndex.toString();
      }
      */
      // Convert Maidenhead grid square to label
  //    function toMaidenheadLabel(maidenhead, level) {
    //    return 'Maidenhead: ' + maidenhead + ', Precision: ' + level.toString();
    //  }
     
      // Add a Maidenhead grid overlay with 4 levels of precision
     
/*    var gridLevels = [2, 4, 6, 8]; // Define the levels of precision
    var gridPrecisions = gridLevels.map(level => Math.pow(10, -level / 2)); // Calculate the grid precisions
    var minLat = 35.5;
    var maxLat = 40.5;
    var minLng = -95.5;
    var maxLng = -93.5;
    
    for (var i = 0; i < gridLevels.length; i++) {
      var level = gridLevels[i];
      var precision = gridPrecisions[i];
      var lat = minLat;
      while (lat < maxLat) {
        var lng = minLng;
        while (lng < maxLng) {
          var maidenhead = toMaidenhead(lat, lng, level);
          var label = toMaidenheadLabel1(maidenhead, level);
          var bounds = [[lat, lng], [lat + precision, lng + 2 * precision]];
          L.rectangle(bounds, { color: 'blue', weight: 1, fillOpacity: 0, attribution: label }).addTo(map);
          lng += 2 * precision;
        }
        lat += precision;
      }
    }
      
  */
  </script>
</body>
</html>
