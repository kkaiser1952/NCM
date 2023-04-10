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
map.setView([39.3621, -94.7722], 10);

// Add the OpenStreetMap tile layer to the map
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
  maxZoom: 18
}).addTo(map);

// Load the GeoJSON data for Platte County
fetch('platte-county.geojson')
  .then(function(response) {
    return response.json();
  })
  .then(function(data) {
    // Create a new GeoJSON layer with the county boundary data
    var countyLayer = L.geoJSON(data);

    // Add the county layer to the map
    countyLayer.addTo(map);
  });

    // Create a new map instance
   // var map = L.map('map');

    // Set the map view to Platte County
    //map.setView([39.3621, -94.7722], 10);

    // Add the OpenStreetMap tile layer to the map
    //L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      //attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
      //maxZoom: 18
    //}).addTo(map);
  </script>
</body>
</html>
