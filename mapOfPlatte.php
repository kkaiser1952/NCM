<!DOCTYPE html>
<!-- Just a test map of Platte and Clay counties -->
<!-- Suggested by ChatGPT -->
<!-- map.setView([39.3172, -94.5123], 10); -->



<html>
<head>
  <title>Leaflet Map Example</title>
  
  <!-- Include Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  
  <!-- Include Leaflet JavaScript -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  
  <style>
    #map {
      height: 800px;
    }
  </style>
</head>
<body>
  <div id="map"></div>
  
  <script>
    // Create a new map instance
    var map = L.map('map');

    // Set the map view to Platte County
    map.setView([39.3621, -94.7722], 10);

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
        var countyLayer = L.geoJSON(data);

        // Add the county layer to the map
        countyLayer.addTo(map);

        // Calculate the bounds of the county layer
        var countyBounds = countyLayer.getBounds();

        // Fit the map to the bounds of the county layer
        map.fitBounds(countyBounds);
      });
      
    // Load the GeoJSON data for Clay County from OpenStreetMap
    fetch('https://nominatim.openstreetmap.org/search.php?q=Clay+County+Missouri&polygon_geojson=1&format=geojson')
      .then(function(response) {
        return response.json();
      })
      .then(function(data) {
        // Create a new GeoJSON layer with the county boundary data
        var countyLayer = L.geoJSON(data);

        // Add the county layer to the map
        countyLayer.addTo(map);

        // Calculate the bounds of the county layer
        var countyBounds = countyLayer.getBounds();

        // Fit the map to the bounds of the county layer
        map.fitBounds(countyBounds);
      });

    // Create a new Graticule instance with the desired options
    var graticule = L.latLngGraticule({
      interval: 1,
      showLabel: true,
      opacity: 0.5,
      fontColor: '#333'
    });

    // Add the Graticule layer to the map
    graticule.addTo(map);

    // Bring the Graticule layer to the front of the map
    graticule.bringToFront();

  </script>
</body>
</html>

