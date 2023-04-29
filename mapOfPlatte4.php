<!DOCTYPE html>
<html>
<head>
  <title>Leaflet Map with Counties</title>
  <!-- Include Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

  <!-- Include Leaflet JavaScript -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

  <!-- Define map height in CSS -->
  <style>
    html, body, #map {
      height: 100%;
      margin: 0;
      padding: 0;
    }
  </style>
</head>
<body>

  <!-- Create a div to hold the map -->
  <div id="mapid"></div>

  <!-- Include the JavaScript to create the map -->
  <script>

    // Create the map
    var map = L.map('mapid');

    // Set the bounds to the bounding box of Platte and Clay Counties
    var bounds = L.latLngBounds([[39.3477, -94.7273], [39.3996, -94.4471]]);
    map.fitBounds(bounds);

    // Add the tile layer
    var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Add the county boundaries
    var countyStyle = {
      "color": "#ff7800",
      "weight": 2,
      "opacity": 1,
      "fillOpacity": 0,
    };

    var counties = L.geoJSON(countyData, {style: countyStyle}).addTo(map);

  </script>

</body>
</html>
