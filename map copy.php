<!DOCTYPE html>
<!-- map.php -->
<!-- Leaflet is the primary mapping used here:
    Primary maping program, also uses poiMarkers.php, objMarkers.php and stationMarkers.php -->
<!-- Original version 2017-01-16 -->
<!-- This Update 2021-10-16 -->
<!-- This Update 2023-08-03 -->
<!-- This Update 2023-12-27 -->

<?php
	
	ini_set('display_errors',1); 
	error_reporting (E_ALL ^ E_NOTICE);

    require_once "dbConnectDtls.php";  // Access to MySQL
    require_once "ENV_SETUP.php";      // API's
    require_once "GridSquare.php";
    require_once "config.php";
    require_once "config2.php";
    
    // Value comes from an open net or prompt 
    $q = intval($_GET["NetID"]); 
    
    //$q = 11001; 

    
    // We need the min & max latitude to determin if we want to pull data from poiMarkers.php
    // This should be changed to min and max longitude or the Americas vs. Europe etc.
    $sql="SELECT MAX(latitude) as maxlat,
                 MIN(latitude) as minlat,
                 MAX(longitude) as maxlon,
                 MIN(longitude) as minlon
            FROM NetLog 
           WHERE netID = $q AND latitude <> ''
          ";
          //echo "$sql";
        $stmt = $db_found->prepare($sql);
        $stmt->execute();
    	$result = $stmt->fetch();
    		$maxlat = $result[maxlat];
    		$minlat = $result[minlat];
    		$maxlon = $result[maxlon];
    		$minlon = $result[minlon];
    //echo "$maxalt, $minalt";
    
    // Loads the programs that create the station, poi,d object markers
	include "stationMarkers.php";
    include "poiMarkers.php";    
    include "objMarkers.php";

?>

<html lang="en">
<head>
	<title>NCM Map of Station Locations</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	

	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" >
	<link rel="shortcut icon" type="image/x-icon" href="favicons/apple-icon.png">

     <!-- ******************************** Load LEAFLET from CDN *********************************** -->
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
     <!-- ********************************* End Load LEAFLET **************************************** -->
     
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
    <!-- Various additional Leaflet javascripts -->
     
    <script src="js/leaflet_numbered_markers.js"></script>
    <script src="js/L.Grid.js"></script>     

    <script src="js/leaflet/leaflet.mouseCoordinate-master/dist/leaflet.mousecoordinate.min.js"></script>   
    
    <script src="js/hamgridsquare.js"></script>
    
    <script src="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.js"></script>  
    <script src="js/leaflet/leaflet.contextmenu.min.js"></script>
    
    <!-- Allows for rotating markers when more than one at the same place -->
    <script src="js/leaflet.rotatedMarker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-geometryutil@0.9.1/src/leaflet.geometryutil.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@5/turf.min.js"></script>
    
    <script src="https://assets.what3words.com/sdk/v3/what3words.js?key=5WHIM4GD"></script>
    
    <script src="https://ha8tks.github.io/Leaflet.Maidenhead/src/L.Maidenhead.js"></script>
    
     <!-- ******************************** Load ESRI LEAFLET from CDN ******************************* -->
     <!-- Load Esri Leaflet from CDN -->
  
  <script
  src="https://unpkg.com/esri-leaflet@3.0.11/dist/esri-leaflet.js"
  integrity="sha512-qSE34Lz9JHdaPt3AZsi6L3dcqYHO9nnQEIxfrkgrRqqe+R0DPuAMu+j2vlb92zPka9O+XHZV4+9G5/rHT5ADsQ=="
  crossorigin=""></script>
 
  <script
  src="https://unpkg.com/esri-leaflet-vector@4.1.0/dist/esri-leaflet-vector.js"
  integrity="sha512-o4eWk+0ue3rnRHK50Sp5U3NbbkHZLJ89Ao/nH4f9ayMpasUwHVZfYqJC8hVYB2nriDxK+TFJ0UoAHPIaJn3UGA=="
  crossorigin=""></script>   
  
  <script
  src="https://unpkg.com/esri-leaflet-geocoder@3.1.4/dist/esri-leaflet-geocoder.js"
  integrity="sha512-ODcrBUbBplqiGXL2S0tWNVYStUTTWYyQcSrCLjIW8vL+CEb758m7Dm0v5vyl8qrT8stBwKaYVWZTGymf7vj9jg=="
  crossorigin=""></script>
  
    <!-- ******************************** What 3 Words *************************************** -->
  <script src="js/control.w3w.js"></script>
 
    <!-- circleKoords is the javascript program that calculates the number of rings and the distance between them -->
  <script src="js/circleKoords.js"></script>  
  
  <link
    rel="stylesheet"
    href="https://unpkg.com/esri-leaflet-geocoder@3.1.4/dist/esri-leaflet-geocoder.css"
    integrity="sha512-BkZKghR9DV2LpDgmb/Uvl8bdoQj9O6OkkgbfXVpFfHTGcrHGqJIk1J5t+ZY5E3peLfTBazzjScnBguwthKvC1g=="
    crossorigin="" />
    <!-- ******************************** End ESRI LEAFLET ***************************************** -->
     
     <!-- ******************************** Style Sheets *************************************** -->
    <link rel="stylesheet" href="css/leaflet_numbered_markers.css" />
    <link rel="stylesheet" href="css/L.Grid.css" />   

    <link rel="stylesheet" href="js/leaflet/leaflet.mouseCoordinate-master/dist/leaflet.mousecoordinate.css">
    <link rel="stylesheet" href="css/control.w3w.css" />
    
    <link rel="stylesheet" href="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.css" />
    <link rel="stylesheet" type="text/css" href="css/maps.css">  
    <link rel="stylesheet" type="text/css" href="css/leaflet/leaflet.contextmenu.min.css">
    
    <!-- override from leaflet.mousecoordinate.css -->
	<style>
		.leaflet-control-mouseCoordinate{
    		box-sizing: border-box;
    		background-color: rgba(255, 255, 255, 0.5);
    		top: 80%;
    		left: 10px;
    		width: auto;
    		padding-bottom: 40px;
        }
        
        .leaflet-container{
            line-height: 1;
        }
        
        .leaflet-control-w3w-locationText {
    	    position: fixed;
    		font-size: 14pt;
    		top: 93%;
    		left: 32px;  /* was 110 */
    		border: none;
		    text-decoration: none;
		    width: auto; /*30%;*/ 
		    background-color: inherit;
		    color: rgb(182,7,7);
		    
		}
		
		#extraButtons {
    		position: absolute;
            top: 100px;
            right: 10px;
            z-index: 1000;
    		font-weight: bold;
            
		}
		
		#toggleObjectLine {
    		background-color: #ff7d78;
    		display: none;
		}
		
		/* The toggle grid on/off button */
		#customToggleMaidenhead {
    		background-color: #ff7d78;
		}
		
		#Oactivity {
			text-align: center;
			color: red;
			font-weight: bold;
			font-size: 20pt;
			position: absolute;
			top: 10px;
			left: 10px;
			border: 2px solid green;
			
			background: transparent;
			padding-right: 10px;
			z-index: 1900;
		}
		
		/* Media query for screens with a maximum width of 600px */
        @media only screen and (max-width: 600px) {
        #Oactivity {
            font-size: 18pt; /* Adjust the font size for smaller screens */
            padding: 5px; /* Adjust padding for smaller screens */
        }
        @media only screen and (max-width: 600px) and (-webkit-min-device-pixel-ratio: 2) {
    /* Your styles for smaller screens */
        }}  /* End @media */
	</style>
	
</head>
<body>
    
    <!-- Buttons go here -->
    <div id="extraButtons">
        <button id="customToggleMaidenhead">Toggle Maidenhead Grid</button>
        <br>
        <button id="toggleObjectLine">Toggle Object Line</button>
    </div>

    <!-- the map div holds the map -->
    <div id="map"></div>
    
    <!-- the stations div holds a list of the stations marked on the map -->
    <!-- Under the banner in the upper left corner -->
    <div id="stations"> 
		<b style="color:red; text-decoration: underline;">
		    <?php echo "<b>$logrow[netcall]</b><br>$stationList";?>
	</div>

    <!-- The title banner -->
    <div id="Oactivity" class="Oactivity">
    	<img src="images/NCM.png" alt="NCM" style="width: 35px; padding-left: 10px; padding-top: 5px;">
    	<?php echo"$netcall Net #$logrow[netID] $logrow[activity] $logrow[logdate]" ?>
    </div>

</body>
<!-- Everything is inside a javascript, the script closing is near the end of the page -->
<script> 
        
// Button Function to toggle the visibility of the polyline
var objectLine;

function toggleObjectLine() {
    if (objectKoords.length > 0) {
        if (objectLine) {
            // Remove the current polyline if it exists
            objectLine.removeFrom(map);
            objectLine = null;
        } else {
            // Create and add the polyline to the map
            objectLine = L.polyline(objectKoords, { color: colorwheel[1], weight: 4 }).addTo(map);
        }
    }
}

// Begin handling of the toggleObjectLine stuff
// Example latitude and longitude values
var lat = 39.202170; 
var lng = -94.601830; 

// Initialize OBJMarkerList as a Leaflet layer group
var OBJMarkerList = L.layerGroup();

console.log(OBJMarkerList.getLayers());
console.log('@265');
//console.log('@262 OBJMarkerList '+JSON.stringify(OBJMarkerList));

// Add layers to OBJMarkerList (example)
//var marker = L.marker([lat, lng]).addTo(OBJMarkerList);

// Function to update button state
function updateButtonState() {
    var button = document.getElementById("toggleObjectLine");
    button.disabled = OBJMarkerList.getLayers().length === 0;
    button.style.display = OBJMarkerList.getLayers().length === 0 ? 'none' : 'block';
}

// Update button state initially
updateButtonState();

// Now you can use the code you provided
document.getElementById('toggleObjectLine').addEventListener('click', toggleObjectLine);

// End handling of the toggleObjectLine stuff
/////////////////////////////////////////////

// Define the beginning map
var map = L.map('map', {
	drawControl: true,
	zoom: 13,
	zoomAnimation: false,
	zoomOptions: { animate: false }
}); 


//https://github.com/ha8tks/Leaflet.Maidenhead
var maidenheadLayer = L.maidenhead({
  color: '#ff7d78'
});

// Add a button click event listener to toggle the Maidenhead layer
document.getElementById('customToggleMaidenhead').addEventListener('click', function () {
            // Toggle the visibility of the Maidenhead grid layer
            if (map.hasLayer(maidenheadLayer)) {
                map.removeLayer(maidenheadLayer);
            } else {
                maidenheadLayer.addTo(map);
            }
        });
	
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

	
	// Define the layers for the map	
	//From: https://esri.github.io/esri-leaflet/examples/switching-basemaps.html
	   
	   esriapi = <?php  echo getenv(esriapi); ?>  // api for esri maps
	   
	   //alert (esriapi);
          Community = L.esri.Vector.vectorBasemapLayer('ArcGIS:Community', {
            apikey: esriapi}).addTo(map),
          Streets   = L.esri.Vector.vectorBasemapLayer('OSM:Streets', {
            apikey: esriapi}).addTo(map),
          Topo      = L.esri.Vector.vectorBasemapLayer('ArcGIS:Topographic', {
            apikey: esriapi}).addTo(map),
          Imagery   = L.esri.Vector.vectorBasemapLayer('ArcGIS:Imagery', {
            apikey: esriapi}).addTo(map),
          Standard  = L.esri.Vector.vectorBasemapLayer('OSM:Standard', {
            apikey: esriapi}).addTo(map),
          Default  = L.esri.Vector.vectorBasemapLayer('OSM:StandardRelief', {
            apikey: esriapi}).addTo(map);
            
   
    const baseMaps = { "<span style='color: blue; font-weight: bold;'>Community": Community,
                       "<span style='color: blue; font-weight: bold;'>Streets": Streets,
                       "<span style='color: blue; font-weight: bold;'>Topo": Topo,
                       "<span style='color: blue; font-weight: bold;'>Imagery": Imagery,
                       "<span style='color: blue; font-weight: bold;'>Standard": Standard,
                       "<span style='color: blue; font-weight: bold;'>Default": Default                                
                     };
                     
                  
// =========  ADD Things to the Map ===============================================================
// ================================================================================================

    // Add what3words, shows w3w in a control
    var w = new L.Control.w3w();
	    w.addTo(map);
        map.on('click', function(e) {
		console.log(e);
		w.setCoordinates(e);
	});
                   
    
    //L.control.mousePosition({separator:',',position:'topright',prefix:''}).addTo(map);
    // https://github.com/PowerPan/leaflet.mouseCoordinate replaces mousePosition above
    L.control.mouseCoordinate({gpsLong:false,utm:true,qth:true,position:'bottomleft'}).addTo(map);
    
    // https://github.com/ppete2/Leaflet.PolylineMeasure
    // Position to show the control. Values: 'topright', 'topleft', 'bottomright', 'bottomleft'
    // Show imperial or metric distances. Values: 'metres', 'landmiles', 'nauticalmiles'           
    L.control.polylineMeasure ({position:'topright', unit:'landmiles', showBearings:true, clearMeasurementsOnStop: false, showClearControl: true, showUnitControl: true}).addTo (map);
    
    // Change the position of the Zoom Control to a created placeholder.
    map.zoomControl.setPosition('topright');
    
    // Define the Plus and Minus for zooming and its location
    // prevents the map from zooming with the mouse wheel
    map.scrollWheelZoom.disable();  
    
    // Distance scale 
    L.control.scale({position: 'bottomright'}).addTo(map);  
    
    // Adds a temp marker popup to show location of click
    var popup = L.popup();
        
    // Define a PoiIcon class for use by Points of Interest
    var PoiIconClass = L.Icon.extend({
        options: {
            iconSize: [32, 37]
        }
    });

    // Define a ObjIcon class for use by Objects from APRS or W3W
    var ObjIconClass = L.Icon.extend({
        options: {
            iconSize: [32, 37]
        }
    });
    
    // Adds a temp marker popup to show location of click
    //var popup = L.popup();
    function onMapClick(e) {
        popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at::<br>" + e.latlng.toString() + "<br>"   )
            .openOn(map);
    }
    
    map.on('click', onMapClick);

    // adds the lat/lon grid lines, read them on the top and on the left
    L.grid().addTo(map);  

    var arcgisOnline = L.esri.Geocoding.arcgisOnlineProvider();


    // Create some icons from the above PoiIconClass class and one from ObjIconClass
    var firstaidicon  = new PoiIconClass({iconUrl: 'images/markers/firstaid.png'}),
        eocicon       = new PoiIconClass({iconUrl: 'images/markers/eoc.png'}),
        policeicon    = new PoiIconClass({iconUrl: 'images/markers/police.png'}),
        sherifficon   = new PoiIconClass({iconUrl: 'images/markers/police.png'}),
        skywarnicon   = new PoiIconClass({iconUrl: 'images/markers/skywarn.png'}),
        fireicon      = new PoiIconClass({iconUrl: 'images/markers/fire.png'}),
        repeatericon  = new PoiIconClass({iconUrl: 'markers/repeater.png'}),
        govicon       = new PoiIconClass({iconUrl: 'markers/gov.png'}),
        townhallicon  = new PoiIconClass({iconUrl: 'markers/gov.png'}),
        rfhole        = new PoiIconClass({iconUrl: 'BRKMarkers/hole.svg'}),    
        objicon       = new ObjIconClass({iconURL: 'images/markers/marker00.png'}), //00 marker
        blueFlagicon  = new ObjIconClass({iconUrl: 'BRKMarkers/blue_flag.svg'}),
        greenFlagicon = new ObjIconClass({iconUrl: 'BRKMarkers/green_flag.svg'}),
        spotter       = new ObjIconClass({iconUrl: 'images/markers/skywarn2.png'}),
        siren         = new ObjIconClass({iconUrl: 'images/markers/siren.png'})
        ;
        
        
    
    // These are the markers that will appear on the map
    // Bring in the station and poi markers to appear on the map
    <?php
        echo ("$stationMarkers");   // All the checked in stations   
    ?>
    // Bring in the POI markers
    <?php
        echo ("$poiMarkers");       // The Points of Interest Markers
        echo ("$POIMarkerList");    // The poi Markers list
    ?>

    
    //=======================================================================
    //======================= Station Markers ===============================
    //=======================================================================
        
    var Stations = L.layerGroup([<?php echo "$callsignList"?>]);
    // WA0TJT,W0DLK,KD0NBH,KC0YT,AA0JX,AA0DV

    // Add the stationmarkers to the map
    Stations.addTo(map);
    
    // ???
    // I don't know what this does but without it the POI menu items don't show
    map.fitBounds([<?php echo "$fitBounds"?>]);

    var bounds = L.latLngBounds([<?php echo "$fitBounds"?>]);
        //console.log('fitBounds as bounds= '+JSON.stringify(bounds)); 

    // find the corners and middle of the stationmarkers
    var middle = bounds.getCenter();
        console.log('@496 middle: '+middle);
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
    // marker size was [220,220] 2024-01-12
    var mk1 = new L.marker(new L.latLng( sw ),{
        icon: L.icon({iconUrl: blackmarkername , iconSize: [50,50] }),
        title:'mk1'}).addTo(map).bindPopup('MK1<br>The SW Corner<br>'+sw).openPopup();
    
    var mk2 = new L.marker(new L.latLng( nw ),{
       icon: L.icon({iconUrl: blackmarkername , iconSize: [50,50] }),
       title:'mk2'}).addTo(map).bindPopup('MK2<br>The NW Corner<br>'+nw).openPopup();
    
    var mk3 = new L.marker(new L.latLng( ne ),{
       icon: L.icon({iconUrl: blackmarkername , iconSize: [50,50] }),
       title:'mk3'}).addTo(map).bindPopup('MK3<br>The NE Corner<br>'+ne).openPopup();
    
    var mk4 = new L.marker(new L.latLng( se ),{
       icon: L.icon({iconUrl: blackmarkername , iconSize: [50,50] }),
       title:'mk4'}).addTo(map).bindPopup('MK4<br>The SE Corner<br>'+se).openPopup();
	
    // Add the temp center marker to the map here in the javascript code allows it to use the current map view,
    // When its earlier in the stack, it centers on our house becaue that is the default map location
    var mk5 = new L.marker(new L.latLng( middle ),{
        contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
        text: 'Click here to add mileage circles', callback: circleKoords}],   
        icon: L.icon({iconUrl: blackmanInTheMiddle , iconSize: [225,225] }),     
        title:'mk5'}).addTo(map).bindPopup('MK5<br>The Center Marker<br>'+middle).openPopup();
    
    // Definition of the 5 markers above, corners plus middle    
     var CornerList = L.layerGroup([mk1, mk2, mk3, mk4, mk5]);
     
    //======================================================================
    // ================== End Station Marker Corners =======================
    //======================================================================
    
    
     //=================================================================================
    //================ APRS Like Object Marker Corners and all the Objects =============
    // ======= These are Objects created by APRS or W3W from the TimeLog table =========
    //====================== THERE MAY NOT BE ANY TO REPORT ============================
    
    // find the corners and middle of the stationmarkers
    var objMiddle = bounds.getCenter(); 
        console.log('@551 objMiddle: '+ objMiddle);
    var padit  = bounds.pad(.075);   // add a little bit to the corner bounding box
    var objsw = padit.getSouthWest();   // get the SouthWest most point
    var objnw = padit.getNorthWest();
    var objne = padit.getNorthEast();
    var objse = padit.getSouthEast();
    
    <?php   
           echo "$objBounds" ;
           echo "$objMiddle" ;
           echo "$objPadit";
    
    // Object markers here
     echo "$objMarkers"; 
    
    // Corner and center flags for the object markers, 5 for each callsign that has objects
    echo "$cornerMarkers"; 

    // Object Marker List starts here
     echo "$OBJMarkerList"; 
     
      // uniqueCallList is needed to so we can count how many color changes we need, always < 8
     echo "$uniqueCallList";
        
    ?>

    // Add the OBJMarkerList to the map
    OBJMarkerList.addTo(map);
       
    // The colorwheel changes the ring color when multiple rings are used
    const newColor = "";
    const colorwheel = ["#00f900","#932092","#ff9200","#00fcff","#98989d","#fefb00","#000000","#ff2600"];
             
    const style = (feature) => {
        for (i = 0; i < uniqueCallList.length; i++) {
            newColor = colorwheel[i];
        		return {
        			color: colorwheel[i],
        			weight: 3,
        			opacity: 2, 
        		};
        }  // end for loop
    } // end of style 
        
    //console.log('@530 OBJMarkerList= '+JSON.stringify(OBJMarkerList));    
    //console.log('@230 in connectTheDots function '+JSON.stringify(data));
    // Add connecting lines between the object markers           
          var objectKoords = connectTheDots(OBJMarkerList);  
                console.log('@539 objectKoords= '+objectKoords);
/* the OBJMarkerList

    */
             objectLine = L.polyline(objectKoords,{color: colorwheel[1], weight: 4}).addTo(map);

    
    //====================================================================== 
    //====================== Points of Interest ============================
    //======================================================================   
    //====================== THERE MAY NOT BE ANY TO REPORT ================
        
    // was classList now classNames to avoid a JS conflict of names
    // The classNames is the list of POI types.
     var classNames = '<?php echo "$classNames CornerL, ObjectL;"; ?>'.split(',');
       console.log('In map.php classNames= '+classNames);
    
     let station = {"<img src='markers/green_marker_hole.png' class='greenmarker' alt='green_marker_hole' align='middle' /><span class='biggreenmarker'> Stations</span>": Stations};

     // The values i.e. aviationList, federalList ... are created in the poiMarkers.php @ about line 66 but it appears not all are being picked up
    
     const classMap = {};
     var y = {};
    
    // Helper function to add the category to the classMap if the variable exists
    function addToClassMap(category, variable, imageName) {
        //console.log(category + variable + imageName);
      if (window.hasOwnProperty(variable)) {
        classMap[category] = {
          [`<img src='images/markers/${imageName}' width='32' align='middle' /> <span class='${category}'>
          ${category}</span>`]: window[variable],
        };
      }
    } // End addToClassMap function
    
    // Call the helper function for each category
    addToClassMap('aviationL',  'aviationList', 'aviation.png');
    addToClassMap('eocL',       'eocList',      'eoc.png');
    addToClassMap('fireL',      'fireList',     'fire.png');
    addToClassMap('hospitalL',  'hospitalList', 'firstaid.png');
    addToClassMap('policeL',    'policeList',   'police.png');
    addToClassMap('repeaterL',  'repeaterList', 'repeater.png');
    addToClassMap('rfholeL',    'rfholeList',   'hole.svg');
    addToClassMap('sheriffL',   'sheriffList',  'police.png');
    addToClassMap('stateL',     'stateList',    'gov.png');
    
    addToClassMap('chpL',       'chpList',      'police.png');
    addToClassMap('federalL',   'federalList',  'gov.png');
    addToClassMap('skywarnL',   'skywarnList',  'skywarn.png');
    addToClassMap('spotterL',   'skywarnList',  'skywarn2.png');
    addToClassMap('sirenL',     'sirenList',    'siren.png');
    addToClassMap('townhallL',  'townhallList', 'gov.png');
    
    addToClassMap('objectsL',   'ObjectList',   'marker00.png');
    addToClassMap('cornersL',   'CornerList',   'red_50_flag.png');
    
    //console.log('ObjectL List:', classMap);
        
    // Loop through classNames and assign the corresponding object to y
    for (x of classNames) {
      if (classMap.hasOwnProperty(x)) {
        Object.assign(y, classMap[x]);
      }
    }
    
    //console.log('ObjectL List:', y);
    
    // Here we add the station object with the merged y objects from above
    var overlayMaps = Object.assign({}, y);

    // This must stay here to properly display on the map
    // The collapsed: true makes the POI's compress into a 'Markers' icon
    L.control.layers(baseMaps, overlayMaps, {position:'bottomright', collapsed:true}).addTo(map);
    
    //====================== End Points of Interest ============================
    
    
   $('.leaflet-control-attribution').hide()
    
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
        
    // This function can be used to connect the object markers together with a line
// Object markers come from the TimeLog unlike the rest that come from NetLog
function connectTheDots(data){
    var c = [];
    for(i in data._layers) {
        var x = data._layers[i]._latlng.lat;
        var y = data._layers[i]._latlng.lng;
        c.push([x, y]);
    }
    return c;
} 


</script>   <!-- End of javascript holding the map stuff -->


</html>
