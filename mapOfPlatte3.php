<!DOCTYPE html>
<html>
<head>
  <title>Leaflet Map Example</title>
  
  <!-- Include Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  
  <!-- Include Leaflet JavaScript -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  
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
    var map = L.map('map');


    // Set the map view to Platte County and Clay County
    map.fitBounds([
      [39.3946, -95.0588],
      [39.32, -94.6302]
    ]);

    // Add the OpenStreetMap tile layer to the map
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
      maxZoom: 18
    }).addTo(map);

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
            fillOpacity: 0,
            weight: 2
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
            fillOpacity: 0,
            weight: 2
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

    // Add the Maidenhead grid to the map
    L.latlngGraticule({
      showLabel: true,
      color: 'green',
      zoomInterval: [
        {start: 0, end: 1, interval: 10},
        {start: 2, end: 2, interval: 5},
        {start: 3, end: 3, interval: 1}
      ]
    }).addTo(map);
    
   // L.utm({ellps: 'WGS84', zone: 15, southHemi: false}).addTo(map);
    //L.maidenhead({color: 'black', fontsize: 14, precision: 8}).addTo(map);

  </script>
</body>
</html>
