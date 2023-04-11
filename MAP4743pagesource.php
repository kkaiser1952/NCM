<!DOCTYPE html>

<!-- This is a hand built map, not one from a net anymore, all the items appearing on the map are hard coded into this program. -->

<!-- Primary maping program, also uses poiMarkers.php, objMarkers.php and stationMarkers.php -->

<!-- Development using objlayer3818.php instead of objMarkers3818.php -->

  
<html lang="en">
<head>
	<title>NCM Map of Station Locations</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" >

     <!-- ******************************** Load LEAFLET from CDN *********************************** -->
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

  <!-- Include Leaflet JavaScript -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
     <!-- ********************************* End Load LEAFLET **************************************** -->
     
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
    <!-- Various additional Leaflet javascripts -->
    <script src="js/leaflet_numbered_markers.js"></script>
    <script src="js/L.Grid.js"></script>                    <!-- https://github.com/jieter/Leaflet.Grid -->
    <script src="js/L.Control.MousePosition.js"></script>   <!-- https://github.com/ardhi/Leaflet.MousePosition -->
    <script src="js/hamgridsquare.js"></script>
    
    <script src="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.js"></script>  
    <script src="js/leaflet/leaflet.contextmenu.min.js"></script>
    <!-- Allows for rotating markers when more than one at the same place -->
    <script src="js/leaflet.rotatedMarker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-geometryutil@0.9.1/src/leaflet.geometryutil.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@5/turf.min.js"></script>
    
    <script src="https://assets.what3words.com/sdk/v3/what3words.js?key=5WHIM4GD"></script>


     
     <!-- ******************************** Load ESRI LEAFLET from CDN ******************************* -->
     <script src="https://unpkg.com/esri-leaflet@2.2.4/dist/esri-leaflet.js"
    integrity="sha512-tyPum7h2h36X52O2gz+Pe8z/3l+Y9S1yEUscbVs5r5aEY5dFmP1WWRY/WLLElnFHa+k1JBQZSCDGwEAnm2IxAQ=="
    crossorigin=""></script>
    
    <!-- Load Esri Leaflet Geocoder from CDN -->
	<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.14/dist/esri-leaflet-geocoder.css"
    integrity="sha512-v5YmWLm8KqAAmg5808pETiccEohtt8rPVMGQ1jA6jqkWVydV5Cuz3nJ9fQ7ittSxvuqsvI9RSGfVoKPaAJZ/AQ=="
    crossorigin="">
    
    <script src="https://unpkg.com/esri-leaflet-geocoder@2.2.14/dist/esri-leaflet-geocoder.js"
    integrity="sha512-uK5jVwR81KVTGe8KpJa1QIN4n60TsSV8+DPbL5wWlYQvb0/nYNgSOg9dZG6ViQhwx/gaMszuWllTemL+K+IXjg=="
    crossorigin=""></script>     
    <!-- ******************************** End ESRI LEAFLET ***************************************** -->
     
     <!-- ******************************** Style Sheets *************************************** -->
    <link rel="stylesheet" href="css/leaflet_numbered_markers.css" />
    <link rel="stylesheet" href="css/L.Grid.css" />   
    <link rel="stylesheet" href="css/L.Control.MousePosition.css" />
    <link rel="stylesheet" href="css/control.w3w.css" />
    
    <link rel="stylesheet" href="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.css" />
    <link rel="stylesheet" type="text/css" href="css/maps.css">  
    <link rel="stylesheet" type="text/css" href="css/leaflet/leaflet.contextmenu.min.css">
    
        
    <!-- What 3 Words -->
    <script src="js/control.w3w.js"></script>

    
    <!-- circleKoords is the javascript program that caluclates the number of rings and the distance between them -->
    <script src="js/circleKoords.js"></script>    

	<style>
		/* All CSS is in css/maps.css */
		.cc {  /* used for the comment */
		    display: inline-block;
		    text-transform: lowercase;
    		font-weight: bold;
    		color: red;
    		font-size: larger;
		}
		.cc:first-letter {
    		text-transform: uppercase;
		}
		
		.bb {
    		font-weight: bold;
    		color: blue;
    		font-size: larger;
		}
		
		element.style  {
    		width: 60px !important;
        }
        
        .gg {
            font-weight: bold;
            color: green;
            font-size: larger;
        }
        
        .xx {
            font-wight: bold;
            font-size: x-large;
        }
        
        .objmarker {
            color: green;
            font-size: x-large;
        }
        
        .number-icon {
            background-image: url("images/number-marker-icon.png");
            text-align:center;
            color:White;    
        }
        
        .leaflet-control {
            background: transparent;
            border: solid black;
        }
        
        .leaflet-control-zoom {
           
        }
        

        .huechange { 
            filter: hue-rotate(120deg); 
        }

        
		
	</style>
	
</head>

<body>
    
    <!-- the map div holds the map -->
    <div id="map"></div>
    
    <!-- the stations div holds a list of the stations marked on the map -->
    <!-- Under the banner in the upper left corner -->
    <div id="stations"> 
		<b style="color:red; text-decoration: underline;">TE0ST
    		</b><br><a class='rowno' id='marker_1' href='#'>1 _WA0TJT</a><br><a class='rowno' id='marker_2' href='#'>2 _W0DLK</a><br><a class='rowno' id='marker_3' href='#'>3 _KD0FTY</a><br><a class='rowno' id='marker_4' href='#'>4 _KC9OAZ</a><br>	</div>

    <!-- The title banner -->
    <div id="activity" class="activity">
    	<img src="images/NCM.png" alt="NCM" style="width: 35px; padding-left: 10px; padding-top: 5px;">
    	TE0ST Net #4743 For Testing Only Test     </div>
    
 
    

<!-- Everything is inside a javascript, the script closing is near the end of the page -->
<script> 
    // This function is used to connect the markers together in an object string
    function connectTheDots(data){
            var c = [];
            for(i in data._layers) {
                var x = data._layers[i]._latlng.lat;
                var y = data._layers[i]._latlng.lng;
                c.push([x, y]);
            }
            return c;
        }
    
    //what3words.api.convertTo3wa({lat:39.203,lng:-94.602},'en').then(function(response){console.log("@176 W3W= [convertTo3wa]",response);});
    
    // Define the map
    const map = L.map('map', {
    	drawControl: true,
		zoom: 12
	}); 
	
	var stationMarkers = [];
    var fg = new L.featureGroup();
    
  
    // Markers (flags for use as corners and center
    const blackmarkername       = "BRKMarkers/black_flag.svg";
    const bluemarkername        = "BRKMarkers/blue_flag.svg";
    const darkgreenmarkername   = "BRKMarkers/darkgreen_flag.svg";
    const greenmarkername       = "BRKMarkers/green_flag.svg";
    const graymarkername        = "BRKMarkers/grey_flag.svg";
    const lightbluemarkername   = "BRKMarkers/lightblue_flag.svg";  
    const orangemarkername      = "BRKMarkers/orange_flag.svg";   
    const purplemarkername      = "BRKMarkers/purple_flag.svg";
    const redmarkername         = "BRKMarkers/red_flag.svg";
    const whitemarkername       = "BRKMarkers/white_flag.svg";
    const goldmarkername        = "BRKMarkers/yellow_flag.svg";
    const plummarkername        = "BRKMarkers/plum_flag.svg";
    
    var manInTheMiddle_50       = "BRKMarkers/black_flag.svg";
    var blackmanInTheMiddle     = "BRKMarkers/black_man.svg";
    var bluemanInTheMiddle      = "BRKMarkers/blue_man.svg";
    var darkgreenmanInTheMiddle = "BRKMarkers/darkgreen_man.svg";
    var greymanInTheMiddle      = "BRKMarkers/grey_man.svg";
    var lightbluemanInTheMiddle = "BRKMarkers/lightblue_man.svg";
    var orangemanInTheMiddle    = "BRKMarkers/orange_man.svg";
    var pinkmanInTheMiddle      = "BRKMarkers/pink_man.svg";
    var purplemanInTheMiddle    = "BRKMarkers/purple_man.svg";
    var redmanInTheMiddle       = "BRKMarkers/red_man.svg";
    var whitemanInTheMiddle     = "BRKMarkers/white_man.svg";
    var goldmanInTheMiddle      = "BRKMarkers/yellow_man.svg";
    var plummanInTheMiddle      = "BRKMarkers/plum_man.svg";

	
	// Define the layers for the map
    var Streets = L.esri.basemapLayer('Streets').addTo(map),
        Imagery = L.esri.basemapLayer('Imagery').addTo(map),
        Topo    = L.esri.basemapLayer('Topographic').addTo(map),
        NatGeo  = L.esri.basemapLayer('NationalGeographic').addTo(map);
    
    var baseMaps = { "<span style='color: blue; font-weight: bold;'>Imagery": Imagery,
                     "<span style='color: blue; font-weight: bold;'>NatGeo": NatGeo,
                     "<span style='color: blue; font-weight: bold;'>Topo": Topo,
                     "<span style='color: blue; font-weight: bold;'>Streets": Streets               
                   };
                   
    map.on('click', onMapClick);

    // adds the lat/lon grid lines
    L.grid().addTo(map);  
    
    // Add the lat/lon mouse position 
    L.control.mousePosition({separator:',',position:'topright',prefix:''}).addTo(map);
    
            // https://github.com/ppete2/Leaflet.PolylineMeasure
            // Position to show the control. Values: 'topright', 'topleft', 'bottomright', 'bottomleft'
            // Show imperial or metric distances. Values: 'metres', 'landmiles', 'nauticalmiles'
            
    L.control.polylineMeasure ({position:'topright', unit:'landmiles', showBearings:true, clearMeasurementsOnStop: false, showClearControl: true, showUnitControl: true}).addTo (map);
    
    // Change the position of the Zoom Control to a newly created placeholder.
    map.zoomControl.setPosition('topright');
    
    L.control.scale().addTo(map);  
    
   // L.control.layers(baseMaps, overlayMaps,  {position:'bottomright', collapsed:false}).addTo(map);
    
    // Define the Plus and Minus for zooming and its location
    map.scrollWheelZoom.disable();  // prevents the map from zooming with the mouse wheel
    
    // Add what3words, shows w3w in a control
var w = new L.Control.w3w();
	w.addTo(map);
	map.on('click', function(e) {
		console.log(e);
		w.setCoordinates(e);
	});
	
// Adds a temp marker popup to show location of click
var popup = L.popup();

var arcgisOnline = L.esri.Geocoding.arcgisOnlineProvider();
    
// Define a PoiIcon class
var PoiIconClass = L.Icon.extend({
    options: {
        iconSize: [32, 37]
    }
});

// Define a ObjIcon class
var ObjIconClass = L.Icon.extend({
    options: {
        iconSize: [32, 37]
    }
});

// Create some icons from the above PoiIconClass class and one from ObjIconClass
var firstaidicon = new PoiIconClass({iconUrl: 'images/markers/firstaid.png'}),
    eocicon = new PoiIconClass({iconUrl: 'images/markers/eoc.png'}),
    policeicon = new PoiIconClass({iconUrl: 'images/markers/police.png'}),
    skywarnicon = new PoiIconClass({iconUrl: 'images/markers/skywarn.png'}),
    fireicon = new PoiIconClass({iconUrl: 'images/markers/fire.png'}),
    repeatericon = new PoiIconClass({iconUrl: 'markers/repeater.png'}),
    govicon = new PoiIconClass({iconUrl: 'markers/gov.png'}),

    blueFlagicon = new ObjIconClass({iconUrl: 'BRKMarkers/blue_flag.svg'}),
    
    objicon = new ObjIconClass({iconURL: 'images/markers/marker00.png'}),          // the 00 marker

    greenFlagicon = new ObjIconClass({iconUrl: 'BRKMarkers/green_flag.svg'});

// These are the markers that will appear on the map
// Bring in the station markers to appear on the map

			var _WA0TJT = new L.marker(new L.LatLng(39.203,-94.60233),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedDivIcon({number: '1' }),
				title:`marker_1` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>1<br><b>WA0TJT</b><br> ID: #0013<br>Keith Kaiser<br>Platte Co., MO Dist: A<br>39.203, -94.60233<br>EM29QE<br><a href='https://what3words.com/mailings.fried.imbalances?maptype=osm' target='_blank'>///mailings.fried.imbalances</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.203&lon=-94.60233&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_WA0TJT`._icon).addClass(`bluemrkr`);
                stationMarkers.push(_WA0TJT);
				
			var _W0DLK = new L.marker(new L.LatLng(39.201636,-94.602375),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '2' }),
				title:`marker_2` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>2<br><b>W0DLK</b><br> ID: #0023<br>Deb Kaiser<br>Platte Co., MO Dist: A<br>39.201636, -94.602375<br>EM29QE<br><a href='https://what3words.com/betrayal.tattoo.thickens?maptype=osm' target='_blank'>///betrayal.tattoo.thickens</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.201636&lon=-94.602375&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_W0DLK`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_W0DLK);
				
			var _KD0FTY = new L.marker(new L.LatLng(39.206945,-94.604219),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '3' }),
				title:`marker_3` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>3<br><b>KD0FTY</b><br> ID: #0223<br>Clark Martineau<br>Platte Co., MO Dist: A<br>39.206945, -94.604219<br>EM29QE<br><a href='https://what3words.com/arrange.boxing.casting?maptype=osm' target='_blank'>///arrange.boxing.casting</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.206945&lon=-94.604219&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_KD0FTY`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_KD0FTY);
				
			var _KC9OAZ = new L.marker(new L.LatLng(39.200531,-94.601332),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '4' }),
				title:`marker_4` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>4<br><b>KC9OAZ</b><br> ID: #5159<br>Jared Moore<br>Platte  Co., MO Dist: <br>39.200531, -94.601332<br>EM29QE<br><a href='https://what3words.com/inclined.distancing.segregation?maptype=osm' target='_blank'>///inclined.distancing.segregation</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.200531&lon=-94.601332&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_KC9OAZ`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_KC9OAZ);
			;

            var HMSPH = new L.marker(new L.LatLng(48.034632,-122.775006),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/aviation.png`, iconSize: [32, 34]}),
                        title:`marker_A1`}).addTo(fg).bindPopup(`HMSPH<br>Hadlock Mason St<br>Port Hadlock WA<br>Port Hadlock<br><b style='color:red;'></b><br>48.034632, -122.775006,  0 Ft.<br>CN88OA`).openPopup();                        
 
                        $(`aviation`._icon).addClass(`aviationmrkr`);
            var CFKHB = new L.marker(new L.LatLng(40.71948,-123.92928),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/aviation.png`, iconSize: [32, 34]}),
                        title:`marker_A2`}).addTo(fg).bindPopup(`CFKHB<br>Cal Fire Kneeland Helitack Base<br>"9685 Mountain View Rd"<br>"Kneeland, CA 95549"<br><b style='color:red;'>"Cal Fire Rotary Air Craft and refull Air Attack Base"</b><br>40.71948, -123.92928,  0 Ft.<br>CN80AR`).openPopup();                        
 
                        $(`aviation`._icon).addClass(`aviationmrkr`);
            var MCI = new L.marker(new L.LatLng(39.3003,-94.72721),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/aviation.png`, iconSize: [32, 34]}),
                        title:`marker_A3`}).addTo(fg).bindPopup(`MCI<br>Kansas City International Airport<br>1 International Square, Kansas City, MO 64153<br>North Kansas City<br><b style='color:red;'></b><br>39.3003, -94.72721,  0 Ft.<br>EM29PH`).openPopup();                        
 
                        $(`aviation`._icon).addClass(`aviationmrkr`);
            var PTIACPT = new L.marker(new L.LatLng(48.053802,-122.810628),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/aviation.png`, iconSize: [32, 34]}),
                        title:`marker_A4`}).addTo(fg).bindPopup(`PTIACPT<br>PT Intl Airport Cutoff<br>Port Townsend WA<br>Port Townsend<br><b style='color:red;'></b><br>48.053802, -122.810628,  0 Ft.<br>CN88OB`).openPopup();                        
 
                        $(`aviation`._icon).addClass(`aviationmrkr`);
            var SVBPT = new L.marker(new L.LatLng(48.077025,-122.840721),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/aviation.png`, iconSize: [32, 34]}),
                        title:`marker_A5`}).addTo(fg).bindPopup(`SVBPT<br>Sky Valley<br>Sky Valley 405 Blossom<br>Port Townsend<br><b style='color:red;'></b><br>48.077025, -122.840721,  0 Ft.<br>CN88NB`).openPopup();                        
 
                        $(`aviation`._icon).addClass(`aviationmrkr`);
            var DPNGWA = new L.marker(new L.LatLng(48.092211,-122.927963),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/aviation.png`, iconSize: [32, 34]}),
                        title:`marker_A6`}).addTo(fg).bindPopup(`DPNGWA<br>Diamond Pt<br>Diamond Pt 317 North Gardiner, WA<br>North Gardiner<br><b style='color:red;'></b><br>48.092211, -122.927963,  0 Ft.<br>CN88MC`).openPopup();                        
 
                        $(`aviation`._icon).addClass(`aviationmrkr`);
            var KCI = new L.marker(new L.LatLng(39.12051,-94.59077),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/aviation.png`, iconSize: [32, 34]}),
                        title:`marker_A7`}).addTo(fg).bindPopup(`KCI<br>Charles B Wheeler Downtown Airport<br>900 Richards Rd. Kansas City, MO 64116<br>Kansas City<br><b style='color:red;'></b><br>39.12051, -94.59077,  0 Ft.<br>EM29QC`).openPopup();                        
 
                        $(`aviation`._icon).addClass(`aviationmrkr`);
            var RAAB = new L.marker(new L.LatLng(40.5555,-124.13204),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/aviation.png`, iconSize: [32, 34]}),
                        title:`marker_A8`}).addTo(fg).bindPopup(`RAAB<br>Rohnerville Air Attack Base<br>"2330 Airport Rd"<br>"Fortuna, CA 95540"<br><b style='color:red;'>"Cal Fire Fixed Wing Air Attack Base"</b><br>40.5555, -124.13204,  0 Ft.<br>CN70WN`).openPopup();                        
 
                        $(`aviation`._icon).addClass(`aviationmrkr`);
            var CHPDC237 = new L.marker(new L.LatLng(40.79191,-124.17572),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P1`}).addTo(fg).bindPopup(`CHPDC237<br>California Highway Patrol Dispatch Center<br>"1656 Union St"<br>"Eureka, CA 95501"<br><b style='color:red;'></b><br>40.79191, -124.17572,  0 Ft.<br>CN70VT`).openPopup();                        
 
                        $(`chp`._icon).addClass(`polmrkr`);
            var HPA172 = new L.marker(new L.LatLng(40.86155,-124.07923),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P2`}).addTo(fg).bindPopup(`HPA172<br>Highway Patrol-Arcata<br>"255 Samoa Blvd"<br>"Arcata, CA 95521"<br><b style='color:red;'></b><br>40.86155, -124.07923,  0 Ft.<br>CN70XU`).openPopup();                        
 
                        $(`chp`._icon).addClass(`polmrkr`);
            var CHPGS227 = new L.marker(new L.LatLng(40.11593,-123.81354),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P3`}).addTo(fg).bindPopup(`CHPGS227<br>California Highway Patrol-Garberville Station<br>"30 West Coast Rd"<br>"Redway, CA 95560"<br><b style='color:red;'></b><br>40.11593, -123.81354,  0 Ft.<br>CN80CC`).openPopup();                        
 
                        $(`chp`._icon).addClass(`polmrkr`);
            var W0KCN15 = new L.marker(new L.LatLng(39.363954,-94.584749),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E1`}).addTo(fg).bindPopup(`W0KCN15<br>Northland ARES Clay Co. Fire Station #2<br>6569 N Prospect Ave<br>Smithville, MO<br><b style='color:red;'></b><br>39.363954, -94.584749,  0 Ft.<br>EM29QI`).openPopup();                        
 
                        $(`eoc`._icon).addClass(`eocmrkr`);
            var HCES239 = new L.marker(new L.LatLng(40.803,-124.16221),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E2`}).addTo(fg).bindPopup(`HCES239<br>Humboldt County Emergency Services<br>"826 4th St"<br>"Eureka, CA 95501"<br><b style='color:red;'>"Humboldt County CERT, AuxComm"</b><br>40.803, -124.16221,  0 Ft.<br>CN70WT`).openPopup();                        
 
                        $(`eoc`._icon).addClass(`eocmrkr`);
            var W0KCN3 = new L.marker(new L.LatLng(39.2859182,-94.667236),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E3`}).addTo(fg).bindPopup(`W0KCN3<br>Northland ARES Platte Co. Resource Center<br><br>Kansas City, MO<br><b style='color:red;'></b><br>39.2859182, -94.667236,  0 Ft.<br>EM29PG`).openPopup();                        
 
                        $(`eoc`._icon).addClass(`eocmrkr`);
            var JCDEM265 = new L.marker(new L.LatLng(48.024051,-122.763807),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E4`}).addTo(fg).bindPopup(`JCDEM265<br>JC DEM<br>81 ELKINS<br>PORT HADLOCK<br><b style='color:red;'></b><br>48.024051, -122.763807,  0 Ft.<br>CN88OA`).openPopup();                        
 
                        $(`eoc`._icon).addClass(`eocmrkr`);
            var ALTEOC266 = new L.marker(new L.LatLng(48.116172,-122.764327),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E5`}).addTo(fg).bindPopup(`ALTEOC266<br>ALT-EOC<br>701 HARRISON<br>PORT TOWNSEND<br><b style='color:red;'></b><br>48.116172, -122.764327,  0 Ft.<br>CN88OC`).openPopup();                        
 
                        $(`eoc`._icon).addClass(`eocmrkr`);
            var EOC399 = new L.marker(new L.LatLng(34.248206,-80.606327),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E6`}).addTo(fg).bindPopup(`EOC399<br><br><br>Camden<br><b style='color:red;'>Kershaw County EOC</b><br>34.248206, -80.606327,  0 Ft.<br>EM94QF`).openPopup();                        
 
                        $(`eoc`._icon).addClass(`eocmrkr`);
            var NARESEOC = new L.marker(new L.LatLng(39.245231,-94.41976),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E7`}).addTo(fg).bindPopup(`NARESEOC<br>Clay County Sheriff & KCNARES EOC<br><br>Liberty, MO<br><b style='color:red;'></b><br>39.245231, -94.41976,  0 Ft.<br>EM29SF`).openPopup();                        
 
                        $(`eoc`._icon).addClass(`eocmrkr`);
            var W0KCN4 = new L.marker(new L.LatLng(39.3721733,-94.780929),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E8`}).addTo(fg).bindPopup(`W0KCN4<br>Northland ARES Platte Co. EOC<br><br>Platte City, MO<br><b style='color:red;'></b><br>39.3721733, -94.780929,  0 Ft.<br>EM29OI`).openPopup();                        
 
                        $(`eoc`._icon).addClass(`eocmrkr`);
            var USFSMRRDO206 = new L.marker(new L.LatLng(40.46494,-123.53175),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/gov.png`, iconSize: [32, 34]}),
                        title:`marker_G1`}).addTo(fg).bindPopup(`USFSMRRDO206<br>US Forest Service Mad River Ranger District Office<br>"741 CA-36"<br>"Mad River, CA 95526"<br><b style='color:red;'></b><br>40.46494, -123.53175,  0 Ft.<br>CN80FL`).openPopup();                        
 
                        $(`federal`._icon).addClass(`govmrkr`);
            var LTRD193 = new L.marker(new L.LatLng(40.88817,-123.58598),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/gov.png`, iconSize: [32, 34]}),
                        title:`marker_G2`}).addTo(fg).bindPopup(`LTRD193<br>Lower Trinity Ranger District<br>"1020 CA-299"<br>"Salyer, CA 95563"<br><b style='color:red;'></b><br>40.88817, -123.58598,  0 Ft.<br>CN80EV`).openPopup();                        
 
                        $(`federal`._icon).addClass(`govmrkr`);
            var LTRDUSFS191 = new L.marker(new L.LatLng(40.9472,-123.63672),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/gov.png`, iconSize: [32, 34]}),
                        title:`marker_G3`}).addTo(fg).bindPopup(`LTRDUSFS191<br>Lower Trinity Ranger District U.S. Forest Service<br>"580 CA-96"<br>"Willow Creek, CA 95573"<br><b style='color:red;'></b><br>40.9472, -123.63672,  0 Ft.<br>CN80EW`).openPopup();                        
 
                        $(`federal`._icon).addClass(`govmrkr`);
            var MRFSUSFS205 = new L.marker(new L.LatLng(40.46022,-123.52366),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/gov.png`, iconSize: [32, 34]}),
                        title:`marker_G4`}).addTo(fg).bindPopup(`MRFSUSFS205<br>Mad River Fire Station, U.S.Forest Service<br>"CA-36"<br>"Bridgeville, CA 95526"<br><b style='color:red;'></b><br>40.46022, -123.52366,  0 Ft.<br>CN80FL`).openPopup();                        
 
                        $(`federal`._icon).addClass(`govmrkr`);
            var KCMOFS6 = new L.marker(new L.LatLng(39.164872338000066,-94.54946718099995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F1`}).addTo(fg).bindPopup(`KCMOFS6<br>KCMO Fire Station No. 6<br>2600 NE Parvin Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>39.164872338000066, -94.54946718099995,  0 Ft.<br>EM29RD`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS7 = new L.marker(new L.LatLng(39.088027072000045,-94.59222542099997),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F2`}).addTo(fg).bindPopup(`KCMOFS7<br>KCMO Fire Station No. 7<br>616 West Pennway St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.088027072000045, -94.59222542099997,  0 Ft.<br>EM29QC`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS8 = new L.marker(new L.LatLng(39.09503169800007,-94.57740912999998),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F3`}).addTo(fg).bindPopup(`KCMOFS8<br>KCMO Fire Station No. 8<br>1517 Locust St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.09503169800007, -94.57740912999998,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var BRVRCOFR29 = new L.marker(new L.LatLng(28.431189,-80.805377),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F4`}).addTo(fg).bindPopup(`BRVRCOFR29<br>Brevard County Fire Rescue Station 29<br>3950 Canaveral Groves Blvd<br>Cocoa, FL 32926<br><b style='color:red;'></b><br>28.431189, -80.805377,  0 Ft.<br>EL98OK`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var SPFD171 = new L.marker(new L.LatLng(40.78639,-124.2),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F5`}).addTo(fg).bindPopup(`SPFD171<br>Samoa Peninsula Fire District<br>"1982 Gass St"<br>"Samoa, CA 95564"<br><b style='color:red;'></b><br>40.78639, -124.2,  0 Ft.<br>CN70VS`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var AFD173 = new L.marker(new L.LatLng(40.86865,-124.08511),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F6`}).addTo(fg).bindPopup(`AFD173<br>Arcata Fire District / Arcata Station<br>"631 9th St"<br>"Arcata, CA 95521"<br><b style='color:red;'></b><br>40.86865, -124.08511,  0 Ft.<br>CN70WU`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS16 = new L.marker(new L.LatLng(39.29508854300008,-94.68790113199998),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F7`}).addTo(fg).bindPopup(`KCMOFS16<br>KCMO Fire Station No. 16<br>9205 NW 112th St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.29508854300008, -94.68790113199998,  0 Ft.<br>EM29PH`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var AFD174 = new L.marker(new L.LatLng(40.89901,-124.09185),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F8`}).addTo(fg).bindPopup(`AFD174<br>Arcata Fire District / Mad River Station<br>"3235 Janes Rd"<br>"Arcata, CA 95521"<br><b style='color:red;'></b><br>40.89901, -124.09185,  0 Ft.<br>CN70WV`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS5 = new L.marker(new L.LatLng(39.29465245500006,-94.72458748899999),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F9`}).addTo(fg).bindPopup(`KCMOFS5<br>KCMO Fire Station No. 5<br>173 N Ottawa Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.29465245500006, -94.72458748899999,  0 Ft.<br>EM29PH`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var HBFS2 = new L.marker(new L.LatLng(40.75793,-124.17967),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F10`}).addTo(fg).bindPopup(`HBFS2<br>Humboldt Bay Fire Station 2<br>"755 Herrick Ave"<br>"Eureka, CA 95503"<br><b style='color:red;'></b><br>40.75793, -124.17967,  0 Ft.<br>CN70VS`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS3 = new L.marker(new L.LatLng(39.29502746500003,-94.57483520999995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F11`}).addTo(fg).bindPopup(`KCMOFS3<br>KCMO Fire Station No. 3<br>11101 N Oak St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.29502746500003, -94.57483520999995,  0 Ft.<br>EM29RH`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var TFESS12 = new L.marker(new L.LatLng(28.589587,-80.831269),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F12`}).addTo(fg).bindPopup(`TFESS12<br>Titusville Fire & Emergency Services Station 12<br>2400 Harrison Street<br>Titusville, FL 32780<br><b style='color:red;'></b><br>28.589587, -80.831269,  0 Ft.<br>EL98OO`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var RVRSDEFD = new L.marker(new L.LatLng(39.175757,-94.616012),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F13`}).addTo(fg).bindPopup(`RVRSDEFD<br>Riverside, MO City Fire Department<br>2990 NW Vivion Rd. <br>Riverside, MO 64150<br><b style='color:red;'></b><br>39.175757, -94.616012,  0 Ft.<br>EM29QE`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var GNSVFS1 = new L.marker(new L.LatLng(34.290941,-83.826461),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F14`}).addTo(fg).bindPopup(`GNSVFS1<br>Gainesville Fire Station 1<br>725 Pine St, <br>Gainesville, GA 30501<br><b style='color:red;'></b><br>34.290941, -83.826461,  0 Ft.<br>EM84CG`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var HBFS3 = new L.marker(new L.LatLng(40.78177,-124.18126),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F15`}).addTo(fg).bindPopup(`HBFS3<br>Humboldt Bay Fire Station 3<br>"2905 Ocean Ave"<br>"Eureka, CA 95501"<br><b style='color:red;'></b><br>40.78177, -124.18126,  0 Ft.<br>CN70VS`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var HBFS1 = new L.marker(new L.LatLng(40.80125,-124.16873),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F16`}).addTo(fg).bindPopup(`HBFS1<br>Humboldt Bay Fire Station 1<br>"533 C St"<br>"Eureka, CA 95501"<br><b style='color:red;'>"HBF Main Office"</b><br>40.80125, -124.16873,  0 Ft.<br>CN70VT`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var HBFS4 = new L.marker(new L.LatLng(40.79978,-124.14866),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F17`}).addTo(fg).bindPopup(`HBFS4<br>Humboldt Bay Fire Station 4<br>"1016 Myrtle Avenue"<br>"Eureka, CA 95501"<br><b style='color:red;'></b><br>40.79978, -124.14866,  0 Ft.<br>CN70WT`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var HBFS5 = new L.marker(new L.LatLng(40.78097,-124.12982),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F18`}).addTo(fg).bindPopup(`HBFS5<br>Humboldt Bay Fire Station 5<br>"3455 Harris St"<br>"Eureka, CA 95503"<br><b style='color:red;'></b><br>40.78097, -124.12982,  0 Ft.<br>CN70WS`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS1 = new L.marker(new L.LatLng(38.84544806200006,-94.55557100699997),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F19`}).addTo(fg).bindPopup(`KCMOFS1<br>KCMO Fire Station No. 1<br>15480 Hangar Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>38.84544806200006, -94.55557100699997,  0 Ft.<br>EM28RU`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS4 = new L.marker(new L.LatLng(39.21082648400005,-94.62698133999999),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F20`}).addTo(fg).bindPopup(`KCMOFS4<br>KCMO Fire Station No. 4<br>4000 NW 64th St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.21082648400005, -94.62698133999999,  0 Ft.<br>EM29QF`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS17 = new L.marker(new L.LatLng(39.06448674100005,-94.56659040899996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F21`}).addTo(fg).bindPopup(`KCMOFS17<br>KCMO Fire Station No. 17<br>3401 Paseo<br>Kansas City, MO<br><b style='color:red;'></b><br>39.06448674100005, -94.56659040899996,  0 Ft.<br>EM29RB`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS38 = new L.marker(new L.LatLng(39.24114461900007,-94.57637879999999),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F22`}).addTo(fg).bindPopup(`KCMOFS38<br>KCMO Fire Station No. 38<br>8100 N Oak Tfwy<br>Kansas City, MO<br><b style='color:red;'></b><br>39.24114461900007, -94.57637879999999,  0 Ft.<br>EM29RF`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS39 = new L.marker(new L.LatLng(39.037389129000076,-94.44871189199995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F23`}).addTo(fg).bindPopup(`KCMOFS39<br>KCMO Fire Station No. 39<br>11100 E 47th St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.037389129000076, -94.44871189199995,  0 Ft.<br>EM29SA`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS40 = new L.marker(new L.LatLng(39.18825564000008,-94.57705538299996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F24`}).addTo(fg).bindPopup(`KCMOFS40<br>KCMO Fire Station No. 40<br>5200 N Oak Tfwy<br>Kansas City, MO<br><b style='color:red;'></b><br>39.18825564000008, -94.57705538299996,  0 Ft.<br>EM29RE`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS41 = new L.marker(new L.LatLng(38.956671338000035,-94.52135318999996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F25`}).addTo(fg).bindPopup(`KCMOFS41<br>KCMO Fire Station No. 41<br>9300 Hillcrest Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>38.956671338000035, -94.52135318999996,  0 Ft.<br>EM28RW`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS42 = new L.marker(new L.LatLng(38.924447272000066,-94.51993356699995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F26`}).addTo(fg).bindPopup(`KCMOFS42<br>KCMO Fire Station No. 42<br>6006 E Red Bridge Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>38.924447272000066, -94.51993356699995,  0 Ft.<br>EM28RW`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS43 = new L.marker(new L.LatLng(38.96734958800005,-94.43185910999995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F27`}).addTo(fg).bindPopup(`KCMOFS43<br>KCMO Fire Station No. 43<br>12900 E M 350 Hwy<br>Kansas City, MO<br><b style='color:red;'></b><br>38.96734958800005, -94.43185910999995,  0 Ft.<br>EM28SX`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS44 = new L.marker(new L.LatLng(39.246423046000075,-94.66588993499994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F28`}).addTo(fg).bindPopup(`KCMOFS44<br>KCMO Fire Station No. 44<br>7511 NW Barry Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>39.246423046000075, -94.66588993499994,  0 Ft.<br>EM29QF`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS45 = new L.marker(new L.LatLng(38.89023597400006,-94.58854005199998),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F29`}).addTo(fg).bindPopup(`KCMOFS45<br>KCMO Fire Station No. 45<br>500 E 131st St<br>Kansas City, MO<br><b style='color:red;'></b><br>38.89023597400006, -94.58854005199998,  0 Ft.<br>EM28QV`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS47 = new L.marker(new L.LatLng(39.14034793800005,-94.52048369499994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F30`}).addTo(fg).bindPopup(`KCMOFS47<br>KCMO Fire Station No. 47<br>5130 Deramus Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.14034793800005, -94.52048369499994,  0 Ft.<br>EM29RD`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var RVRSFD = new L.marker(new L.LatLng(39.17579,-94.615947),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F31`}).addTo(fg).bindPopup(`RVRSFD<br>   Riverside City Fire Department<br> 2990 NW Vivion Rd<br> 	   Riverside MO 64150<br><b style='color:red;'></b><br>39.17579, -94.615947,  0 Ft.<br>EM29QE`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS14 = new L.marker(new L.LatLng(39.24420365000003,-94.52101456199995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F32`}).addTo(fg).bindPopup(`KCMOFS14<br>KCMO Fire Station No. 14<br>8300 N Brighton Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.24420365000003, -94.52101456199995,  0 Ft.<br>EM29RF`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var FIRE13254 = new L.marker(new L.LatLng(48.057266,-122.80605),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F33`}).addTo(fg).bindPopup(`FIRE13254<br>Fire13<br>50 AIRPORT<br>PORT TOWNSEND<br><b style='color:red;'></b><br>48.057266, -122.80605,  0 Ft.<br>CN88OB`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS37 = new L.marker(new L.LatLng(38.98838295400003,-94.59471418799995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F34`}).addTo(fg).bindPopup(`KCMOFS37<br>KCMO Fire Station No. 37<br>7708 Wornall Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>38.98838295400003, -94.59471418799995,  0 Ft.<br>EM28QX`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS36 = new L.marker(new L.LatLng(38.947990154000024,-94.58198512499996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F35`}).addTo(fg).bindPopup(`KCMOFS36<br>KCMO Fire Station No. 36<br>9903 Holmes Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>38.947990154000024, -94.58198512499996,  0 Ft.<br>EM28RW`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS18 = new L.marker(new L.LatLng(39.068426627000065,-94.54306673199994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F36`}).addTo(fg).bindPopup(`KCMOFS18<br>KCMO Fire Station No. 18<br>3211 Indiana Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.068426627000065, -94.54306673199994,  0 Ft.<br>EM29RB`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS19 = new L.marker(new L.LatLng(39.04970557900003,-94.59317453799997),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F37`}).addTo(fg).bindPopup(`KCMOFS19<br>KCMO Fire Station No. 19<br>550 W 43rd St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.04970557900003, -94.59317453799997,  0 Ft.<br>EM29QB`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS23 = new L.marker(new L.LatLng(39.10519819800004,-94.52673633999996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F38`}).addTo(fg).bindPopup(`KCMOFS23<br>KCMO Fire Station No. 23<br>4777 Independence Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.10519819800004, -94.52673633999996,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS24 = new L.marker(new L.LatLng(39.08534478900003,-94.51940024199996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F39`}).addTo(fg).bindPopup(`KCMOFS24<br>KCMO Fire Station No. 24<br>2039 Hardesty Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.08534478900003, -94.51940024199996,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS25 = new L.marker(new L.LatLng(39.10791790600007,-94.57838314599996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F40`}).addTo(fg).bindPopup(`KCMOFS25<br>KCMO Fire Station No. 25<br>401 E Missouri Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.10791790600007, -94.57838314599996,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS27 = new L.marker(new L.LatLng(39.09423963200004,-94.50519189199997),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F41`}).addTo(fg).bindPopup(`KCMOFS27<br>KCMO Fire Station No. 27<br>6600 E Truman Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>39.09423963200004, -94.50519189199997,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS28 = new L.marker(new L.LatLng(38.92612585100005,-94.57996235599995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F42`}).addTo(fg).bindPopup(`KCMOFS28<br>KCMO Fire Station No. 28<br>930 Red Bridge Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>38.92612585100005, -94.57996235599995,  0 Ft.<br>EM28RW`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS29 = new L.marker(new L.LatLng(39.01353614300007,-94.56910049699997),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F43`}).addTo(fg).bindPopup(`KCMOFS29<br>KCMO Fire Station No. 29<br>1414 E 63rd St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.01353614300007, -94.56910049699997,  0 Ft.<br>EM29RA`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS30 = new L.marker(new L.LatLng(38.98954598500006,-94.55777761299998),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F44`}).addTo(fg).bindPopup(`KCMOFS30<br>KCMO Fire Station No. 30<br>7534 Prospect Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>38.98954598500006, -94.55777761299998,  0 Ft.<br>EM28RX`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS33 = new L.marker(new L.LatLng(39.00341036400005,-94.49917701399994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F45`}).addTo(fg).bindPopup(`KCMOFS33<br>KCMO Fire Station No. 33<br>7504 E 67th St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.00341036400005, -94.49917701399994,  0 Ft.<br>EM29SA`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS34 = new L.marker(new L.LatLng(39.18216645700005,-94.52198633599994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F46`}).addTo(fg).bindPopup(`KCMOFS34<br>KCMO Fire Station No. 34<br>4836 N Brighton Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.18216645700005, -94.52198633599994,  0 Ft.<br>EM29RE`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS35 = new L.marker(new L.LatLng(39.04105321900005,-94.54716372899998),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F47`}).addTo(fg).bindPopup(`KCMOFS35<br>KCMO Fire Station No. 35<br>3200 Emanuel Cleaver II Blvd<br>Kansas City, MO<br><b style='color:red;'></b><br>39.04105321900005, -94.54716372899998,  0 Ft.<br>EM29RA`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var CARROLFD = new L.marker(new L.LatLng(39.364764,-93.482455),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F48`}).addTo(fg).bindPopup(`CARROLFD<br>Carrollton Fire Department<br>710 Harvest Hills Dr<br>Carroll, MO 64633<br><b style='color:red;'></b><br>39.364764, -93.482455,  0 Ft.<br>EM39GI`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var AFD175 = new L.marker(new L.LatLng(40.94398,-124.10055),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F49`}).addTo(fg).bindPopup(`AFD175<br>Arcata Fire District / McKinleyville Station<br>"2149 Central Ave"<br>"McKinleyville, CA 95519"<br><b style='color:red;'></b><br>40.94398, -124.10055,  0 Ft.<br>CN70WW`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var Fire400 = new L.marker(new L.LatLng(34.245217,-80.602271),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F50`}).addTo(fg).bindPopup(`Fire400<br><br><br>Camden<br><b style='color:red;'>Kershaw County Fire / Sheriff</b><br>34.245217, -80.602271,  0 Ft.<br>EM94QF`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var GFPD220 = new L.marker(new L.LatLng(40.10266,-123.79382),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F51`}).addTo(fg).bindPopup(`GFPD220<br>Garberville Fire Protection District<br>"680 Locust St"<br>"Garberville, CA 95542"<br><b style='color:red;'></b><br>40.10266, -123.79382,  0 Ft.<br>CN80CC`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var WFS2217 = new L.marker(new L.LatLng(40.05841,-123.97026),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F52`}).addTo(fg).bindPopup(`WFS2217<br>Whitethorn Fire Station 2<br>"498 Shelter Cove Rd"<br>"Whitethorn, CA 95589"<br><b style='color:red;'></b><br>40.05841, -123.97026,  0 Ft.<br>CN80AB`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var BVFD215 = new L.marker(new L.LatLng(40.10015,-123.85869),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F53`}).addTo(fg).bindPopup(`BVFD215<br>Briceland Volunteer Fire Department<br>"4438 Briceland Rd"<br>"Garberville, CA 95542"<br><b style='color:red;'></b><br>40.10015, -123.85869,  0 Ft.<br>CN80BC`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var PVFD214 = new L.marker(new L.LatLng(40.21163,-123.78644),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F54`}).addTo(fg).bindPopup(`PVFD214<br>Phillipsville Volunteer Fire Department<br>"2973 CA-254"<br>"Phillipsville, CA 95559"<br><b style='color:red;'></b><br>40.21163, -123.78644,  0 Ft.<br>CN80CF`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var MVFD213 = new L.marker(new L.LatLng(40.23615,-123.8219),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F55`}).addTo(fg).bindPopup(`MVFD213<br>Miranda Volunteer Fire Department<br>"75 School Rd"<br>"Miranda, CA 95553"<br><b style='color:red;'></b><br>40.23615, -123.8219,  0 Ft.<br>CN80CF`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var MFFS212 = new L.marker(new L.LatLng(40.26633,-123.87313),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F56`}).addTo(fg).bindPopup(`MFFS212<br>Myers Flat Fire Station<br>"54 Myers Ave"<br>"Myers Flat, CA 95554"<br><b style='color:red;'></b><br>40.26633, -123.87313,  0 Ft.<br>CN80BG`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var PFD209 = new L.marker(new L.LatLng(40.32522,-124.28753),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F57`}).addTo(fg).bindPopup(`PFD209<br>Petrolia Fire District<br>"98 Sherman Ave"<br>"Petrolia, CA 95558"<br><b style='color:red;'></b><br>40.32522, -124.28753,  0 Ft.<br>CN70UH`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var SVFD208 = new L.marker(new L.LatLng(40.48164,-124.10331),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F58`}).addTo(fg).bindPopup(`SVFD208<br>Scotia Volunteer Fire Department<br><br><br><b style='color:red;'></b><br>40.48164, -124.10331,  0 Ft.<br>CN70WL`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var RDVFD207 = new L.marker(new L.LatLng(40.50129,-124.107),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F59`}).addTo(fg).bindPopup(`RDVFD207<br>Rio Dell Volunteer Fire Department<br>"50 Center St"<br>"Rio Dell, CA 95562"<br><b style='color:red;'></b><br>40.50129, -124.107,  0 Ft.<br>CN70WM`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var HFD202 = new L.marker(new L.LatLng(40.54748,-124.09449),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F60`}).addTo(fg).bindPopup(`HFD202<br>Hydesville Fire Department<br>"3494 CA-36"<br>"Hydesville, CA 95547"<br><b style='color:red;'></b><br>40.54748, -124.09449,  0 Ft.<br>CN70WN`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KVFDFS222 = new L.marker(new L.LatLng(40.15756,-123.46215),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F61`}).addTo(fg).bindPopup(`KVFDFS222<br>Kettenpom Volunteer Fire Department Fire Station<br>"4001 Zenia Lake Mountain Rd"<br>"Zenia, CA 95595"<br><b style='color:red;'></b><br>40.15756, -123.46215,  0 Ft.<br>CN80GD`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var WGVF223 = new L.marker(new L.LatLng(39.98179,-123.97839),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F62`}).addTo(fg).bindPopup(`WGVF223<br>Whale Gulch Volunteer Fire<br>"76850 Usal Rd"<br>"Whitethorn, CA 95589"<br><b style='color:red;'></b><br>39.98179, -123.97839,  0 Ft.<br>CM89AX`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var Fire397 = new L.marker(new L.LatLng(34.226688,-80.677715),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F63`}).addTo(fg).bindPopup(`Fire397<br><br><br>Lugoff<br><b style='color:red;'></b><br>34.226688, -80.677715,  0 Ft.<br>EM94PF`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var PL7650 = new L.marker(new L.LatLng(47.939441,-122.68719),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F64`}).addTo(fg).bindPopup(`PL7650<br>Pt Ludlow<br>Pt Ludlow 7650 Oak Bay Port Ludlow WA<br>Port Ludlow<br><b style='color:red;'></b><br>47.939441, -122.68719,  0 Ft.<br>CN87PW`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var B272SB = new L.marker(new L.LatLng(47.69367,-122.9029),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F65`}).addTo(fg).bindPopup(`B272SB<br>Brinnon 272 Schoolhouse<br>Brinnon 272 Schoolhouse Brinnon WA<br>Brinnon<br><b style='color:red;'></b><br>47.69367, -122.9029,  0 Ft.<br>CN87NQ`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KCMOFS10 = new L.marker(new L.LatLng(39.10270070000007,-94.56220495299999),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F66`}).addTo(fg).bindPopup(`KCMOFS10<br>KCMO Fire Station No. 10<br>1505 E 9th St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.10270070000007, -94.56220495299999,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var SCVFD218 = new L.marker(new L.LatLng(40.02877,-124.06532),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F67`}).addTo(fg).bindPopup(`SCVFD218<br>Shelter Cove Volunteer Fire Department<br>"9126 Shelter Cove Rd"<br>"Whitethorn, CA 95589"<br><b style='color:red;'></b><br>40.02877, -124.06532,  0 Ft.<br>CN70XA`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var FIRE16257 = new L.marker(new L.LatLng(48.116172,-122.764327),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F68`}).addTo(fg).bindPopup(`FIRE16257<br>Fire16<br>701 HARRISON<br>PORT TOWNSEND<br><b style='color:red;'></b><br>48.116172, -122.764327,  0 Ft.<br>CN88OC`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var FIRE15256 = new L.marker(new L.LatLng(48.102685,-122.825696),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F69`}).addTo(fg).bindPopup(`FIRE15256<br>Fire15<br>35 CRITTER<br>PORT TOWNSEND<br><b style='color:red;'></b><br>48.102685, -122.825696,  0 Ft.<br>CN88OC`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var FIRE14255 = new L.marker(new L.LatLng(48.088759,-122.868354),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F70`}).addTo(fg).bindPopup(`FIRE14255<br>Fire14<br>3850 CAPE GEORGE<br>PORT TOWNSEND<br><b style='color:red;'></b><br>48.088759, -122.868354,  0 Ft.<br>CN88NC`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var FIRE12253 = new L.marker(new L.LatLng(48.043012,-122.691671),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F71`}).addTo(fg).bindPopup(`FIRE12253<br>Fire12<br>6633 FLAGLER<br>NORDLAND<br><b style='color:red;'></b><br>48.043012, -122.691671,  0 Ft.<br>CN88PB`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var FIRE11252 = new L.marker(new L.LatLng(48.011343,-122.770733),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F72`}).addTo(fg).bindPopup(`FIRE11252<br>Fire11<br>9193 RHODY<br>CHIMACUM<br><b style='color:red;'></b><br>48.011343, -122.770733,  0 Ft.<br>CN88OA`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var FVFDCH201 = new L.marker(new L.LatLng(40.57024,-124.13481),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F73`}).addTo(fg).bindPopup(`FVFDCH201<br>Fortuna Volunteer Fire Department Campton Heights Station<br>"3050 School St"<br>"Fortuna, CA 95540"<br><b style='color:red;'></b><br>40.57024, -124.13481,  0 Ft.<br>CN70WN`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var CFS204 = new L.marker(new L.LatLng(40.51942,-124.02393),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F74`}).addTo(fg).bindPopup(`CFS204<br>Carlotta Fire Station<br>"7920 CA-36"<br>"Carlotta, CA 95528"<br><b style='color:red;'></b><br>40.51942, -124.02393,  0 Ft.<br>CN70XM`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var FFD177 = new L.marker(new L.LatLng(40.96415,-124.03615),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F75`}).addTo(fg).bindPopup(`FFD177<br>Fieldbrook Fire Department<br>"4584 Fieldbrook Rd"<br>"McKinleyville, CA 95519"<br><b style='color:red;'></b><br>40.96415, -124.03615,  0 Ft.<br>CN70XX`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var WVFD178 = new L.marker(new L.LatLng(41.03568,-124.1101),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F76`}).addTo(fg).bindPopup(`WVFD178<br>Westhaven Volunteer Fire Department<br>"446 6th Ave"<br>"Trinidad, CA 95570"<br><b style='color:red;'></b><br>41.03568, -124.1101,  0 Ft.<br>CN71WA`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var TFD179 = new L.marker(new L.LatLng(41.06041,-124.14269),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F77`}).addTo(fg).bindPopup(`TFD179<br>Trinidad Fire Department<br>"409 Trinity St"<br>"Trinidad, CA 95570"<br><b style='color:red;'></b><br>41.06041, -124.14269,  0 Ft.<br>CN71WB`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var OVFD181 = new L.marker(new L.LatLng(41.29056,-124.05703),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F78`}).addTo(fg).bindPopup(`OVFD181<br>Orick Volunteer Fire Department<br>"101 Swan Rd"<br>"Orick, CA 95555"<br><b style='color:red;'></b><br>41.29056, -124.05703,  0 Ft.<br>CN71XG`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var YFD182 = new L.marker(new L.LatLng(41.04817,-123.67285),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F79`}).addTo(fg).bindPopup(`YFD182<br>Yurok Fire Dept<br>"Trinity-Klamath"<br>"Hoopa, CA 95546"<br><b style='color:red;'></b><br>41.04817, -123.67285,  0 Ft.<br>CN81DB`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var CFPOBFS = new L.marker(new L.LatLng(41.75657,-124.15613),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F80`}).addTo(fg).bindPopup(`CFPOBFS<br>CFPO Beatsch Fire station<br>"175 Humboldt Rd"<br>"Crescent City, CA 95531"<br><b style='color:red;'></b><br>41.75657, -124.15613,  0 Ft.<br>CN71WS`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KFD34 = new L.marker(new L.LatLng(41.57347,-124.07127),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F81`}).addTo(fg).bindPopup(`KFD34<br>Klamath Fire Station 34<br>"104 Redwood Dr"<br>"Klamath, CA 95548"<br><b style='color:red;'></b><br>41.57347, -124.07127,  0 Ft.<br>CN71XN`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KFD35 = new L.marker(new L.LatLng(41.57543,-124.04627),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F82`}).addTo(fg).bindPopup(`KFD35<br>Klamath Fire Station 35<br>"19 Weber Dr"<br>"Klamath, CA 95548"<br><b style='color:red;'></b><br>41.57543, -124.04627,  0 Ft.<br>CN71XN`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var CCFR187 = new L.marker(new L.LatLng(41.75428,-124.19869),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F83`}).addTo(fg).bindPopup(`CCFR187<br>Crescent City Fire and Rescue - City Station<br>"520 I St"<br>"Crescent City, CA 95531"<br><b style='color:red;'></b><br>41.75428, -124.19869,  0 Ft.<br>CN71VS`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var CCFRWHQ189 = new L.marker(new L.LatLng(41.77253,-124.20543),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F84`}).addTo(fg).bindPopup(`CCFRWHQ189<br>Crescent City Fire and Rescue - Washington Headquarters<br>"255 W Washington Blvd"<br>"Crescent City, CA 95531"<br><b style='color:red;'></b><br>41.77253, -124.20543,  0 Ft.<br>CN71VS`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var HFD190 = new L.marker(new L.LatLng(41.04795,-123.67271),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F85`}).addTo(fg).bindPopup(`HFD190<br>Hoopa Fire Department<br>"11120 CA-96"<br>"Hoopa, CA 95546"<br><b style='color:red;'></b><br>41.04795, -123.67271,  0 Ft.<br>CN81DB`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var FFD199 = new L.marker(new L.LatLng(40.58939,-124.14762),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F86`}).addTo(fg).bindPopup(`FFD199<br>Fortuna Fire Department<br>"320 S Fortuna Blvd"<br>"Fortuna, CA 95540"<br><b style='color:red;'></b><br>40.58939, -124.14762,  0 Ft.<br>CN70WO`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var BLFD176 = new L.marker(new L.LatLng(40.88308,-123.99108),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F87`}).addTo(fg).bindPopup(`BLFD176<br>Blue Lake Fire Department<br>"111 First Ave"<br>"Blue Lake, CA 95525"<br><b style='color:red;'></b><br>40.88308, -123.99108,  0 Ft.<br>CN80AV`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var FFD198 = new L.marker(new L.LatLng(40.57622,-124.2635),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F88`}).addTo(fg).bindPopup(`FFD198<br>Ferndale Fire Department<br>"436 Brown St"<br>"Ferndale, CA 95536"<br><b style='color:red;'></b><br>40.57622, -124.2635,  0 Ft.<br>CN70UN`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var LFS197 = new L.marker(new L.LatLng(40.64431,-124.22063),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F89`}).addTo(fg).bindPopup(`LFS197<br>Loleta Fire Station<br>"585 Park St"<br>"Loleta, CA 95551"<br><b style='color:red;'></b><br>40.64431, -124.22063,  0 Ft.<br>CN70VP`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var MCVF196 = new L.marker(new L.LatLng(40.76064,-123.87006),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F90`}).addTo(fg).bindPopup(`MCVF196<br>Maple Creek Volunteer Fire<br>"15933 Maple Creek Rd"<br>"Korbel, CA 95550"<br><b style='color:red;'></b><br>40.76064, -123.87006,  0 Ft.<br>CN80BS`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var KFPD194 = new L.marker(new L.LatLng(40.77186,-124.00153),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F91`}).addTo(fg).bindPopup(`KFPD194<br>Kneeland Fire Protection Distribution<br>"6201 Greenwood Heights Dr"<br>"Kneeland, CA 95549"<br><b style='color:red;'></b><br>40.77186, -124.00153,  0 Ft.<br>CN70XS`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var WCFD192 = new L.marker(new L.LatLng(40.94043,-123.6334),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F92`}).addTo(fg).bindPopup(`WCFD192<br>Willow Creek Fire Department<br>"38883 CA-299"<br>"Willow Creek, CA 95573"<br><b style='color:red;'></b><br>40.94043, -123.6334,  0 Ft.<br>CN80EW`).openPopup();                        
 
                        $(`fire`._icon).addClass(`firemrkr`);
            var WHIDBEY264 = new L.marker(new L.LatLng(48.29484,-122.653811),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H1`}).addTo(fg).bindPopup(`WHIDBEY264<br>WHIDBEY<br>275 SE CABOT<br>OAK HARBOR<br><b style='color:red;'></b><br>48.29484, -122.653811,  0 Ft.<br>CN88QH`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var LMH = new L.marker(new L.LatLng(38.979225,-95.248259),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H2`}).addTo(fg).bindPopup(`LMH<br>Lawrence Memorial Hospital<br>"325 Maine Street"<br> "Lawrence, Kansas 66044"<br><b style='color:red;'>ACT staffs this location in emergencies </b><br>38.979225, -95.248259,  0 Ft.<br>EM28JX`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var FORKS261 = new L.marker(new L.LatLng(47.946119,-124.392853),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H3`}).addTo(fg).bindPopup(`FORKS261<br>FORKS<br>530 BOGACHIEL<br>FORKS<br><b style='color:red;'></b><br>47.946119, -124.392853,  0 Ft.<br>CN77TW`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var JCC260 = new L.marker(new L.LatLng(47.821937,-122.875899),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H4`}).addTo(fg).bindPopup(`JCC260<br>JC CLINIC<br>294843 US101<br>QUILCENE<br><b style='color:red;'></b><br>47.821937, -122.875899,  0 Ft.<br>CN87NT`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var JCC259 = new L.marker(new L.LatLng(47.919701,-122.702967),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H5`}).addTo(fg).bindPopup(`JCC259<br>JC CLINIC<br>89 BREAKER<br>PORT LUDLOW<br><b style='color:red;'></b><br>47.919701, -122.702967,  0 Ft.<br>CN87PW`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var SJH160 = new L.marker(new L.LatLng(40.7841,-124.1422),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H6`}).addTo(fg).bindPopup(`SJH160<br>St Joseph Hospital<br>"2700 Dolbeer St"<br>"Eureka, CA 95501"<br><b style='color:red;'>"Level 3 Trauma Center, Helipad"</b><br>40.7841, -124.1422,  0 Ft.<br>CN70WS`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var BATES = new L.marker(new L.LatLng(38.2498,-94.3432),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H7`}).addTo(fg).bindPopup(`BATES<br>BATES COUNTY HOSPITAL<br>615 West Nursery St<br>Butler, Mo. 64730<br><b style='color:red;'></b><br>38.2498, -94.3432,  0 Ft.<br>EM28TF`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var PA262 = new L.marker(new L.LatLng(48.115502,-123.414468),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H8`}).addTo(fg).bindPopup(`PA262<br>PA<br>939 CAROLINE<br>PORT ANGELES<br><b style='color:red;'></b><br>48.115502, -123.414468,  0 Ft.<br>CN88HC`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var MRCH161 = new L.marker(new L.LatLng(40.8963,-124.0917),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H9`}).addTo(fg).bindPopup(`MRCH161<br>Mad River Community Hospital<br>"3800 Janes Rd"<br>"Arcata, CA 95521"<br><b style='color:red;'>"Level 4 Trauma Center, Helipad"</b><br>40.8963, -124.0917,  0 Ft.<br>CN70WV`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var RMH162 = new L.marker(new L.LatLng(40.5823,-124.1364),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H10`}).addTo(fg).bindPopup(`RMH162<br>Redwood Memorial Hospital<br>"3300 Renner Drive"<br>"Fortuna, CA 95540"<br><b style='color:red;'></b><br>40.5823, -124.1364,  0 Ft.<br>CN70WN`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var JPCH163 = new L.marker(new L.LatLng(40.1016,-123.7922),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H11`}).addTo(fg).bindPopup(`JPCH163<br>Jerold Phelps Community Hospital<br>"733 Cedar St"<br>"Garberville, CA 95542"<br><b style='color:red;'></b><br>40.1016, -123.7922,  0 Ft.<br>CN80CC`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var TH164 = new L.marker(new L.LatLng(40.7381,-122.9396),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H12`}).addTo(fg).bindPopup(`TH164<br>Trinity Hospital<br>"60 Easter Avenue"<br>"Weaverville, CA 96093"<br><b style='color:red;'></b><br>40.7381, -122.9396,  0 Ft.<br>CN80MR`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var SCH165 = new L.marker(new L.LatLng(41.7737,-124.1942),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H13`}).addTo(fg).bindPopup(`SCH165<br>Sutter Coast Hospital<br>"800 E Washington Blvd"<br>"Crescent City, CA 95531"<br><b style='color:red;'></b><br>41.7737, -124.1942,  0 Ft.<br>CN71VS`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var JCMC258 = new L.marker(new L.LatLng(48.105752,-122789857),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H14`}).addTo(fg).bindPopup(`JCMC258<br>JCMC<br>834 SHERIDAN<br>PORT TOWNSEND<br><b style='color:red;'></b><br>48.105752, -122789857,  0 Ft.<br>N8C`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var WHIDBEY263 = new L.marker(new L.LatLng(48.213953,-122.684483),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H15`}).addTo(fg).bindPopup(`WHIDBEY263<br>WHIDBEY<br>101 N MAIN<br>COUPEVILLE<br><b style='color:red;'></b><br>48.213953, -122.684483,  0 Ft.<br>CN88PF`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var SMMC = new L.marker(new L.LatLng(38.9955,-94.6908),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H16`}).addTo(fg).bindPopup(`SMMC<br>Shawnee Mission Medical Center<br>9100 W. 74th St<br>Shawnee Mission, KS 66204-4004<br><b style='color:red;'></b><br>38.9955, -94.6908,  0 Ft.<br>EM28PX`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var PETTIS = new L.marker(new L.LatLng(38.6973,-93.2163),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H17`}).addTo(fg).bindPopup(`PETTIS<br>PETTIS Co Health Dept<br>911 E 16th st<br>SEDALIA, MO 65301<br><b style='color:red;'></b><br>38.6973, -93.2163,  0 Ft.<br>EM38JQ`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var OPR = new L.marker(new L.LatLng(39.9372,-94.7262),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H18`}).addTo(fg).bindPopup(`OPR<br>Overland Park RMC<br>10500 QuivIra Rd<br>Overland Park, KS 66215<br><b style='color:red;'></b><br>39.9372, -94.7262,  0 Ft.<br>EM29PW`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var EXSPR = new L.marker(new L.LatLng(39.3568,-94.237),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H19`}).addTo(fg).bindPopup(`EXSPR<br>Excelsior Springs Medical Center<br>1700 Rainbow Boulevard<br>Excelsior Springs, MO 64024-1190<br><b style='color:red;'></b><br>39.3568, -94.237,  0 Ft.<br>EM29VI`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var OMC = new L.marker(new L.LatLng(38.853,-94.8235),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H20`}).addTo(fg).bindPopup(`OMC<br>Olathe Medical Center, Inc.<br>20333 W 151 st<br>Olathe KS 66061<br><b style='color:red;'></b><br>38.853, -94.8235,  0 Ft.<br>EM28OU`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var NORKC = new L.marker(new L.LatLng(39.1495,-94.5513),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H21`}).addTo(fg).bindPopup(`NORKC<br>North Kansas City Hospital<br>2800 Clay Edwards Dr<br>North Kansas City, MO 64116<br><b style='color:red;'></b><br>39.1495, -94.5513,  0 Ft.<br>EM29RD`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var MENORA = new L.marker(new L.LatLng(38.9107,-94.6512),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H22`}).addTo(fg).bindPopup(`MENORA<br>Menorah Medical Center<br>5721 west 119th st<br>Overland Park, KS 66209<br><b style='color:red;'></b><br>38.9107, -94.6512,  0 Ft.<br>EM28QV`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var LSMED = new L.marker(new L.LatLng(38.9035,-94.3327),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H23`}).addTo(fg).bindPopup(`LSMED<br>Lee's Summit Medical Center<br>2100 SE Blue Pkwy<br>Lee's Summit, MO 64081-1497<br><b style='color:red;'></b><br>38.9035, -94.3327,  0 Ft.<br>EM28UV`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var LRHC = new L.marker(new L.LatLng(39.1893,-93.8768),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H24`}).addTo(fg).bindPopup(`LRHC<br>LAFAYETTE REGIONAL HEALTH CENTER<br>1500 STATE<br>LEXINGTON, MO 64067<br><b style='color:red;'></b><br>39.1893, -93.8768,  0 Ft.<br>EM39BE`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var LCHD19 = new L.marker(new L.LatLng(39.1732,-93.8748),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H25`}).addTo(fg).bindPopup(`LCHD19<br>LAFAYETTE CO HEALTH DEPT<br>547 South 13 Highway<br>Lexington, MO 64067<br><b style='color:red;'></b><br>39.1732, -93.8748,  0 Ft.<br>EM39BE`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var LIBRTY = new L.marker(new L.LatLng(39.274,-94.4233),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H26`}).addTo(fg).bindPopup(`LIBRTY<br>Liberty Hospital<br>2525 Glen Hendren<br>Liberty, MO 64068<br><b style='color:red;'></b><br>39.274, -94.4233,  0 Ft.<br>EM29SG`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var KU0MED = new L.marker(new L.LatLng(39.557,-94.6102),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H27`}).addTo(fg).bindPopup(`KU0MED<br>University of Kansas Hospital<br>3901 Rainbow Blvd Mail Stop 3004<br>Kansas City, KS 66160-7200<br><b style='color:red;'></b><br>39.557, -94.6102,  0 Ft.<br>EM29QN`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var KINDRD = new L.marker(new L.LatLng(38.968,-94.5745),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H28`}).addTo(fg).bindPopup(`KINDRD<br>Kindred Hospital Kansas City<br>8701 Troost Ave<br>Kansas City, MO 64131-2767<br><b style='color:red;'></b><br>38.968, -94.5745,  0 Ft.<br>EM28RX`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var KCVA = new L.marker(new L.LatLng(39.672,-94.5282),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H29`}).addTo(fg).bindPopup(`KCVA<br>Veterans Affairs Medical Center<br>4801 E Linwood Blvd<br>Kansas City, MO 64128-2295<br><b style='color:red;'></b><br>39.672, -94.5282,  0 Ft.<br>EM29RQ`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var PMC = new L.marker(new L.LatLng(39.127,-94.7865),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H30`}).addTo(fg).bindPopup(`PMC<br>Providence Medical Center<br>8929 Parallel Parkway<br>Kansas City, KS 66212-1689<br><b style='color:red;'></b><br>39.127, -94.7865,  0 Ft.<br>EM29OD`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var STLPLZ = new L.marker(new L.LatLng(39.477,-94.5895),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H31`}).addTo(fg).bindPopup(`STLPLZ<br>Saint Lukes Hospital Plaza<br>4401 Wornall Road<br>Kansas City, MO 64111<br><b style='color:red;'></b><br>39.477, -94.5895,  0 Ft.<br>EM29QL`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var RAYCO = new L.marker(new L.LatLng(39.2587,-93.9543),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H32`}).addTo(fg).bindPopup(`RAYCO<br>RAY COUNTY HOSPITAL<br>904 WOLLARD BLVD<br>RICHMOND, MO 64085<br><b style='color:red;'></b><br>39.2587, -93.9543,  0 Ft.<br>EM39AG`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var STJOHN = new L.marker(new L.LatLng(39.2822,-94.9058),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H33`}).addTo(fg).bindPopup(`STJOHN<br>Saint John Hospital<br><br><br><b style='color:red;'></b><br>39.2822, -94.9058,  0 Ft.<br>EM29NG`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var STJOMC = new L.marker(new L.LatLng(38.9362,-94.6037),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H34`}).addTo(fg).bindPopup(`STJOMC<br>Saint Joseph Medical Center<br>1000 Carondelet Dr<br>Kansas City, MO 64114-4865<br><b style='color:red;'></b><br>38.9362, -94.6037,  0 Ft.<br>EM28QW`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var STLEAS = new L.marker(new L.LatLng(38.9415,-94.3813),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H35`}).addTo(fg).bindPopup(`STLEAS<br>Saint Lukes East-Lee's Summit<br>100 N.E. Saint Luke's Blvd<br>Lees Summit, MO 64086-5998<br><b style='color:red;'></b><br>38.9415, -94.3813,  0 Ft.<br>EM28TW`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var RESRCH = new L.marker(new L.LatLng(39.167,-94.6682),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H36`}).addTo(fg).bindPopup(`RESRCH<br>Research Medical Center<br>2316 E. Meyer Blvd<br>Kansas City, MO 64132<br><b style='color:red;'></b><br>39.167, -94.6682,  0 Ft.<br>EM29PE`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var STLSMI = new L.marker(new L.LatLng(39.3758,-94.5807),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H37`}).addTo(fg).bindPopup(`STLSMI<br>Saint Lukes Smithville Campus<br>601 south 169 Highway<br>Smithville, MO 64089<br><b style='color:red;'></b><br>39.3758, -94.5807,  0 Ft.<br>EM29RJ`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var STLUBR = new L.marker(new L.LatLng(39.2482,-94.6487),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H38`}).addTo(fg).bindPopup(`STLUBR<br>Saint Lukes Barry Road Campus<br>5830 Northwest Barry Rd<br>Kansas City, MO 64154-2778<br><b style='color:red;'></b><br>39.2482, -94.6487,  0 Ft.<br>EM29QF`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var STLUSO = new L.marker(new L.LatLng(38.904,-94.6682),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H39`}).addTo(fg).bindPopup(`STLUSO<br>Saint Lukes South Hospital<br>12300 Metcalf Ave<br>Overland Park, KS 66213<br><b style='color:red;'></b><br>38.904, -94.6682,  0 Ft.<br>EM28PV`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var STM = new L.marker(new L.LatLng(39.263,-94.2627),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H40`}).addTo(fg).bindPopup(`STM<br>Saint Marys Medical Center<br>201 NW R D Mize Rd<br>Blue Springs, MO 64014<br><b style='color:red;'></b><br>39.263, -94.2627,  0 Ft.<br>EM29UG`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var TRLKWD = new L.marker(new L.LatLng(38.9745,-94.3915),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H41`}).addTo(fg).bindPopup(`TRLKWD<br>Truman Lakewood<br><br><br><b style='color:red;'></b><br>38.9745, -94.3915,  0 Ft.<br>EM28TX`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var TRUHH = new L.marker(new L.LatLng(39.853,-94.5737),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H42`}).addTo(fg).bindPopup(`TRUHH<br>Truman Medical Center-Hospital Hill<br>2055 Holmes<br>Kansas City, MO 64108-2621<br><b style='color:red;'></b><br>39.853, -94.5737,  0 Ft.<br>EM29RU`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var W0CPT = new L.marker(new L.LatLng(39.5,-94.3483),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H43`}).addTo(fg).bindPopup(`W0CPT<br>Centerpoint Medical Center<br>19600 East 39th St<br>Independence Mo 64057<br><b style='color:red;'></b><br>39.5, -94.3483,  0 Ft.<br>EM29TL`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var WEMO = new L.marker(new L.LatLng(38.7667,-93.7217),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H44`}).addTo(fg).bindPopup(`WEMO<br>WESTERN MISSOURI MEDICAL CENTER<br>403 BURKARTH RD<br>WARRENSBURG, MO 64093<br><b style='color:red;'></b><br>38.7667, -93.7217,  0 Ft.<br>EM38DS`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var RMCBKS = new L.marker(new L.LatLng(39.8,-94.5778),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H45`}).addTo(fg).bindPopup(`RMCBKS<br>Research Medical Center- Brookside<br>6601 Rockhill Rd<br>Kansas City, MO 64131-2767<br><b style='color:red;'></b><br>39.8, -94.5778,  0 Ft.<br>EM29RT`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var KC0CBC = new L.marker(new L.LatLng(39.537,-94.5865),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H46`}).addTo(fg).bindPopup(`KC0CBC<br>Kansas City Blood Bank<br>4240 Main St<br>KC MO<br><b style='color:red;'></b><br>39.537, -94.5865,  0 Ft.<br>EM29QM`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var I70 = new L.marker(new L.LatLng(38.9783,-93.4162),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H47`}).addTo(fg).bindPopup(`I70<br>I-70 MEDICAL CENTER<br>105 HOSPITAL DR<br>SWEET SPRINGS, MO 65351<br><b style='color:red;'></b><br>38.9783, -93.4162,  0 Ft.<br>EM38HX`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var CASS = new L.marker(new L.LatLng(38.6645,-94.3725),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H48`}).addTo(fg).bindPopup(`CASS<br>Cass Medical Center<br>1800 East Mechanic Street<br>Harrisonville, MO 64701-2017<br><b style='color:red;'></b><br>38.6645, -94.3725,  0 Ft.<br>EM28TP`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var CMH = new L.marker(new L.LatLng(39.852,-943.74),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H49`}).addTo(fg).bindPopup(`CMH<br>Childrens Mercy Hospital<br>2401 Gillham Road<br>Kansas City, MO 64108<br><b style='color:red;'></b><br>39.852, -943.74,  0 Ft.<br>M9U`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var CMHS = new L.marker(new L.LatLng(38.9302,-94.6613),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H50`}).addTo(fg).bindPopup(`CMHS<br>Childrens Mercy Hospital South<br>5808 W 110th<br>Leawood, KS 66211<br><b style='color:red;'></b><br>38.9302, -94.6613,  0 Ft.<br>EM28QW`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var CUSHNG = new L.marker(new L.LatLng(39.3072,-94.9185),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H51`}).addTo(fg).bindPopup(`CUSHNG<br>Cushing Memorial Hospital<br>711 Marshall St<br>Leavenworth, KS 66048<br><b style='color:red;'></b><br>39.3072, -94.9185,  0 Ft.<br>EM29MH`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var DCEC = new L.marker(new L.LatLng(39.862,-94.576),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H52`}).addTo(fg).bindPopup(`DCEC<br>Metro Regional Healthcare Coord. Ctr<br>610 E 22nd St.<br>Kansas City, MO<br><b style='color:red;'></b><br>39.862, -94.576,  0 Ft.<br>EM29RU`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var FITZ = new L.marker(new L.LatLng(39.928,-93.2143),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H53`}).addTo(fg).bindPopup(`FITZ<br>FITZGIBBON HOSPITAL<br>2305 S HWY 65<br>MARSHALL, MO 65340<br><b style='color:red;'></b><br>39.928, -93.2143,  0 Ft.<br>EM39JW`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var BOTHWL = new L.marker(new L.LatLng(38.6993,-93.2208),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H54`}).addTo(fg).bindPopup(`BOTHWL<br>BOTHWELL REGIONAL HEALTH CENTER<br>601 E 14TH ST<br>SEDALIA, MO 65301<br><b style='color:red;'></b><br>38.6993, -93.2208,  0 Ft.<br>EM38JQ`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var GVMH = new L.marker(new L.LatLng(38.3892,-93.7702),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H55`}).addTo(fg).bindPopup(`GVMH<br>GOLDEN VALLEY MEMORIAL HOSPITAL<br>1600 NORTH 2ND ST<br>CLINTON, MO 64735<br><b style='color:red;'></b><br>38.3892, -93.7702,  0 Ft.<br>EM38CJ`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var CARROL = new L.marker(new L.LatLng(39.3762,-93.494),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H56`}).addTo(fg).bindPopup(`CARROL<br>CARROLL COUNTY HOSPITAL<br>1502 N JEFFERSON<br>CAROLLTON, MO 64633<br><b style='color:red;'></b><br>39.3762, -93.494,  0 Ft.<br>EM39GJ`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var BRMC = new L.marker(new L.LatLng(38.8158,-94.5033),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H57`}).addTo(fg).bindPopup(`BRMC<br>Research Belton Hospital<br>17065 S 71 Hwy<br>Belton, MO 64012<br><b style='color:red;'></b><br>38.8158, -94.5033,  0 Ft.<br>EM28RT`).openPopup();                        
 
                        $(`hospital`._icon).addClass(`hosmrkr`);
            var PTPOLICE1925 = new L.marker(new L.LatLng(48.11464,-122.77136),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P4`}).addTo(fg).bindPopup(`PTPOLICE1925<br>PT POLICE<br>PT Police 1925 Blain Port Townsend WA <br>PORT TOWNSEND<br><b style='color:red;'></b><br>48.11464, -122.77136,  0 Ft.<br>CN88OC`).openPopup();                        
 
                        $(`police`._icon).addClass(`polmrkr`);
            var APD231 = new L.marker(new L.LatLng(40.86734,-124.08477),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P5`}).addTo(fg).bindPopup(`APD231<br>Arcata Police Department<br>"736 F St"<br>"Arcata, CA 95521"<br><b style='color:red;'>"CERT governing body"</b><br>40.86734, -124.08477,  0 Ft.<br>CN70WU`).openPopup();                        
 
                        $(`police`._icon).addClass(`polmrkr`);
            var BLPD236 = new L.marker(new L.LatLng(40.8827,-123.99215),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P6`}).addTo(fg).bindPopup(`BLPD236<br>Blue Lake Police Department<br>"111 Greenwood Ave"<br>"Blue Lake, CA 95525"<br><b style='color:red;'></b><br>40.8827, -123.99215,  0 Ft.<br>CN80AV`).openPopup();                        
 
                        $(`police`._icon).addClass(`polmrkr`);
            var HTP235 = new L.marker(new L.LatLng(41.06548,-123.68557),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P7`}).addTo(fg).bindPopup(`HTP235<br>Hoopa Tribal Police<br>"12637 CA-96"<br>"Hoopa, CA 95546"<br><b style='color:red;'></b><br>41.06548, -123.68557,  0 Ft.<br>CN81DB`).openPopup();                        
 
                        $(`police`._icon).addClass(`polmrkr`);
            var HSUCP233 = new L.marker(new L.LatLng(40.87461,-124.07913),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P8`}).addTo(fg).bindPopup(`HSUCP233<br>Humboldt State University Campus Police<br>"1 Harpst St"<br>"Arcata, CA 95521"<br><b style='color:red;'></b><br>40.87461, -124.07913,  0 Ft.<br>CN70XU`).openPopup();                        
 
                        $(`police`._icon).addClass(`polmrkr`);
            var FPD229 = new L.marker(new L.LatLng(40.57692,-124.26119),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P9`}).addTo(fg).bindPopup(`FPD229<br>Ferndale Police Department<br>"600 Berding St"<br>"Ferndale, CA 95536"<br><b style='color:red;'>"CERT governing body"</b><br>40.57692, -124.26119,  0 Ft.<br>CN70UN`).openPopup();                        
 
                        $(`police`._icon).addClass(`polmrkr`);
            var FPD230 = new L.marker(new L.LatLng(40.59758,-124.15494),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P10`}).addTo(fg).bindPopup(`FPD230<br>Fortuna Police Department<br>"621 11th St"<br>"Fortuna, CA 95540"<br><b style='color:red;'></b><br>40.59758, -124.15494,  0 Ft.<br>CN70WO`).openPopup();                        
 
                        $(`police`._icon).addClass(`polmrkr`);
            var EPD228 = new L.marker(new L.LatLng(40.8006,-124.16932),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P11`}).addTo(fg).bindPopup(`EPD228<br>Eureka Police Department<br>"604 C St"<br>"Eureka, CA 95501"<br><b style='color:red;'></b><br>40.8006, -124.16932,  0 Ft.<br>CN70VT`).openPopup();                        
 
                        $(`police`._icon).addClass(`polmrkr`);
            var TPD232 = new L.marker(new L.LatLng(41.05984,-124.14284),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P12`}).addTo(fg).bindPopup(`TPD232<br>Trinidad Police Department<br>"463 Trinity St"<br>"Trinidad, CA 95570"<br><b style='color:red;'></b><br>41.05984, -124.14284,  0 Ft.<br>CN71WB`).openPopup();                        
 
                        $(`police`._icon).addClass(`polmrkr`);
            var RDPD234 = new L.marker(new L.LatLng(40.4991,-124.10674),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P13`}).addTo(fg).bindPopup(`RDPD234<br>Rio Dell Police Department<br>"675 Wildwood Ave"<br>"Rio Dell, CA 95562"<br><b style='color:red;'></b><br>40.4991, -124.10674,  0 Ft.<br>CN70WL`).openPopup();                        
 
                        $(`police`._icon).addClass(`polmrkr`);
            var W4HRS = new L.marker(new L.LatLng(33.37939835,-79.28469849),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R1`}).addTo(fg).bindPopup(`W4HRS<br>W4HRS<br><br>Georgetown - Memorial Hospital<br><b style='color:red;'>146.7 PL 123 OFFSET -</b><br>33.37939835, -79.28469849,  0 Ft.<br>FM03IJ`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4HRS = new L.marker(new L.LatLng(32.78419876,-79.94499969),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R2`}).addTo(fg).bindPopup(`W4HRS<br>W4HRS<br><br>Charleston - Rutledge Tower (MUSC)<br><b style='color:red;'>145.45 PL 123 OFFSET -</b><br>32.78419876, -79.94499969,  0 Ft.<br>FM02AS`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4GL = new L.marker(new L.LatLng(33.96319962,-80.40219879),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R3`}).addTo(fg).bindPopup(`W4GL<br>W4GL<br><br>Wedgefield<br><b style='color:red;'>145.43 PL 156.7 OFFSET -</b><br>33.96319962, -80.40219879,  0 Ft.<br>EM93TX`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4BRK = new L.marker(new L.LatLng(33.19599915,-80.01309967),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R4`}).addTo(fg).bindPopup(`W4BRK<br>W4BRK<br><br>Moncks Corner<br><b style='color:red;'>146.61 PL 123 OFFSET -</b><br>33.19599915, -80.01309967,  0 Ft.<br>EM93XE`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KK4ONF = new L.marker(new L.LatLng(32.4276903,-81.0087199),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R5`}).addTo(fg).bindPopup(`KK4ONF<br>KK4ONF<br><br>Switzerland<br><b style='color:red;'>146.06 PL 123 OFFSET +</b><br>32.4276903, -81.0087199,  0 Ft.<br>EM92LK`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KE4MDP = new L.marker(new L.LatLng(35.0461998,-81.58930206),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R6`}).addTo(fg).bindPopup(`KE4MDP<br>KE4MDP<br><br>Gaffney - Draytonville Mtn<br><b style='color:red;'>145.43 PL 162.2 OFFSET -</b><br>35.0461998, -81.58930206,  0 Ft.<br>EM95EB`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WA4USN = new L.marker(new L.LatLng(32.58060074,-80.15969849),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R7`}).addTo(fg).bindPopup(`WA4USN<br>WA4USN<br><br>Seabrook Island<br><b style='color:red;'>145.41 PL 123 OFFSET -</b><br>32.58060074, -80.15969849,  0 Ft.<br>EM92WN`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KJ4BWK = new L.marker(new L.LatLng(34.0007019,-81.03479767),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R8`}).addTo(fg).bindPopup(`KJ4BWK<br>KJ4BWK<br><br>Columbia<br><b style='color:red;'>145.4 PL  OFFSET -</b><br>34.0007019, -81.03479767,  0 Ft.<br>EM94LA`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KG4BZN = new L.marker(new L.LatLng(32.90520096,-80.66680145),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R9`}).addTo(fg).bindPopup(`KG4BZN<br>KG4BZN<br><br>Walterboro<br><b style='color:red;'>145.39 PL  OFFSET -</b><br>32.90520096, -80.66680145,  0 Ft.<br>EM92PV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var K4NAB = new L.marker(new L.LatLng(33.50180054,-81.96510315),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R10`}).addTo(fg).bindPopup(`K4NAB<br>K4NAB<br><br>North Augusta<br><b style='color:red;'>146.73 PL  OFFSET -</b><br>33.50180054, -81.96510315,  0 Ft.<br>EM93AM`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4DV = new L.marker(new L.LatLng(33.68489838,-81.92639923),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R11`}).addTo(fg).bindPopup(`W4DV<br>W4DV<br><br>Trenton - SC<br><b style='color:red;'>145.49 PL 71.9 OFFSET -</b><br>33.68489838, -81.92639923,  0 Ft.<br>EM93AQ`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var K4KNJ = new L.marker(new L.LatLng(34.28580093,-79.24590302),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R12`}).addTo(fg).bindPopup(`K4KNJ<br>K4KNJ<br><br>Fork<br><b style='color:red;'>146.535 PL CSQ OFFSET x</b><br>34.28580093, -79.24590302,  0 Ft.<br>FM04JG`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4HRS = new L.marker(new L.LatLng(32.97570038,-80.07230377),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R13`}).addTo(fg).bindPopup(`W4HRS<br>W4HRS<br><br>North Charleston - Trident Hospital<br><b style='color:red;'>146.73 PL 123 OFFSET -</b><br>32.97570038, -80.07230377,  0 Ft.<br>EM92XX`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KW4BET = new L.marker(new L.LatLng(33.8420316,-78.6400437),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R14`}).addTo(fg).bindPopup(`KW4BET<br>KW4BET<br><br>Cherry Grove Beach - Near The Shack Restaurant<br><b style='color:red;'>146.58 PL D023 OFFSET x</b><br>33.8420316, -78.6400437,  0 Ft.<br>FM03QU`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WA4UKX = new L.marker(new L.LatLng(34.73709869,-82.25430298),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R15`}).addTo(fg).bindPopup(`WA4UKX<br>WA4UKX<br><br>Simpsonville<br><b style='color:red;'>146.73 PL 100 OFFSET -</b><br>34.73709869, -82.25430298,  0 Ft.<br>EM84UR`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4NYK = new L.marker(new L.LatLng(35.05569839,-82.7845993),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R16`}).addTo(fg).bindPopup(`W4NYK<br>W4NYK<br><br>Greenville - Ceasars Head<br><b style='color:red;'>146.61 PL  OFFSET -</b><br>35.05569839, -82.7845993,  0 Ft.<br>EM85OB`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4ZKM = new L.marker(new L.LatLng(33.26150131,-81.65670013),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R17`}).addTo(fg).bindPopup(`W4ZKM<br>W4ZKM<br><br>Jackson  - SRS “C” Road near Central Shops<br><b style='color:red;'>145.45 PL 123 OFFSET -</b><br>33.26150131, -81.65670013,  0 Ft.<br>EM93EG`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var K9OH = new L.marker(new L.LatLng(35.10570145,-82.62760162),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R18`}).addTo(fg).bindPopup(`K9OH<br>K9OH<br><br>Marietta - Caesars Head Mountain<br><b style='color:red;'>145.47 PL 91.5 OFFSET -</b><br>35.10570145, -82.62760162,  0 Ft.<br>EM85QC`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var K4USC = new L.marker(new L.LatLng(34.72969818,-81.63749695),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R19`}).addTo(fg).bindPopup(`K4USC<br>K4USC<br><br>Union<br><b style='color:red;'>146.685 PL  OFFSET -</b><br>34.72969818, -81.63749695,  0 Ft.<br>EM94ER`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WT4F = new L.marker(new L.LatLng(34.88339996,-82.70739746),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R20`}).addTo(fg).bindPopup(`WT4F<br>WT4F<br><br>Pickens<br><b style='color:red;'>146.7 PL 107.2 OFFSET -</b><br>34.88339996, -82.70739746,  0 Ft.<br>EM84PV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WR4SC = new L.marker(new L.LatLng(33.9496994,-79.1085968),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R21`}).addTo(fg).bindPopup(`WR4SC<br>WR4SC<br><br>Aynor<br><b style='color:red;'>146.715 PL 162.2 OFFSET -</b><br>33.9496994, -79.1085968,  0 Ft.<br>FM03KW`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WR4SC = new L.marker(new L.LatLng(34.11859894,-80.93689728),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R22`}).addTo(fg).bindPopup(`WR4SC<br>WR4SC<br><br>Columbia<br><b style='color:red;'>146.715 PL 91.5 OFFSET -</b><br>34.11859894, -80.93689728,  0 Ft.<br>EM94MC`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KK4ZBE = new L.marker(new L.LatLng(32.83229828,-79.82839966),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R23`}).addTo(fg).bindPopup(`KK4ZBE<br>KK4ZBE<br><br>Mt. Pleasant - East Cooper Medical Center<br><b style='color:red;'>146.685 PL 162.2 OFFSET -</b><br>32.83229828, -79.82839966,  0 Ft.<br>FM02CT`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WR4SC = new L.marker(new L.LatLng(32.90520096,-80.66680145),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R24`}).addTo(fg).bindPopup(`WR4SC<br>WR4SC<br><br>White Hall<br><b style='color:red;'>146.715 PL 123 OFFSET -</b><br>32.90520096, -80.66680145,  0 Ft.<br>EM92PV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WR4SC = new L.marker(new L.LatLng(34.28020096,-79.74279785),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R25`}).addTo(fg).bindPopup(`WR4SC<br>WR4SC<br><br>Florence<br><b style='color:red;'>146.685 PL 91.5 OFFSET -</b><br>34.28020096, -79.74279785,  0 Ft.<br>FM04DG`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4HRS = new L.marker(new L.LatLng(33.19889832,-80.00689697),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R26`}).addTo(fg).bindPopup(`W4HRS<br>W4HRS<br><br>Moncks Corner - EOC<br><b style='color:red;'>145.49 PL 103.5 OFFSET -</b><br>33.19889832, -80.00689697,  0 Ft.<br>EM93XE`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var AD4U = new L.marker(new L.LatLng(33.66490173,-80.7779007),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R27`}).addTo(fg).bindPopup(`AD4U<br>AD4U<br><br>St Matthews<br><b style='color:red;'>146.67 PL 156.7 OFFSET -</b><br>33.66490173, -80.7779007,  0 Ft.<br>EM93OP`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4BFT = new L.marker(new L.LatLng(32.41880035,-80.68859863),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R28`}).addTo(fg).bindPopup(`W4BFT<br>W4BFT<br><br>Beaufort - WJWJ<br><b style='color:red;'>146.655 PL  OFFSET -</b><br>32.41880035, -80.68859863,  0 Ft.<br>EM92PK`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WR4EC = new L.marker(new L.LatLng(33.7942009,-81.89029694),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R29`}).addTo(fg).bindPopup(`WR4EC<br>WR4EC<br><br>Edgefield<br><b style='color:red;'>146.85 PL 91.5 OFFSET -</b><br>33.7942009, -81.89029694,  0 Ft.<br>EM93BT`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4GL = new L.marker(new L.LatLng(33.92039871,-80.34149933),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R30`}).addTo(fg).bindPopup(`W4GL<br>W4GL<br><br>Sumter<br><b style='color:red;'>146.64 PL 156.7 OFFSET -</b><br>33.92039871, -80.34149933,  0 Ft.<br>EM93TW`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4PAX = new L.marker(new L.LatLng(34.72040176,-80.77089691),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R31`}).addTo(fg).bindPopup(`W4PAX<br>W4PAX<br><br>Lancaster<br><b style='color:red;'>146.7 PL 123 OFFSET -</b><br>34.72040176, -80.77089691,  0 Ft.<br>EM94OR`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4APE = new L.marker(new L.LatLng(34.74810028,-79.84259796),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R32`}).addTo(fg).bindPopup(`W4APE<br>W4APE<br><br>Cheraw<br><b style='color:red;'>145.49 PL 123 OFFSET -</b><br>34.74810028, -79.84259796,  0 Ft.<br>FM04BR`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4APE = new L.marker(new L.LatLng(34.19979858,-79.23249817),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R33`}).addTo(fg).bindPopup(`W4APE<br>W4APE<br><br>Mullins<br><b style='color:red;'>145.47 PL 123 OFFSET -</b><br>34.19979858, -79.23249817,  0 Ft.<br>FM04JE`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WR4SC = new L.marker(new L.LatLng(34.94060135,-82.41059875),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R34`}).addTo(fg).bindPopup(`WR4SC<br>WR4SC<br><br>Greenville<br><b style='color:red;'>145.37 PL 123 OFFSET -</b><br>34.94060135, -82.41059875,  0 Ft.<br>EM84TW`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var N1RCW = new L.marker(new L.LatLng(32.256,-80.9581),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R35`}).addTo(fg).bindPopup(`N1RCW<br>N1RCW<br><br>Bluffton - Lawton Station<br><b style='color:red;'>147.435 PL 88.5 OFFSET x</b><br>32.256, -80.9581,  0 Ft.<br>EM92MG`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4FTK  = new L.marker(new L.LatLng(34.92490005,-81.02510071),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R36`}).addTo(fg).bindPopup(`W4FTK <br>W4FTK <br><br>Rock Hill<br><b style='color:red;'>147.225 PL 110.9 OFFSET +</b><br>34.92490005, -81.02510071,  0 Ft.<br>EM94LW`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WA4NMW = new L.marker(new L.LatLng(33.01300049,-80.25800323),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R37`}).addTo(fg).bindPopup(`WA4NMW<br>WA4NMW<br><br>Knightsville<br><b style='color:red;'>147.225 PL 123 OFFSET +</b><br>33.01300049, -80.25800323,  0 Ft.<br>EM93UA`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WR4SC = new L.marker(new L.LatLng(34.19630051,-81.41230011),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R38`}).addTo(fg).bindPopup(`WR4SC<br>WR4SC<br><br>Little Mountain<br><b style='color:red;'>147.21 PL 156.7 OFFSET +</b><br>34.19630051, -81.41230011,  0 Ft.<br>EM94HE`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4FTK = new L.marker(new L.LatLng(33.969955,-79.03414),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R39`}).addTo(fg).bindPopup(`W4FTK<br>W4FTK<br><br>Aynor<br><b style='color:red;'>147.21 PL D315 OFFSET +</b><br>33.969955, -79.03414,  0 Ft.<br>FM03LX`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WX4PG = new L.marker(new L.LatLng(34.9009497,-82.6592992),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R40`}).addTo(fg).bindPopup(`WX4PG<br>WX4PG<br><br>Pickens - Glassy Mtn<br><b style='color:red;'>147.195 PL 141.3 OFFSET +</b><br>34.9009497, -82.6592992,  0 Ft.<br>EM84QV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4APE = new L.marker(new L.LatLng(34.24779892,-79.81109619),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R41`}).addTo(fg).bindPopup(`W4APE<br>W4APE<br><br>Florence<br><b style='color:red;'>147.195 PL 123 OFFSET +</b><br>34.24779892, -79.81109619,  0 Ft.<br>FM04CF`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4HNK = new L.marker(new L.LatLng(33.14189911,-80.35079956),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R42`}).addTo(fg).bindPopup(`W4HNK<br>W4HNK<br><br>Dorchester<br><b style='color:red;'>147.18 PL 123 OFFSET +</b><br>33.14189911, -80.35079956,  0 Ft.<br>EM93TD`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4GWD = new L.marker(new L.LatLng(34.37239838,-82.1678009),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R43`}).addTo(fg).bindPopup(`W4GWD<br>W4GWD<br><br>Greenwood<br><b style='color:red;'>147.165 PL 107.2 OFFSET +</b><br>34.37239838, -82.1678009,  0 Ft.<br>EM84VI`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var K4CCC = new L.marker(new L.LatLng(34.74860001,-79.84140015),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R44`}).addTo(fg).bindPopup(`K4CCC<br>K4CCC<br><br>Cheraw<br><b style='color:red;'>147.135 PL 123 OFFSET +</b><br>34.74860001, -79.84140015,  0 Ft.<br>FM04BR`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4GS = new L.marker(new L.LatLng(33.68909836,-78.88670349),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R45`}).addTo(fg).bindPopup(`W4GS<br>W4GS<br><br>Myrtle Beach<br><b style='color:red;'>147.12 PL 85.4 OFFSET +</b><br>33.68909836, -78.88670349,  0 Ft.<br>FM03NQ`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WR4SC = new L.marker(new L.LatLng(32.80220032,-80.02359772),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R46`}).addTo(fg).bindPopup(`WR4SC<br>WR4SC<br><br>Charleston<br><b style='color:red;'>147.105 PL 123 OFFSET +</b><br>32.80220032, -80.02359772,  0 Ft.<br>EM92XT`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WR4SC = new L.marker(new L.LatLng(34.88639832,-81.82080078),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R47`}).addTo(fg).bindPopup(`WR4SC<br>WR4SC<br><br>Spartanburg - Camp Croft<br><b style='color:red;'>147.09 PL 162.2 OFFSET +</b><br>34.88639832, -81.82080078,  0 Ft.<br>EM94CV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KJ4QLH = new L.marker(new L.LatLng(33.52,-81.08),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R48`}).addTo(fg).bindPopup(`KJ4QLH<br>KJ4QLH<br><br>Neeses<br><b style='color:red;'>147.09 PL 156.7 OFFSET +</b><br>33.52, -81.08,  0 Ft.<br>EM93LM`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4FTK = new L.marker(new L.LatLng(33.854465,-80.529466),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R49`}).addTo(fg).bindPopup(`W4FTK<br>W4FTK<br><br>Wedgefield<br><b style='color:red;'>147.06 PL D315 OFFSET +</b><br>33.854465, -80.529466,  0 Ft.<br>EM93RU`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KK4ONF = new L.marker(new L.LatLng(32.28710175,-81.08070374),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R50`}).addTo(fg).bindPopup(`KK4ONF<br>KK4ONF<br><br>Hardeeville<br><b style='color:red;'>147.06 PL 123 OFFSET +</b><br>32.28710175, -81.08070374,  0 Ft.<br>EM92LG`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4IAR = new L.marker(new L.LatLng(32.21630096,-80.75260162),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R51`}).addTo(fg).bindPopup(`W4IAR<br>W4IAR<br><br>Hilton Head Island<br><b style='color:red;'>147.24 PL 100 OFFSET +</b><br>32.21630096, -80.75260162,  0 Ft.<br>EM92OF`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4GS = new L.marker(new L.LatLng(33.70660019,-78.87419891),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R52`}).addTo(fg).bindPopup(`W4GS<br>W4GS<br><br>Myrtle Beach<br><b style='color:red;'>147.24 PL 85.4 OFFSET +</b><br>33.70660019, -78.87419891,  0 Ft.<br>FM03NQ`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KA4FEC = new L.marker(new L.LatLng(33.98149872,-81.23619843),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R53`}).addTo(fg).bindPopup(`KA4FEC<br>KA4FEC<br><br>Lexington<br><b style='color:red;'>147.39 PL 156.7 OFFSET +</b><br>33.98149872, -81.23619843,  0 Ft.<br>EM93JX`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var NE4SC = new L.marker(new L.LatLng(33.44609833,-79.28469849),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R54`}).addTo(fg).bindPopup(`NE4SC<br>NE4SC<br><br>Georgetown<br><b style='color:red;'>147.375 PL 123 OFFSET +</b><br>33.44609833, -79.28469849,  0 Ft.<br>FM03IK`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KK4BQ = new L.marker(new L.LatLng(33.2448733,-81.3587177),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R55`}).addTo(fg).bindPopup(`KK4BQ<br>KK4BQ<br><br>Barnwell<br><b style='color:red;'>147.375 PL 91.5 OFFSET +</b><br>33.2448733, -81.3587177,  0 Ft.<br>EM93HF`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var K4HI = new L.marker(new L.LatLng(34.0007019,-81.03479767),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R56`}).addTo(fg).bindPopup(`K4HI<br>K4HI<br><br>Columbia<br><b style='color:red;'>147.36 PL 100 OFFSET +</b><br>34.0007019, -81.03479767,  0 Ft.<br>EM94LA`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4ANK = new L.marker(new L.LatLng(32.77659988,-79.93090057),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R57`}).addTo(fg).bindPopup(`W4ANK<br>W4ANK<br><br>Charleston - Adams Run<br><b style='color:red;'>147.345 PL 123 OFFSET +</b><br>32.77659988, -79.93090057,  0 Ft.<br>FM02AS`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WR4SC = new L.marker(new L.LatLng(33.40499878,-81.83750153),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R58`}).addTo(fg).bindPopup(`WR4SC<br>WR4SC<br><br>Beech Island<br><b style='color:red;'>147.345 PL 91.5 OFFSET +</b><br>33.40499878, -81.83750153,  0 Ft.<br>EM93BJ`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4CAE = new L.marker(new L.LatLng(34.0007019,-81.03479767),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R59`}).addTo(fg).bindPopup(`W4CAE<br>W4CAE<br><br>Columbia<br><b style='color:red;'>147.33 PL 156.7 OFFSET +</b><br>34.0007019, -81.03479767,  0 Ft.<br>EM94LA`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var K4JLA = new L.marker(new L.LatLng(34.88639832,-81.82080078),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R60`}).addTo(fg).bindPopup(`K4JLA<br>K4JLA<br><br>Spartanburg<br><b style='color:red;'>147.315 PL 123 OFFSET +</b><br>34.88639832, -81.82080078,  0 Ft.<br>EM94CV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KK4B = new L.marker(new L.LatLng(33.39550018,-79.95809937),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R61`}).addTo(fg).bindPopup(`KK4B<br>KK4B<br><br>Russellville<br><b style='color:red;'>147.3 PL 162.2 OFFSET +</b><br>33.39550018, -79.95809937,  0 Ft.<br>FM03AJ`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var K2PJ = new L.marker(new L.LatLng(34.08570099,-79.07150269),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R62`}).addTo(fg).bindPopup(`K2PJ<br>K2PJ<br><br>Pleasantview<br><b style='color:red;'>147.285 PL 85.4 OFFSET +</b><br>34.08570099, -79.07150269,  0 Ft.<br>FM04LC`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var N4ADM = new L.marker(new L.LatLng(33.5603981,-81.71959686),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R63`}).addTo(fg).bindPopup(`N4ADM<br>N4ADM<br><br>Aiken<br><b style='color:red;'>147.285 PL 100 OFFSET +</b><br>33.5603981, -81.71959686,  0 Ft.<br>EM93DN`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var N4HRS = new L.marker(new L.LatLng(34.99430084,-81.24199677),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R64`}).addTo(fg).bindPopup(`N4HRS<br>N4HRS<br><br>York<br><b style='color:red;'>147.27 PL 110.9 OFFSET +</b><br>34.99430084, -81.24199677,  0 Ft.<br>EM94JX`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WA4JRJ = new L.marker(new L.LatLng(34.68569946,-82.95320129),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R65`}).addTo(fg).bindPopup(`WA4JRJ<br>WA4JRJ<br><br>Seneca<br><b style='color:red;'>147.27 PL 91.5 OFFSET +</b><br>34.68569946, -82.95320129,  0 Ft.<br>EM84MQ`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4ANK = new L.marker(new L.LatLng(33.14369965,-80.35639954),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R66`}).addTo(fg).bindPopup(`W4ANK<br>W4ANK<br><br>Jedburg<br><b style='color:red;'>147.27 PL 123 OFFSET +</b><br>33.14369965, -80.35639954,  0 Ft.<br>EM93TD`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4RRC = new L.marker(new L.LatLng(33.91289902,-81.52559662),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R67`}).addTo(fg).bindPopup(`W4RRC<br>W4RRC<br><br>Leesville<br><b style='color:red;'>147.255 PL 123 OFFSET +</b><br>33.91289902, -81.52559662,  0 Ft.<br>EM93FV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var K4ILT = new L.marker(new L.LatLng(33.17359924,-80.57389832),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R68`}).addTo(fg).bindPopup(`K4ILT<br>K4ILT<br><br>Saint George<br><b style='color:red;'>147.045 PL 103.5 OFFSET +</b><br>33.17359924, -80.57389832,  0 Ft.<br>EM93RE`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var K4YTZ = new L.marker(new L.LatLng(34.83969879,-81.01860046),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R69`}).addTo(fg).bindPopup(`K4YTZ<br>K4YTZ<br><br>Rock Hill<br><b style='color:red;'>147.03 PL 88.5 OFFSET -</b><br>34.83969879, -81.01860046,  0 Ft.<br>EM94LU`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var N2OBS = new L.marker(new L.LatLng(32.9856987,-80.10980225),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R70`}).addTo(fg).bindPopup(`N2OBS<br>N2OBS<br><br>Ladson<br><b style='color:red;'>146.865 PL 123 OFFSET -</b><br>32.9856987, -80.10980225,  0 Ft.<br>EM92WX`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4ULH = new L.marker(new L.LatLng(34.28020096,-79.74279785),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R71`}).addTo(fg).bindPopup(`W4ULH<br>W4ULH<br><br>Florence - ETV tower<br><b style='color:red;'>146.85 PL 123 OFFSET -</b><br>34.28020096, -79.74279785,  0 Ft.<br>FM04DG`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var K4ILT = new L.marker(new L.LatLng(33.18619919,-80.57939911),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R72`}).addTo(fg).bindPopup(`K4ILT<br>K4ILT<br><br>Saint George<br><b style='color:red;'>146.835 PL 103.5 OFFSET -</b><br>33.18619919, -80.57939911,  0 Ft.<br>EM93RE`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KA4GDW = new L.marker(new L.LatLng(33.35114,-80.68542),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R73`}).addTo(fg).bindPopup(`KA4GDW<br>KA4GDW<br><br>Bowman<br><b style='color:red;'>146.835 PL 179.9 OFFSET -</b><br>33.35114, -80.68542,  0 Ft.<br>EM93PI`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KI4RAX = new L.marker(new L.LatLng(34.20999908,-80.69000244),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R74`}).addTo(fg).bindPopup(`KI4RAX<br>KI4RAX<br><br>Lugoff<br><b style='color:red;'>146.82 PL 91.5 OFFSET -</b><br>34.20999908, -80.69000244,  0 Ft.<br>EM94PF`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4NYK = new L.marker(new L.LatLng(34.94120026,-82.41069794),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R75`}).addTo(fg).bindPopup(`W4NYK<br>W4NYK<br><br>Greenville - Paris Mountain<br><b style='color:red;'>146.82 PL  OFFSET -</b><br>34.94120026, -82.41069794,  0 Ft.<br>EM84TW`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KJ4QLH = new L.marker(new L.LatLng(33.53,-80.82),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R76`}).addTo(fg).bindPopup(`KJ4QLH<br>KJ4QLH<br><br>Orangeburg<br><b style='color:red;'>146.805 PL 156.7 OFFSET -</b><br>33.53, -80.82,  0 Ft.<br>EM93OM`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4GS = new L.marker(new L.LatLng(33.55099869,-79.04139709),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R77`}).addTo(fg).bindPopup(`W4GS<br>W4GS<br><br>Murrells Inlet<br><b style='color:red;'>146.805 PL 85.4 OFFSET -</b><br>33.55099869, -79.04139709,  0 Ft.<br>FM03LN`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var N4AW = new L.marker(new L.LatLng(35.06480026,-82.77739716),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R78`}).addTo(fg).bindPopup(`N4AW<br>N4AW<br><br>Pickens - Sassafrass Mountain<br><b style='color:red;'>146.79 PL  OFFSET -</b><br>35.06480026, -82.77739716,  0 Ft.<br>EM85OB`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WA4USN = new L.marker(new L.LatLng(32.79059982,-79.90809631),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R79`}).addTo(fg).bindPopup(`WA4USN<br>WA4USN<br><br>Charleston - USS Yorktown<br><b style='color:red;'>146.79 PL 123 OFFSET -</b><br>32.79059982, -79.90809631,  0 Ft.<br>FM02BS`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4CAE = new L.marker(new L.LatLng(34.05509949,-80.8321991),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R80`}).addTo(fg).bindPopup(`W4CAE<br>W4CAE<br><br>Fort Jackson<br><b style='color:red;'>146.775 PL 156.7 OFFSET -</b><br>34.05509949, -80.8321991,  0 Ft.<br>EM94OB`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4FTK = new L.marker(new L.LatLng(34.715431,-81.019479),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R81`}).addTo(fg).bindPopup(`W4FTK<br>W4FTK<br><br>Richburg<br><b style='color:red;'>146.76 PL D315 OFFSET -</b><br>34.715431, -81.019479,  0 Ft.<br>EM94LR`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KB4RRC = new L.marker(new L.LatLng(34.24750137,-79.81719971),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R82`}).addTo(fg).bindPopup(`KB4RRC<br>KB4RRC<br><br>Darlington<br><b style='color:red;'>147.255 PL 162.2 OFFSET +</b><br>34.24750137, -79.81719971,  0 Ft.<br>FM04CF`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WR4SC = new L.marker(new L.LatLng(32.92440033,-79.69940186),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R83`}).addTo(fg).bindPopup(`WR4SC<br>WR4SC<br><br>Charleston<br><b style='color:red;'>146.76 PL 123 OFFSET -</b><br>32.92440033, -79.69940186,  0 Ft.<br>FM02DW`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4FTK = new L.marker(new L.LatLng(34.188721,-81.404594),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R84`}).addTo(fg).bindPopup(`W4FTK<br>W4FTK<br><br>Little Mountain<br><b style='color:red;'>146.745 PL D315 OFFSET -</b><br>34.188721, -81.404594,  0 Ft.<br>EM94HE`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KD4HLH = new L.marker(new L.LatLng(34.57160187,-82.11209869),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R85`}).addTo(fg).bindPopup(`KD4HLH<br>KD4HLH<br><br>Laurens<br><b style='color:red;'>146.865 PL 107.2 OFFSET -</b><br>34.57160187, -82.11209869,  0 Ft.<br>EM84WN`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4NYR = new L.marker(new L.LatLng(35.12120056,-81.51589966),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R86`}).addTo(fg).bindPopup(`W4NYR<br>W4NYR<br><br>Blacksburg - Whitaker Mountain<br><b style='color:red;'>146.88 PL  OFFSET -</b><br>35.12120056, -81.51589966,  0 Ft.<br>EM95FC`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KJ4YLP = new L.marker(new L.LatLng(34.88249969,-83.09750366),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R87`}).addTo(fg).bindPopup(`KJ4YLP<br>KJ4YLP<br><br>Mountain Rest - Long Mtn<br><b style='color:red;'>147.03 PL 123 OFFSET -</b><br>34.88249969, -83.09750366,  0 Ft.<br>EM84KV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KK4BQ = new L.marker(new L.LatLng(33.18780136,-81.39689636),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R88`}).addTo(fg).bindPopup(`KK4BQ<br>KK4BQ<br><br>Barnwell<br><b style='color:red;'>147.03 PL 156.7 OFFSET +</b><br>33.18780136, -81.39689636,  0 Ft.<br>EM93HE`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4GL = new L.marker(new L.LatLng(33.8810997,-80.27059937),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R89`}).addTo(fg).bindPopup(`W4GL<br>W4GL<br><br>Sumter<br><b style='color:red;'>147.015 PL 156.7 OFFSET +</b><br>33.8810997, -80.27059937,  0 Ft.<br>EM93UV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WB4YXZ = new L.marker(new L.LatLng(34.90100098,-82.65930176),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R90`}).addTo(fg).bindPopup(`WB4YXZ<br>WB4YXZ<br><br>Pickens - Glassy Mountain<br><b style='color:red;'>147 PL 151.4 OFFSET -</b><br>34.90100098, -82.65930176,  0 Ft.<br>EM84QV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KO4L = new L.marker(new L.LatLng(34.06060028,-79.3125),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R91`}).addTo(fg).bindPopup(`KO4L<br>KO4L<br><br>Marion<br><b style='color:red;'>147 PL 91.5 OFFSET -</b><br>34.06060028, -79.3125,  0 Ft.<br>FM04IB`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W1GRE = new L.marker(new L.LatLng(32.96580124,-80.15750122),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R92`}).addTo(fg).bindPopup(`W1GRE<br>W1GRE<br><br>Summerville - Summerville Med. Center<br><b style='color:red;'>146.985 PL 123 OFFSET -</b><br>32.96580124, -80.15750122,  0 Ft.<br>EM92WX`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KB4RRC = new L.marker(new L.LatLng(34.19910049,-79.76779938),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R93`}).addTo(fg).bindPopup(`KB4RRC<br>KB4RRC<br><br>Florence - City County Complex<br><b style='color:red;'>146.97 PL 167.9 OFFSET -</b><br>34.19910049, -79.76779938,  0 Ft.<br>FM04CE`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var N4AW = new L.marker(new L.LatLng(34.51079941,-82.64679718),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R94`}).addTo(fg).bindPopup(`N4AW<br>N4AW<br><br>Anderson - Anderson Memorial Hospital<br><b style='color:red;'>146.97 PL 127.3 OFFSET -</b><br>34.51079941, -82.64679718,  0 Ft.<br>EM84QM`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WA4USN = new L.marker(new L.LatLng(32.9939003,-80.26999664),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R95`}).addTo(fg).bindPopup(`WA4USN<br>WA4USN<br><br>Knightsville<br><b style='color:red;'>146.94 PL 123 OFFSET -</b><br>32.9939003, -80.26999664,  0 Ft.<br>EM92UX`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4IQQ = new L.marker(new L.LatLng(34.8526001,-82.39399719),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R96`}).addTo(fg).bindPopup(`W4IQQ<br>W4IQQ<br><br>Greenville<br><b style='color:red;'>146.94 PL 107.2 OFFSET -</b><br>34.8526001, -82.39399719,  0 Ft.<br>EM84TU`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4APE = new L.marker(new L.LatLng(34.29270172,-80.33760071),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R97`}).addTo(fg).bindPopup(`W4APE<br>W4APE<br><br>Lucknow<br><b style='color:red;'>146.925 PL 123 OFFSET -</b><br>34.29270172, -80.33760071,  0 Ft.<br>EM94TH`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WA4SJS = new L.marker(new L.LatLng(32.7118988,-80.68170166),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R98`}).addTo(fg).bindPopup(`WA4SJS<br>WA4SJS<br><br>White Hall<br><b style='color:red;'>146.91 PL 156.7 OFFSET -</b><br>32.7118988, -80.68170166,  0 Ft.<br>EM92PR`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4DEW = new L.marker(new L.LatLng(34.00149918,-81.77200317),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R99`}).addTo(fg).bindPopup(`W4DEW<br>W4DEW<br><br>Saluda - water tank<br><b style='color:red;'>146.91 PL 123 OFFSET -</b><br>34.00149918, -81.77200317,  0 Ft.<br>EM94CA`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4APE = new L.marker(new L.LatLng(34.74850082,-80.41680145),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R100`}).addTo(fg).bindPopup(`W4APE<br>W4APE<br><br>Pageland<br><b style='color:red;'>146.895 PL 123 OFFSET -</b><br>34.74850082, -80.41680145,  0 Ft.<br>EM94SR`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WR4SC = new L.marker(new L.LatLng(33.54309845,-80.82420349),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R101`}).addTo(fg).bindPopup(`WR4SC<br>WR4SC<br><br>Orangeburg<br><b style='color:red;'>146.88 PL 123 OFFSET -</b><br>33.54309845, -80.82420349,  0 Ft.<br>EM93ON`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4PDE = new L.marker(new L.LatLng(34.3689003,-79.32839966),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R102`}).addTo(fg).bindPopup(`W4PDE<br>W4PDE<br><br>Dillon - WPDE News 15 Tower<br><b style='color:red;'>146.745 PL 82.5 OFFSET -</b><br>34.3689003, -79.32839966,  0 Ft.<br>FM04II`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var N2ZZ = new L.marker(new L.LatLng(33.57089996,-81.76309967),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R103`}).addTo(fg).bindPopup(`N2ZZ<br>N2ZZ<br><br>Aiken - Aiken Regional Medical Center<br><b style='color:red;'>145.35 PL 156.7 OFFSET -</b><br>33.57089996, -81.76309967,  0 Ft.<br>EM93CN`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KCRJCRAC2 = new L.marker(new L.LatLng(38.9252611,-94.6553389),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R104`}).addTo(fg).bindPopup(`KCRJCRAC2<br>Kansas City Room, W0ERH<br>443.725+MHz
<br>Black & Veatch, KS<br><b style='color:red;'>JCRAC club repeater</b><br>38.9252611, -94.6553389,  0 Ft.<br>EM28QW`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KCRJCRAC1 = new L.marker(new L.LatLng(39.0106639,-94.7212972),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R105`}).addTo(fg).bindPopup(`KCRJCRAC1<br>Kansas City Room, W0ERH<br>442.600+MHz
<br>Shawnee, KS<br><b style='color:red;'>JCRAC club repeater</b><br>39.0106639, -94.7212972,  0 Ft.<br>EM29PA`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KCRKW1 = new L.marker(new L.LatLng(38.9879167,-94.67075),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R106`}).addTo(fg).bindPopup(`KCRKW1<br>Kansas City Room, K0HAM<br>146.910-MHz



<br>Overland Park, KS<br><b style='color:red;'>Jerry Dixon KCØKW</b><br>38.9879167, -94.67075,  0 Ft.<br>EM28PX`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KCRHCV = new L.marker(new L.LatLng(38.8648222,-94.7789944),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R107`}).addTo(fg).bindPopup(`KCRHCV<br>Kansas City Room Host, #28952<br>444.400MHz
<br>Olathe, KS<br><b style='color:red;'>Hosts the Kansas City Room #28952</b><br>38.8648222, -94.7789944,  0 Ft.<br>EM28OU`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var SAXRPTR = new L.marker(new L.LatLng(39.3641,-93.48071),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R108`}).addTo(fg).bindPopup(`SAXRPTR<br>N0SAX<br>710 Harvest Hills Dr<br>Carroll, MO 64633<br><b style='color:red;'></b><br>39.3641, -93.48071,  0 Ft.<br>EM39GI`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WA0KHP = new L.marker(new L.LatLng(39.36392,-94.584721),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R109`}).addTo(fg).bindPopup(`WA0KHP<br>Clay Co Repeater Club / KC Northland ARES Repeater (146.79Mhz T:107.2 )<br>146.79Mhz T:107.2<br>Kansas City, MO<br><b style='color:red;'>Clay Co. Repeater Club</b><br>39.36392, -94.584721,  0 Ft.<br>EM29QI`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WA0QFJ = new L.marker(new L.LatLng(39.273172,-94.663137),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R110`}).addTo(fg).bindPopup(`WA0QFJ<br>PCARG Repeater (147.330MHz T:151.4/444.550MHz )<br>147.330MHz T:151.4/444.550MHz<br>Kansas City, MO<br><b style='color:red;'>PCARG club repeater</b><br>39.273172, -94.663137,  0 Ft.<br>EM29QG`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var PRATT241 = new L.marker(new L.LatLng(40.1274,-123.69148),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R111`}).addTo(fg).bindPopup(`PRATT241<br>Pratt Mt.<br><br><br><b style='color:red;'>"Sheriff, PG&E, Med Net, Fire Net, Caltrans, HCOE, FWRA (146.610 MHz NEG PL 103.5), Backup: Generato</b><br>40.1274, -123.69148,  0 Ft.<br>CN80DD`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var SC242 = new L.marker(new L.LatLng(0,0),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R112`}).addTo(fg).bindPopup(`SC242<br>Shelter Cove<br><br><br><b style='color:red;'>"Sheriff"</b><br>0, 0,  0 Ft.<br>JJ00AA`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var MP243 = new L.marker(new L.LatLng(40.41852,-124.12059),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R113`}).addTo(fg).bindPopup(`MP243<br>Mount Pierce<br><br><br><b style='color:red;'>"Sheriff, Arcata Fire/Ambulance, HCOE, FWRA (146.760 MHz NEG PL 103.5), Backup: Off-Site Generator"</b><br>40.41852, -124.12059,  0 Ft.<br>CN70WK`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KG4BZN = new L.marker(new L.LatLng(32.90520096,-80.66680145),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R114`}).addTo(fg).bindPopup(`KG4BZN<br>KG4BZN<br><br>Walterboro<br><b style='color:red;'>147.135 PL  OFFSET +</b><br>32.90520096, -80.66680145,  0 Ft.<br>EM92PV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KCRKW2 = new L.marker(new L.LatLng(38.5861611,-94.6204139),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R115`}).addTo(fg).bindPopup(`KCRKW2<br>Kansas City Room, K0HAM<br>145.410-MHz
<br>Louisburg, KS<br><b style='color:red;'>Jerry Dixon KCØKW</b><br>38.5861611, -94.6204139,  0 Ft.<br>EM28QO`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KCRWW = new L.marker(new L.LatLng(39.0465806,-94.5874444),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R116`}).addTo(fg).bindPopup(`KCRWW<br>Kansas City Room, N0WW<br>The Plaza 443.275+MHz
<br>Kansas City, MO<br><b style='color:red;'>Keith Little NØWW</b><br>39.0465806, -94.5874444,  0 Ft.<br>EM29QB`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var ACT = new L.marker(new L.LatLng(38.896175,-95.174838),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R117`}).addTo(fg).bindPopup(`ACT<br>Douglas County Emergency Management<br><br>"Lawrence, KS"<br><b style='color:red;'>147.03+ 88.5 Narrow band 2.5KHz UFN</b><br>38.896175, -95.174838,  0 Ft.<br>EM28JV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var DCARC = new L.marker(new L.LatLng(38.896175,-95.174838),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R118`}).addTo(fg).bindPopup(`DCARC<br>Douglas County Amateur Radio Club<br><br>"Lawrence, KS"<br><b style='color:red;'>146.76- 88.5 Narrow band 2.5KHz UFN</b><br>38.896175, -95.174838,  0 Ft.<br>EM28JV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KCRCNC = new L.marker(new L.LatLng(38.1788722,-93.3541889),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R119`}).addTo(fg).bindPopup(`KCRCNC<br>Kansas City Room, KD0CNC<br>Warsaw Missouri 147300MHz
<br>Warsaw, MO<br><b style='color:red;'>KD0CNC</b><br>38.1788722, -93.3541889,  0 Ft.<br>EM38HE`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KCRHAM4 = new L.marker(new L.LatLng(39.2611111,-95.6558333),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R120`}).addTo(fg).bindPopup(`KCRHAM4<br>Kansas City Room, K0HAM<br>Hoyt Kansas 444.725MHz
<br>Hoyt, KS<br><b style='color:red;'>Jerry Dixon KCØKW</b><br>39.2611111, -95.6558333,  0 Ft.<br>EM29EG`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KCRMED = new L.marker(new L.LatLng(39.0562778,-94.6095),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R121`}).addTo(fg).bindPopup(`KCRMED<br>Kansas City Room, Ku0MED<br>KU Medical Center 442.325+MHz
<br>Kansas City, KS<br><b style='color:red;'>Jerry Dixon KCØKW</b><br>39.0562778, -94.6095,  0 Ft.<br>EM29QB`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KCRQFJ = new L.marker(new L.LatLng(39.2731222,-94.6629583),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R122`}).addTo(fg).bindPopup(`KCRQFJ<br>Kansas City Room, WA0QFJ<br>Tiffany Springs 444.550+MHz
<br>Kansas City, MO<br><b style='color:red;'>PCARG Club Repeater</b><br>39.2731222, -94.6629583,  0 Ft.<br>EM29QG`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KCRHAM3 = new L.marker(new L.LatLng(39.0922333,-94.9453528),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R123`}).addTo(fg).bindPopup(`KCRHAM3<br>Kansas City Room, K0HAM<br>Basehor 145.390-MHz
<br>Basehor, KS<br><b style='color:red;'>Jerry Dixon KCØKW</b><br>39.0922333, -94.9453528,  0 Ft.<br>EM29MC`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KCRHAM2 = new L.marker(new L.LatLng(38.9084722,-94.4548056),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R124`}).addTo(fg).bindPopup(`KCRHAM2<br>Kansas City Room, K0HAM<br>Longview MCC 147.315+MHz
<br>Lee's Summit, MO<br><b style='color:red;'>Jerry Dixon KCØKW</b><br>38.9084722, -94.4548056,  0 Ft.<br>EM28SV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KCRROO = new L.marker(new L.LatLng(39.2819722,-94.9058889),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R125`}).addTo(fg).bindPopup(`KCRROO<br>Kansas City Room, W0ROO<br>Leavenworth 444.800+MHz
<br>Leavenworth, KS<br><b style='color:red;'>Leavenworth club repeater</b><br>39.2819722, -94.9058889,  0 Ft.<br>EM29NG`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var HH244 = new L.marker(new L.LatLng(40.72496,-124.19386),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R126`}).addTo(fg).bindPopup(`HH244<br>Humboldt Hill<br><br><br><b style='color:red;'>"FWRA (146.700 MHz NEG PL 103.5)"</b><br>40.72496, -124.19386,  0 Ft.<br>CN70VR`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var HCCH245 = new L.marker(new L.LatLng(40.803,-124.16221),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R127`}).addTo(fg).bindPopup(`HCCH245<br>Humboldt County Court House<br>"826 4th St"<br>"Eureka, CA 95501"<br><b style='color:red;'>"Sheriff, Public Works, PG&E, OES"</b><br>40.803, -124.16221,  0 Ft.<br>CN70WT`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var HORSE246 = new L.marker(new L.LatLng(40.87531,-123.7327),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R128`}).addTo(fg).bindPopup(`HORSE246<br>Horse Mt.<br><br><br><b style='color:red;'>"Sheriff, PG&E, Fire Net, FWRA (147.0000 MHz POS PL 103.5, 442.0000 MHz POS PL 100.0), Backup: Gener</b><br>40.87531, -123.7327,  0 Ft.<br>CN80DV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KM4ABW = new L.marker(new L.LatLng(33.68700027,-80.21170044),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R129`}).addTo(fg).bindPopup(`KM4ABW<br>KM4ABW<br><br>Manning - On top of the hospital. <br><b style='color:red;'>145.15 PL 91.5 OFFSET -</b><br>33.68700027, -80.21170044,  0 Ft.<br>EM93VQ`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4TWX = new L.marker(new L.LatLng(34.88339996,-82.70739746),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R130`}).addTo(fg).bindPopup(`W4TWX<br>W4TWX<br><br>Six Mile - Six Mile Mountian<br><b style='color:red;'>145.17 PL 162.2 OFFSET -</b><br>34.88339996, -82.70739746,  0 Ft.<br>EM84PV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var K4LMD = new L.marker(new L.LatLng(33.203402,-80.799942),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R131`}).addTo(fg).bindPopup(`K4LMD<br>K4LMD<br><br>Branchville - Wire Road<br><b style='color:red;'>145.21 PL 100 OFFSET -</b><br>33.203402, -80.799942,  0 Ft.<br>EM93OE`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4APE = new L.marker(new L.LatLng(33.58100128,-79.98899841),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R132`}).addTo(fg).bindPopup(`W4APE<br>W4APE<br><br>Greeleyville<br><b style='color:red;'>145.23 PL 123 OFFSET -</b><br>33.58100128, -79.98899841,  0 Ft.<br>FM03AN`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var K4WD = new L.marker(new L.LatLng(34.88100052,-83.09889984),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R133`}).addTo(fg).bindPopup(`K4WD<br>K4WD<br><br>Walhalla - Long Mountain<br><b style='color:red;'>145.29 PL 162.2 OFFSET -</b><br>34.88100052, -83.09889984,  0 Ft.<br>EM84KV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4CHR = new L.marker(new L.LatLng(34.68790054,-81.17980194),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R134`}).addTo(fg).bindPopup(`W4CHR<br>W4CHR<br><br>Chester - Near Chester County Hospital<br><b style='color:red;'>145.31 PL 167.9 OFFSET -</b><br>34.68790054, -81.17980194,  0 Ft.<br>EM94JQ`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var NE4SC = new L.marker(new L.LatLng(33.75859833,-79.72820282),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R135`}).addTo(fg).bindPopup(`NE4SC<br>NE4SC<br><br>Kingstree<br><b style='color:red;'>145.31 PL 123 OFFSET -</b><br>33.75859833, -79.72820282,  0 Ft.<br>FM03DS`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4BFT = new L.marker(new L.LatLng(32.39139938,-80.74849701),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R136`}).addTo(fg).bindPopup(`W4BFT<br>W4BFT<br><br>Beaufort<br><b style='color:red;'>145.13 PL 88.5 OFFSET -</b><br>32.39139938, -80.74849701,  0 Ft.<br>EM92PJ`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4IAR = new L.marker(new L.LatLng(32.21630096,-80.75260162),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R137`}).addTo(fg).bindPopup(`W4IAR<br>W4IAR<br><br>Hilton Head Island<br><b style='color:red;'>145.31 PL 100 OFFSET -</b><br>32.21630096, -80.75260162,  0 Ft.<br>EM92OF`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4DV = new L.marker(new L.LatLng(33.4734993,-82.01049805),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R138`}).addTo(fg).bindPopup(`W4DV<br>W4DV<br><br>North Augusta<br><b style='color:red;'>145.11 PL 71.9 OFFSET -</b><br>33.4734993, -82.01049805,  0 Ft.<br>EM83XL`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W7JCR268 = new L.marker(new L.LatLng(48.124567,-122.76529),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R139`}).addTo(fg).bindPopup(`W7JCR268<br>W7JCR<br>END OF REED ST<br>PORT TOWNSEND<br><b style='color:red;'>145.15- 114.8</b><br>48.124567, -122.76529,  0 Ft.<br>CN88OC`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var ROGERS248 = new L.marker(new L.LatLng(41.16941,-124.02483),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R140`}).addTo(fg).bindPopup(`ROGERS248<br>Rogers Peak<br><br><br><b style='color:red;'>"Sheriff"</b><br>41.16941, -124.02483,  0 Ft.<br>CN71XE`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var RAINBOW249 = new L.marker(new L.LatLng(40.372,-124.12568),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R141`}).addTo(fg).bindPopup(`RAINBOW249<br>Rainbow Ridge<br><br><br><b style='color:red;'>"HARC (146.910 MHz NEG PL 103.5)"</b><br>40.372, -124.12568,  0 Ft.<br>CN70WI`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var WB4TGK = new L.marker(new L.LatLng(33.29710007,-81.03479767),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R142`}).addTo(fg).bindPopup(`WB4TGK<br>WB4TGK<br><br>Bamberg<br><b style='color:red;'>145.33 PL 156.7 OFFSET -</b><br>33.29710007, -81.03479767,  0 Ft.<br>EM93LH`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var KT4TF = new L.marker(new L.LatLng(34.99580002,-80.85500336),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R143`}).addTo(fg).bindPopup(`KT4TF<br>KT4TF<br><br>Fort Mill<br><b style='color:red;'>145.11 PL 110.9 OFFSET -</b><br>34.99580002, -80.85500336,  0 Ft.<br>EM94NX`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var W4GS = new L.marker(new L.LatLng(33.9137001,-79.04519653),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R144`}).addTo(fg).bindPopup(`W4GS<br>W4GS<br><br>Conway<br><b style='color:red;'>145.11 PL 85.4 OFFSET -</b><br>33.9137001, -79.04519653,  0 Ft.<br>FM03LV`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var AA7MI270 = new L.marker(new L.LatLng(48.116172,-122.764327),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R145`}).addTo(fg).bindPopup(`AA7MI270<br>AA7MI<br>701 HARRISON<br>PORT TOWNSEND<br><b style='color:red;'>443.825+ CC1</b><br>48.116172, -122.764327,  0 Ft.<br>CN88OC`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var AA7MI269 = new L.marker(new L.LatLng(48.040336,-122.687109),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R146`}).addTo(fg).bindPopup(`AA7MI269<br>AA7MI<br>6456 FLAGLER<br>NORDLAND<br><b style='color:red;'>440.725+ 114.8</b><br>48.040336, -122.687109,  0 Ft.<br>CN88PA`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var SPM247 = new L.marker(new L.LatLng(41.03856,-123.74792),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R147`}).addTo(fg).bindPopup(`SPM247<br>Sugar Pine Mountain<br><br><br><b style='color:red;'>"Sheriff, Backup: Solar, Generator"</b><br>41.03856, -123.74792,  0 Ft.<br>CN81DA`).openPopup();                        
 
                        $(`repeater`._icon).addClass(`rptmrkr`);
            var FPD93721 = new L.marker(new L.LatLng(36.737611,-119.78787),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P14`}).addTo(fg).bindPopup(`FPD93721<br>Fresno Police Department<br>2323 Mariposa St #2075<br>Fresno, CA 93721<br><b style='color:red;'></b><br>36.737611, -119.78787,  0 Ft.<br>DM06CR`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var JCSHRFF267 = new L.marker(new L.LatLng(48.024051,-122.763807),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P15`}).addTo(fg).bindPopup(`JCSHRFF267<br>JC SHERIFF<br>81 ELKINS<br>PORT HADLOCK<br><b style='color:red;'></b><br>48.024051, -122.763807,  0 Ft.<br>CN88OA`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var PKVLPD = new L.marker(new L.LatLng(39.207055,-94.683832),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P16`}).addTo(fg).bindPopup(`PKVLPD<br>Parkville Police Department<br> 8880 Clark Ave<br>	   Parkville MO 64152<br><b style='color:red;'></b><br>39.207055, -94.683832,  0 Ft.<br>EM29PE`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var HCSDGS226 = new L.marker(new L.LatLng(40.10251,-123.79386),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P17`}).addTo(fg).bindPopup(`HCSDGS226<br>Humboldt County Sheriff's Department-Garberville Station<br>"648 Locust St"<br>"Garberville, CA 95542"<br><b style='color:red;'></b><br>40.10251, -123.79386,  0 Ft.<br>CN80CC`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var CCSHERIFF = new L.marker(new L.LatLng(39.245231,-94.41976),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P18`}).addTo(fg).bindPopup(`CCSHERIFF<br>Clay County Sheriff<br><br>Liberty, MO<br><b style='color:red;'></b><br>39.245231, -94.41976,  0 Ft.<br>EM29SF`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var COMOPD = new L.marker(new L.LatLng(39.197769,-94.5038),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P19`}).addTo(fg).bindPopup(`COMOPD<br>Claycomo Police Department<br>   115 US-69<br>		   Claycomo MO 64119<br><b style='color:red;'></b><br>39.197769, -94.5038,  0 Ft.<br>EM29RE`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var PLTCTYPD = new L.marker(new L.LatLng(39.370039,-94.77987),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P20`}).addTo(fg).bindPopup(`PLTCTYPD<br>Platte City Police Department<br>355 Main St<br>Platte City, MO 64079<br><b style='color:red;'></b><br>39.370039, -94.77987,  0 Ft.<br>EM29OI`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var NKCPD = new L.marker(new L.LatLng(39.143363,-94.573404),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P21`}).addTo(fg).bindPopup(`NKCPD<br>North Kansas City Police Department<br>   2020 Howell St<br>	   North Kansas City MO 64116<br><b style='color:red;'></b><br>39.143363, -94.573404,  0 Ft.<br>EM29RD`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var GSTNPD = new L.marker(new L.LatLng(39.221477,-94.57198),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P22`}).addTo(fg).bindPopup(`GSTNPD<br>Gladstone Police Department<br>	7010 N Holmes St<br>	   Gladstone MO 64118<br><b style='color:red;'></b><br>39.221477, -94.57198,  0 Ft.<br>EM29RF`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var Sheriff398 = new L.marker(new L.LatLng(34.226835,-80.680747),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P23`}).addTo(fg).bindPopup(`Sheriff398<br><br><br>Lugoff<br><b style='color:red;'></b><br>34.226835, -80.680747,  0 Ft.<br>EM94PF`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var RVRSPD = new L.marker(new L.LatLng(39.175239,-94.616458),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P24`}).addTo(fg).bindPopup(`RVRSPD<br>Riverside City Police Department<br> 2990 NW Vivion Rd<br>	   Riverside MO 64150<br><b style='color:red;'></b><br>39.175239, -94.616458,  0 Ft.<br>EM29QE`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var Sheriff401 = new L.marker(new L.LatLng(34.244964,-80.602518),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P25`}).addTo(fg).bindPopup(`Sheriff401<br><br><br>Camden<br><b style='color:red;'>Kershaw County Fire / Sheriff</b><br>34.244964, -80.602518,  0 Ft.<br>EM94QF`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var LKWKPD = new L.marker(new L.LatLng(39.227468,-94.634039),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P26`}).addTo(fg).bindPopup(`LKWKPD<br>Lake Waukomis Police Department<br> 1147 NW South Shore Dr<br>  Lake Waukomis MO 64151<br><b style='color:red;'></b><br>39.227468, -94.634039,  0 Ft.<br>EM29QF`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var HCSO224 = new L.marker(new L.LatLng(40.803,-124.16221),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P27`}).addTo(fg).bindPopup(`HCSO224<br>Humboldt County Sheriff's Office<br>"826 4th St"<br>"Eureka, CA 95501"<br><b style='color:red;'>"County Jail, Sheriff Main Office, Office of Emergency Services, County CERT Mgt."</b><br>40.803, -124.16221,  0 Ft.<br>CN70WT`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var HCSOMS225 = new L.marker(new L.LatLng(40.94431,-124.09901),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P28`}).addTo(fg).bindPopup(`HCSOMS225<br>Humboldt County Sheriff's Office-McKinleyville Station<br>"1608 Pickett Rd"<br>"McKinleyville, CA 95519"<br><b style='color:red;'></b><br>40.94431, -124.09901,  0 Ft.<br>CN70WW`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var NRTPD = new L.marker(new L.LatLng(39.183487,-94.605311),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P29`}).addTo(fg).bindPopup(`NRTPD<br>Northmoor Police Department<br> 2039 NW 49th Terrace<br>    Northmoor MO 64151<br><b style='color:red;'></b><br>39.183487, -94.605311,  0 Ft.<br>EM29QE`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var KCNPPD = new L.marker(new L.LatLng(39.291975,-94.684958),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P30`}).addTo(fg).bindPopup(`KCNPPD<br>Kansas City Police North Patrol<br> 11000 NW Prairie View Rd<br>Kansas City MO 64153<br><b style='color:red;'></b><br>39.291975, -94.684958,  0 Ft.<br>EM29PH`).openPopup();                        
 
                        $(`sheriff`._icon).addClass(`polmrkr`);
            var CTEAUELV = new L.marker(new L.LatLng(39.150823,-94.523884),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S1`}).addTo(fg).bindPopup(`CTEAUELV<br>KK2 - Chouteau Elevator<br>4801 NE Birmingham Rd<br>Kansas City, MO 64117<br><b style='color:red;'>HT Compatible w/static</b><br>39.150823, -94.523884,  0 Ft.<br>EM29RD`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var C2 = new L.marker(new L.LatLng(39.309645,-94.584606),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S2`}).addTo(fg).bindPopup(`C2<br>C2 - Overpass, 169 & 435<br><br><br><b style='color:red;'></b><br>39.309645, -94.584606,  0 Ft.<br>EM29QH`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var TANEY210 = new L.marker(new L.LatLng(39.144788,-94.558242),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S3`}).addTo(fg).bindPopup(`TANEY210<br>KK1 - Taney Ave on 210 Highway<br>Taney Ave on 210 Highway<br>North Kansas City, MO<br><b style='color:red;'>HT Compatable</b><br>39.144788, -94.558242,  0 Ft.<br>EM29RD`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var HWY291on210 = new L.marker(new L.LatLng(39.18423,-94.396235),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S4`}).addTo(fg).bindPopup(`HWY291on210<br>KK3 - Highway 210 @ Highway 291<br><br>Kansas City, MO 64117<br><b style='color:red;'>HT Compatible w/static</b><br>39.18423, -94.396235,  0 Ft.<br>EM29TE`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var Non291Hwy = new L.marker(new L.LatLng(39.236328,-94.221919),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S5`}).addTo(fg).bindPopup(`Non291Hwy<br>KK4 - Supplemental Route N on Hwy 291<br>///forefinger.hiding.butlers<br>Orrick, MO 64077<br><b style='color:red;'>HT Not compatible at this location</b><br>39.236328, -94.221919,  0 Ft.<br>EM29VF`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var C11 = new L.marker(new L.LatLng(39.179323,-94.509957),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S6`}).addTo(fg).bindPopup(`C11<br>C11 - Winnetonka High School<br>5815 NE 48th St,<br>Kansas City, MO 64119<br><b style='color:red;'></b><br>39.179323, -94.509957,  0 Ft.<br>EM29RE`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var LecRestStop = new L.marker(new L.LatLng(38.994852,-95.399612),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S7`}).addTo(fg).bindPopup(`LecRestStop<br>Lecompton Rest Stop<br>"E 550 Rd. / CR 1029 & Hwy 40"<br>"Lawrence, KS"<br><b style='color:red;'>Lecompton Rest Stop </b><br>38.994852, -95.399612,  0 Ft.<br>EM28HX`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var BROADWAY = new L.marker(new L.LatLng(39.34261,-94.22378),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S8`}).addTo(fg).bindPopup(`BROADWAY<br>KK7 - Down Town<br>100 W Broadway St<br>Excelsior Springs, MO<br><b style='color:red;'>No Known Repeater Available</b><br>39.34261, -94.22378,  774 Ft.<br>EM29VI`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var P4 = new L.marker(new L.LatLng(39.387704,-94.880363),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S9`}).addTo(fg).bindPopup(`P4<br>P4-West Bend State Park, Scenic Overlook<br>State Park, Weston Bend<br>Weston, MO<br><b style='color:red;'></b><br>39.387704, -94.880363,  0 Ft.<br>EM29NJ`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var SUNNYSIDE = new L.marker(new L.LatLng(39.34506,-94.22949),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S10`}).addTo(fg).bindPopup(`SUNNYSIDE<br>KK8 - Sunnyside Park<br>Sunnyside Park<br>Excelsior Springs, MO<br><b style='color:red;'>HT Not compatible at this location</b><br>39.34506, -94.22949,  892 Ft.<br>EM29VI`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var WATKINSMILL = new L.marker(new L.LatLng(39.4022,-94.26212),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S11`}).addTo(fg).bindPopup(`WATKINSMILL<br>KK9 - Watkins Mill State Park Beach<br>17016 Endsley Rd<br>Lawson, MO<br><b style='color:red;'>HT Not compatible at this location</b><br>39.4022, -94.26212,  932 Ft.<br>EM29UJ`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var P2 = new L.marker(new L.LatLng(39.457844,-94.970231),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S12`}).addTo(fg).bindPopup(`P2<br>P2-Iatan Power Plant<br>20250 MO 45 Hwy<br>Weston, MO<br><b style='color:red;'></b><br>39.457844, -94.970231,  0 Ft.<br>EM29MK`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var SWSKOL = new L.marker(new L.LatLng(39.433538,-94.207032),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S13`}).addTo(fg).bindPopup(`SWSKOL<br>KK6 -Southwest Elementary School<br>///rekindle.jacket.spaceships <br> 307 W Moss St.<br>Lawson, MO<br><b style='color:red;'>HT Not compatible at this location</b><br>39.433538, -94.207032,  0 Ft.<br>EM29VK`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var C12 = new L.marker(new L.LatLng(39.173509,-94.46439),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S14`}).addTo(fg).bindPopup(`C12<br>C12 - NE Parvin and N Arlington Ave<br>NE Parvin and N Doniphan Ave (Near Worlds/Oceans of Fun)<br>Kansas City, MO<br><b style='color:red;'></b><br>39.173509, -94.46439,  0 Ft.<br>EM29SE`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var P12 = new L.marker(new L.LatLng(39.174753,-94.624798),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S15`}).addTo(fg).bindPopup(`P12<br>P12 - Park Hill South High School, SE Parking Lot<br>4500 NW Riverpark Drive<br>Riverside, MO 64150 <br><b style='color:red;'></b><br>39.174753, -94.624798,  0 Ft.<br>EM29QE`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var P11 = new L.marker(new L.LatLng(39.188631,-94.679035),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S16`}).addTo(fg).bindPopup(`P11<br>P11 - Park University<br>8700 NW River Park Dr<br>Parkville, MO 64152<br><b style='color:red;'></b><br>39.188631, -94.679035,  0 Ft.<br>EM29PE`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var P10 = new L.marker(new L.LatLng(39.225043,-94.762684),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S17`}).addTo(fg).bindPopup(`P10<br>P10 - I-435 & 45 Hwy<br>Exit 22 on I-435<br>Kansas City, MO 64154<br><b style='color:red;'></b><br>39.225043, -94.762684,  0 Ft.<br>EM29OF`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var P9 = new L.marker(new L.LatLng(39.245307,-94.758275),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S18`}).addTo(fg).bindPopup(`P9<br>P9 - 152 Hwy at NW I-435<br>Exit 24 on I-435<br>Kansas City, MO 64154<br><b style='color:red;'></b><br>39.245307, -94.758275,  0 Ft.<br>EM29OF`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var P8 = new L.marker(new L.LatLng(39.279242,-94.606069),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S19`}).addTo(fg).bindPopup(`P8<br>P8 - Platte Purchase Park<br>N Platte Purchase Dr & NW 100 St<br>Kansas City, MO 64154<br><b style='color:red;'></b><br>39.279242, -94.606069,  0 Ft.<br>EM29QG`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var P7 = new L.marker(new L.LatLng(39.307052,-94.602296),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S20`}).addTo(fg).bindPopup(`P7<br>P7 - Overpass, Cookingham Dr./291 & 435<br>Cookingham Drive/291 crossing over 435<br>Kansas City, MO<br><b style='color:red;'></b><br>39.307052, -94.602296,  0 Ft.<br>EM29QH`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var P6 = new L.marker(new L.LatLng(39.354489,-94.766264),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S21`}).addTo(fg).bindPopup(`P6<br>P6 - I-435 & NW 120th Street<br><br><br><b style='color:red;'></b><br>39.354489, -94.766264,  0 Ft.<br>EM29OI`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var P5 = new L.marker(new L.LatLng(39.354489,-94.766264),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S22`}).addTo(fg).bindPopup(`P5<br>P5 - QuikTrip, I-29 and 92 Hwy (Platte City)<br>QuikTrip 1850 Branch Street<br>Platte City, MO 64079<br><b style='color:red;'></b><br>39.354489, -94.766264,  0 Ft.<br>EM29OI`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var P3 = new L.marker(new L.LatLng(39.451409,-94.787076),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S23`}).addTo(fg).bindPopup(`P3<br>P3-Camden Point (I-29 & E Hwy)<br>17805 NW Co Rd E<br>Camden Point, MO<br><b style='color:red;'></b><br>39.451409, -94.787076,  0 Ft.<br>EM29OK`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var P1 = new L.marker(new L.LatLng(39.51854,-94.784505),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S24`}).addTo(fg).bindPopup(`P1<br>P1-Dearborn (I-29 & Z Hwy)<br>17605 Co Hwy Z<br>Dearborn, MO<br><b style='color:red;'></b><br>39.51854, -94.784505,  0 Ft.<br>EM29OM`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var XSPRINGS = new L.marker(new L.LatLng(39.339163,-94.223569),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S25`}).addTo(fg).bindPopup(`XSPRINGS<br>KK5 - Excelsior Springs<br>///rally.logic.jokes<br>Excelsior Springs, MO<br><b style='color:red;'>HT Not compatible at this location</b><br>39.339163, -94.223569,  0 Ft.<br>EM29VI`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var P13 = new L.marker(new L.LatLng(39.170833,-94.608147),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S26`}).addTo(fg).bindPopup(`P13<br>P13 - The Palisades Subdivision-Riverside<br>4300 NW Riverview Drive<br>Riverside, MO 64150 <br><b style='color:red;'></b><br>39.170833, -94.608147,  0 Ft.<br>EM29QE`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var C1 = new L.marker(new L.LatLng(39.325553,-94.583868),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S27`}).addTo(fg).bindPopup(`C1<br>C1 - 169 & 128th Street<br><br><br><b style='color:red;'></b><br>39.325553, -94.583868,  0 Ft.<br>EM29QH`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var C10 = new L.marker(new L.LatLng(39.196726,-94.599145),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S28`}).addTo(fg).bindPopup(`C10<br>C10 - West Englewood Elementary School<br>1506 NW Englewood Rd<br>Kansas City, MO 64118<br><b style='color:red;'></b><br>39.196726, -94.599145,  0 Ft.<br>EM29QE`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var C9 = new L.marker(new L.LatLng(39.224454,-94.499699),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S29`}).addTo(fg).bindPopup(`C9<br>C9 - Overpass, NE Shoal Creek Pkwy & 435<br>Near the Mormon Church<br><br><b style='color:red;'></b><br>39.224454, -94.499699,  0 Ft.<br>EM29SF`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var C8 = new L.marker(new L.LatLng(39.257306,-94.448994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S30`}).addTo(fg).bindPopup(`C8<br>C8 - 219 Highway, .25 mile south of 291 crossing I-35 in Liberty<br>1005 MO-291<br>Liberty, MO 64068<br><b style='color:red;'></b><br>39.257306, -94.448994,  0 Ft.<br>EM29SG`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var C7 = new L.marker(new L.LatLng(39.266411,-94.450781),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S31`}).addTo(fg).bindPopup(`C7<br>C7 - Pleasant Valley Baptist Church<br>1600 MO-291<br>Liberty, MO 64068<br><b style='color:red;'></b><br>39.266411, -94.450781,  0 Ft.<br>EM29SG`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var C6 = new L.marker(new L.LatLng(39.273379,-94.583606),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S32`}).addTo(fg).bindPopup(`C6<br>C6 - Northland Cathedral<br>101 NW 99th St<br>Kansas City, MO 64155<br><b style='color:red;'></b><br>39.273379, -94.583606,  0 Ft.<br>EM29QG`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var NWS240 = new L.marker(new L.LatLng(40.81001,-124.15964),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S33`}).addTo(fg).bindPopup(`NWS240<br>National Weather Service<br>"300 Startare Dr"<br>"Eureka, CA 95501"<br><b style='color:red;'>"Amatuer Radio Station"</b><br>40.81001, -124.15964,  0 Ft.<br>CN70WT`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var C5 = new L.marker(new L.LatLng(39.293429,-94.556897),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S34`}).addTo(fg).bindPopup(`C5<br>C5 - N. Woodland Dr. & Shoal Creek Pkwy<br>Anne Garney Park Dr<br>Kansas City, MO 64155<br><b style='color:red;'></b><br>39.293429, -94.556897,  0 Ft.<br>EM29RH`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var C4 = new L.marker(new L.LatLng(39.331046,-94.263284),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S35`}).addTo(fg).bindPopup(`C4<br>C4 - McCleary Road & 69 Highway<br>2203 Patsy Ln<br>Excelsior Springs, MO 64024<br><b style='color:red;'></b><br>39.331046, -94.263284,  0 Ft.<br>EM29UH`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var C3 = new L.marker(new L.LatLng(39.324398,-94.395751),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S36`}).addTo(fg).bindPopup(`C3<br>C3 - Overpass, 128th St. & I35<br>128th crossing over N/S i35<br><br><b style='color:red;'></b><br>39.324398, -94.395751,  0 Ft.<br>EM29TH`).openPopup();                        
 
                        $(`skywarn`._icon).addClass(`skymrkr`);
            var CALTRNS238 = new L.marker(new L.LatLng(40.79191,-124.17572),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/gov.png`, iconSize: [32, 34]}),
                        title:`marker_G5`}).addTo(fg).bindPopup(`CALTRNS238<br>Caltrans<br>"1656 Union St"<br>"Eureka, CA 95501"<br><b style='color:red;'></b><br>40.79191, -124.17572,  0 Ft.<br>CN70VT`).openPopup();                        
 
                        $(`state`._icon).addClass(`govmrkr`);
            var RGSP221 = new L.marker(new L.LatLng(40.01975,-123.79269),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/gov.png`, iconSize: [32, 34]}),
                        title:`marker_G6`}).addTo(fg).bindPopup(`RGSP221<br>Richardson Grove State Park<br>"1600 US-101"<br>"Garberville, CA 95542"<br><b style='color:red;'></b><br>40.01975, -123.79269,  0 Ft.<br>CN80CA`).openPopup();                        
 
                        $(`state`._icon).addClass(`govmrkr`);
            var CFTFS216 = new L.marker(new L.LatLng(40.05676,-123.9616),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/gov.png`, iconSize: [32, 34]}),
                        title:`marker_G7`}).addTo(fg).bindPopup(`CFTFS216<br>Cal Fire Thorn Fire Station<br>"13298 Briceland Rd"<br>"Whitethorn, CA 95589"<br><b style='color:red;'></b><br>40.05676, -123.9616,  0 Ft.<br>CN80AB`).openPopup();                        
 
                        $(`state`._icon).addClass(`govmrkr`);
            var CFWS211 = new L.marker(new L.LatLng(40.32164,-123.92413),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/gov.png`, iconSize: [32, 34]}),
                        title:`marker_G8`}).addTo(fg).bindPopup(`CFWS211<br>Cal Fire Weott Station<br>"370 Newton Rd"<br>"Weott, CA 95571"<br><b style='color:red;'></b><br>40.32164, -123.92413,  0 Ft.<br>CN80AH`).openPopup();                        
 
                        $(`state`._icon).addClass(`govmrkr`);
            var CDFMFS210 = new L.marker(new L.LatLng(40.23787,-124.13246),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/gov.png`, iconSize: [32, 34]}),
                        title:`marker_G9`}).addTo(fg).bindPopup(`CDFMFS210<br>California Department of Forestry Mattole Fire Station<br>"44056 Mattole Rd"<br>"Petrolia, CA 95558"<br><b style='color:red;'></b><br>40.23787, -124.13246,  0 Ft.<br>CN70WF`).openPopup();                        
 
                        $(`state`._icon).addClass(`govmrkr`);
            var CDFW250 = new L.marker(new L.LatLng(40.80494,-124.16492),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/gov.png`, iconSize: [32, 34]}),
                        title:`marker_G10`}).addTo(fg).bindPopup(`CDFW250<br>California Department of Fish and Wildlife<br>"619 2nd St"<br>"Eureka, CA 95501"<br><b style='color:red;'></b><br>40.80494, -124.16492,  0 Ft.<br>CN70WT`).openPopup();                        
 
                        $(`state`._icon).addClass(`govmrkr`);
            var CFCCFS188 = new L.marker(new L.LatLng(41.76493,-124.19461),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/gov.png`, iconSize: [32, 34]}),
                        title:`marker_G11`}).addTo(fg).bindPopup(`CFCCFS188<br>CAL Fire/Crescent City Fire Station<br>"1025 US-101"<br>"Crescent City, CA 95531"<br><b style='color:red;'></b><br>41.76493, -124.19461,  0 Ft.<br>CN71VS`).openPopup();                        
 
                        $(`state`._icon).addClass(`govmrkr`);
            var CFICC200 = new L.marker(new L.LatLng(40.5925,-124.14733),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/gov.png`, iconSize: [32, 34]}),
                        title:`marker_G12`}).addTo(fg).bindPopup(`CFICC200<br>CAL FIRE-Interagency Command Center<br>"118 N Fortuna Blvd"<br>"Fortuna, CA 95540"<br><b style='color:red;'>"Cal Fire, U.S. Forestry, California Fish and Wild Life, National Parks"</b><br>40.5925, -124.14733,  0 Ft.<br>CN70WO`).openPopup();                        
 
                        $(`state`._icon).addClass(`govmrkr`);
            var CDFGF219 = new L.marker(new L.LatLng(40.10613,-123.79055),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/gov.png`, iconSize: [32, 34]}),
                        title:`marker_G13`}).addTo(fg).bindPopup(`CDFGF219<br>California Department of Forestry Garberville Forest Fire Station<br>"324 Alderpoint Rd"<br>"Garberville, CA 95542"<br><b style='color:red;'></b><br>40.10613, -123.79055,  0 Ft.<br>CN80CC`).openPopup();                        
 
                        $(`state`._icon).addClass(`govmrkr`);
            var CFTVS183 = new L.marker(new L.LatLng(41.52502,-123.99436),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/gov.png`, iconSize: [32, 34]}),
                        title:`marker_G14`}).addTo(fg).bindPopup(`CFTVS183<br>Cal Fire Terwer Valley Station<br>"180 Terwer Valley Rd"<br>"Klamath, CA 95548"<br><b style='color:red;'></b><br>41.52502, -123.99436,  0 Ft.<br>CN81AM`).openPopup();                        
 
                        $(`state`._icon).addClass(`govmrkr`);
            var CFTFFS180 = new L.marker(new L.LatLng(41.07636,-124.14483),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/gov.png`, iconSize: [32, 34]}),
                        title:`marker_G15`}).addTo(fg).bindPopup(`CFTFFS180<br>CAL FIRE Trinidad Forest Fire Station<br>"923 Patricks Point Dr"<br>"Trinidad, CA 95570"<br><b style='color:red;'></b><br>41.07636, -124.14483,  0 Ft.<br>CN71WB`).openPopup();                        
 
                        $(`state`._icon).addClass(`govmrkr`);
var AviationList = L.layerGroup([HMSPH, CFKHB, MCI, PTIACPT, SVBPT, DPNGWA, KCI, RAAB]);var CHPList = L.layerGroup([CHPDC237, HPA172, CHPGS227]);var EOCList = L.layerGroup([W0KCN15, HCES239, W0KCN3, JCDEM265, ALTEOC266, EOC399, NARESEOC, W0KCN4]);var FederalList = L.layerGroup([USFSMRRDO206, LTRD193, LTRDUSFS191, MRFSUSFS205]);var FireList = L.layerGroup([KCMOFS6, KCMOFS7, KCMOFS8, BRVRCOFR29, SPFD171, AFD173, KCMOFS16, AFD174, KCMOFS5, HBFS2, KCMOFS3, TFESS12, RVRSDEFD, GNSVFS1, HBFS3, HBFS1, HBFS4, HBFS5, KCMOFS1, KCMOFS4, KCMOFS17, KCMOFS38, KCMOFS39, KCMOFS40, KCMOFS41, KCMOFS42, KCMOFS43, KCMOFS44, KCMOFS45, KCMOFS47, RVRSFD, KCMOFS14, FIRE13254, KCMOFS37, KCMOFS36, KCMOFS18, KCMOFS19, KCMOFS23, KCMOFS24, KCMOFS25, KCMOFS27, KCMOFS28, KCMOFS29, KCMOFS30, KCMOFS33, KCMOFS34, KCMOFS35, CARROLFD, AFD175, Fire400, GFPD220, WFS2217, BVFD215, PVFD214, MVFD213, MFFS212, PFD209, SVFD208, RDVFD207, HFD202, KVFDFS222, WGVF223, Fire397, PL7650, B272SB, KCMOFS10, SCVFD218, FIRE16257, FIRE15256, FIRE14255, FIRE12253, FIRE11252, FVFDCH201, CFS204, FFD177, WVFD178, TFD179, OVFD181, YFD182, CFPOBFS, KFD34, KFD35, CCFR187, CCFRWHQ189, HFD190, FFD199, BLFD176, FFD198, LFS197, MCVF196, KFPD194, WCFD192]);var HOSPITALList = L.layerGroup([WHIDBEY264, LMH, FORKS261, JCC260, JCC259, SJH160, BATES, PA262, MRCH161, RMH162, JPCH163, TH164, SCH165, JCMC258, WHIDBEY263, SMMC, PETTIS, OPR, EXSPR, OMC, NORKC, MENORA, LSMED, LRHC, LCHD19, LIBRTY, KU0MED, KINDRD, KCVA, PMC, STLPLZ, RAYCO, STJOHN, STJOMC, STLEAS, RESRCH, STLSMI, STLUBR, STLUSO, STM, TRLKWD, TRUHH, W0CPT, WEMO, RMCBKS, KC0CBC, I70, CASS, CMH, CMHS, CUSHNG, DCEC, FITZ, BOTHWL, GVMH, CARROL, BRMC]);var POLICEList = L.layerGroup([PTPOLICE1925, APD231, BLPD236, HTP235, HSUCP233, FPD229, FPD230, EPD228, TPD232, RDPD234]);var RepeaterList = L.layerGroup([W4HRS, W4HRS, W4GL, W4BRK, KK4ONF, KE4MDP, WA4USN, KJ4BWK, KG4BZN, K4NAB, W4DV, K4KNJ, W4HRS, KW4BET, WA4UKX, W4NYK, W4ZKM, K9OH, K4USC, WT4F, WR4SC, WR4SC, KK4ZBE, WR4SC, WR4SC, W4HRS, AD4U, W4BFT, WR4EC, W4GL, W4PAX, W4APE, W4APE, WR4SC, N1RCW, W4FTK , WA4NMW, WR4SC, W4FTK, WX4PG, W4APE, W4HNK, W4GWD, K4CCC, W4GS, WR4SC, WR4SC, KJ4QLH, W4FTK, KK4ONF, W4IAR, W4GS, KA4FEC, NE4SC, KK4BQ, K4HI, W4ANK, WR4SC, W4CAE, K4JLA, KK4B, K2PJ, N4ADM, N4HRS, WA4JRJ, W4ANK, W4RRC, K4ILT, K4YTZ, N2OBS, W4ULH, K4ILT, KA4GDW, KI4RAX, W4NYK, KJ4QLH, W4GS, N4AW, WA4USN, W4CAE, W4FTK, KB4RRC, WR4SC, W4FTK, KD4HLH, W4NYR, KJ4YLP, KK4BQ, W4GL, WB4YXZ, KO4L, W1GRE, KB4RRC, N4AW, WA4USN, W4IQQ, W4APE, WA4SJS, W4DEW, W4APE, WR4SC, W4PDE, N2ZZ, KCRJCRAC2, KCRJCRAC1, KCRKW1, KCRHCV, SAXRPTR, WA0KHP, WA0QFJ, PRATT241, SC242, MP243, KG4BZN, KCRKW2, KCRWW, ACT, DCARC, KCRCNC, KCRHAM4, KCRMED, KCRQFJ, KCRHAM3, KCRHAM2, KCRROO, HH244, HCCH245, HORSE246, KM4ABW, W4TWX, K4LMD, W4APE, K4WD, W4CHR, NE4SC, W4BFT, W4IAR, W4DV, W7JCR268, ROGERS248]);var SheriffList = L.layerGroup([FPD93721, JCSHRFF267, PKVLPD, HCSDGS226, CCSHERIFF, COMOPD, PLTCTYPD, NKCPD, GSTNPD, Sheriff398, RVRSPD, Sheriff401, LKWKPD, HCSO224, HCSOMS225, NRTPD, KCNPPD]);var SkyWarnList = L.layerGroup([CTEAUELV, C2, TANEY210, HWY291on210, Non291Hwy, C11, LecRestStop, BROADWAY, P4, SUNNYSIDE, WATKINSMILL, P2, SWSKOL, C12, P12, P11, P10, P9, P8, P7, P6, P5, P3, P1, XSPRINGS, P13, C1, C10, C9, C8, C7, C6, NWS240, C5, C4, C3]);var StateList = L.layerGroup([CALTRNS238, RGSP221, CFTFS216, CFWS211, CDFMFS210, CDFW250, CFCCFS188, CFICC200, CDFGF219, CFTVS183, CFTFFS180]);
var Stations = L.layerGroup([_WA0TJT,_W0DLK,_KD0FTY,_KC9OAZ]);
// WA0TJT,W0DLK,KD0NBH,KC0YT,AA0JX,AA0DV

// Add the stationmarkers to the map
Stations.addTo(map);
//OBJMarkerList.addTo(map);

    var bounds = L.latLngBounds([[[39.203,-94.60233],[39.201636,-94.602375],[39.206945,-94.604219],[39.200531,-94.601332]]]);
    //console.log('@304 bounds= '+JSON.stringify(bounds)); 
    //{"_southWest":{"lat":39.2002636,"lng":-94.641221},"_northEast":{"lat":39.2628465,"lng":-94.568932}}

// I don't know if I need this or not.
    map.fitBounds([[[39.203,-94.60233],[39.201636,-94.602375],[39.206945,-94.604219],[39.200531,-94.601332]]]);
    

    // find the corners and middle of the stationmarkers
    var middle = bounds.getCenter(); // alert(middle); //LatLng(-93.20448, 38.902475)
    var padit  = bounds.pad(.075);   // add a little bit to the corner bounding box
    var sw = padit.getSouthWest();   // get the SouthWest most point
    var nw = padit.getNorthWest();
    var ne = padit.getNorthEast();
    var se = padit.getSouthEast();

    //=======================================================================
    //======================= Station Marker Corners ========================
    //=======================================================================
    // POI's do not have corner markers, however they should be restricted to 
    // display within these markers with a little wiggle room
    
    // These are the corner markers of the extended bounds of the stations
    var mk1 = new L.marker(new L.latLng( sw ),{
        icon: L.icon({iconUrl: blackmarkername , iconSize: [220,220] }),
        title:'mk1'}).addTo(map).bindPopup('MK1<br>The SW Corner<br>'+sw).openPopup();
    
    var mk2 = new L.marker(new L.latLng( nw ),{
       icon: L.icon({iconUrl: blackmarkername , iconSize: [220,220] }),
       title:'mk2'}).addTo(map).bindPopup('MK2<br>The NW Corner<br>'+nw).openPopup();
    
    var mk3 = new L.marker(new L.latLng( ne ),{
       icon: L.icon({iconUrl: blackmarkername , iconSize: [220,220] }),
       title:'mk3'}).addTo(map).bindPopup('MK3<br>The NE Corner<br>'+ne).openPopup();
    
    var mk4 = new L.marker(new L.latLng( se ),{
       icon: L.icon({iconUrl: blackmarkername , iconSize: [220,220] }),
       title:'mk4'}).addTo(map).bindPopup('MK4<br>The SE Corner<br>'+se).openPopup();
	
    // Add the temp center marker to the map here in the javascript code allows it to use the current map view,
    // When its earlier in the stack, it centers on our house becaue that is the default map location
    var mk5 = new L.marker(new L.latLng( middle ),{
        contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
        text: 'Click here to add mileage circles', callback: circleKoords}],   
        icon: L.icon({iconUrl: blackmanInTheMiddle , iconSize: [220,220] }),     
        title:'mk5'}).addTo(map).bindPopup('MK5<br>The Center Marker<br>'+middle).openPopup();
    
    // Definition of the 5 markers above, corners plus middle    
    var CornerList = L.layerGroup([mk1, mk2, mk3, mk4, mk5]);
    //======================================================================
    // ================== End Station Marker Corners =======================
    //======================================================================
    
     //=======================================================================
    //================ Object Marker Corners and all the Objects =============
    //========================================================================

        // These are neded to determine the corners and centers
        var W0DLKOBJ = L.latLngBounds( [[39.201636,-94.602375],[39.201259,-94.603175],[39.20169,-94.603628],[39.201986,-94.603036],[39.202337,-94.602932]]);var WA0TJTOBJ = L.latLngBounds( [[39.201393,-94.601576],[39.20067,-94.6015],[39.20167,-94.60217],[39.20117,-94.60167],[39.2025,-94.6025],[39.203,-94.60233],[39.203,-94.60233],[39.201016,-94.601541],[39.203,-94.60233]]);W0DLKOBJ.getCenter();WA0TJTOBJ.getCenter();var W0DLKPAD    = W0DLKOBJ.pad(.075);var WA0TJTPAD    = WA0TJTOBJ.pad(.075);        
        // Object markers here
         var W0DLK01 = new L.marker(new L.LatLng(39.202337,-94.602932),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker01.png', iconSize: [32, 34]}),
                                title:`marker_001`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>OBJ:<br>W0DLK01<br><br></div>
                     <div style='color:red; font-weight: bold; font-size:18pt;'>Object Description:<br> Red Corvette</div>
                     <div class='gg'><br>LOCATION: <br><a href='https://what3words.com/mascot.weaves.formula?maptype=osm' target='_blank'>///mascot.weaves.formula</a><br><br>Cross Roads:<br> N Ames Ave &amp; N Bedford Ave <br><br>Coordinates:<br>39.202337,-94.602932<br>Grid: EM29QE<br></div><br><br><div class='cc'>Full Comment:<br>ascot.weaves.formula -> Cross Roads: N Ames Ave &amp; N Bedford Ave (39.202337,-94.602932) Red Corvette<br><br></div>
                     <div class='xx'>Captured:<br>2021-09-22 23:19:18</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');    
                                $('Objects'._icon).addClass('huechange');                                          
                            var W0DLK02 = new L.marker(new L.LatLng(39.201986,-94.603036),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker02.png', iconSize: [32, 34]}),
                                title:`marker_002`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>OBJ:<br>W0DLK02<br><br></div>
                     <div style='color:red; font-weight: bold; font-size:18pt;'>Object Description:<br> Blue F150</div>
                     <div class='gg'><br>LOCATION: <br><a href='https://what3words.com/poses.fiction.engineering?maptype=osm' target='_blank'>///poses.fiction.engineering</a><br><br>Cross Roads:<br> N Bedford Ave &amp; NW 60th Ct <br><br>Coordinates:<br>39.201986,-94.603036<br>Grid: EM29QE<br></div><br><br><div class='cc'>Full Comment:<br>oses.fiction.engineering -> Cross Roads: N Bedford Ave &amp; NW 60th Ct (39.201986,-94.603036) Blue F150<br><br></div>
                     <div class='xx'>Captured:<br>2021-09-22 23:19:39</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');    
                                $('Objects'._icon).addClass('huechange');                                          
                            var W0DLK03 = new L.marker(new L.LatLng(39.20169,-94.603628),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker03.png', iconSize: [32, 34]}),
                                title:`marker_003`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>OBJ:<br>W0DLK03<br><br></div>
                     <div style='color:red; font-weight: bold; font-size:18pt;'>Object Description:<br> White Van</div>
                     <div class='gg'><br>LOCATION: <br><a href='https://what3words.com/page.outings.crosses?maptype=osm' target='_blank'>///page.outings.crosses</a><br><br>Cross Roads:<br> N Bedford Ave &amp; NW 59th Ct <br><br>Coordinates:<br>39.20169,-94.603628<br>Grid: EM29QE<br></div><br><br><div class='cc'>Full Comment:<br>age.outings.crosses -> Cross Roads: N Bedford Ave &amp; NW 59th Ct (39.20169,-94.603628) White Van<br><br></div>
                     <div class='xx'>Captured:<br>2021-09-22 23:20:09</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');    
                                $('Objects'._icon).addClass('huechange');                                          
                            var W0DLK04 = new L.marker(new L.LatLng(39.201259,-94.603175),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker04.png', iconSize: [32, 34]}),
                                title:`marker_004`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>OBJ:<br>W0DLK04<br><br></div>
                     <div style='color:red; font-weight: bold; font-size:18pt;'>Object Description:<br> Green Camaro</div>
                     <div class='gg'><br>LOCATION: <br><a href='https://what3words.com/frozen.generously.tilts?maptype=osm' target='_blank'>///frozen.generously.tilts</a><br><br>Cross Roads:<br> N Bedford Ave &amp; NW 59th Ct <br><br>Coordinates:<br>39.201259,-94.603175<br>Grid: EM29QE<br></div><br><br><div class='cc'>Full Comment:<br>rozen.generously.tilts -> Cross Roads: N Bedford Ave &amp; NW 59th Ct (39.201259,-94.603175) Green Camaro<br><br></div>
                     <div class='xx'>Captured:<br>2021-09-22 23:20:51</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');    
                                $('Objects'._icon).addClass('huechange');                                          
                            var W0DLK05 = new L.marker(new L.LatLng(39.201636,-94.602375),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker05.png', iconSize: [32, 34]}),
                                title:`marker_005`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>OBJ:<br>W0DLK05<br><br></div>
                     <div style='color:red; font-weight: bold; font-size:18pt;'>Object Description:<br> Silver Colorado</div>
                     <div class='gg'><br>LOCATION: <br><a href='https://what3words.com/betrayal.tattoo.thickens?maptype=osm' target='_blank'>///betrayal.tattoo.thickens</a><br><br>Cross Roads:<br> N Ames Ave &amp; N Bedford Ave <br><br>Coordinates:<br>39.201636,-94.602375<br>Grid: EM29QE<br></div><br><br><div class='cc'>Full Comment:<br>etrayal.tattoo.thickens -> Cross Roads: N Ames Ave &amp; N Bedford Ave (39.201636,-94.602375) Silver Colorado<br><br></div>
                     <div class='xx'>Captured:<br>2021-09-22 23:21:17</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');    
                                $('Objects'._icon).addClass('huechange');            
                                
                                                              
                            var WA0TJT01 = new L.marker(new L.LatLng(39.2025,-94.6025),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker01.png', iconSize: [32, 34]}),
                                title:`marker_001`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>OBJ:<br>WA0TJT01<br><br></div>
                     <div style='color:red; font-weight: bold; font-size:18pt;'>Object Description:<br> red door</div>
                     <div class='gg'><br>LOCATION: @ 20210922222135 <br><a href='https://what3words.com/hindering.will.hotter?maptype=osm' target='_blank'>///hindering.will.hotter</a><br><br>Cross Roads:<br> NW 60th Ct &amp; N Bedford Ave <br><br>Coordinates:<br>39.2025,-94.6025<br>Grid: EM29QE<br></div><br><br><div class='cc'>Full Comment:<br> @:20210922222135 (39.2025,-94.6025)  ///hindering.will.hotter   Cross Roads: NW 60th Ct &amp; N Bedford Ave Object: red door<br><br></div>
                     <div class='xx'>Captured:<br>2021-09-22 22:22:04</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');    
                                $('Objects'._icon).addClass('huechange');                                          
                            var WA0TJT02 = new L.marker(new L.LatLng(39.20167,-94.60217),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker02.png', iconSize: [32, 34]}),
                                title:`marker_002`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>OBJ:<br>WA0TJT02<br><br></div>
                     <div style='color:red; font-weight: bold; font-size:18pt;'>Object Description:<br> silver truck</div>
                     <div class='gg'><br>LOCATION: @ 20210922222321 <br><a href='https://what3words.com/estimate.spray.appreciated?maptype=osm' target='_blank'>///estimate.spray.appreciated</a><br><br>Cross Roads:<br> N Ames Ave &amp; N Bedford Ave <br><br>Coordinates:<br>39.20167,-94.60217<br>Grid: EM29QE<br></div><br><br><div class='cc'>Full Comment:<br> @:20210922222321 (39.20167,-94.60217)  ///estimate.spray.appreciated   Cross Roads: N Ames Ave &amp; N Bedford Ave Object: silver truck<br><br></div>
                     <div class='xx'>Captured:<br>2021-09-22 22:24:08</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');    
                                $('Objects'._icon).addClass('huechange');                                          
                            var WA0TJT03 = new L.marker(new L.LatLng(39.20117,-94.60167),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker03.png', iconSize: [32, 34]}),
                                title:`marker_003`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>OBJ:<br>WA0TJT03<br><br></div>
                     <div style='color:red; font-weight: bold; font-size:18pt;'>Object Description:<br> 2v suv</div>
                     <div class='gg'><br>LOCATION: @ 20210922222459 <br><a href='https://what3words.com/activation.development.secrets?maptype=osm' target='_blank'>///activation.development.secrets</a><br><br>Cross Roads:<br> N Ames Ave &amp; NW 59 St <br><br>Coordinates:<br>39.20117,-94.60167<br>Grid: EM29QE<br></div><br><br><div class='cc'>Full Comment:<br> @:20210922222459 (39.20117,-94.60167)  ///activation.development.secrets   Cross Roads: N Ames Ave &amp; NW 59 St Object: 2v suv<br><br></div>
                     <div class='xx'>Captured:<br>2021-09-22 22:25:20</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');    
                                $('Objects'._icon).addClass('huechange');                                          
                            var WA0TJT04 = new L.marker(new L.LatLng(39.20067,-94.6015),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker04.png', iconSize: [32, 34]}),
                                title:`marker_004`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>OBJ:<br>WA0TJT04<br><br></div>
                     <div style='color:red; font-weight: bold; font-size:18pt;'>Object Description:<br> brown door</div>
                     <div class='gg'><br>LOCATION: @ 20210922222756 <br><a href='https://what3words.com/egging.seamstress.trophy?maptype=osm' target='_blank'>///egging.seamstress.trophy</a><br><br>Cross Roads:<br> N Ames Ave &amp; NW 59 St <br><br>Coordinates:<br>39.20067,-94.6015<br>Grid: EM29QE<br></div><br><br><div class='cc'>Full Comment:<br> @:20210922222756 (39.20067,-94.6015)  ///egging.seamstress.trophy   Cross Roads: N Ames Ave &amp; NW 59 St Object: brown door<br><br></div>
                     <div class='xx'>Captured:<br>2021-09-22 22:28:15</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');    
                                $('Objects'._icon).addClass('huechange');                                          
                            var WA0TJT05 = new L.marker(new L.LatLng(39.201016,-94.601541),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker05.png', iconSize: [32, 34]}),
                                title:`marker_005`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>OBJ:<br>WA0TJT05<br><br></div>
                     <div style='color:red; font-weight: bold; font-size:18pt;'>Object Description:<br> blk suv</div>
                     <div class='gg'><br>LOCATION: <br><a href='https://what3words.com/shiny.saturation.motivator?maptype=osm' target='_blank'>///shiny.saturation.motivator</a><br><br>Cross Roads:<br> N Ames Ave &amp; NW 59 St <br><br>Coordinates:<br>39.201016,-94.601541<br>Grid: EM29QE<br></div><br><br><div class='cc'>Full Comment:<br>hiny.saturation.motivator -> Cross Roads: N Ames Ave &amp; NW 59 St (39.201016,-94.601541) blk suv<br><br></div>
                     <div class='xx'>Captured:<br>2021-09-22 22:30:14</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');    
                                $('Objects'._icon).addClass('huechange');                                          
                            var WA0TJT06 = new L.marker(new L.LatLng(39.201393,-94.601576),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker06.png', iconSize: [32, 34]}),
                                title:`marker_006`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>OBJ:<br>WA0TJT06<br><br></div>
                     <div style='color:red; font-weight: bold; font-size:18pt;'>Object Description:<br> 3 cars</div>
                     <div class='gg'><br>LOCATION: <br><a href='https://what3words.com/blinking.huffs.reforms?maptype=osm' target='_blank'>///blinking.huffs.reforms</a><br><br>Cross Roads:<br> N Ames Ave &amp; NW 59 St <br><br>Coordinates:<br>39.201393,-94.601576<br>Grid: EM29QE<br></div><br><br><div class='cc'>Full Comment:<br>linking.huffs.reforms -> Cross Roads: N Ames Ave &amp; NW 59 St (39.201393,-94.601576) 3 cars<br><br></div>
                     <div class='xx'>Captured:<br>2021-09-22 22:32:05</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');    
                                $('Objects'._icon).addClass('huechange');                                          
                            var WA0TJT07 = new L.marker(new L.LatLng(39.203,-94.60233),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker07.png', iconSize: [32, 34]}),
                                title:`marker_007`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>OBJ:<br>WA0TJT07<br><br></div>
                     <div style='color:red; font-weight: bold; font-size:18pt;'>Object Description:<br> man standing on rock</div>
                     <div class='gg'><br>LOCATION: @ 20210923193427 <br><a href='https://what3words.com/mailings.fried.imbalances?maptype=osm' target='_blank'>///mailings.fried.imbalances</a><br><br>Cross Roads:<br> NW 60th Ct &amp; N Bedford Ave <br><br>Coordinates:<br>39.203,-94.60233<br>Grid: EM29QE<br></div><br><br><div class='cc'>Full Comment:<br> @:20210923193427 (39.203,-94.60233)  ///mailings.fried.imbalances   Cross Roads: NW 60th Ct &amp; N Bedford Ave Object: man standing on rock<br><br></div>
                     <div class='xx'>Captured:<br>2021-09-23 19:36:12</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');    
                                $('Objects'._icon).addClass('huechange');                                          
                            var WA0TJT08 = new L.marker(new L.LatLng(39.203,-94.60233),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker08.png', iconSize: [32, 34]}),
                                title:`marker_008`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>OBJ:<br>WA0TJT08<br><br></div>
                     <div style='color:red; font-weight: bold; font-size:18pt;'>Object Description:<br> null</div>
                     <div class='gg'><br>LOCATION: @ 20210923193427 <br><a href='https://what3words.com/mailings.fried.imbalances?maptype=osm' target='_blank'>///mailings.fried.imbalances</a><br><br>Cross Roads:<br> N Ames Ave &amp; NW 60th Ct <br><br>Coordinates:<br>39.203,-94.60233<br>Grid: EM29QE<br></div><br><br><div class='cc'>Full Comment:<br> @:20210923193427 (39.203,-94.60233)  ///mailings.fried.imbalances   Cross Roads: N Ames Ave &amp; NW 60th Ct Object: null<br><br></div>
                     <div class='xx'>Captured:<br>2021-09-23 22:48:37</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');    
                                $('Objects'._icon).addClass('huechange');                                          
                            var WA0TJT09 = new L.marker(new L.LatLng(39.203,-94.60233),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker09.png', iconSize: [32, 34]}),
                                title:`marker_009`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>OBJ:<br>WA0TJT09<br><br></div>
                     <div style='color:red; font-weight: bold; font-size:18pt;'>Object Description:<br> yelloo VW</div>
                     <div class='gg'><br>LOCATION: @ 20210923193427 <br><a href='https://what3words.com/mailings.fried.imbalances?maptype=osm' target='_blank'>///mailings.fried.imbalances</a><br><br>Cross Roads:<br> NW 60th Ct &amp; N Bedford Ave <br><br>Coordinates:<br>39.203,-94.60233<br>Grid: EM29QE<br></div><br><br><div class='cc'>Full Comment:<br> @:20210923193427 (39.203,-94.60233)  ///mailings.fried.imbalances   Cross Roads: NW 60th Ct &amp; N Bedford Ave Object: yelloo VW<br><br></div>
                     <div class='xx'>Captured:<br>2021-09-24 01:04:55</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');    
                                $('Objects'._icon).addClass('huechange');                                          
                                   
        //console.log('@398 objMarkers '+objMarkers.toString());
        //console.log(WA0TJT01);
         
        // Object Marker List starts here
        var OBJMarkerList = L.layerGroup([W0DLK01,W0DLK02,W0DLK03,W0DLK04,W0DLK05,WA0TJT01,WA0TJT02,WA0TJT03,WA0TJT04,WA0TJT05,WA0TJT06,WA0TJT07,WA0TJT08,WA0TJT09,]);        
        console.log('@415 OBJMarkerList'); // dont use line number in console.log below
        //console.log(OBJMarkerList);
        
        // Corner and center flags for the object markers, 5 for each callsign that has objects
        var W0DLKob1 = new L.marker(new L.latLng( W0DLKPAD.getSouthWest() ),{   
    	/*	contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
            text: 'Click here to add mileage circles', callback: circleKoords}], */
            icon: L.icon({iconUrl: bluemarkername , iconSize: [200,200] }),
            title:'ob1'}).addTo(map).bindPopup('OBJ:<br> W0DLKSW<br>'+38.951259+','+-94.852375+'<br>The Objects SW Corner');
                        
           var W0DLKob2 = new L.marker(new L.latLng( W0DLKPAD.getNorthWest() ),{
        /*   contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], */
           icon: L.icon({iconUrl: bluemarkername , iconSize: [200,200] }),
           title:'ob2'}).addTo(map).bindPopup('OBJ:<br> W0DLKNW<br>'+39.452337+','+-94.852375+'<br>The Objects NW Corner');
                           
           var W0DLKob3 = new L.marker(new L.latLng( W0DLKPAD.getNorthEast() ),{
        /*   contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], */
           icon: L.icon({iconUrl: bluemarkername , iconSize: [200,200] }),
           title:'ob3'}).addTo(map).bindPopup('OBJ:<br> W0DLKNE<br>'+39.452337+','+-94.353628+'<br>The Objects NE Corner');
                           
           var W0DLKob4 = new L.marker(new L.latLng( W0DLKPAD.getSouthEast() ),{
       /*    contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], */
           icon: L.icon({iconUrl: bluemarkername , iconSize: [200,200] }),
           title:'ob4'}).addTo(map).bindPopup('OBJ:<br> W0DLKSE<br>'+38.951259+','+-94.353628+'<br>The Objects SE Corner');
                           
           var W0DLKob5 = new L.marker(new L.latLng( W0DLKPAD.getCenter() ),{
        /*   contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],   */
           icon: L.icon({iconUrl: bluemanInTheMiddle , iconSize: [200,200] }),     
           title:'ob5'}).addTo(map).bindPopup('OBJ:<br> W0DLKCT<br>'+38.951259+','+-94.353628+'<br>The Objects Center Marker');
           
           /* This extra ob6 is so we can draw lines around the objects */
           var W0DLKob6 = new L.marker(new L.latLng( W0DLKPAD.getSouthWest() ),{
           icon: L.icon({iconUrl: bluemarkername , iconSize: [200,200] }),
           title:'ob4'}).addTo(map).bindPopup('OBJ:<br> W0DLKSW<br>'+38.951259+','+-94.353628+'<br>The Objects SE Corner');
           var WA0TJTob1 = new L.marker(new L.latLng( WA0TJTPAD.getSouthWest() ),{   
    	/*	contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
            text: 'Click here to add mileage circles', callback: circleKoords}], */
            icon: L.icon({iconUrl: plummarkername , iconSize: [200,200] }),
            title:'ob1'}).addTo(map).bindPopup('OBJ:<br> WA0TJTSW<br>'+38.95067+','+-94.8515+'<br>The Objects SW Corner');
                        
           var WA0TJTob2 = new L.marker(new L.latLng( WA0TJTPAD.getNorthWest() ),{
        /*   contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], */
           icon: L.icon({iconUrl: plummarkername , iconSize: [200,200] }),
           title:'ob2'}).addTo(map).bindPopup('OBJ:<br> WA0TJTNW<br>'+39.453+','+-94.8515+'<br>The Objects NW Corner');
                           
           var WA0TJTob3 = new L.marker(new L.latLng( WA0TJTPAD.getNorthEast() ),{
        /*   contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], */
           icon: L.icon({iconUrl: plummarkername , iconSize: [200,200] }),
           title:'ob3'}).addTo(map).bindPopup('OBJ:<br> WA0TJTNE<br>'+39.453+','+-94.3525+'<br>The Objects NE Corner');
                           
           var WA0TJTob4 = new L.marker(new L.latLng( WA0TJTPAD.getSouthEast() ),{
       /*    contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], */
           icon: L.icon({iconUrl: plummarkername , iconSize: [200,200] }),
           title:'ob4'}).addTo(map).bindPopup('OBJ:<br> WA0TJTSE<br>'+38.95067+','+-94.3525+'<br>The Objects SE Corner');
                           
           var WA0TJTob5 = new L.marker(new L.latLng( WA0TJTPAD.getCenter() ),{
       /*    contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],   */
           icon: L.icon({iconUrl: plummanInTheMiddle , iconSize: [200,200] }),     
           title:'ob5'}).addTo(map).bindPopup('OBJ:<br> WA0TJTCT<br>'+38.95067+','+-94.3525+'<br>The Objects Center Marker');
           
           /* This extra ob6 is so we can draw lines around the objects */
           var WA0TJTob6 = new L.marker(new L.latLng( WA0TJTPAD.getSouthWest() ),{
           icon: L.icon({iconUrl: plummarkername , iconSize: [200,200] }),
           title:'ob4'}).addTo(map).bindPopup('OBJ:<br> WA0TJTSW<br>'+38.95067+','+-94.3525+'<br>The Objects SE Corner');
         
         var OBJMarkerList = L.layerGroup([W0DLK01,W0DLK02,W0DLK03,W0DLK04,W0DLK05,WA0TJT01,WA0TJT02,WA0TJT03,WA0TJT04,WA0TJT05,WA0TJT06,WA0TJT07,WA0TJT08,WA0TJT09,]);
         
         const W0DLKOBJMarkerList = L.layerGroup([W0DLK01,W0DLK02,W0DLK03,W0DLK04,W0DLK05,]);
         
         const WA0TJTOBJMarkerList = L.layerGroup([WA0TJT01,WA0TJT02,WA0TJT03,WA0TJT04,WA0TJT05,WA0TJT06,WA0TJT07,WA0TJT08,WA0TJT09,]);
         
         const allnameBounds = (['W0DLKOBJMarkerList','WA0TJTOBJMarkerList']);     
         
         console.log('@5867 '+allnameBounds[1]);
               
        // color wheel for the lines
       const colorwheel = ["green","blue","orange","plum","lightblue","gray","gold","black","red"];
    
       //var newcolor = '';
       var u = -1; // to iterate through the colorwheel
       
       //   for (z of allnameBounds) {
        for (const entry of allnameBounds) {
                newcolor = colorwheel[u]; // sets the color in the var objectLine below
                    console.log('@5876 entry= '+entry+' u= '+u+', newcolor= '+newcolor);
                    
                 // OML = allnameBounds[u];  
            
            // Add connecting lines between the object markers           
             objectKoords = connectTheDots(WA0TJTOBJMarkerList);   // W0DLKOBJMarkerList
                console.log('@5883 objectKoords= '+objectKoords);
             objectLine = L.polyline(objectKoords,{color: colorwheel[u], weight: 4}).addTo(map);
             
             //newcolor = colorwheel[u+1];
             //console.log('@5887 u= '+u+', newcolor= '+newcolor);
            
             objectKoords = connectTheDots(W0DLKOBJMarkerList); // WA0TJTOBJMarkerList
                console.log('@5890 objectKoords= '+objectKoords);
             objectLine = L.polyline(objectKoords,{color: colorwheel[u+1], weight: 4}).addTo(map);   
           
               // console.log('@5893 z= '+z+', newcolor= '+newcolor+', cw= '+colorwheel[u]);
                
       u++;
          } // end for loop
       
        // Add the OBJMarkerList to the map, this was the missing piece 
        OBJMarkerList.addTo(map);

    //====================================================================== 
    //====================== Points of Interest ============================
    //======================================================================    
// The classList is the list of POI types.
var classList = 'AviationL,CHPL,EOCL,FederalL,FireL,HOSPITALL,POLICEL,RepeaterL,SheriffL,SkyWarnL,StateL, CornerL, ObjectL;'.split(',');
   console.log('@457 in map.php classList= '+classList);

let station = {"<img src='markers/green_marker_hole.png' class='greenmarker' alt='green_marker_hole' align='middle' /><span class='biggreenmarker'> Stations</span>": Stations};

// Each test below if satisfied creates a javascript object, each one connects the previous to the next 
// THE FULL LIST:  Hospital ,Repeater ,EOC ,Sheriff ,SkyWarn ,Fire ,CHP ,State ,Federal ,Aviation ,Police ,class
// Each test below if satisfied creates a javascript object, each one connects the previous to the next 
var y = {...station};
var x;
for (x of classList) {
    
    if (x == 'AviationL') {
        let Aviation = {"<img src='images/markers/aviation.png' width='32' align='middle' /> <span class='aviation'>Aviation</span>": AviationList};
        y = {...y, ...Aviation}; 
        
    }else if (x == 'CHPL') {
        let CHP = {"<img src='images/markers/police.png' width='32' height='37' align='middle' /> <span class='polmarker'>Police</span>":  SheriffList};
        y = {...y,...CHP}; 
        
    }else if (x == 'EOCL') {
        let EOC = {"<img src='images/markers/eoc.png' align='middle' /> <span class='eocmarker'>EOC</span>": EOCList};
        y = {...y, ...EOC};
        
    }else if (x == 'FederalL') {
        let Federal = {"<img src='images/markers/gov.png' width='32' height='37' align='middle' /> <span class='gov'>Fed</span>":  FederalList};
        y = {...y,...Federal};

        
    }else if (x == 'FireL') {
        let Fire = {"<img src='images/markers/fire.png' align='middle' /> <span class='firemarker'>Fire Station</span>": FireList};
        y = {...y, ...Fire};
        
    }else if (x == 'HospitalL') {
        let Hospital = {"<img src='images/markers/firstaid.png' align='middle' /> <span class='hosmarker'>Hospitals</span>": HospitalList};
        y = {...y, ...Hospital};
        
    }else if (x == 'PoliceL') {
        let Police = {"<img src='images/markers/police.png' width='32' height='37' align='middle' /> <span class='polmarker'>Police</span>": SheriffList};
        y = {...y, ...Police};
        
    }else if (x == 'RepeaterL') {
        let Repeater = {"<img src='images/markers/repeater.png' align='middle' /> <span class='rptmarker'>Repeaters</span>": RepeaterList};
        y = {...y, ...Repeater};
        
    }else if (x == 'SheriffL') {
        let Sheriff = {"<img src='images/markers/police.png' width='32' height='37' align='middle' /> <span class='polmarker'>Police</span>":  SheriffList};
        y = {...y,...Sheriff};
        
    }else if (x == 'SkyWarnL') {
        let SkyWarn = {"<img src='images/markers/skywarn.png' align='middle' /> <span class='skymarker'>SkyWarn</span>": SkyWarnList};
        y = {...y, ...SkyWarn};    
        
    }else if (x == 'StateL') {
        let State = {"<img src='images/markers/gov.png' width='32' height='37' align='middle' /> <span class='polmarker'>State</span>":  SheriffList};
        y = {...y,...State};
        
    }else if (x == 'ObjectL') {
        let Objects = {"<img src='images/markers/marker00.png' align='middle' /> <span class='objmrkrs'>Objects</span>": ObjectList};
        y = {...y, ...Objects}; 
        
    }else if (x == ' CornerL') {
        let Corners = {"<img src='images/markers/red_50_flag.png' align='middle' /> <span class='corners'>Corners</span>": CornerList};
        y = {...y, ...Corners};
    }}; // End of for loop
    
// Here we add the station object with the merged y objects from above
var overlayMaps = {...y }; 


// Set the center point of the map based on the coordinates
//map.fitBounds([[39.203,-94.60233],[39.201636,-94.602375],[39.206945,-94.604219],[39.200531,-94.601332]], {pad: 0.5});

L.control.layers(baseMaps, overlayMaps, {position:'bottomright', collapsed:false}).addTo(map);


// Define the Plus and Minus for zooming and its location
//dupe map.scrollWheelZoom.disable();  // prevents the map from zooming with the mouse wheel

// dupe var arcgisOnline = L.esri.Geocoding.arcgisOnlineProvider();

// Add what3words, shows w3w in a control
var w = new L.Control.w3w();
	w.addTo(map);
	map.on('click', function(e) {
		console.log(e);
		w.setCoordinates(e);
	});
	
// Adds a temp marker popup to show location of click
//var popup = L.popup();
function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at:<br>" + e.latlng.toString() + "<br>"  )
        .openOn(map);
}
map.on('click', onMapClick);


// adds the lat/lon grid lines
L.grid().addTo(map);  

// Change the position of the Zoom Control to a newly created placeholder.
map.zoomControl.setPosition('topright');


L.control.scale().addTo(map);

// You can also put other controls in the same placeholder.
//L.control.scale({position: 'verticalcenterright'}).addTo(map);

// Set up to show markers popup	

		function markerFunction(id){
	        for (var i in stationMarkers){
	            var markerID = stationMarkers[i].options.title;
	            if (markerID == id){
	                stationMarkers[i].openPopup();
	            };
	        } // end of for loop
		} // end markerFunction 
		
	    // JQuery call to display the popup from the marker list
	    $("a").click(function(){
	        markerFunction($(this)[0].id);
	    });
	    
	    
	    function isEmpty(obj) {
    	    for(var key in obj) {
        	    if(obj.hasOwnProperty(key))
        	        return false;
    	    }
    	        return true;
	    }
	    
	    var lastLayer = null;
          map.on('contextmenu.show',(e)=>{
            console.log(e);
            lastLayer = e.relatedTarget; 
        });
	    

</script>   <!-- End of javascript holding the map stuff -->

</body>
</html>
