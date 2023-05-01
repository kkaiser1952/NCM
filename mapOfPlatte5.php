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
<script src="https://unpkg.com/leaflet.maidenhead@1.0.0/src/maidenhead.js"></script>
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
      "weight": 3,
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
      
      
      L.maidenhead({precision: 8}).addTo(map)
      
      
  </script>
</body>
</html>
