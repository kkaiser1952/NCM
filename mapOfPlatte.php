<!DOCTYPE html>
<html>
<head>
  <title>Leaflet Map Example</title>
  
  <!-- Include Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  
  <!-- Include Leaflet JavaScript -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  
  <style>
    #map {
      height: 600px;
    }
  </style>
</head>
<body>
  <div id="map"></div>
  
  <script>
    // Create a new map instance
    var map = L.map('map');

    // Set the map view to Missouri
    map.setView([38.5, -92.5], 7);

    // Add the OpenStreetMap tile layer to the map
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
      maxZoom: 18
    }).addTo(map);

    // Load the GeoJSON data for Clay and Platte Counties from OpenStreetMap
    Promise.all([
      fetch('https://nominatim.openstreetmap.org/search.php?q=Clay+County+Missouri&polygon_geojson=1&format=geojson'),
      fetch('https://nominatim.openstreetmap.org/search.php?q=Platte+County+Missouri&polygon_geojson=1&format=geojson')
    ])
    .then(function(responses) {
      return Promise.all(responses.map(function(response) {
        return response.json();
      }));
    })
    .then(function(datas) {
      // Create new GeoJSON layers with the county boundary data
      var clayLayer = L.geoJSON(datas[0]);
      var platteLayer = L.geoJSON(datas[1]);

      // Add the county layers to the map
      clayLayer.addTo(map);
      platteLayer.addTo(map);

      // Calculate the bounds of the county layers
      var clayBounds = clayLayer.getBounds();
      var platteBounds = platteLayer.getBounds();

      // Fit the map to the bounds of the county layers
      map.fitBounds(clayBounds.extend(platteBounds));

      // Add tooltips to the county layers
      clayLayer.bindTooltip('Clay County').openTooltip();
      platteLayer.bindTooltip('Platte County').openTooltip();

      // Add markers to the map with random coordinates and numbers
      for (var i = 1; i <= 5; i++) {
        var marker = L.marker([
          Math.random() * (platteBounds.getNorth() - platteBounds.getSouth()) + platteBounds.getSouth(),
          Math.random() * (platteBounds.getEast() - platteBounds.getWest()) + platteBounds.getWest()
        ]).addTo(map);
        marker.bindPopup('Marker ' + i);
      }
    });
  </script>
</body>
</html>
