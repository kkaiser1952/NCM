<!DOCTYPE html>
<html>
<head>
  <title>Leaflet Map Example</title>
  
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" >
  
  <!-- ******************************** Load LEAFLET from CDN *********************************** -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
  <!-- ********************************* End Load LEAFLET **************************************** -->
  
  <!-- What 3 Words -->
  <script src="js/control.w3w.js"></script>

  
  <style>
    html, body, #map {
      height: 100%;
      margin: 0;
      padding: 0;
    }
    
    .leaflet-control-mouseCoordinate{
    		background: #d0effa;
    		top: 80%;
    		left: 10px;
    		padding-bottom: 40px;
    }
    .leaflet-container{
        line-height: 1;
    }
    
    .leaflet-control-w3w-locationText {
	    position: fixed;
		font-size: 14pt;
		top: 94%;
		left: 32px;  /* was 110 */
		border: none;
	    text-decoration: none;
	    width: 30%; 
	    background-color: inherit;
	    color: rgb(182,7,7);
	    
	}
  </style>

</head>

<body>
    
  <!-- the map div holds the map -->
  <div id="map"></div>
  
  <script>
      
    // This function can be used to connect the object markers together with a line
    function connectTheDots(data){
        var c = [];
        for(i in data._layers) {
            var x = data._layers[i]._latlng.lat;
            var y = data._layers[i]._latlng.lng;
            c.push([x, y]);
        }
        return c;
    }
    
    // Create a new map instance
    var map = L.map('map', {
    	drawControl: true,
    	zoom: 12
    });

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
      marker.bindPopup(i.toString()).openPopup();
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
