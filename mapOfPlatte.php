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
  
    <!-- ******************************** Style Sheets *************************************** -->
    <link rel="stylesheet" href="css/leaflet_numbered_markers.css" />
    <link rel="stylesheet" href="css/L.Grid.css" />   
    <!--<link rel="stylesheet" href="css/L.Control.MousePosition.css" /> -->
    <link rel="stylesheet" href="js/leaflet/leaflet.mouseCoordinate-master/dist/leaflet.mousecoordinate.css">
    <link rel="stylesheet" href="css/control.w3w.css" />
    
    <link rel="stylesheet" href="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.css" />
    <link rel="stylesheet" type="text/css" href="css/maps.css">  
    <link rel="stylesheet" type="text/css" href="css/leaflet/leaflet.contextmenu.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
    
    <!-- https://github.com/ardhi/Leaflet.MousePosition -->
    <!--<script src="js/L.Control.MousePosition.js"></script>-->
     
    <!-- https://github.com/PowerPan/leaflet.mouseCoordinate replaces MousePosition -->
    <script src="js/leaflet/leaflet.mouseCoordinate-master/dist/leaflet.mousecoordinate.min.js"></script>   
    
    <!-- <script src="https://github.com/PowerPan/leaflet.mouseCoordinate.git"></script> -->
    
    <script src="js/hamgridsquare.js"></script>
    
    <script src="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.js"></script>  
    <script src="js/leaflet/leaflet.contextmenu.min.js"></script>
    <!-- Allows for rotating markers when more than one at the same place -->
    <script src="js/leaflet.rotatedMarker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-geometryutil@0.9.1/src/leaflet.geometryutil.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@5/turf.min.js"></script>
    
    <script src="https://assets.what3words.com/sdk/v3/what3words.js?key=5WHIM4GD"></script>
    
    
     
     <!-- ******************************** Load ESRI LEAFLET from CDN ******************************* -->
     <!-- Load Esri Leaflet from CDN -->
  <script src="https://unpkg.com/esri-leaflet@3.0.8/dist/esri-leaflet.js"
    integrity="sha512-E0DKVahIg0p1UHR2Kf9NX7x7TUewJb30mxkxEm2qOYTVJObgsAGpEol9F6iK6oefCbkJiA4/i6fnTHzM6H1kEA=="
    crossorigin=""></script>

  <!-- Load Esri Leaflet Vector from CDN -->
  <script src="https://unpkg.com/esri-leaflet-vector@4.0.0/dist/esri-leaflet-vector.js"
    integrity="sha512-EMt/tpooNkBOxxQy2SOE1HgzWbg9u1gI6mT23Wl0eBWTwN9nuaPtLAaX9irNocMrHf0XhRzT8B0vXQ/bzD0I0w=="
    crossorigin=""></script>
    
    <script src="https://unpkg.com/esri-leaflet-geocoder@2.2.14/dist/esri-leaflet-geocoder.js"
    integrity="sha512-uK5jVwR81KVTGe8KpJa1QIN4n60TsSV8+DPbL5wWlYQvb0/nYNgSOg9dZG6ViQhwx/gaMszuWllTemL+K+IXjg=="
    crossorigin=""></script>     
    <!-- ******************************** End ESRI LEAFLET ***************************************** ->
  
  <!-- What 3 Words -->
  <script src="js/control.w3w.js"></script>
  
  <!-- Various additional Leaflet javascripts -->
  <script src="js/leaflet_numbered_markers.js"></script>
  <script src="js/L.Grid.js"></script>                    <!-- https://github.com/jieter/Leaflet.Grid -->
  <script src="js/geolet.js"></script>
  


  
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
  
  
  <!-- STATIONS DIV, ACTIVITY DIV  GO HERE -->
  
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
    	zoom: 11
    });
    
    // Add what3words, shows w3w in a control
    var w = new L.Control.w3w();
	    w.addTo(map);
        map.on('click', function(e) {
		console.log(e);
		w.setCoordinates(e);
	});
	
	//L.control.mousePosition({separator:',',position:'topright',prefix:''}).addTo(map);
    // https://github.com/PowerPan/leaflet.mouseCoordinate replaces mousePosition above
    //L.control.mouseCoordinate({gpsLong:false,utm:true,qth:true,position:'bottomleft'}).addTo(map);
    
    // https://github.com/ppete2/Leaflet.PolylineMeasure
    // Position to show the control. Values: 'topright', 'topleft', 'bottomright', 'bottomleft'
    // Show imperial or metric distances. Values: 'metres', 'landmiles', 'nauticalmiles'           
    //L.control.polylineMeasure ({position:'topright', unit:'landmiles', showBearings:true, clearMeasurementsOnStop: false, showClearControl: true, showUnitControl: true}).addTo (map);
    
    // Change the position of the Zoom Control to a newly created placeholder.
    map.zoomControl.setPosition('topright');
    // Define the Plus and Minus for zooming and its location
    map.scrollWheelZoom.disable();  // prevents the map from zooming with the mouse wheel
    
    // Distance scale 
    L.control.scale({position: 'bottomright'}).addTo(map);
    
    // Adds a temp marker popup to show location of click
    var popup = L.popup();
    
    /*
    var PoiIconClass = L.Icon.extend({
        options: {
            iconSize: [32, 37]
        }
    });
    */
    
    // Adds a temp marker popup to show location of click
    //var popup = L.popup();
    function onMapClick(e) {
        popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at:<br>" + e.latlng.toString() + "<br>"   )
            .openOn(map);
    }
    
    map.on('click', onMapClick);
    
    // adds the lat/lon grid lines, read them on the top and on the left
    L.grid().addTo(map);  
    
    // https://github.com/rhlt/leaflet-geolet
    L.geolet({ position: 'bottomleft' }).addTo(map);
    
    //var arcgisOnline = L.esri.Geocoding.arcgisOnlineProvider();
    
    var stationMarkers = [];
    var fg = new L.featureGroup();
    
  
    // Flags for use as corners markers
    const blackmarkername         = "BRKMarkers/black_flag.svg";
    const bluemarkername          = "BRKMarkers/blue_flag.svg";
    const darkgreenmarkername     = "BRKMarkers/darkgreen_flag.svg";
    const greenmarkername         = "BRKMarkers/green_flag.svg";
    const graymarkername          = "BRKMarkers/grey_flag.svg";
    const lightbluemarkername     = "BRKMarkers/lightblue_flag.svg";  
    const orangemarkername        = "BRKMarkers/orange_flag.svg";   
    const purplemarkername        = "BRKMarkers/purple_flag.svg";
    const redmarkername           = "BRKMarkers/red_flag.svg";
    const whitemarkername         = "BRKMarkers/white_flag.svg";
    const goldmarkername          = "BRKMarkers/yellow_flag.svg";
    const plummarkername          = "BRKMarkers/plum_flag.svg";
    
    // Center markers
    const manInTheMiddle_50       = "BRKMarkers/black_flag.svg";
    const blackmanInTheMiddle     = "BRKMarkers/black_man.svg";
    const bluemanInTheMiddle      = "BRKMarkers/blue_man.svg";
    const darkgreenmanInTheMiddle = "BRKMarkers/darkgreen_man.svg";
    const greymanInTheMiddle      = "BRKMarkers/grey_man.svg";
    const graymanInTheMiddle      = "BRKMarkers/grey_man.svg";
    const lightbluemanInTheMiddle = "BRKMarkers/lightblue_man.svg";
    const orangemanInTheMiddle    = "BRKMarkers/orange_man.svg";
    const pinkmanInTheMiddle      = "BRKMarkers/pink_man.svg";
    const purplemanInTheMiddle    = "BRKMarkers/purple_man.svg";
    const redmanInTheMiddle       = "BRKMarkers/red_man.svg";
    const whitemanInTheMiddle     = "BRKMarkers/white_man.svg";
    const goldmanInTheMiddle      = "BRKMarkers/yellow_man.svg";
    const plummanInTheMiddle      = "BRKMarkers/plum_man.svg";
    
  
    // Create some icons from the above PoiIconClass class and one from ObjIconClass
/*    var firstaidicon  = new PoiIconClass({iconUrl: 'images/markers/firstaid.png'}),
        eocicon       = new PoiIconClass({iconUrl: 'images/markers/eoc.png'}),
        policeicon    = new PoiIconClass({iconUrl: 'images/markers/police.png'}),
        skywarnicon   = new PoiIconClass({iconUrl: 'images/markers/skywarn.png'}),
        fireicon      = new PoiIconClass({iconUrl: 'images/markers/fire.png'}),
        repeatericon  = new PoiIconClass({iconUrl: 'markers/repeater.png'}),
        govicon       = new PoiIconClass({iconUrl: 'markers/gov.png'}),
        townhallicon  = new PoiIconClass({iconUrl: 'markers/gov.png'}),
        
        objicon       = new ObjIconClass({iconURL: 'images/markers/marker00.png'}), //00 marker
    
        blueFlagicon  = new ObjIconClass({iconUrl: 'BRKMarkers/blue_flag.svg'}),
        greenFlagicon = new ObjIconClass({iconUrl: 'BRKMarkers/green_flag.svg'});
*/
    
    // EVERYTHING ABOVE THIS HAS BEEN TESTED AND WORKS
    

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
