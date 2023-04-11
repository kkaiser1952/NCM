<!DOCTYPE html>
<html>
<head>
  <title>Leaflet Map Example</title>
  
  <!-- Include Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
     <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
  
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

    // Set the map view to Clay and Platte Counties
    map.fitBounds([[39.165, -94.8335], [39.4385, -94.499]]);

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
      
      // Add 5 randomly located numbered markers
    for (var i = 1; i <= 5; i++) {
      var marker = L.marker(getRandomCoords()).addTo(map);
      marker.bindPopup('Marker ' + i).openPopup();
      marker.bindTooltip(i.toString(), {
        permanent: true,
        direction: 'top',
        className: 'numbered-marker'
      });
    }
    
    
// Function to generate random coordinates within the map bounds
function getRandomCoords() {
  var southWest = map.getBounds().getSouthWest();
  var northEast = map.getBounds().getNorthEast();
  var lngSpan = northEast.lng - southWest.lng;
  var latSpan = northEast.lat - southWest.lat;
  var randomLng = Math.random() * lngSpan + southWest.lng;
  var randomLat = Math.random() * latSpan + southWest.lat;
  return [randomLat, randomLng];
}
  </script>
</body>
</html>
