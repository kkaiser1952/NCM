<!DOCTYPE html>

<!-- Just a test map o platte county -->
<!-- Suggested by chatGPT -->

<html>
<head>
  <title>Leaflet Map Example</title>
  
  <!-- Include Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  
  <!-- Include Leaflet JavaScript -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  
  <script src="js/Leaflet.Graticule.js"></script>


  
  <style>
    #map {
     
      height: 1000px;
    }
  </style>
</head>
<body>
  <div id="map"></div>
  
  <script>
// Create a new map instance
var map = L.map('map');

// Set the map view to Platte County
map.setView([39.3621, -94.7722], 12);

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

    // Create a new Graticule instance with the desired options
    var graticule = L.graticule({
        interval: 2,
        style: {
            color: '#333',
            weight: 1,
            opacity: 0.5
        }
    }).addTo(map);
    
    graticule.bringToFront();


    // Fit the map to the bounds of the county layer
    map.fitBounds(countyBounds);
  });


  </script>
</body>
</html>
