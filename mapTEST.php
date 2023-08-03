<!DOCTYPE html>

<!-- Leaflet is the primary mapping used here:
    Primary maping program, also uses poiMarkers.php, objMarkers.php and stationMarkers.php -->

<!-- This version 2021-10-16 -->


  
<html lang="en">
<head>
	<title>NCM Map of Station Locations</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" >
	<link rel="shortcut icon" type="image/x-icon" href="favicons/apple-icon.png">

     <!-- ******************************** Load LEAFLET from CDN *********************************** -->
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
     <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
     <!-- ********************************* End Load LEAFLET **************************************** -->
     
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
    <!-- Various additional Leaflet javascripts -->
    <script src="js/leaflet_numbered_markers.js"></script>
    <script src="js/L.Grid.js"></script>                    <!-- https://github.com/jieter/Leaflet.Grid -->
    <!-- <script src="js/geolet.js"></script> -->
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
    <!-- ******************************** End ESRI LEAFLET ***************************************** -->
     
     <!-- ******************************** Style Sheets *************************************** -->
    <link rel="stylesheet" href="css/leaflet_numbered_markers.css" />
    <link rel="stylesheet" href="css/L.Grid.css" />   
    <!--<link rel="stylesheet" href="css/L.Control.MousePosition.css" /> -->
    <link rel="stylesheet" href="js/leaflet/leaflet.mouseCoordinate-master/dist/leaflet.mousecoordinate.css">
    <link rel="stylesheet" href="css/control.w3w.css" />
    
    <link rel="stylesheet" href="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.css" />
    <link rel="stylesheet" type="text/css" href="css/maps.css">  
    <link rel="stylesheet" type="text/css" href="css/leaflet/leaflet.contextmenu.min.css">
    
        
    <!-- What 3 Words -->
    <script src="js/control.w3w.js"></script>

    
    <!-- circleKoords is the javascript program that caluclates the number of rings and the distance between them -->
    <script src="js/circleKoords.js"></script>    
    
    <!-- override from leaflet.mousecoordinate.css -->
	<style>
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
    	/*	position: fixed; */
    	    position: fixed;
    		font-size: 14pt;
    	/*	top: 275px;
    		right: 17px; */
    	/*	bottom: 475px; */
    		
    		top: 94%;
    		left: 32px;  /* was 110 */
    		border: none;
    	/*	border: 1px solid #8AC007; */
		/*    z-index: 400; */
		    text-decoration: none;
		/*    background-color: white; */
		    width: 30%; 
		    background-color: inherit;
		    color: rgb(182,7,7);
		    
		}
	</style>
	
	<!-- Experiment to add beautifyl markers -->
	<!--
    <link rel="stylesheet"BeautifyMarker-master/leaflet/fontawesome.min.css" />"
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="BeautifyMarker-master/leaflet-beautify-marker-icon.css" />
    <script src="BeautifyMarker-master/leaflet-beautify-marker-icon.js"></script>
    -->

	
</head>

<body>
    
    <!-- the map div holds the map -->
    <div id="map"></div>
    
    <!-- the stations div holds a list of the stations marked on the map -->
    <!-- Under the banner in the upper left corner -->
    <div id="stations"> 
		<b style="color:red; text-decoration: underline;">
		    <b>W0KCN</b><br><a class='rowno' id='marker_1' href='#'>1 _KD0NBH</a><br><a class='rowno' id='marker_2' href='#'>2 _AA0DV</a><br><a class='rowno' id='marker_3' href='#'>3 _K0RGB</a><br><a class='rowno' id='marker_4' href='#'>4 _W4XJ</a><br><a class='rowno' id='marker_5' href='#'>5 _WA0TJT</a><br><a class='rowno' id='marker_6' href='#'>6 _KE0UXE</a><br><a class='rowno' id='marker_7' href='#'>7 _KF0MEZ</a><br><a class='rowno' id='marker_8' href='#'>8 _N0SMC</a><br><a class='rowno' id='marker_9' href='#'>9 _AB0GD</a><br><a class='rowno' id='marker_10' href='#'>10 _KF0DFC</a><br><a class='rowno' id='marker_11' href='#'>11 _N0UYN</a><br><a class='rowno' id='marker_12' href='#'>12 _N0BKE</a><br><a class='rowno' id='marker_13' href='#'>13 _KF0BQY</a><br><a class='rowno' id='marker_14' href='#'>14 _WY0O</a><br><a class='rowno' id='marker_15' href='#'>15 _KA0OTL</a><br><a class='rowno' id='marker_16' href='#'>16 _K0KEX</a><br>	</div>

    <!-- The title banner -->
    <div id="activity" class="activity">
    	<img src="images/NCM.png" alt="NCM" style="width: 35px; padding-left: 10px; padding-top: 5px;">
    	W0KCN Net #9630 KCNARES Weather     </div>
    

<!-- Everything is inside a javascript, the script closing is near the end of the page -->
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

    
// Define the map
var map = L.map('map', {
	drawControl: true,
	zoom: 12
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
	
	//https://esri.github.io/esri-leaflet/examples/switching-basemaps.html
	   
	   esriapi = 'AAPKc202b5ca82cc46b1a95e2fa42efb35acYCUwyelUFSlSEASOJOTcP2Ehjyha8cRtVfncLMglNftid1dxaVFxkDTxJgG_UxEB'  // api for esri maps
	   
	   //alert (esriapi);
          //Community = L.esri.Vector.vectorBasemapLayer('ArcGIS:Community', {
            //apikey: esriapi}).addTo(map),
          Streets   = L.esri.Vector.vectorBasemapLayer('OSM:Streets', {
            //apikey: esriapi}).addTo(map),
          //Imagery   = L.esri.Vector.vectorBasemapLayer('ArcGIS:Imagery', {
            //apikey: esriapi}).addTo(map),
          //Topo      = L.esri.Vector.vectorBasemapLayer('ArcGIS:Topographic', {
            apikey: esriapi}).addTo(map),
          Standard  = L.esri.Vector.vectorBasemapLayer('OSM:StandardRelief', {
            apikey: esriapi}).addTo(map),
          Default  = L.esri.Vector.vectorBasemapLayer('OSM:StandardRelief', {
            apikey: esriapi}).addTo(map);
            
            // the L.esri.Vector.vectorBasemapLayer basemap enum defaults to 'ArcGIS:Streets' if omitted
 // vectorTiles.Default = L.esri.Vector.vectorBasemapLayer(null, {
  //  apiKey
  //});
   
    const baseMaps = {  
                       "<span style='color: blue; font-weight: bold;'>Streets": Streets,
                       "<span style='color: blue; font-weight: bold;'>Standard": Standard,
                       "<span style='color: blue; font-weight: bold;'>Default": Default                                
                     };
                     
                  
// =========  ADD Things to the Map ===============================================================

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
    
    // Change the position of the Zoom Control to a newly created placeholder.
    map.zoomControl.setPosition('topright');
    // Define the Plus and Minus for zooming and its location
    map.scrollWheelZoom.disable();  // prevents the map from zooming with the mouse wheel
    
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
            .setContent("You clicked the map at:<br>" + e.latlng.toString() + "<br>"   )
            .openOn(map);
    }
    
    map.on('click', onMapClick);

    // adds the lat/lon grid lines, read them on the top and on the left
    L.grid().addTo(map);  
    
    // https://github.com/rhlt/leaflet-geolet
    //L.geolet({ position: 'bottomleft' }).addTo(map);
    

    var arcgisOnline = L.esri.Geocoding.arcgisOnlineProvider();


    // Create some icons from the above PoiIconClass class and one from ObjIconClass
    var firstaidicon  = new PoiIconClass({iconUrl: 'images/markers/firstaid.png'}),
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
        
    
    // These are the markers that will appear on the map
    // Bring in the station markers to appear on the map
    
			var _KD0NBH = new L.marker(new L.latLng(39.2154688,-94.599025),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedDivIcon({number: '1' }),
				title:`marker_1` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>1<br><b>Tactical: NBH<br>KD0NBH</b><br> ID: #001812<br>John Britton<br>Clay Co., MO Dist: A<br>39.2154688, -94.599025<br>EM29QF<br><a href='https://what3words.com/workflow.ships.derivative?maptype=osm' target='_blank'>///workflow.ships.derivative</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2154688&lon=-94.599025&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_KD0NBH`._icon).addClass(`bluemrkr`);
                stationMarkers.push(_KD0NBH);
				
			var _AA0DV = new L.marker(new L.latLng(39.2628465,-94.569978),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '2' }),
				title:`marker_2` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>2<br><b>Tactical: DV<br>AA0DV</b><br> ID: #000003<br>Everett Jenkins<br>Clay Co., MO Dist: G<br>39.2628465, -94.569978<br>EM29RG<br><a href='https://what3words.com/thankfully.sweetened.remains?maptype=osm' target='_blank'>///thankfully.sweetened.remains</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2628465&lon=-94.569978&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_AA0DV`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_AA0DV);
				
			var _K0RGB = new L.marker(new L.latLng(39.4172253,-94.568527),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '3' }),
				title:`marker_3` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>3<br><b>Tactical: RGB<br>K0RGB</b><br> ID: #004898<br>Russ Bryan<br>Clay  Co., MO Dist: G<br>39.4172253, -94.568527<br>EM29RK<br><a href='https://what3words.com/billiard.distort.rails?maptype=osm' target='_blank'>///billiard.distort.rails</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.4172253&lon=-94.568527&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_K0RGB`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_K0RGB);
				
			var _W4XJ = new L.marker(new L.latLng(39.2148975,-94.633957),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '4' }),
				title:`marker_4` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>4<br><b>Tactical: XJ<br>W4XJ</b><br> ID: #002648<br>Randy Sly<br>Platte  Co., MO Dist: A<br>39.2148975, -94.633957<br>EM29QF<br><a href='https://what3words.com/unintended.jeeps.panel?maptype=osm' target='_blank'>///unintended.jeeps.panel</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2148975&lon=-94.633957&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_W4XJ`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_W4XJ);
				
			var _WA0TJT = new L.marker(new L.latLng(39.2028965,-94.602876),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedDivIcon({number: '5' }),
				title:`marker_5` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>5<br><b>Tactical: TJT<br>WA0TJT</b><br> ID: #000013<br>Keith Kaiser<br>Platte  Co., MO Dist: A<br>39.2028965, -94.602876<br>EM29QE<br><a href='https://what3words.com/guiding.confusion.towards?maptype=osm' target='_blank'>///guiding.confusion.towards</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2028965&lon=-94.602876&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_WA0TJT`._icon).addClass(`bluemrkr`);
                stationMarkers.push(_WA0TJT);
				
			var _KE0UXE = new L.marker(new L.latLng(39.4244507,-94.896258),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '6' }),
				title:`marker_6` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>6<br><b>Tactical: UXE<br>KE0UXE</b><br> ID: #000950<br>Dave Garrison<br>Platte Co., MO Dist: A<br>39.4244507, -94.896258<br>EM29NK<br><a href='https://what3words.com/affirms.redefined.whiplash?maptype=osm' target='_blank'>///affirms.redefined.whiplash</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.4244507&lon=-94.896258&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_KE0UXE`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_KE0UXE);
				
			var _KF0MEZ = new L.marker(new L.latLng(39.21816,-94.7307),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '7' }),
				title:`marker_7` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>7<br><b>Tactical: MEZ<br>KF0MEZ</b><br> ID: #039024<br>Bob Ebb<br>Platte Co., MO Dist: A<br>39.21816, -94.7307<br>EM29PF<br><a href='https://what3words.com/ingredients.settle.wept?maptype=osm' target='_blank'>///ingredients.settle.wept</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.21816&lon=-94.7307&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_KF0MEZ`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_KF0MEZ);
				
			var _N0SMC = new L.marker(new L.latLng(39.2519092,-94.571180),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '8' }),
				title:`marker_8` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>8<br><b>Tactical: SMC<br>N0SMC</b><br> ID: #000901<br>Jose Lopez<br>Clay Co., MO Dist: G<br>39.2519092, -94.571180<br>EM29rg10<br><a href='https://what3words.com/scandalous.acquaint.evaded?maptype=osm' target='_blank'>///scandalous.acquaint.evaded</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2519092&lon=-94.571180&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_N0SMC`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_N0SMC);
				
			var _AB0GD = new L.marker(new L.latLng(39.3476289,-94.768086),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '9' }),
				title:`marker_9` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>9<br><b>Tactical: GD<br>AB0GD</b><br> ID: #000079<br>Gregg Duryea<br>Platte  Co., MO Dist: A<br>39.3476289, -94.768086<br>EM29OI<br><a href='https://what3words.com/enjoyable.chains.square?maptype=osm' target='_blank'>///enjoyable.chains.square</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.3476289&lon=-94.768086&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_AB0GD`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_AB0GD);
				
			var _KF0DFC = new L.marker(new L.latLng(39.0815025,-94.582671),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '10' }),
				title:`marker_10` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>10<br><b>Tactical: DFC<br>KF0DFC</b><br> ID: #003586<br>John Jespersen<br>Jackson  Co., MO Dist: A<br>39.0815025, -94.582671<br>EM29RB<br><a href='https://what3words.com/device.formed.round?maptype=osm' target='_blank'>///device.formed.round</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.0815025&lon=-94.582671&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_KF0DFC`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_KF0DFC);
				
			var _N0UYN = new L.marker(new L.latLng(39.2762919,-94.582776),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '11' }),
				title:`marker_11` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>11<br><b>Tactical: UYN<br>N0UYN</b><br> ID: #000005<br>Dennis Crawford<br>Clay Co., MO Dist: G<br>39.2762919, -94.582776<br>EM29RG<br><a href='https://what3words.com/planet.overall.giggled?maptype=osm' target='_blank'>///planet.overall.giggled</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2762919&lon=-94.582776&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_N0UYN`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_N0UYN);
				
			var _N0BKE = new L.marker(new L.latLng(39.220224,-94.518254),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '12' }),
				title:`marker_12` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>12<br><b>Tactical: BKE<br>N0BKE</b><br> ID: #000006<br>Mark Dickerson<br>Clay Co., MO Dist: G<br>39.220224, -94.518254<br>EM29RF<br><a href='https://what3words.com/sockets.charity.submerge?maptype=osm' target='_blank'>///sockets.charity.submerge</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.220224&lon=-94.518254&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_N0BKE`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_N0BKE);
				
			var _KF0BQY = new L.marker(new L.latLng(39.4763031,-94.340813),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '13' }),
				title:`marker_13` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>13<br><b>Tactical: BQY<br>KF0BQY</b><br> ID: #003004<br>Brian Hansen<br>Clinton Co., MO Dist: H<br>39.4763031, -94.340813<br>EM29TL<br><a href='https://what3words.com/laundry.monks.conforms?maptype=osm' target='_blank'>///laundry.monks.conforms</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.4763031&lon=-94.340813&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_KF0BQY`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_KF0BQY);
				
			var _WY0O = new L.marker(new L.latLng(39.3582891,-94.638113),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '14' }),
				title:`marker_14` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>14<br><b>Tactical: O<br>WY0O</b><br> ID: #010076<br>Nick Foster<br>Platte  Co., MO Dist: <br>39.3582891, -94.638113<br>EM29QI<br><a href='https://what3words.com/acutely.pundits.adopts?maptype=osm' target='_blank'>///acutely.pundits.adopts</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.3582891&lon=-94.638113&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_WY0O`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_WY0O);
				
			var _KA0OTL = new L.marker(new L.latLng(39.233196,-94.642213),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedDivIcon({number: '15' }),
				title:`marker_15` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>15<br><b>Tactical: W0KCN<br>KA0OTL</b><br> ID: #000025<br>Jeff Libby<br>Platte Co., MO Dist: A<br>39.233196, -94.642213<br>EM29QF<br><a href='https://what3words.com/protester.hopeful.splits?maptype=osm' target='_blank'>///protester.hopeful.splits</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.233196&lon=-94.642213&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_KA0OTL`._icon).addClass(`bluemrkr`);
                stationMarkers.push(_KA0OTL);
				
			var _K0KEX = new L.marker(new L.latLng(39.4197989,-94.658092),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '16' }),
				title:`marker_16` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>16<br><b>Tactical: KEX<br>K0KEX</b><br> ID: #000029<br>Rick Smith<br>Platte  Co., MO Dist: A<br>39.4197989, -94.658092<br>EM29QK<br><a href='https://what3words.com/hers.parrot.legions?maptype=osm' target='_blank'>///hers.parrot.legions</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.4197989&lon=-94.658092&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_K0KEX`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_K0KEX);
			;

            var NWS240 = new L.marker(new L.LatLng(40.81001,-124.15964),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'NWS240 National Weather Service  Amatuer Radio Station 40.81001,-124.15964' ,
                    }).addTo(fg).bindPopup('NWS240 National Weather Service  Amatuer Radio Station 40.81001,-124.15964' );                        
         
                $('amatuer radio station'._icon).addClass('flagmrkr');
            
            var MCI = new L.marker(new L.LatLng(39.3003,-94.72721),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/aviation.png', iconSize: [32, 34]}),
                title: 'MCI Kansas City International Airport   39.3003,-94.72721' ,
                    }).addTo(fg).bindPopup('MCI Kansas City International Airport   39.3003,-94.72721' );                        
         
                $('aviation'._icon).addClass('aviationmrkr');
            
            var KCI = new L.marker(new L.LatLng(39.12051,-94.59077),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/aviation.png', iconSize: [32, 34]}),
                title: 'KCI Charles B Wheeler Downtown Airport   39.12051,-94.59077' ,
                    }).addTo(fg).bindPopup('KCI Charles B Wheeler Downtown Airport   39.12051,-94.59077' );                        
         
                $('aviation'._icon).addClass('aviationmrkr');
            
            var PTIACPT = new L.marker(new L.LatLng(48.053802,-122.810628),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/aviation.png', iconSize: [32, 34]}),
                title: 'PTIACPT PT Intl Airport Cutoff   48.053802,-122.810628' ,
                    }).addTo(fg).bindPopup('PTIACPT PT Intl Airport Cutoff   48.053802,-122.810628' );                        
         
                $('aviation'._icon).addClass('aviationmrkr');
            
            var HMSPH = new L.marker(new L.LatLng(48.034632,-122.775006),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/aviation.png', iconSize: [32, 34]}),
                title: 'HMSPH Hadlock Mason St   48.034632,-122.775006' ,
                    }).addTo(fg).bindPopup('HMSPH Hadlock Mason St   48.034632,-122.775006' );                        
         
                $('aviation'._icon).addClass('aviationmrkr');
            
            var SVBPT = new L.marker(new L.LatLng(48.077025,-122.840721),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/aviation.png', iconSize: [32, 34]}),
                title: 'SVBPT Sky Valley   48.077025,-122.840721' ,
                    }).addTo(fg).bindPopup('SVBPT Sky Valley   48.077025,-122.840721' );                        
         
                $('aviation'._icon).addClass('aviationmrkr');
            
            var RAAB = new L.marker(new L.LatLng(40.5555,-124.13204),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'RAAB Rohnerville Air Attack Base  Cal Fire Fixed Wing Air Attack Base 40.5555,-124.13204' ,
                    }).addTo(fg).bindPopup('RAAB Rohnerville Air Attack Base  Cal Fire Fixed Wing Air Attack Base 40.5555,-124.13204' );                        
         
                $('cal fire fixed wing air attack base'._icon).addClass('flagmrkr');
            
            var WA0KHP = new L.marker(new L.LatLng(39.36392,-94.584721),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'WA0KHP Clay Co Repeater Club / KC Northland ARES Repeater (146.79Mhz T:107.2 )  Clay Co. Repeater Club 39.36392,-94.584721' ,
                    }).addTo(fg).bindPopup('WA0KHP Clay Co Repeater Club / KC Northland ARES Repeater (146.79Mhz T:107.2 )  Clay Co. Repeater Club 39.36392,-94.584721' );                        
         
                $('clay co. repeater club'._icon).addClass('flagmrkr');
            
            var W0KCN4 = new L.marker(new L.LatLng(39.3721733,-94.780929),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/eoc.png', iconSize: [32, 34]}),
                title: 'W0KCN4 Northland ARES Platte Co. EOC   39.3721733,-94.780929' ,
                    }).addTo(fg).bindPopup('W0KCN4 Northland ARES Platte Co. EOC   39.3721733,-94.780929' );                        
         
                $('eoc'._icon).addClass('eocmrkr');
            
            var W0KCN3 = new L.marker(new L.LatLng(39.2859182,-94.667236),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/eoc.png', iconSize: [32, 34]}),
                title: 'W0KCN3 Northland ARES Platte Co. Resource Center   39.2859182,-94.667236' ,
                    }).addTo(fg).bindPopup('W0KCN3 Northland ARES Platte Co. Resource Center   39.2859182,-94.667236' );                        
         
                $('eoc'._icon).addClass('eocmrkr');
            
            var FIRE15256 = new L.marker(new L.LatLng(48.102685,-122.825696),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FIRE15256 Fire15   48.102685,-122.825696' ,
                    }).addTo(fg).bindPopup('FIRE15256 Fire15   48.102685,-122.825696' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGOBER = new L.marker(new L.LatLng(50.512222,6.465568),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGOBER Gerätehaus Oberhausen   50.512222,6.465568' ,
                    }).addTo(fg).bindPopup('LGOBER Gerätehaus Oberhausen   50.512222,6.465568' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FIRE16257 = new L.marker(new L.LatLng(48.116172,-122.764327),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FIRE16257 Fire16   48.116172,-122.764327' ,
                    }).addTo(fg).bindPopup('FIRE16257 Fire16   48.116172,-122.764327' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGHARP = new L.marker(new L.LatLng(50.518637,6.406335),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGHARP Gerätehaus Harperscheid   50.518637,6.406335' ,
                    }).addTo(fg).bindPopup('LGHARP Gerätehaus Harperscheid   50.518637,6.406335' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGDREI = new L.marker(new L.LatLng(50.542354,6.405359),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGDREI Gerätehaus Dreiborn   50.542354,6.405359' ,
                    }).addTo(fg).bindPopup('LGDREI Gerätehaus Dreiborn   50.542354,6.405359' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGWAL = new L.marker(new L.LatLng(50.71185,6.180236),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGWAL Gerätehaus Wahlhem   50.71185,6.180236' ,
                    }).addTo(fg).bindPopup('LGWAL Gerätehaus Wahlhem   50.71185,6.180236' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGOBER = new L.marker(new L.LatLng(50.72883,6.174868),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGOBER Gerätehaus Kornelimuenster   50.72883,6.174868' ,
                    }).addTo(fg).bindPopup('LGOBER Gerätehaus Kornelimuenster   50.72883,6.174868' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGMAUS = new L.marker(new L.LatLng(50.755673,6.281836),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGMAUS Gerätehaus Mausbach   50.755673,6.281836' ,
                    }).addTo(fg).bindPopup('LGMAUS Gerätehaus Mausbach   50.755673,6.281836' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGIMGE = new L.marker(new L.LatLng(50.577741,6.263472),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGIMGE Gerätehaus Imgenbroich   50.577741,6.263472' ,
                    }).addTo(fg).bindPopup('LGIMGE Gerätehaus Imgenbroich   50.577741,6.263472' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGMALT = new L.marker(new L.LatLng(50.553727,6.241281),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGMALT Gerätehaus Monschau   50.553727,6.241281' ,
                    }).addTo(fg).bindPopup('LGMALT Gerätehaus Monschau   50.553727,6.241281' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGPUFF = new L.marker(new L.LatLng(50.938861,6.212034),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGPUFF Gerätehaus Puffendorf   50.938861,6.212034' ,
                    }).addTo(fg).bindPopup('LGPUFF Gerätehaus Puffendorf   50.938861,6.212034' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGLOVE = new L.marker(new L.LatLng(50.933525,6.187821),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGLOVE Gerätehaus Loverich   50.933525,6.187821' ,
                    }).addTo(fg).bindPopup('LGLOVE Gerätehaus Loverich   50.933525,6.187821' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBEGG = new L.marker(new L.LatLng(50.926302,6.169567),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBEGG Gerätehaus Beggendorf   50.926302,6.169567' ,
                    }).addTo(fg).bindPopup('LGBEGG Gerätehaus Beggendorf   50.926302,6.169567' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var W0KCN15 = new L.marker(new L.LatLng(39.363954,-94.584749),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'W0KCN15 Northland ARES Clay Co. Fire Station #2   39.363954,-94.584749' ,
                    }).addTo(fg).bindPopup('W0KCN15 Northland ARES Clay Co. Fire Station #2   39.363954,-94.584749' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RVRSDEFD = new L.marker(new L.LatLng(39.175757,-94.616012),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RVRSDEFD Riverside, MO City Fire Department   39.175757,-94.616012' ,
                    }).addTo(fg).bindPopup('RVRSDEFD Riverside, MO City Fire Department   39.175757,-94.616012' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var BRVRCOFR29 = new L.marker(new L.LatLng(28.431189,-80.805377),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'BRVRCOFR29 Brevard County Fire Rescue Station 29   28.431189,-80.805377' ,
                    }).addTo(fg).bindPopup('BRVRCOFR29 Brevard County Fire Rescue Station 29   28.431189,-80.805377' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var TFESS12 = new L.marker(new L.LatLng(28.589587,-80.831269),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'TFESS12 Titusville Fire & Emergency Services Station 12   28.589587,-80.831269' ,
                    }).addTo(fg).bindPopup('TFESS12 Titusville Fire & Emergency Services Station 12   28.589587,-80.831269' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var GNSVFS1 = new L.marker(new L.LatLng(34.290941,-83.826461),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'GNSVFS1 Gainesville Fire Station 1   34.290941,-83.826461' ,
                    }).addTo(fg).bindPopup('GNSVFS1 Gainesville Fire Station 1   34.290941,-83.826461' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS1 = new L.marker(new L.LatLng(38.84544806200006,-94.55557100699997),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS1 KCMO Fire Station No. 1   38.84544806200006,-94.55557100699997' ,
                    }).addTo(fg).bindPopup('KCMOFS1 KCMO Fire Station No. 1   38.84544806200006,-94.55557100699997' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS3 = new L.marker(new L.LatLng(39.29502746500003,-94.57483520999995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS3 KCMO Fire Station No. 3   39.29502746500003,-94.57483520999995' ,
                    }).addTo(fg).bindPopup('KCMOFS3 KCMO Fire Station No. 3   39.29502746500003,-94.57483520999995' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS4 = new L.marker(new L.LatLng(39.21082648400005,-94.62698133999999),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS4 KCMO Fire Station No. 4   39.21082648400005,-94.62698133999999' ,
                    }).addTo(fg).bindPopup('KCMOFS4 KCMO Fire Station No. 4   39.21082648400005,-94.62698133999999' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS5 = new L.marker(new L.LatLng(39.29465245500006,-94.72458748899999),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS5 KCMO Fire Station No. 5   39.29465245500006,-94.72458748899999' ,
                    }).addTo(fg).bindPopup('KCMOFS5 KCMO Fire Station No. 5   39.29465245500006,-94.72458748899999' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS6 = new L.marker(new L.LatLng(39.164872338000066,-94.54946718099995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS6 KCMO Fire Station No. 6   39.164872338000066,-94.54946718099995' ,
                    }).addTo(fg).bindPopup('KCMOFS6 KCMO Fire Station No. 6   39.164872338000066,-94.54946718099995' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS7 = new L.marker(new L.LatLng(39.088027072000045,-94.59222542099997),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS7 KCMO Fire Station No. 7   39.088027072000045,-94.59222542099997' ,
                    }).addTo(fg).bindPopup('KCMOFS7 KCMO Fire Station No. 7   39.088027072000045,-94.59222542099997' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS8 = new L.marker(new L.LatLng(39.09503169800007,-94.57740912999998),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS8 KCMO Fire Station No. 8   39.09503169800007,-94.57740912999998' ,
                    }).addTo(fg).bindPopup('KCMOFS8 KCMO Fire Station No. 8   39.09503169800007,-94.57740912999998' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS10 = new L.marker(new L.LatLng(39.10270070000007,-94.56220495299999),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS10 KCMO Fire Station No. 10   39.10270070000007,-94.56220495299999' ,
                    }).addTo(fg).bindPopup('KCMOFS10 KCMO Fire Station No. 10   39.10270070000007,-94.56220495299999' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS16 = new L.marker(new L.LatLng(39.29508854300008,-94.68790113199998),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS16 KCMO Fire Station No. 16   39.29508854300008,-94.68790113199998' ,
                    }).addTo(fg).bindPopup('KCMOFS16 KCMO Fire Station No. 16   39.29508854300008,-94.68790113199998' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS17 = new L.marker(new L.LatLng(39.06448674100005,-94.56659040899996),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS17 KCMO Fire Station No. 17   39.06448674100005,-94.56659040899996' ,
                    }).addTo(fg).bindPopup('KCMOFS17 KCMO Fire Station No. 17   39.06448674100005,-94.56659040899996' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS18 = new L.marker(new L.LatLng(39.068426627000065,-94.54306673199994),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS18 KCMO Fire Station No. 18   39.068426627000065,-94.54306673199994' ,
                    }).addTo(fg).bindPopup('KCMOFS18 KCMO Fire Station No. 18   39.068426627000065,-94.54306673199994' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS19 = new L.marker(new L.LatLng(39.04970557900003,-94.59317453799997),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS19 KCMO Fire Station No. 19   39.04970557900003,-94.59317453799997' ,
                    }).addTo(fg).bindPopup('KCMOFS19 KCMO Fire Station No. 19   39.04970557900003,-94.59317453799997' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS23 = new L.marker(new L.LatLng(39.10519819800004,-94.52673633999996),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS23 KCMO Fire Station No. 23   39.10519819800004,-94.52673633999996' ,
                    }).addTo(fg).bindPopup('KCMOFS23 KCMO Fire Station No. 23   39.10519819800004,-94.52673633999996' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS24 = new L.marker(new L.LatLng(39.08534478900003,-94.51940024199996),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS24 KCMO Fire Station No. 24   39.08534478900003,-94.51940024199996' ,
                    }).addTo(fg).bindPopup('KCMOFS24 KCMO Fire Station No. 24   39.08534478900003,-94.51940024199996' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS25 = new L.marker(new L.LatLng(39.10791790600007,-94.57838314599996),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS25 KCMO Fire Station No. 25   39.10791790600007,-94.57838314599996' ,
                    }).addTo(fg).bindPopup('KCMOFS25 KCMO Fire Station No. 25   39.10791790600007,-94.57838314599996' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS27 = new L.marker(new L.LatLng(39.09423963200004,-94.50519189199997),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS27 KCMO Fire Station No. 27   39.09423963200004,-94.50519189199997' ,
                    }).addTo(fg).bindPopup('KCMOFS27 KCMO Fire Station No. 27   39.09423963200004,-94.50519189199997' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS28 = new L.marker(new L.LatLng(38.92612585100005,-94.57996235599995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS28 KCMO Fire Station No. 28   38.92612585100005,-94.57996235599995' ,
                    }).addTo(fg).bindPopup('KCMOFS28 KCMO Fire Station No. 28   38.92612585100005,-94.57996235599995' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS29 = new L.marker(new L.LatLng(39.01353614300007,-94.56910049699997),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS29 KCMO Fire Station No. 29   39.01353614300007,-94.56910049699997' ,
                    }).addTo(fg).bindPopup('KCMOFS29 KCMO Fire Station No. 29   39.01353614300007,-94.56910049699997' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS30 = new L.marker(new L.LatLng(38.98954598500006,-94.55777761299998),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS30 KCMO Fire Station No. 30   38.98954598500006,-94.55777761299998' ,
                    }).addTo(fg).bindPopup('KCMOFS30 KCMO Fire Station No. 30   38.98954598500006,-94.55777761299998' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS33 = new L.marker(new L.LatLng(39.00341036400005,-94.49917701399994),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS33 KCMO Fire Station No. 33   39.00341036400005,-94.49917701399994' ,
                    }).addTo(fg).bindPopup('KCMOFS33 KCMO Fire Station No. 33   39.00341036400005,-94.49917701399994' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS34 = new L.marker(new L.LatLng(39.18216645700005,-94.52198633599994),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS34 KCMO Fire Station No. 34   39.18216645700005,-94.52198633599994' ,
                    }).addTo(fg).bindPopup('KCMOFS34 KCMO Fire Station No. 34   39.18216645700005,-94.52198633599994' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS35 = new L.marker(new L.LatLng(39.04105321900005,-94.54716372899998),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS35 KCMO Fire Station No. 35   39.04105321900005,-94.54716372899998' ,
                    }).addTo(fg).bindPopup('KCMOFS35 KCMO Fire Station No. 35   39.04105321900005,-94.54716372899998' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS36 = new L.marker(new L.LatLng(38.947990154000024,-94.58198512499996),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS36 KCMO Fire Station No. 36   38.947990154000024,-94.58198512499996' ,
                    }).addTo(fg).bindPopup('KCMOFS36 KCMO Fire Station No. 36   38.947990154000024,-94.58198512499996' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS37 = new L.marker(new L.LatLng(38.98838295400003,-94.59471418799995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS37 KCMO Fire Station No. 37   38.98838295400003,-94.59471418799995' ,
                    }).addTo(fg).bindPopup('KCMOFS37 KCMO Fire Station No. 37   38.98838295400003,-94.59471418799995' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS38 = new L.marker(new L.LatLng(39.24114461900007,-94.57637879999999),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS38 KCMO Fire Station No. 38   39.24114461900007,-94.57637879999999' ,
                    }).addTo(fg).bindPopup('KCMOFS38 KCMO Fire Station No. 38   39.24114461900007,-94.57637879999999' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS39 = new L.marker(new L.LatLng(39.037389129000076,-94.44871189199995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS39 KCMO Fire Station No. 39   39.037389129000076,-94.44871189199995' ,
                    }).addTo(fg).bindPopup('KCMOFS39 KCMO Fire Station No. 39   39.037389129000076,-94.44871189199995' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS40 = new L.marker(new L.LatLng(39.18825564000008,-94.57705538299996),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS40 KCMO Fire Station No. 40   39.18825564000008,-94.57705538299996' ,
                    }).addTo(fg).bindPopup('KCMOFS40 KCMO Fire Station No. 40   39.18825564000008,-94.57705538299996' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS41 = new L.marker(new L.LatLng(38.956671338000035,-94.52135318999996),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS41 KCMO Fire Station No. 41   38.956671338000035,-94.52135318999996' ,
                    }).addTo(fg).bindPopup('KCMOFS41 KCMO Fire Station No. 41   38.956671338000035,-94.52135318999996' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS42 = new L.marker(new L.LatLng(38.924447272000066,-94.51993356699995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS42 KCMO Fire Station No. 42   38.924447272000066,-94.51993356699995' ,
                    }).addTo(fg).bindPopup('KCMOFS42 KCMO Fire Station No. 42   38.924447272000066,-94.51993356699995' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS43 = new L.marker(new L.LatLng(38.96734958800005,-94.43185910999995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS43 KCMO Fire Station No. 43   38.96734958800005,-94.43185910999995' ,
                    }).addTo(fg).bindPopup('KCMOFS43 KCMO Fire Station No. 43   38.96734958800005,-94.43185910999995' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS44 = new L.marker(new L.LatLng(39.246423046000075,-94.66588993499994),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS44 KCMO Fire Station No. 44   39.246423046000075,-94.66588993499994' ,
                    }).addTo(fg).bindPopup('KCMOFS44 KCMO Fire Station No. 44   39.246423046000075,-94.66588993499994' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS45 = new L.marker(new L.LatLng(38.89023597400006,-94.58854005199998),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS45 KCMO Fire Station No. 45   38.89023597400006,-94.58854005199998' ,
                    }).addTo(fg).bindPopup('KCMOFS45 KCMO Fire Station No. 45   38.89023597400006,-94.58854005199998' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS47 = new L.marker(new L.LatLng(39.14034793800005,-94.52048369499994),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS47 KCMO Fire Station No. 47   39.14034793800005,-94.52048369499994' ,
                    }).addTo(fg).bindPopup('KCMOFS47 KCMO Fire Station No. 47   39.14034793800005,-94.52048369499994' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS14 = new L.marker(new L.LatLng(39.24420365000003,-94.52101456199995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS14 KCMO Fire Station No. 14   39.24420365000003,-94.52101456199995' ,
                    }).addTo(fg).bindPopup('KCMOFS14 KCMO Fire Station No. 14   39.24420365000003,-94.52101456199995' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RVRSFD = new L.marker(new L.LatLng(39.17579,-94.615947),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RVRSFD    Riverside City Fire Department   39.17579,-94.615947' ,
                    }).addTo(fg).bindPopup('RVRSFD    Riverside City Fire Department   39.17579,-94.615947' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CARROLFD = new L.marker(new L.LatLng(39.364764,-93.482455),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CARROLFD Carrollton Fire Department   39.364764,-93.482455' ,
                    }).addTo(fg).bindPopup('CARROLFD Carrollton Fire Department   39.364764,-93.482455' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KSZW = new L.marker(new L.LatLng(50.813106,6.15943),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KSZW DRK Fernmeldezug   50.813106,6.15943' ,
                    }).addTo(fg).bindPopup('KSZW DRK Fernmeldezug   50.813106,6.15943' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RSIM = new L.marker(new L.LatLng(50.606579,6.303835),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RSIM Gemeindeverwaltung Simmerath   50.606579,6.303835' ,
                    }).addTo(fg).bindPopup('RSIM Gemeindeverwaltung Simmerath   50.606579,6.303835' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PSIM = new L.marker(new L.LatLng(50.61,6.302051),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PSIM Wache Simmerath   50.61,6.302051' ,
                    }).addTo(fg).bindPopup('PSIM Wache Simmerath   50.61,6.302051' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGEIC = new L.marker(new L.LatLng(50.579681,6.303993),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGEIC Gerätehaus Eicherscheid   50.579681,6.303993' ,
                    }).addTo(fg).bindPopup('LGEIC Gerätehaus Eicherscheid   50.579681,6.303993' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGEIN = new L.marker(new L.LatLng(50.582916,6.37867),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGEIN Gerätehaus Einruhr   50.582916,6.37867' ,
                    }).addTo(fg).bindPopup('LGEIN Gerätehaus Einruhr   50.582916,6.37867' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGERK = new L.marker(new L.LatLng(50.564697,6.361316),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGERK Gerätehaus Erkensruhr   50.564697,6.361316' ,
                    }).addTo(fg).bindPopup('LGERK Gerätehaus Erkensruhr   50.564697,6.361316' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGDED = new L.marker(new L.LatLng(50.583751,6.355568),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGDED Gerätehaus Dedenborn   50.583751,6.355568' ,
                    }).addTo(fg).bindPopup('LGDED Gerätehaus Dedenborn   50.583751,6.355568' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGHAM = new L.marker(new L.LatLng(50.564858,6.329027),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGHAM Gerätehaus Hammer   50.564858,6.329027' ,
                    }).addTo(fg).bindPopup('LGHAM Gerätehaus Hammer   50.564858,6.329027' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGKES = new L.marker(new L.LatLng(50.606444,6.331613),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGKES Gerätehaus Kesternich   50.606444,6.331613' ,
                    }).addTo(fg).bindPopup('LGKES Gerätehaus Kesternich   50.606444,6.331613' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGLAM = new L.marker(new L.LatLng(50.632156,6.271407),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGLAM Gerätehaus Lammersdorf   50.632156,6.271407' ,
                    }).addTo(fg).bindPopup('LGLAM Gerätehaus Lammersdorf   50.632156,6.271407' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGROL = new L.marker(new L.LatLng(50.62973,6.311586),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGROL Gerätehaus Rollesbroich   50.62973,6.311586' ,
                    }).addTo(fg).bindPopup('LGROL Gerätehaus Rollesbroich   50.62973,6.311586' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGRUR = new L.marker(new L.LatLng(50.614395,6.378801),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGRUR Gerätehaus Rurberg   50.614395,6.378801' ,
                    }).addTo(fg).bindPopup('LGRUR Gerätehaus Rurberg   50.614395,6.378801' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSIM = new L.marker(new L.LatLng(50.607846,6.297847),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSIM Gerätehaus Simmerath   50.607846,6.297847' ,
                    }).addTo(fg).bindPopup('LGSIM Gerätehaus Simmerath   50.607846,6.297847' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSTE = new L.marker(new L.LatLng(50.626846,6.354188),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSTE Gerätehaus Steckenborn   50.626846,6.354188' ,
                    }).addTo(fg).bindPopup('LGSTE Gerätehaus Steckenborn   50.626846,6.354188' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSTR = new L.marker(new L.LatLng(50.624717,6.334544),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSTR Gerätehaus Strauch   50.624717,6.334544' ,
                    }).addTo(fg).bindPopup('LGSTR Gerätehaus Strauch   50.624717,6.334544' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGWOF = new L.marker(new L.LatLng(50.62717,6.382292),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGWOF Gerätehaus Woffelsbach   50.62717,6.382292' ,
                    }).addTo(fg).bindPopup('LGWOF Gerätehaus Woffelsbach   50.62717,6.382292' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HBFS1 = new L.marker(new L.LatLng(40.80125,-124.16873),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HBFS1 Humboldt Bay Fire Station 1  HBF Main Office 40.80125,-124.16873' ,
                    }).addTo(fg).bindPopup('HBFS1 Humboldt Bay Fire Station 1  HBF Main Office 40.80125,-124.16873' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RMON = new L.marker(new L.LatLng(50.560007,6.237547),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RMON Stadtverwaltung Monschau   50.560007,6.237547' ,
                    }).addTo(fg).bindPopup('RMON Stadtverwaltung Monschau   50.560007,6.237547' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HBFS4 = new L.marker(new L.LatLng(40.79978,-124.14866),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HBFS4 Humboldt Bay Fire Station 4   40.79978,-124.14866' ,
                    }).addTo(fg).bindPopup('HBFS4 Humboldt Bay Fire Station 4   40.79978,-124.14866' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PMON = new L.marker(new L.LatLng(50.558336,6.239711),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PMON Wache Monschau   50.558336,6.239711' ,
                    }).addTo(fg).bindPopup('PMON Wache Monschau   50.558336,6.239711' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HBFS3 = new L.marker(new L.LatLng(40.78177,-124.18126),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HBFS3 Humboldt Bay Fire Station 3   40.78177,-124.18126' ,
                    }).addTo(fg).bindPopup('HBFS3 Humboldt Bay Fire Station 3   40.78177,-124.18126' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGMON = new L.marker(new L.LatLng(50.565182,6.25227),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGMON Gerätehaus Altstadt   50.565182,6.25227' ,
                    }).addTo(fg).bindPopup('LGMON Gerätehaus Altstadt   50.565182,6.25227' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HBFS5 = new L.marker(new L.LatLng(40.78097,-124.12982),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HBFS5 Humboldt Bay Fire Station 5   40.78097,-124.12982' ,
                    }).addTo(fg).bindPopup('HBFS5 Humboldt Bay Fire Station 5   40.78097,-124.12982' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGHOE1 = new L.marker(new L.LatLng(50.537637,6.254052),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGHOE1 Gerätehaus Höfen   50.537637,6.254052' ,
                    }).addTo(fg).bindPopup('LGHOE1 Gerätehaus Höfen   50.537637,6.254052' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HBFS2 = new L.marker(new L.LatLng(40.75793,-124.17967),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HBFS2 Humboldt Bay Fire Station 2   40.75793,-124.17967' ,
                    }).addTo(fg).bindPopup('HBFS2 Humboldt Bay Fire Station 2   40.75793,-124.17967' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LHROH = new L.marker(new L.LatLng(50.549038,6.283202),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LHROH Gerätehaus Rohren   50.549038,6.283202' ,
                    }).addTo(fg).bindPopup('LHROH Gerätehaus Rohren   50.549038,6.283202' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var SPFD171 = new L.marker(new L.LatLng(40.78639,-124.2),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'SPFD171 Samoa Peninsula Fire District   40.78639,-124.2' ,
                    }).addTo(fg).bindPopup('SPFD171 Samoa Peninsula Fire District   40.78639,-124.2' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGMOE = new L.marker(new L.LatLng(50.566583,6.217732),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGMOE Gerätehaus Mützenich   50.566583,6.217732' ,
                    }).addTo(fg).bindPopup('LGMOE Gerätehaus Mützenich   50.566583,6.217732' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGKAL = new L.marker(new L.LatLng(50.524809,6.219386),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGKAL Gerätehaus Kalterherberg   50.524809,6.219386' ,
                    }).addTo(fg).bindPopup('LGKAL Gerätehaus Kalterherberg   50.524809,6.219386' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var AFD173 = new L.marker(new L.LatLng(40.86865,-124.08511),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'AFD173 Arcata Fire District / Arcata Station   40.86865,-124.08511' ,
                    }).addTo(fg).bindPopup('AFD173 Arcata Fire District / Arcata Station   40.86865,-124.08511' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RROE = new L.marker(new L.LatLng(50.647679,6.195132),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RROE Gemeinde Verwaltung Roetgen   50.647679,6.195132' ,
                    }).addTo(fg).bindPopup('RROE Gemeinde Verwaltung Roetgen   50.647679,6.195132' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var AFD174 = new L.marker(new L.LatLng(40.89901,-124.09185),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'AFD174 Arcata Fire District / Mad River Station   40.89901,-124.09185' ,
                    }).addTo(fg).bindPopup('AFD174 Arcata Fire District / Mad River Station   40.89901,-124.09185' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PROE = new L.marker(new L.LatLng(50.647679,6.195132),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PROE Wache Roetgen   50.647679,6.195132' ,
                    }).addTo(fg).bindPopup('PROE Wache Roetgen   50.647679,6.195132' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var AFD175 = new L.marker(new L.LatLng(40.94398,-124.10055),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'AFD175 Arcata Fire District / McKinleyville Station   40.94398,-124.10055' ,
                    }).addTo(fg).bindPopup('AFD175 Arcata Fire District / McKinleyville Station   40.94398,-124.10055' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGROE = new L.marker(new L.LatLng(50.645685,6.193941),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGROE Gerätehaus Roetgen   50.645685,6.193941' ,
                    }).addTo(fg).bindPopup('LGROE Gerätehaus Roetgen   50.645685,6.193941' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var BLFD176 = new L.marker(new L.LatLng(40.88308,-123.99108),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'BLFD176 Blue Lake Fire Department   40.88308,-123.99108' ,
                    }).addTo(fg).bindPopup('BLFD176 Blue Lake Fire Department   40.88308,-123.99108' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGROT = new L.marker(new L.LatLng(50.679374,6.215632),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGROT Gerätehaus Rott   50.679374,6.215632' ,
                    }).addTo(fg).bindPopup('LGROT Gerätehaus Rott   50.679374,6.215632' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FFD177 = new L.marker(new L.LatLng(40.96415,-124.03615),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FFD177 Fieldbrook Fire Department   40.96415,-124.03615' ,
                    }).addTo(fg).bindPopup('FFD177 Fieldbrook Fire Department   40.96415,-124.03615' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RSTO = new L.marker(new L.LatLng(50.772383,6.226992),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RSTO Stadtverwaltung Stolberg   50.772383,6.226992' ,
                    }).addTo(fg).bindPopup('RSTO Stadtverwaltung Stolberg   50.772383,6.226992' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var WVFD178 = new L.marker(new L.LatLng(41.03568,-124.1101),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'WVFD178 Westhaven Volunteer Fire Department   41.03568,-124.1101' ,
                    }).addTo(fg).bindPopup('WVFD178 Westhaven Volunteer Fire Department   41.03568,-124.1101' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PSTO = new L.marker(new L.LatLng(50.771952,6.215136),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PSTO Polizeihauptwache Stolberg   50.771952,6.215136' ,
                    }).addTo(fg).bindPopup('PSTO Polizeihauptwache Stolberg   50.771952,6.215136' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var TFD179 = new L.marker(new L.LatLng(41.06041,-124.14269),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'TFD179 Trinidad Fire Department   41.06041,-124.14269' ,
                    }).addTo(fg).bindPopup('TFD179 Trinidad Fire Department   41.06041,-124.14269' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HSTO = new L.marker(new L.LatLng(50.772706,6.229039),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HSTO Bethlehem Health Center   50.772706,6.229039' ,
                    }).addTo(fg).bindPopup('HSTO Bethlehem Health Center   50.772706,6.229039' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CFTFFS180 = new L.marker(new L.LatLng(41.07636,-124.14483),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CFTFFS180 CAL FIRE Trinidad Forest Fire Station   41.07636,-124.14483' ,
                    }).addTo(fg).bindPopup('CFTFFS180 CAL FIRE Trinidad Forest Fire Station   41.07636,-124.14483' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FWSTO = new L.marker(new L.LatLng(50.772356,6.215903),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FWSTO Feuerwache Stolberg   50.772356,6.215903' ,
                    }).addTo(fg).bindPopup('FWSTO Feuerwache Stolberg   50.772356,6.215903' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var OVFD181 = new L.marker(new L.LatLng(41.29056,-124.05703),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'OVFD181 Orick Volunteer Fire Department   41.29056,-124.05703' ,
                    }).addTo(fg).bindPopup('OVFD181 Orick Volunteer Fire Department   41.29056,-124.05703' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGVEN = new L.marker(new L.LatLng(50.706595,6.218356),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGVEN Gerätehaus Vennwegen   50.706595,6.218356' ,
                    }).addTo(fg).bindPopup('LGVEN Gerätehaus Vennwegen   50.706595,6.218356' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var YFD182 = new L.marker(new L.LatLng(41.04817,-123.67285),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'YFD182 Yurok Fire Dept   41.04817,-123.67285' ,
                    }).addTo(fg).bindPopup('YFD182 Yurok Fire Dept   41.04817,-123.67285' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBRE = new L.marker(new L.LatLng(50.730662,6.218026),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBRE Gerätehaus Breinig   50.730662,6.218026' ,
                    }).addTo(fg).bindPopup('LGBRE Gerätehaus Breinig   50.730662,6.218026' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CFTVS183 = new L.marker(new L.LatLng(41.52502,-123.99436),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CFTVS183 Cal Fire Terwer Valley Station   41.52502,-123.99436' ,
                    }).addTo(fg).bindPopup('CFTVS183 Cal Fire Terwer Valley Station   41.52502,-123.99436' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGZWE = new L.marker(new L.LatLng(50.721203,6.253643),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGZWE Gerätehaus Zweifall   50.721203,6.253643' ,
                    }).addTo(fg).bindPopup('LGZWE Gerätehaus Zweifall   50.721203,6.253643' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KFD35 = new L.marker(new L.LatLng(41.57543,-124.04627),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KFD35 Klamath Fire Station 35   41.57543,-124.04627' ,
                    }).addTo(fg).bindPopup('KFD35 Klamath Fire Station 35   41.57543,-124.04627' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGVIC = new L.marker(new L.LatLng(50.744947,6.263825),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGVIC Gerätehaus Vicht   50.744947,6.263825' ,
                    }).addTo(fg).bindPopup('LGVIC Gerätehaus Vicht   50.744947,6.263825' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KFD34 = new L.marker(new L.LatLng(41.57347,-124.07127),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KFD34 Klamath Fire Station 34   41.57347,-124.07127' ,
                    }).addTo(fg).bindPopup('KFD34 Klamath Fire Station 34   41.57347,-124.07127' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGGRE = new L.marker(new L.LatLng(50.771925,6.303416),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGGRE Gerätehaus Gressenich   50.771925,6.303416' ,
                    }).addTo(fg).bindPopup('LGGRE Gerätehaus Gressenich   50.771925,6.303416' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CFPOBFS = new L.marker(new L.LatLng(41.75657,-124.15613),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CFPOBFS CFPO Beatsch Fire station   41.75657,-124.15613' ,
                    }).addTo(fg).bindPopup('CFPOBFS CFPO Beatsch Fire station   41.75657,-124.15613' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGWER = new L.marker(new L.LatLng(50.78098,6.286442),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGWER Gerätehaus Werth   50.78098,6.286442' ,
                    }).addTo(fg).bindPopup('LGWER Gerätehaus Werth   50.78098,6.286442' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CCFR187 = new L.marker(new L.LatLng(41.75428,-124.19869),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CCFR187 Crescent City Fire and Rescue _ City Station   41.75428,-124.19869' ,
                    }).addTo(fg).bindPopup('CCFR187 Crescent City Fire and Rescue _ City Station   41.75428,-124.19869' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGDON = new L.marker(new L.LatLng(50.781169,6.237568),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGDON Gerätehaus Donnerberg   50.781169,6.237568' ,
                    }).addTo(fg).bindPopup('LGDON Gerätehaus Donnerberg   50.781169,6.237568' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CFCCFS188 = new L.marker(new L.LatLng(41.76493,-124.19461),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CFCCFS188 CAL Fire/Crescent City Fire Station   41.76493,-124.19461' ,
                    }).addTo(fg).bindPopup('CFCCFS188 CAL Fire/Crescent City Fire Station   41.76493,-124.19461' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGATS = new L.marker(new L.LatLng(50.786182,6.217396),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGATS Gerätehaus Atsch   50.786182,6.217396' ,
                    }).addTo(fg).bindPopup('LGATS Gerätehaus Atsch   50.786182,6.217396' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CCFRWHQ189 = new L.marker(new L.LatLng(41.77253,-124.20543),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CCFRWHQ189 Crescent City Fire and Rescue _ Washington Headquarters   41.77253,-124.20543' ,
                    }).addTo(fg).bindPopup('CCFRWHQ189 Crescent City Fire and Rescue _ Washington Headquarters   41.77253,-124.20543' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSMIT = new L.marker(new L.LatLng(50.773596,6.233773),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSMIT Gerätehaus Stolberg Mitte   50.773596,6.233773' ,
                    }).addTo(fg).bindPopup('LGSMIT Gerätehaus Stolberg Mitte   50.773596,6.233773' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HFD190 = new L.marker(new L.LatLng(41.04795,-123.67271),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HFD190 Hoopa Fire Department   41.04795,-123.67271' ,
                    }).addTo(fg).bindPopup('HFD190 Hoopa Fire Department   41.04795,-123.67271' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RESCH = new L.marker(new L.LatLng(50.817958,6.271965),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RESCH Stadtverwaltung Eschweiler   50.817958,6.271965' ,
                    }).addTo(fg).bindPopup('RESCH Stadtverwaltung Eschweiler   50.817958,6.271965' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PESCH = new L.marker(new L.LatLng(50.822081,6.27491),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PESCH Polizeihauptwache Eschweiler   50.822081,6.27491' ,
                    }).addTo(fg).bindPopup('PESCH Polizeihauptwache Eschweiler   50.822081,6.27491' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var WCFD192 = new L.marker(new L.LatLng(40.94043,-123.6334),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'WCFD192 Willow Creek Fire Department   40.94043,-123.6334' ,
                    }).addTo(fg).bindPopup('WCFD192 Willow Creek Fire Department   40.94043,-123.6334' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FWESCH = new L.marker(new L.LatLng(50.81122,6.255358),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FWESCH Feuerwache Eschweiler   50.81122,6.255358' ,
                    }).addTo(fg).bindPopup('FWESCH Feuerwache Eschweiler   50.81122,6.255358' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KFPD194 = new L.marker(new L.LatLng(40.77186,-124.00153),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KFPD194 Kneeland Fire Protection Distribution   40.77186,-124.00153' ,
                    }).addTo(fg).bindPopup('KFPD194 Kneeland Fire Protection Distribution   40.77186,-124.00153' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBOH = new L.marker(new L.LatLng(50.798068,6.280844),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBOH Gerätehaus Bohl   50.798068,6.280844' ,
                    }).addTo(fg).bindPopup('LGBOH Gerätehaus Bohl   50.798068,6.280844' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CFKHB = new L.marker(new L.LatLng(40.71948,-123.92928),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CFKHB Cal Fire Kneeland Helitack Base  Cal Fire Rotary Air Craft and refull Air Attack Base 40.71948,-123.92928' ,
                    }).addTo(fg).bindPopup('CFKHB Cal Fire Kneeland Helitack Base  Cal Fire Rotary Air Craft and refull Air Attack Base 40.71948,-123.92928' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGWEI = new L.marker(new L.LatLng(50.825261,6.308295),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGWEI Gerätehaus Weisweilerl   50.825261,6.308295' ,
                    }).addTo(fg).bindPopup('LGWEI Gerätehaus Weisweilerl   50.825261,6.308295' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var MCVF196 = new L.marker(new L.LatLng(40.76064,-123.87006),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'MCVF196 Maple Creek Volunteer Fire   40.76064,-123.87006' ,
                    }).addTo(fg).bindPopup('MCVF196 Maple Creek Volunteer Fire   40.76064,-123.87006' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGDUE = new L.marker(new L.LatLng(50.835584,6.273568),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGDUE Gerätehaus Dürwiss   50.835584,6.273568' ,
                    }).addTo(fg).bindPopup('LGDUE Gerätehaus Dürwiss   50.835584,6.273568' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LFS197 = new L.marker(new L.LatLng(40.64431,-124.22063),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LFS197 Loleta Fire Station   40.64431,-124.22063' ,
                    }).addTo(fg).bindPopup('LFS197 Loleta Fire Station   40.64431,-124.22063' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGLOH = new L.marker(new L.LatLng(50.863128,6.290406),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGLOH Gerätehaus Neu_Lohn   50.863128,6.290406' ,
                    }).addTo(fg).bindPopup('LGLOH Gerätehaus Neu_Lohn   50.863128,6.290406' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FFD198 = new L.marker(new L.LatLng(40.57622,-124.2635),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FFD198 Ferndale Fire Department   40.57622,-124.2635' ,
                    }).addTo(fg).bindPopup('FFD198 Ferndale Fire Department   40.57622,-124.2635' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LHKIN = new L.marker(new L.LatLng(50.843966,6.229124),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LHKIN Gerätehaus Kinsweiler   50.843966,6.229124' ,
                    }).addTo(fg).bindPopup('LHKIN Gerätehaus Kinsweiler   50.843966,6.229124' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FFD199 = new L.marker(new L.LatLng(40.58939,-124.14762),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FFD199 Fortuna Fire Department   40.58939,-124.14762' ,
                    }).addTo(fg).bindPopup('FFD199 Fortuna Fire Department   40.58939,-124.14762' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGROE1 = new L.marker(new L.LatLng(50.822782,6.235976),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGROE1 Gerätehaus Röhe   50.822782,6.235976' ,
                    }).addTo(fg).bindPopup('LGROE1 Gerätehaus Röhe   50.822782,6.235976' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CFICC200 = new L.marker(new L.LatLng(40.5925,-124.14733),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CFICC200 CAL FIRE_Interagency Command Center  Cal Fire, U.S. Forestry, California Fish and Wild Life, National Parks 40.5925,-124.14733' ,
                    }).addTo(fg).bindPopup('CFICC200 CAL FIRE_Interagency Command Center  Cal Fire, U.S. Forestry, California Fish and Wild Life, National Parks 40.5925,-124.14733' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RWUER = new L.marker(new L.LatLng(50.819575,6.129974),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RWUER Stadtverwaltung Würselen   50.819575,6.129974' ,
                    }).addTo(fg).bindPopup('RWUER Stadtverwaltung Würselen   50.819575,6.129974' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FVFDCH201 = new L.marker(new L.LatLng(40.57024,-124.13481),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FVFDCH201 Fortuna Volunteer Fire Department Campton Heights Station   40.57024,-124.13481' ,
                    }).addTo(fg).bindPopup('FVFDCH201 Fortuna Volunteer Fire Department Campton Heights Station   40.57024,-124.13481' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PWUER = new L.marker(new L.LatLng(50.820841,6.128693),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PWUER Polizeiwache Würselen   50.820841,6.128693' ,
                    }).addTo(fg).bindPopup('PWUER Polizeiwache Würselen   50.820841,6.128693' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HFD202 = new L.marker(new L.LatLng(40.54748,-124.09449),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HFD202 Hydesville Fire Department   40.54748,-124.09449' ,
                    }).addTo(fg).bindPopup('HFD202 Hydesville Fire Department   40.54748,-124.09449' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HRMK = new L.marker(new L.LatLng(50.815424,6.142567),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HRMK Rhein_Maas Klinikum   50.815424,6.142567' ,
                    }).addTo(fg).bindPopup('HRMK Rhein_Maas Klinikum   50.815424,6.142567' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FWWUER = new L.marker(new L.LatLng(50.829789,6.136548),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FWWUER Feuerwache Würselen   50.829789,6.136548' ,
                    }).addTo(fg).bindPopup('FWWUER Feuerwache Würselen   50.829789,6.136548' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CFS204 = new L.marker(new L.LatLng(40.51942,-124.02393),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CFS204 Carlotta Fire Station   40.51942,-124.02393' ,
                    }).addTo(fg).bindPopup('CFS204 Carlotta Fire Station   40.51942,-124.02393' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBAR = new L.marker(new L.LatLng(50.844639,6.112714),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBAR Gerätehaus Bardenberg   50.844639,6.112714' ,
                    }).addTo(fg).bindPopup('LGBAR Gerätehaus Bardenberg   50.844639,6.112714' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var MRFSUSFS205 = new L.marker(new L.LatLng(40.46022,-123.52366),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'MRFSUSFS205 Mad River Fire Station, U.S.Forest Service   40.46022,-123.52366' ,
                    }).addTo(fg).bindPopup('MRFSUSFS205 Mad River Fire Station, U.S.Forest Service   40.46022,-123.52366' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBROI = new L.marker(new L.LatLng(50.826609,6.174031),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBROI Gerätehaus Broichweiden   50.826609,6.174031' ,
                    }).addTo(fg).bindPopup('LGBROI Gerätehaus Broichweiden   50.826609,6.174031' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGWMIT = new L.marker(new L.LatLng(50.829789,6.136548),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGWMIT Gerätehaus Mitte   50.829789,6.136548' ,
                    }).addTo(fg).bindPopup('LGWMIT Gerätehaus Mitte   50.829789,6.136548' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RDVFD207 = new L.marker(new L.LatLng(40.50129,-124.107),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RDVFD207 Rio Dell Volunteer Fire Department   40.50129,-124.107' ,
                    }).addTo(fg).bindPopup('RDVFD207 Rio Dell Volunteer Fire Department   40.50129,-124.107' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RHER = new L.marker(new L.LatLng(50.870513,6.101261),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RHER Stadtverwaltung Herzogenrath   50.870513,6.101261' ,
                    }).addTo(fg).bindPopup('RHER Stadtverwaltung Herzogenrath   50.870513,6.101261' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var SVFD208 = new L.marker(new L.LatLng(40.48164,-124.10331),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'SVFD208 Scotia Volunteer Fire Department   40.48164,-124.10331' ,
                    }).addTo(fg).bindPopup('SVFD208 Scotia Volunteer Fire Department   40.48164,-124.10331' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var UEHER = new L.marker(new L.LatLng(50.870836,6.102201),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'UEHER Polizeiwache Herzogenrath   50.870836,6.102201' ,
                    }).addTo(fg).bindPopup('UEHER Polizeiwache Herzogenrath   50.870836,6.102201' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PFD209 = new L.marker(new L.LatLng(40.32522,-124.28753),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PFD209 Petrolia Fire District   40.32522,-124.28753' ,
                    }).addTo(fg).bindPopup('PFD209 Petrolia Fire District   40.32522,-124.28753' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FWHER = new L.marker(new L.LatLng(50.866874,6.09844),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FWHER Feuerwache Herzogenrath   50.866874,6.09844' ,
                    }).addTo(fg).bindPopup('FWHER Feuerwache Herzogenrath   50.866874,6.09844' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CDFMFS210 = new L.marker(new L.LatLng(40.23787,-124.13246),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CDFMFS210 California Department of Forestry Mattole Fire Station   40.23787,-124.13246' ,
                    }).addTo(fg).bindPopup('CDFMFS210 California Department of Forestry Mattole Fire Station   40.23787,-124.13246' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGMER = new L.marker(new L.LatLng(50.887492,6.101902),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGMER Gerätehaus Merkstein   50.887492,6.101902' ,
                    }).addTo(fg).bindPopup('LGMER Gerätehaus Merkstein   50.887492,6.101902' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CFWS211 = new L.marker(new L.LatLng(40.32164,-123.92413),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CFWS211 Cal Fire Weott Station   40.32164,-123.92413' ,
                    }).addTo(fg).bindPopup('CFWS211 Cal Fire Weott Station   40.32164,-123.92413' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGKOH = new L.marker(new L.LatLng(50.832215,6.085105),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGKOH Gerätehaus Kohlscheid   50.832215,6.085105' ,
                    }).addTo(fg).bindPopup('LGKOH Gerätehaus Kohlscheid   50.832215,6.085105' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var MFFS212 = new L.marker(new L.LatLng(40.26633,-123.87313),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'MFFS212 Myers Flat Fire Station   40.26633,-123.87313' ,
                    }).addTo(fg).bindPopup('MFFS212 Myers Flat Fire Station   40.26633,-123.87313' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RBAES = new L.marker(new L.LatLng(50.908164,6.187756),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RBAES Stadtverwaltung Baesweiler   50.908164,6.187756' ,
                    }).addTo(fg).bindPopup('RBAES Stadtverwaltung Baesweiler   50.908164,6.187756' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var MVFD213 = new L.marker(new L.LatLng(40.23615,-123.8219),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'MVFD213 Miranda Volunteer Fire Department   40.23615,-123.8219' ,
                    }).addTo(fg).bindPopup('MVFD213 Miranda Volunteer Fire Department   40.23615,-123.8219' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PBAES = new L.marker(new L.LatLng(50.908164,6.187756),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PBAES Polizeiwache Baesweiler   50.908164,6.187756' ,
                    }).addTo(fg).bindPopup('PBAES Polizeiwache Baesweiler   50.908164,6.187756' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PVFD214 = new L.marker(new L.LatLng(40.21163,-123.78644),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PVFD214 Phillipsville Volunteer Fire Department   40.21163,-123.78644' ,
                    }).addTo(fg).bindPopup('PVFD214 Phillipsville Volunteer Fire Department   40.21163,-123.78644' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBAES = new L.marker(new L.LatLng(50.908164,6.187756),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBAES Gerätehaus Baesweiler   50.908164,6.187756' ,
                    }).addTo(fg).bindPopup('LGBAES Gerätehaus Baesweiler   50.908164,6.187756' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var BVFD215 = new L.marker(new L.LatLng(40.10015,-123.85869),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'BVFD215 Briceland Volunteer Fire Department   40.10015,-123.85869' ,
                    }).addTo(fg).bindPopup('BVFD215 Briceland Volunteer Fire Department   40.10015,-123.85869' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBEG = new L.marker(new L.LatLng(50.926302,6.169597),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBEG Gerätehaus Beggendorf   50.926302,6.169597' ,
                    }).addTo(fg).bindPopup('LGBEG Gerätehaus Beggendorf   50.926302,6.169597' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CFTFS216 = new L.marker(new L.LatLng(40.05676,-123.9616),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CFTFS216 Cal Fire Thorn Fire Station   40.05676,-123.9616' ,
                    }).addTo(fg).bindPopup('CFTFS216 Cal Fire Thorn Fire Station   40.05676,-123.9616' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGOID = new L.marker(new L.LatLng(50.892694,6.18344),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGOID Gerätehaus Oidtweiler   50.892694,6.18344' ,
                    }).addTo(fg).bindPopup('LGOID Gerätehaus Oidtweiler   50.892694,6.18344' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var WFS2217 = new L.marker(new L.LatLng(40.05841,-123.97026),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'WFS2217 Whitethorn Fire Station 2   40.05841,-123.97026' ,
                    }).addTo(fg).bindPopup('WFS2217 Whitethorn Fire Station 2   40.05841,-123.97026' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSET = new L.marker(new L.LatLng(50.925385,6.200954),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSET Gerätehaus Setterich   50.925385,6.200954' ,
                    }).addTo(fg).bindPopup('LGSET Gerätehaus Setterich   50.925385,6.200954' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var SCVFD218 = new L.marker(new L.LatLng(40.02877,-124.06532),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'SCVFD218 Shelter Cove Volunteer Fire Department   40.02877,-124.06532' ,
                    }).addTo(fg).bindPopup('SCVFD218 Shelter Cove Volunteer Fire Department   40.02877,-124.06532' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RALS = new L.marker(new L.LatLng(50.875364,6.166517),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RALS Stadtverwaltung Alsdorf   50.875364,6.166517' ,
                    }).addTo(fg).bindPopup('RALS Stadtverwaltung Alsdorf   50.875364,6.166517' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CDFGF219 = new L.marker(new L.LatLng(40.10613,-123.79055),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CDFGF219 California Department of Forestry Garberville Forest Fire Station   40.10613,-123.79055' ,
                    }).addTo(fg).bindPopup('CDFGF219 California Department of Forestry Garberville Forest Fire Station   40.10613,-123.79055' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PALS = new L.marker(new L.LatLng(50.871914,6.179722),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PALS Polizeiwache Alsdorf   50.871914,6.179722' ,
                    }).addTo(fg).bindPopup('PALS Polizeiwache Alsdorf   50.871914,6.179722' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var GFPD220 = new L.marker(new L.LatLng(40.10266,-123.79382),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'GFPD220 Garberville Fire Protection District   40.10266,-123.79382' ,
                    }).addTo(fg).bindPopup('GFPD220 Garberville Fire Protection District   40.10266,-123.79382' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGALS = new L.marker(new L.LatLng(50.875067,6.173953),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGALS Gerätehaus Alsdorf   50.875067,6.173953' ,
                    }).addTo(fg).bindPopup('LGALS Gerätehaus Alsdorf   50.875067,6.173953' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGHOE = new L.marker(new L.LatLng(50.860056,6.20485),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGHOE Gerätehaus Hoengen   50.860056,6.20485' ,
                    }).addTo(fg).bindPopup('LGHOE Gerätehaus Hoengen   50.860056,6.20485' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KVFDFS222 = new L.marker(new L.LatLng(40.15756,-123.46215),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KVFDFS222 Kettenpom Volunteer Fire Department Fire Station   40.15756,-123.46215' ,
                    }).addTo(fg).bindPopup('KVFDFS222 Kettenpom Volunteer Fire Department Fire Station   40.15756,-123.46215' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBET = new L.marker(new L.LatLng(50.886872,6.198953),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBET Gerätehaus Bettendorf   50.886872,6.198953' ,
                    }).addTo(fg).bindPopup('LGBET Gerätehaus Bettendorf   50.886872,6.198953' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var WGVF223 = new L.marker(new L.LatLng(39.98179,-123.97839),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'WGVF223 Whale Gulch Volunteer Fire   39.98179,-123.97839' ,
                    }).addTo(fg).bindPopup('WGVF223 Whale Gulch Volunteer Fire   39.98179,-123.97839' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RAAC = new L.marker(new L.LatLng(50.768098,6.088472),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RAAC Stadtverwaltung Aachen   50.768098,6.088472' ,
                    }).addTo(fg).bindPopup('RAAC Stadtverwaltung Aachen   50.768098,6.088472' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PAAC = new L.marker(new L.LatLng(50.756751,6.149202),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PAAC Polizeipräsidium Aachen   50.756751,6.149202' ,
                    }).addTo(fg).bindPopup('PAAC Polizeipräsidium Aachen   50.756751,6.149202' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RWTH = new L.marker(new L.LatLng(50.776318,6.043778),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RWTH Uni Klinik RWTH   50.776318,6.043778' ,
                    }).addTo(fg).bindPopup('RWTH Uni Klinik RWTH   50.776318,6.043778' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FWAAC1 = new L.marker(new L.LatLng(50.7771,6.11679),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FWAAC1 Feuerwache Aachen   50.7771,6.11679' ,
                    }).addTo(fg).bindPopup('FWAAC1 Feuerwache Aachen   50.7771,6.11679' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FWAAC2 = new L.marker(new L.LatLng(50.728695,6.175038),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FWAAC2 Feuerwache 2  Aachen   50.728695,6.175038' ,
                    }).addTo(fg).bindPopup('FWAAC2 Feuerwache 2  Aachen   50.728695,6.175038' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FWAAC3 = new L.marker(new L.LatLng(50.789039,6.047787),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FWAAC3 Feuerwache 3 Aachen   50.789039,6.047787' ,
                    }).addTo(fg).bindPopup('FWAAC3 Feuerwache 3 Aachen   50.789039,6.047787' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGACMIT = new L.marker(new L.LatLng(50.786317,6.135769),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGACMIT Gerätehaus Mitte   50.786317,6.135769' ,
                    }).addTo(fg).bindPopup('LGACMIT Gerätehaus Mitte   50.786317,6.135769' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGLAU = new L.marker(new L.LatLng(50.798014,6.060472),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGLAU Gerätehaus Laurensberg   50.798014,6.060472' ,
                    }).addTo(fg).bindPopup('LGLAU Gerätehaus Laurensberg   50.798014,6.060472' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBRA = new L.marker(new L.LatLng(50.747453,6.163663),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBRA Gerätehaus Brand   50.747453,6.163663' ,
                    }).addTo(fg).bindPopup('LGBRA Gerätehaus Brand   50.747453,6.163663' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGRICH = new L.marker(new L.LatLng(50.814562,6.05599),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGRICH Gerätehaus Richterich   50.814562,6.05599' ,
                    }).addTo(fg).bindPopup('LGRICH Gerätehaus Richterich   50.814562,6.05599' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSIEF = new L.marker(new L.LatLng(50.694817,6.146472),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSIEF Gerätehaus Sief   50.694817,6.146472' ,
                    }).addTo(fg).bindPopup('LGSIEF Gerätehaus Sief   50.694817,6.146472' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGEILD = new L.marker(new L.LatLng(50.77656,6.149927),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGEILD Gerätehaus Eilendorf   50.77656,6.149927' ,
                    }).addTo(fg).bindPopup('LGEILD Gerätehaus Eilendorf   50.77656,6.149927' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGHAAR = new L.marker(new L.LatLng(50.797582,6.123783),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGHAAR Gerätehaus Haaren   50.797582,6.123783' ,
                    }).addTo(fg).bindPopup('LGHAAR Gerätehaus Haaren   50.797582,6.123783' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGVERL = new L.marker(new L.LatLng(50.797933,6.152941),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGVERL Gerätehaus Verlautenheide   50.797933,6.152941' ,
                    }).addTo(fg).bindPopup('LGVERL Gerätehaus Verlautenheide   50.797933,6.152941' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HSLE = new L.marker(new L.LatLng(50.533379,6.48691),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HSLE Krankenhaus Schleiden   50.533379,6.48691' ,
                    }).addTo(fg).bindPopup('HSLE Krankenhaus Schleiden   50.533379,6.48691' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSLE = new L.marker(new L.LatLng(50.532139,6.479103),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSLE Gerätehaus Schleiden   50.532139,6.479103' ,
                    }).addTo(fg).bindPopup('LGSLE Gerätehaus Schleiden   50.532139,6.479103' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGGEMU = new L.marker(new L.LatLng(50.560923,6.497772),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGGEMU Gerätehaus Gemuend   50.560923,6.497772' ,
                    }).addTo(fg).bindPopup('LGGEMU Gerätehaus Gemuend   50.560923,6.497772' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGOBER1 = new L.marker(new L.LatLng(50.512222,6.465568),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGOBER1 Gerätehaus Oberhausen   50.512222,6.465568' ,
                    }).addTo(fg).bindPopup('LGOBER1 Gerätehaus Oberhausen   50.512222,6.465568' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGHER = new L.marker(new L.LatLng(50.554778,6.457676),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGHER Gerätehaus Herhahn   50.554778,6.457676' ,
                    }).addTo(fg).bindPopup('LGHER Gerätehaus Herhahn   50.554778,6.457676' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGHARP = new L.marker(new L.LatLng(50.518637,6.406335),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGHARP Gerätehaus Harperscheid   50.518637,6.406335' ,
                    }).addTo(fg).bindPopup('LGHARP Gerätehaus Harperscheid   50.518637,6.406335' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FIRE11252 = new L.marker(new L.LatLng(48.011343,-122.770733),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FIRE11252 Fire11   48.011343,-122.770733' ,
                    }).addTo(fg).bindPopup('FIRE11252 Fire11   48.011343,-122.770733' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSCHM = new L.marker(new L.LatLng(50.657598,6.398873),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSCHM Gerätehaus Schmidt   50.657598,6.398873' ,
                    }).addTo(fg).bindPopup('LGSCHM Gerätehaus Schmidt   50.657598,6.398873' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FIRE12253 = new L.marker(new L.LatLng(48.043012,-122.691671),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FIRE12253 Fire12   48.043012,-122.691671' ,
                    }).addTo(fg).bindPopup('FIRE12253 Fire12   48.043012,-122.691671' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FIRE13254 = new L.marker(new L.LatLng(48.057266,-122.80605),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FIRE13254 Fire13   48.057266,-122.80605' ,
                    }).addTo(fg).bindPopup('FIRE13254 Fire13   48.057266,-122.80605' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FIRE14255 = new L.marker(new L.LatLng(48.088759,-122.868354),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FIRE14255 Fire14   48.088759,-122.868354' ,
                    }).addTo(fg).bindPopup('FIRE14255 Fire14   48.088759,-122.868354' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGGEMU = new L.marker(new L.LatLng(50.560923,6.497772),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGGEMU Gerätehaus Gemnd   50.560923,6.497772' ,
                    }).addTo(fg).bindPopup('LGGEMU Gerätehaus Gemnd   50.560923,6.497772' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var JCC259 = new L.marker(new L.LatLng(47.919701,-122.702967),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'JCC259 JC CLINIC   47.919701,-122.702967' ,
                    }).addTo(fg).bindPopup('JCC259 JC CLINIC   47.919701,-122.702967' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var JCC260 = new L.marker(new L.LatLng(47.821937,-122.875899),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'JCC260 JC CLINIC   47.821937,-122.875899' ,
                    }).addTo(fg).bindPopup('JCC260 JC CLINIC   47.821937,-122.875899' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var FWRW6 = new L.marker(new L.LatLng(50.780334,6.097386),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'FWRW6 Rettungswache 6   50.780334,6.097386' ,
                    }).addTo(fg).bindPopup('FWRW6 Rettungswache 6   50.780334,6.097386' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var FWRW5 = new L.marker(new L.LatLng(50.78098,6.12967),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'FWRW5 Rettungswache 5   50.78098,6.12967' ,
                    }).addTo(fg).bindPopup('FWRW5 Rettungswache 5   50.78098,6.12967' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var FWRW4 = new L.marker(new L.LatLng(50.781304,6.134702),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'FWRW4 Rettungswache 4   50.781304,6.134702' ,
                    }).addTo(fg).bindPopup('FWRW4 Rettungswache 4   50.781304,6.134702' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var LMH = new L.marker(new L.LatLng(38.979225,-95.248259),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'LMH Lawrence Memorial Hospital  ACT staffs this location in emergencies  38.979225,-95.248259' ,
                    }).addTo(fg).bindPopup('LMH Lawrence Memorial Hospital  ACT staffs this location in emergencies  38.979225,-95.248259' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var HSIM = new L.marker(new L.LatLng(50.604692,6.301457),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'HSIM Eifel Clinic St. Brigida   50.604692,6.301457' ,
                    }).addTo(fg).bindPopup('HSIM Eifel Clinic St. Brigida   50.604692,6.301457' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var RMH162 = new L.marker(new L.LatLng(40.5823,-124.1364),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'RMH162 Redwood Memorial Hospital   40.5823,-124.1364' ,
                    }).addTo(fg).bindPopup('RMH162 Redwood Memorial Hospital   40.5823,-124.1364' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var JPCH163 = new L.marker(new L.LatLng(40.1016,-123.7922),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'JPCH163 Jerold Phelps Community Hospital   40.1016,-123.7922' ,
                    }).addTo(fg).bindPopup('JPCH163 Jerold Phelps Community Hospital   40.1016,-123.7922' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var TH164 = new L.marker(new L.LatLng(40.7381,-122.9396),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'TH164 Trinity Hospital   40.7381,-122.9396' ,
                    }).addTo(fg).bindPopup('TH164 Trinity Hospital   40.7381,-122.9396' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var SCH165 = new L.marker(new L.LatLng(41.7737,-124.1942),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'SCH165 Sutter Coast Hospital   41.7737,-124.1942' ,
                    }).addTo(fg).bindPopup('SCH165 Sutter Coast Hospital   41.7737,-124.1942' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var HESCH = new L.marker(new L.LatLng(50.818443,6.264238),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'HESCH St._Antonius_Hospital   50.818443,6.264238' ,
                    }).addTo(fg).bindPopup('HESCH St._Antonius_Hospital   50.818443,6.264238' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var MARIEN = new L.marker(new L.LatLng(50.762088,6.095381),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'MARIEN Marienhospital   50.762088,6.095381' ,
                    }).addTo(fg).bindPopup('MARIEN Marienhospital   50.762088,6.095381' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var LUISEN = new L.marker(new L.LatLng(50.767613,6.076744),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'LUISEN Luisenhospital   50.767613,6.076744' ,
                    }).addTo(fg).bindPopup('LUISEN Luisenhospital   50.767613,6.076744' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var FWWEST = new L.marker(new L.LatLng(50.769338,6.056529),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'FWWEST Rettungswache West   50.769338,6.056529' ,
                    }).addTo(fg).bindPopup('FWWEST Rettungswache West   50.769338,6.056529' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var TANEY210 = new L.marker(new L.LatLng(39.144788,-94.558242),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'TANEY210 KK1 _ Taney Ave on 210 Highway  HT Compatable 39.144788,-94.558242' ,
                    }).addTo(fg).bindPopup('TANEY210 KK1 _ Taney Ave on 210 Highway  HT Compatable 39.144788,-94.558242' );                        
         
                $('ht compatable'._icon).addClass('flagmrkr');
            
            var CTEAUELV = new L.marker(new L.LatLng(39.150823,-94.523884),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'CTEAUELV KK2 _ Chouteau Elevator  HT Compatible w/static 39.150823,-94.523884' ,
                    }).addTo(fg).bindPopup('CTEAUELV KK2 _ Chouteau Elevator  HT Compatible w/static 39.150823,-94.523884' );                        
         
                $('ht compatible w/static'._icon).addClass('flagmrkr');
            
            var HWY291on210 = new L.marker(new L.LatLng(39.18423,-94.396235),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'HWY291on210 KK3 _ Highway 210 @ Highway 291  HT Compatible w/static 39.18423,-94.396235' ,
                    }).addTo(fg).bindPopup('HWY291on210 KK3 _ Highway 210 @ Highway 291  HT Compatible w/static 39.18423,-94.396235' );                        
         
                $('ht compatible w/static'._icon).addClass('flagmrkr');
            
            var Non291Hwy = new L.marker(new L.LatLng(39.236328,-94.221919),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'Non291Hwy KK4 _ Supplemental Route N on Hwy 291  HT Not compatible at this location 39.236328,-94.221919' ,
                    }).addTo(fg).bindPopup('Non291Hwy KK4 _ Supplemental Route N on Hwy 291  HT Not compatible at this location 39.236328,-94.221919' );                        
         
                $('ht not compatible at this location'._icon).addClass('flagmrkr');
            
            var XSPRINGS = new L.marker(new L.LatLng(39.339163,-94.223569),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'XSPRINGS KK5 _ Excelsior Springs  HT Not compatible at this location 39.339163,-94.223569' ,
                    }).addTo(fg).bindPopup('XSPRINGS KK5 _ Excelsior Springs  HT Not compatible at this location 39.339163,-94.223569' );                        
         
                $('ht not compatible at this location'._icon).addClass('flagmrkr');
            
            var SWSKOL = new L.marker(new L.LatLng(39.433538,-94.207032),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'SWSKOL KK6 _Southwest Elementary School  HT Not compatible at this location 39.433538,-94.207032' ,
                    }).addTo(fg).bindPopup('SWSKOL KK6 _Southwest Elementary School  HT Not compatible at this location 39.433538,-94.207032' );                        
         
                $('ht not compatible at this location'._icon).addClass('flagmrkr');
            
            var SUNNYSIDE = new L.marker(new L.LatLng(39.34506,-94.22949),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'SUNNYSIDE KK8 _ Sunnyside Park  HT Not compatible at this location 39.34506,-94.22949' ,
                    }).addTo(fg).bindPopup('SUNNYSIDE KK8 _ Sunnyside Park  HT Not compatible at this location 39.34506,-94.22949' );                        
         
                $('ht not compatible at this location'._icon).addClass('flagmrkr');
            
            var WATKINSMILL = new L.marker(new L.LatLng(39.4022,-94.26212),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'WATKINSMILL KK9 _ Watkins Mill State Park Beach  HT Not compatible at this location 39.4022,-94.26212' ,
                    }).addTo(fg).bindPopup('WATKINSMILL KK9 _ Watkins Mill State Park Beach  HT Not compatible at this location 39.4022,-94.26212' );                        
         
                $('ht not compatible at this location'._icon).addClass('flagmrkr');
            
            var HCES239 = new L.marker(new L.LatLng(40.803,-124.16221),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'HCES239 Humboldt County Emergency Services  Humboldt County CERT AuxComm 40.803,-124.16221' ,
                    }).addTo(fg).bindPopup('HCES239 Humboldt County Emergency Services  Humboldt County CERT AuxComm 40.803,-124.16221' );                        
         
                $('humboldt county cert auxcomm'._icon).addClass('flagmrkr');
            
            var KCRJCRAC1 = new L.marker(new L.LatLng(39.0106639,-94.7212972),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KCRJCRAC1 Kansas City Room, W0ERH  JCRAC club repeater 39.0106639,-94.7212972' ,
                    }).addTo(fg).bindPopup('KCRJCRAC1 Kansas City Room, W0ERH  JCRAC club repeater 39.0106639,-94.7212972' );                        
         
                $('jcrac club repeater'._icon).addClass('flagmrkr');
            
            var KCRJCRAC2 = new L.marker(new L.LatLng(38.9252611,-94.6553389),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KCRJCRAC2 Kansas City Room, W0ERH  JCRAC club repeater 38.9252611,-94.6553389' ,
                    }).addTo(fg).bindPopup('KCRJCRAC2 Kansas City Room, W0ERH  JCRAC club repeater 38.9252611,-94.6553389' );                        
         
                $('jcrac club repeater'._icon).addClass('flagmrkr');
            
            var KCRKW1 = new L.marker(new L.LatLng(38.9879167,-94.67075),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KCRKW1 Kansas City Room, K0HAM  Jerry Dixon KCØKW 38.9879167,-94.67075' ,
                    }).addTo(fg).bindPopup('KCRKW1 Kansas City Room, K0HAM  Jerry Dixon KCØKW 38.9879167,-94.67075' );                        
         
                $('jerry dixon kcøkw'._icon).addClass('flagmrkr');
            
            var KCRKW2 = new L.marker(new L.LatLng(38.5861611,-94.6204139),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KCRKW2 Kansas City Room, K0HAM  Jerry Dixon KCØKW 38.5861611,-94.6204139' ,
                    }).addTo(fg).bindPopup('KCRKW2 Kansas City Room, K0HAM  Jerry Dixon KCØKW 38.5861611,-94.6204139' );                        
         
                $('jerry dixon kcøkw'._icon).addClass('flagmrkr');
            
            var KCRHAM2 = new L.marker(new L.LatLng(38.9084722,-94.4548056),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KCRHAM2 Kansas City Room, K0HAM  Jerry Dixon KCØKW 38.9084722,-94.4548056' ,
                    }).addTo(fg).bindPopup('KCRHAM2 Kansas City Room, K0HAM  Jerry Dixon KCØKW 38.9084722,-94.4548056' );                        
         
                $('jerry dixon kcøkw'._icon).addClass('flagmrkr');
            
            var KCRHAM3 = new L.marker(new L.LatLng(39.0922333,-94.9453528),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KCRHAM3 Kansas City Room, K0HAM  Jerry Dixon KCØKW 39.0922333,-94.9453528' ,
                    }).addTo(fg).bindPopup('KCRHAM3 Kansas City Room, K0HAM  Jerry Dixon KCØKW 39.0922333,-94.9453528' );                        
         
                $('jerry dixon kcøkw'._icon).addClass('flagmrkr');
            
            var KCRMED = new L.marker(new L.LatLng(39.0562778,-94.6095),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KCRMED Kansas City Room, Ku0MED  Jerry Dixon KCØKW 39.0562778,-94.6095' ,
                    }).addTo(fg).bindPopup('KCRMED Kansas City Room, Ku0MED  Jerry Dixon KCØKW 39.0562778,-94.6095' );                        
         
                $('jerry dixon kcøkw'._icon).addClass('flagmrkr');
            
            var KCRHAM4 = new L.marker(new L.LatLng(39.2611111,-95.6558333),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KCRHAM4 Kansas City Room, K0HAM  Jerry Dixon KCØKW 39.2611111,-95.6558333' ,
                    }).addTo(fg).bindPopup('KCRHAM4 Kansas City Room, K0HAM  Jerry Dixon KCØKW 39.2611111,-95.6558333' );                        
         
                $('jerry dixon kcøkw'._icon).addClass('flagmrkr');
            
            var BATES = new L.marker(new L.LatLng(38.2498,-94.3432),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'BATES BATES COUNTY HOSPITAL  KCHEART 38.2498,-94.3432' ,
                    }).addTo(fg).bindPopup('BATES BATES COUNTY HOSPITAL  KCHEART 38.2498,-94.3432' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var BOTHWL = new L.marker(new L.LatLng(38.6993,-93.2208),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'BOTHWL BOTHWELL REGIONAL HEALTH CENTER   38.6993,-93.2208' ,
                    }).addTo(fg).bindPopup('BOTHWL BOTHWELL REGIONAL HEALTH CENTER   38.6993,-93.2208' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var BRMC = new L.marker(new L.LatLng(38.8158,-94.5033),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'BRMC Research Belton Hospital   38.8158,-94.5033' ,
                    }).addTo(fg).bindPopup('BRMC Research Belton Hospital   38.8158,-94.5033' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var CARROL = new L.marker(new L.LatLng(39.3762,-93.494),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'CARROL CARROLL COUNTY HOSPITAL   39.3762,-93.494' ,
                    }).addTo(fg).bindPopup('CARROL CARROLL COUNTY HOSPITAL   39.3762,-93.494' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var CASS = new L.marker(new L.LatLng(38.6645,-94.3725),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'CASS Cass Medical Center   38.6645,-94.3725' ,
                    }).addTo(fg).bindPopup('CASS Cass Medical Center   38.6645,-94.3725' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var CMH = new L.marker(new L.LatLng(39.852,-943.74),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'CMH Childrens Mercy Hospital   39.852,-943.74' ,
                    }).addTo(fg).bindPopup('CMH Childrens Mercy Hospital   39.852,-943.74' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var CMHS = new L.marker(new L.LatLng(38.9302,-94.6613),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'CMHS Childrens Mercy Hospital South   38.9302,-94.6613' ,
                    }).addTo(fg).bindPopup('CMHS Childrens Mercy Hospital South   38.9302,-94.6613' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var CUSHNG = new L.marker(new L.LatLng(39.3072,-94.9185),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'CUSHNG Cushing Memorial Hospital   39.3072,-94.9185' ,
                    }).addTo(fg).bindPopup('CUSHNG Cushing Memorial Hospital   39.3072,-94.9185' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var DCEC = new L.marker(new L.LatLng(39.862,-94.576),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'DCEC Metro Regional Healthcare Coord. Ctr   39.862,-94.576' ,
                    }).addTo(fg).bindPopup('DCEC Metro Regional Healthcare Coord. Ctr   39.862,-94.576' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var EXSPR = new L.marker(new L.LatLng(39.3568,-94.237),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'EXSPR Excelsior Springs Medical Center   39.3568,-94.237' ,
                    }).addTo(fg).bindPopup('EXSPR Excelsior Springs Medical Center   39.3568,-94.237' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var FITZ = new L.marker(new L.LatLng(39.928,-93.2143),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'FITZ FITZGIBBON HOSPITAL   39.928,-93.2143' ,
                    }).addTo(fg).bindPopup('FITZ FITZGIBBON HOSPITAL   39.928,-93.2143' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var GVMH = new L.marker(new L.LatLng(38.3892,-93.7702),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'GVMH GOLDEN VALLEY MEMORIAL HOSPITAL   38.3892,-93.7702' ,
                    }).addTo(fg).bindPopup('GVMH GOLDEN VALLEY MEMORIAL HOSPITAL   38.3892,-93.7702' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var I70 = new L.marker(new L.LatLng(38.9783,-93.4162),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'I70 I_70 MEDICAL CENTER   38.9783,-93.4162' ,
                    }).addTo(fg).bindPopup('I70 I_70 MEDICAL CENTER   38.9783,-93.4162' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var KC0CBC = new L.marker(new L.LatLng(39.537,-94.5865),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KC0CBC Kansas City Blood Bank   39.537,-94.5865' ,
                    }).addTo(fg).bindPopup('KC0CBC Kansas City Blood Bank   39.537,-94.5865' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var KCVA = new L.marker(new L.LatLng(39.672,-94.5282),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KCVA Veterans Affairs Medical Center   39.672,-94.5282' ,
                    }).addTo(fg).bindPopup('KCVA Veterans Affairs Medical Center   39.672,-94.5282' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var KINDRD = new L.marker(new L.LatLng(38.968,-94.5745),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KINDRD Kindred Hospital Kansas City   38.968,-94.5745' ,
                    }).addTo(fg).bindPopup('KINDRD Kindred Hospital Kansas City   38.968,-94.5745' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var KU0MED = new L.marker(new L.LatLng(39.557,-94.6102),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KU0MED University of Kansas Hospital   39.557,-94.6102' ,
                    }).addTo(fg).bindPopup('KU0MED University of Kansas Hospital   39.557,-94.6102' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var LIBRTY = new L.marker(new L.LatLng(39.274,-94.4233),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'LIBRTY Liberty Hospital   39.274,-94.4233' ,
                    }).addTo(fg).bindPopup('LIBRTY Liberty Hospital   39.274,-94.4233' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var LCHD19 = new L.marker(new L.LatLng(39.1732,-93.8748),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'LCHD19 LAFAYETTE CO HEALTH DEPT   39.1732,-93.8748' ,
                    }).addTo(fg).bindPopup('LCHD19 LAFAYETTE CO HEALTH DEPT   39.1732,-93.8748' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var LRHC = new L.marker(new L.LatLng(39.1893,-93.8768),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'LRHC LAFAYETTE REGIONAL HEALTH CENTER   39.1893,-93.8768' ,
                    }).addTo(fg).bindPopup('LRHC LAFAYETTE REGIONAL HEALTH CENTER   39.1893,-93.8768' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var LSMED = new L.marker(new L.LatLng(38.9035,-94.3327),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'LSMED Lee Summit Medical Center   38.9035,-94.3327' ,
                    }).addTo(fg).bindPopup('LSMED Lee Summit Medical Center   38.9035,-94.3327' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var MENORA = new L.marker(new L.LatLng(38.9107,-94.6512),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'MENORA Menorah Medical Center   38.9107,-94.6512' ,
                    }).addTo(fg).bindPopup('MENORA Menorah Medical Center   38.9107,-94.6512' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var NORKC = new L.marker(new L.LatLng(39.1495,-94.5513),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'NORKC North Kansas City Hospital   39.1495,-94.5513' ,
                    }).addTo(fg).bindPopup('NORKC North Kansas City Hospital   39.1495,-94.5513' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var OMC = new L.marker(new L.LatLng(38.853,-94.8235),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'OMC Olathe Medical Center, Inc.   38.853,-94.8235' ,
                    }).addTo(fg).bindPopup('OMC Olathe Medical Center, Inc.   38.853,-94.8235' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var OPR = new L.marker(new L.LatLng(39.9372,-94.7262),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'OPR Overland Park RMC   39.9372,-94.7262' ,
                    }).addTo(fg).bindPopup('OPR Overland Park RMC   39.9372,-94.7262' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var PETTIS = new L.marker(new L.LatLng(38.6973,-93.2163),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'PETTIS PETTIS Co Health Dept   38.6973,-93.2163' ,
                    }).addTo(fg).bindPopup('PETTIS PETTIS Co Health Dept   38.6973,-93.2163' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var PMC = new L.marker(new L.LatLng(39.127,-94.7865),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'PMC Providence Medical Center   39.127,-94.7865' ,
                    }).addTo(fg).bindPopup('PMC Providence Medical Center   39.127,-94.7865' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var RAYCO = new L.marker(new L.LatLng(39.2587,-93.9543),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'RAYCO RAY COUNTY HOSPITAL   39.2587,-93.9543' ,
                    }).addTo(fg).bindPopup('RAYCO RAY COUNTY HOSPITAL   39.2587,-93.9543' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var RESRCH = new L.marker(new L.LatLng(39.167,-94.6682),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'RESRCH Research Medical Center   39.167,-94.6682' ,
                    }).addTo(fg).bindPopup('RESRCH Research Medical Center   39.167,-94.6682' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var RMCBKS = new L.marker(new L.LatLng(39.8,-94.5778),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'RMCBKS Research Medical Center_ Brookside   39.8,-94.5778' ,
                    }).addTo(fg).bindPopup('RMCBKS Research Medical Center_ Brookside   39.8,-94.5778' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var SMMC = new L.marker(new L.LatLng(38.9955,-94.6908),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'SMMC Shawnee Mission Medical Center   38.9955,-94.6908' ,
                    }).addTo(fg).bindPopup('SMMC Shawnee Mission Medical Center   38.9955,-94.6908' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STJOHN = new L.marker(new L.LatLng(39.2822,-94.9058),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STJOHN Saint John Hospital   39.2822,-94.9058' ,
                    }).addTo(fg).bindPopup('STJOHN Saint John Hospital   39.2822,-94.9058' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STJOMC = new L.marker(new L.LatLng(38.9362,-94.6037),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STJOMC Saint Joseph Medical Center   38.9362,-94.6037' ,
                    }).addTo(fg).bindPopup('STJOMC Saint Joseph Medical Center   38.9362,-94.6037' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STLEAS = new L.marker(new L.LatLng(38.9415,-94.3813),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STLEAS Saint Lukes East_Lees Summit   38.9415,-94.3813' ,
                    }).addTo(fg).bindPopup('STLEAS Saint Lukes East_Lees Summit   38.9415,-94.3813' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STLPLZ = new L.marker(new L.LatLng(39.477,-94.5895),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STLPLZ Saint Lukes Hospital Plaza   39.477,-94.5895' ,
                    }).addTo(fg).bindPopup('STLPLZ Saint Lukes Hospital Plaza   39.477,-94.5895' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STLSMI = new L.marker(new L.LatLng(39.3758,-94.5807),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STLSMI Saint Lukes Smithville Campus   39.3758,-94.5807' ,
                    }).addTo(fg).bindPopup('STLSMI Saint Lukes Smithville Campus   39.3758,-94.5807' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STLUBR = new L.marker(new L.LatLng(39.2482,-94.6487),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STLUBR Saint Lukes Barry Road Campus   39.2482,-94.6487' ,
                    }).addTo(fg).bindPopup('STLUBR Saint Lukes Barry Road Campus   39.2482,-94.6487' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STLUSO = new L.marker(new L.LatLng(38.904,-94.6682),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STLUSO Saint Lukes South Hospital   38.904,-94.6682' ,
                    }).addTo(fg).bindPopup('STLUSO Saint Lukes South Hospital   38.904,-94.6682' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STM = new L.marker(new L.LatLng(39.263,-94.2627),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STM Saint Marys Medical Center   39.263,-94.2627' ,
                    }).addTo(fg).bindPopup('STM Saint Marys Medical Center   39.263,-94.2627' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var TRLKWD = new L.marker(new L.LatLng(38.9745,-94.3915),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'TRLKWD Truman Lakewood   38.9745,-94.3915' ,
                    }).addTo(fg).bindPopup('TRLKWD Truman Lakewood   38.9745,-94.3915' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var TRUHH = new L.marker(new L.LatLng(39.853,-94.5737),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'TRUHH Truman Medical Center_Hospital Hill   39.853,-94.5737' ,
                    }).addTo(fg).bindPopup('TRUHH Truman Medical Center_Hospital Hill   39.853,-94.5737' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var W0CPT = new L.marker(new L.LatLng(39.5,-94.3483),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'W0CPT Centerpoint Medical Center   39.5,-94.3483' ,
                    }).addTo(fg).bindPopup('W0CPT Centerpoint Medical Center   39.5,-94.3483' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var WEMO = new L.marker(new L.LatLng(38.7667,-93.7217),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'WEMO WESTERN MISSOURI MEDICAL CENTER   38.7667,-93.7217' ,
                    }).addTo(fg).bindPopup('WEMO WESTERN MISSOURI MEDICAL CENTER   38.7667,-93.7217' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var KCRCNC = new L.marker(new L.LatLng(38.1788722,-93.3541889),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KCRCNC Kansas City Room, KD0CNC  KD0CNC 38.1788722,-93.3541889' ,
                    }).addTo(fg).bindPopup('KCRCNC Kansas City Room, KD0CNC  KD0CNC 38.1788722,-93.3541889' );                        
         
                $('kd0cnc'._icon).addClass('flagmrkr');
            
            var KCRWW = new L.marker(new L.LatLng(39.0465806,-94.5874444),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KCRWW Kansas City Room, N0WW  Keith Little NØWW 39.0465806,-94.5874444' ,
                    }).addTo(fg).bindPopup('KCRWW Kansas City Room, N0WW  Keith Little NØWW 39.0465806,-94.5874444' );                        
         
                $('keith little nøww'._icon).addClass('flagmrkr');
            
            var EOC399 = new L.marker(new L.LatLng(34.248206,-80.606327),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'EOC399 A EOC  Kershaw County EOC 34.248206,-80.606327' ,
                    }).addTo(fg).bindPopup('EOC399 A EOC  Kershaw County EOC 34.248206,-80.606327' );                        
         
                $('kershaw county eoc'._icon).addClass('flagmrkr');
            
            var Fire400 = new L.marker(new L.LatLng(34.245217,-80.602271),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'Fire400 Kershaw FD1  Kershaw County Fire / Sheriff 34.245217,-80.602271' ,
                    }).addTo(fg).bindPopup('Fire400 Kershaw FD1  Kershaw County Fire / Sheriff 34.245217,-80.602271' );                        
         
                $('kershaw county fire / sheriff'._icon).addClass('flagmrkr');
            
            var KCRROO = new L.marker(new L.LatLng(39.2819722,-94.9058889),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KCRROO Kansas City Room, W0ROO  Leavenworth club repeater 39.2819722,-94.9058889' ,
                    }).addTo(fg).bindPopup('KCRROO Kansas City Room, W0ROO  Leavenworth club repeater 39.2819722,-94.9058889' );                        
         
                $('leavenworth club repeater'._icon).addClass('flagmrkr');
            
            var LecRestStop = new L.marker(new L.LatLng(38.994852,-95.399612),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'LecRestStop Lecompton Rest Stop  Lecompton Rest Stop  38.994852,-95.399612' ,
                    }).addTo(fg).bindPopup('LecRestStop Lecompton Rest Stop  Lecompton Rest Stop  38.994852,-95.399612' );                        
         
                $('lecompton rest stop '._icon).addClass('flagmrkr');
            
            var SJH160 = new L.marker(new L.LatLng(40.7841,-124.1422),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'SJH160 St Joseph Hospital  Level 3 Trauma Center, Helipad 40.7841,-124.1422' ,
                    }).addTo(fg).bindPopup('SJH160 St Joseph Hospital  Level 3 Trauma Center, Helipad 40.7841,-124.1422' );                        
         
                $('level 3 trauma center, helipad'._icon).addClass('flagmrkr');
            
            var MRCH161 = new L.marker(new L.LatLng(40.8963,-124.0917),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'MRCH161 Mad River Community Hospital  Level 4 Trauma Center, Helipad 40.8963,-124.0917' ,
                    }).addTo(fg).bindPopup('MRCH161 Mad River Community Hospital  Level 4 Trauma Center, Helipad 40.8963,-124.0917' );                        
         
                $('level 4 trauma center, helipad'._icon).addClass('flagmrkr');
            
            var BROADWAY = new L.marker(new L.LatLng(39.34261,-94.22378),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'BROADWAY KK7 _ Down Town  No Known Repeater Available 39.34261,-94.22378' ,
                    }).addTo(fg).bindPopup('BROADWAY KK7 _ Down Town  No Known Repeater Available 39.34261,-94.22378' );                        
         
                $('no known repeater available'._icon).addClass('flagmrkr');
            
            var DB0QA = new L.marker(new L.LatLng(50.875067,6.16656),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'DB0QA 70cm Alsdorf  Operator DB9KN Max 50.875067,6.16656' ,
                    }).addTo(fg).bindPopup('DB0QA 70cm Alsdorf  Operator DB9KN Max 50.875067,6.16656' );                        
         
                $('operator db9kn max'._icon).addClass('flagmrkr');
            
            var DB0WA = new L.marker(new L.LatLng(50.745647,6.043222),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'DB0WA 2m Aachen  Operator DF1VB Jochen 50.745647,6.043222' ,
                    }).addTo(fg).bindPopup('DB0WA 2m Aachen  Operator DF1VB Jochen 50.745647,6.043222' );                        
         
                $('operator df1vb jochen'._icon).addClass('flagmrkr');
            
            var DB0AVR = new L.marker(new L.LatLng(50.764271,6.218675),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'DB0AVR 70cm Stolberg  Operator DH6KQ Andreas 50.764271,6.218675' ,
                    }).addTo(fg).bindPopup('DB0AVR 70cm Stolberg  Operator DH6KQ Andreas 50.764271,6.218675' );                        
         
                $('operator dh6kq andreas'._icon).addClass('flagmrkr');
            
            var DJ2UB = new L.marker(new L.LatLng(50.756536,6.158414),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'DJ2UB 70cm Aachen Brand  Operator DJ2UN Uli 50.756536,6.158414' ,
                    }).addTo(fg).bindPopup('DJ2UB 70cm Aachen Brand  Operator DJ2UN Uli 50.756536,6.158414' );                        
         
                $('operator dj2un uli'._icon).addClass('flagmrkr');
            
            var DB0SE = new L.marker(new L.LatLng(50.477617,6.52308),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'DB0SE 70cm Kall  Operator DL8KBX Klaus 50.477617,6.52308' ,
                    }).addTo(fg).bindPopup('DB0SE 70cm Kall  Operator DL8KBX Klaus 50.477617,6.52308' );                        
         
                $('operator dl8kbx klaus'._icon).addClass('flagmrkr');
            
            var DB0NIS = new L.marker(new L.LatLng(50.65722,6.398236),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'DB0NIS 70cm Nideggen_Schmidt  Operator DL8KCS Werner 50.65722,6.398236' ,
                    }).addTo(fg).bindPopup('DB0NIS 70cm Nideggen_Schmidt  Operator DL8KCS Werner 50.65722,6.398236' );                        
         
                $('operator dl8kcs werner'._icon).addClass('flagmrkr');
            
            var WA0QFJ = new L.marker(new L.LatLng(39.273172,-94.663137),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'WA0QFJ PCARG Repeater (147.330MHz T:151.4/444.550MHz )  PCARG club repeater 39.273172,-94.663137' ,
                    }).addTo(fg).bindPopup('WA0QFJ PCARG Repeater (147.330MHz T:151.4/444.550MHz )  PCARG club repeater 39.273172,-94.663137' );                        
         
                $('pcarg club repeater'._icon).addClass('flagmrkr');
            
            var KCRQFJ = new L.marker(new L.LatLng(39.2731222,-94.6629583),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KCRQFJ Kansas City Room, WA0QFJ  PCARG Club Repeater 39.2731222,-94.6629583' ,
                    }).addTo(fg).bindPopup('KCRQFJ Kansas City Room, WA0QFJ  PCARG Club Repeater 39.2731222,-94.6629583' );                        
         
                $('pcarg club repeater'._icon).addClass('flagmrkr');
            
            var PTPOLICE1925 = new L.marker(new L.LatLng(48.11464,-122.77136),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'PTPOLICE1925 PT POLICE   48.11464,-122.77136' ,
                    }).addTo(fg).bindPopup('PTPOLICE1925 PT POLICE   48.11464,-122.77136' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var FPD93721 = new L.marker(new L.LatLng(36.737611,-119.78787),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'FPD93721 Fresno Police Department   36.737611,-119.78787' ,
                    }).addTo(fg).bindPopup('FPD93721 Fresno Police Department   36.737611,-119.78787' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var NRTPD = new L.marker(new L.LatLng(39.183487,-94.605311),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'NRTPD Northmoor Police Department   39.183487,-94.605311' ,
                    }).addTo(fg).bindPopup('NRTPD Northmoor Police Department   39.183487,-94.605311' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var RVRSPD = new L.marker(new L.LatLng(39.175239,-94.616458),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'RVRSPD Riverside City Police Department   39.175239,-94.616458' ,
                    }).addTo(fg).bindPopup('RVRSPD Riverside City Police Department   39.175239,-94.616458' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var PKVLPD = new L.marker(new L.LatLng(39.207055,-94.683832),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'PKVLPD Parkville Police Department   39.207055,-94.683832' ,
                    }).addTo(fg).bindPopup('PKVLPD Parkville Police Department   39.207055,-94.683832' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var LKWKPD = new L.marker(new L.LatLng(39.227468,-94.634039),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'LKWKPD Lake Waukomis Police Department   39.227468,-94.634039' ,
                    }).addTo(fg).bindPopup('LKWKPD Lake Waukomis Police Department   39.227468,-94.634039' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var GSTNPD = new L.marker(new L.LatLng(39.221477,-94.57198),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'GSTNPD Gladstone Police Department   39.221477,-94.57198' ,
                    }).addTo(fg).bindPopup('GSTNPD Gladstone Police Department   39.221477,-94.57198' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var NKCPD = new L.marker(new L.LatLng(39.143363,-94.573404),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'NKCPD North Kansas City Police Department   39.143363,-94.573404' ,
                    }).addTo(fg).bindPopup('NKCPD North Kansas City Police Department   39.143363,-94.573404' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var COMOPD = new L.marker(new L.LatLng(39.197769,-94.5038),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'COMOPD Claycomo Police Department   39.197769,-94.5038' ,
                    }).addTo(fg).bindPopup('COMOPD Claycomo Police Department   39.197769,-94.5038' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var KCNPPD = new L.marker(new L.LatLng(39.291975,-94.684958),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'KCNPPD Kansas City Police North Patrol   39.291975,-94.684958' ,
                    }).addTo(fg).bindPopup('KCNPPD Kansas City Police North Patrol   39.291975,-94.684958' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var PLTCTYPD = new L.marker(new L.LatLng(39.370039,-94.77987),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'PLTCTYPD Platte City Police Department   39.370039,-94.77987' ,
                    }).addTo(fg).bindPopup('PLTCTYPD Platte City Police Department   39.370039,-94.77987' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var KSZS = new L.marker(new L.LatLng(50.598817,6.289012),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'KSZS Katastrophenschutzzentrum   50.598817,6.289012' ,
                    }).addTo(fg).bindPopup('KSZS Katastrophenschutzzentrum   50.598817,6.289012' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var HPA172 = new L.marker(new L.LatLng(40.86155,-124.07923),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'HPA172 Highway Patrol_Arcata   40.86155,-124.07923' ,
                    }).addTo(fg).bindPopup('HPA172 Highway Patrol_Arcata   40.86155,-124.07923' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var LTRDUSFS191 = new L.marker(new L.LatLng(40.9472,-123.63672),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'LTRDUSFS191 Lower Trinity Ranger District U.S. Forest Service   40.9472,-123.63672' ,
                    }).addTo(fg).bindPopup('LTRDUSFS191 Lower Trinity Ranger District U.S. Forest Service   40.9472,-123.63672' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var LTRD193 = new L.marker(new L.LatLng(40.88817,-123.58598),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'LTRD193 Lower Trinity Ranger District   40.88817,-123.58598' ,
                    }).addTo(fg).bindPopup('LTRD193 Lower Trinity Ranger District   40.88817,-123.58598' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var USFSMRRDO206 = new L.marker(new L.LatLng(40.46494,-123.53175),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'USFSMRRDO206 US Forest Service Mad River Ranger District Office   40.46494,-123.53175' ,
                    }).addTo(fg).bindPopup('USFSMRRDO206 US Forest Service Mad River Ranger District Office   40.46494,-123.53175' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var CHPGS227 = new L.marker(new L.LatLng(40.11593,-123.81354),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'CHPGS227 California Highway Patrol_Garberville Station   40.11593,-123.81354' ,
                    }).addTo(fg).bindPopup('CHPGS227 California Highway Patrol_Garberville Station   40.11593,-123.81354' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var EPD228 = new L.marker(new L.LatLng(40.8006,-124.16932),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'EPD228 Eureka Police Department   40.8006,-124.16932' ,
                    }).addTo(fg).bindPopup('EPD228 Eureka Police Department   40.8006,-124.16932' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var FPD229 = new L.marker(new L.LatLng(40.57692,-124.26119),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'FPD229 Ferndale Police Department  CERT governing body 40.57692,-124.26119' ,
                    }).addTo(fg).bindPopup('FPD229 Ferndale Police Department  CERT governing body 40.57692,-124.26119' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var FPD230 = new L.marker(new L.LatLng(40.59758,-124.15494),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'FPD230 Fortuna Police Department   40.59758,-124.15494' ,
                    }).addTo(fg).bindPopup('FPD230 Fortuna Police Department   40.59758,-124.15494' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var APD231 = new L.marker(new L.LatLng(40.86734,-124.08477),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'APD231 Arcata Police Department  CERT governing body 40.86734,-124.08477' ,
                    }).addTo(fg).bindPopup('APD231 Arcata Police Department  CERT governing body 40.86734,-124.08477' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var TPD232 = new L.marker(new L.LatLng(41.05984,-124.14284),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'TPD232 Trinidad Police Department   41.05984,-124.14284' ,
                    }).addTo(fg).bindPopup('TPD232 Trinidad Police Department   41.05984,-124.14284' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var HSUCP233 = new L.marker(new L.LatLng(40.87461,-124.07913),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'HSUCP233 Humboldt State University Campus Police   40.87461,-124.07913' ,
                    }).addTo(fg).bindPopup('HSUCP233 Humboldt State University Campus Police   40.87461,-124.07913' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var RDPD234 = new L.marker(new L.LatLng(40.4991,-124.10674),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'RDPD234 Rio Dell Police Department   40.4991,-124.10674' ,
                    }).addTo(fg).bindPopup('RDPD234 Rio Dell Police Department   40.4991,-124.10674' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var HTP235 = new L.marker(new L.LatLng(41.06548,-123.68557),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'HTP235 Hoopa Tribal Police   41.06548,-123.68557' ,
                    }).addTo(fg).bindPopup('HTP235 Hoopa Tribal Police   41.06548,-123.68557' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var BLPD236 = new L.marker(new L.LatLng(40.8827,-123.99215),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'BLPD236 Blue Lake Police Department   40.8827,-123.99215' ,
                    }).addTo(fg).bindPopup('BLPD236 Blue Lake Police Department   40.8827,-123.99215' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var CHPDC237 = new L.marker(new L.LatLng(40.79191,-124.17572),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'CHPDC237 California Highway Patrol Dispatch Center   40.79191,-124.17572' ,
                    }).addTo(fg).bindPopup('CHPDC237 California Highway Patrol Dispatch Center   40.79191,-124.17572' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var CDFW250 = new L.marker(new L.LatLng(40.80494,-124.16492),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'CDFW250 California Department of Fish and Wildlife   40.80494,-124.16492' ,
                    }).addTo(fg).bindPopup('CDFW250 California Department of Fish and Wildlife   40.80494,-124.16492' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var W7JCR268 = new L.marker(new L.LatLng(48.124567,-122.76529),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W7JCR268 W7JCR  145.15- 114.8 48.124567,-122.76529' ,
                    }).addTo(fg).bindPopup('W7JCR268 W7JCR  145.15- 114.8 48.124567,-122.76529' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var AA7MI269 = new L.marker(new L.LatLng(48.040336,-122.687109),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'AA7MI269 AA7MI  440.725+ 114.8 48.040336,-122.687109' ,
                    }).addTo(fg).bindPopup('AA7MI269 AA7MI  440.725+ 114.8 48.040336,-122.687109' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var AA7MI270 = new L.marker(new L.LatLng(48.116172,-122.764327),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'AA7MI270 AA7MI  443.825+ CC1 48.116172,-122.764327' ,
                    }).addTo(fg).bindPopup('AA7MI270 AA7MI  443.825+ CC1 48.116172,-122.764327' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var ON0RBO = new L.marker(new L.LatLng(50.653178,6.168431),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'ON0RBO 70cm Petergensfeld    50.653178,6.168431' ,
                    }).addTo(fg).bindPopup('ON0RBO 70cm Petergensfeld    50.653178,6.168431' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GS = new L.marker(new L.LatLng(33.9137001,-79.04519653),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GS W4GS  145.11 PL 85.4 OFFSET - 33.9137001,-79.04519653' ,
                    }).addTo(fg).bindPopup('W4GS W4GS  145.11 PL 85.4 OFFSET - 33.9137001,-79.04519653' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KT4TF = new L.marker(new L.LatLng(34.99580002,-80.85500336),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KT4TF KT4TF  145.11 PL 110.9 OFFSET - 34.99580002,-80.85500336' ,
                    }).addTo(fg).bindPopup('KT4TF KT4TF  145.11 PL 110.9 OFFSET - 34.99580002,-80.85500336' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4DV = new L.marker(new L.LatLng(33.4734993,-82.01049805),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4DV W4DV  145.11 PL 71.9 OFFSET - 33.4734993,-82.01049805' ,
                    }).addTo(fg).bindPopup('W4DV W4DV  145.11 PL 71.9 OFFSET - 33.4734993,-82.01049805' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4BFT = new L.marker(new L.LatLng(32.39139938,-80.74849701),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4BFT W4BFT  145.13 PL 88.5 OFFSET - 32.39139938,-80.74849701' ,
                    }).addTo(fg).bindPopup('W4BFT W4BFT  145.13 PL 88.5 OFFSET - 32.39139938,-80.74849701' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KM4ABW = new L.marker(new L.LatLng(33.68700027,-80.21170044),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KM4ABW KM4ABW  145.15 PL 91.5 OFFSET - 33.68700027,-80.21170044' ,
                    }).addTo(fg).bindPopup('KM4ABW KM4ABW  145.15 PL 91.5 OFFSET - 33.68700027,-80.21170044' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4TWX = new L.marker(new L.LatLng(34.88339996,-82.70739746),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4TWX W4TWX  145.17 PL 162.2 OFFSET - 34.88339996,-82.70739746' ,
                    }).addTo(fg).bindPopup('W4TWX W4TWX  145.17 PL 162.2 OFFSET - 34.88339996,-82.70739746' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4LMD = new L.marker(new L.LatLng(33.203402,-80.799942),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4LMD K4LMD  145.21 PL 100 OFFSET - 33.203402,-80.799942' ,
                    }).addTo(fg).bindPopup('K4LMD K4LMD  145.21 PL 100 OFFSET - 33.203402,-80.799942' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4APE = new L.marker(new L.LatLng(33.58100128,-79.98899841),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4APE W4APE  145.23 PL 123 OFFSET - 33.58100128,-79.98899841' ,
                    }).addTo(fg).bindPopup('W4APE W4APE  145.23 PL 123 OFFSET - 33.58100128,-79.98899841' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4WD = new L.marker(new L.LatLng(34.88100052,-83.09889984),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4WD K4WD  145.29 PL 162.2 OFFSET - 34.88100052,-83.09889984' ,
                    }).addTo(fg).bindPopup('K4WD K4WD  145.29 PL 162.2 OFFSET - 34.88100052,-83.09889984' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4CHR = new L.marker(new L.LatLng(34.68790054,-81.17980194),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4CHR W4CHR  145.31 PL 167.9 OFFSET - 34.68790054,-81.17980194' ,
                    }).addTo(fg).bindPopup('W4CHR W4CHR  145.31 PL 167.9 OFFSET - 34.68790054,-81.17980194' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4IAR = new L.marker(new L.LatLng(32.21630096,-80.75260162),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4IAR W4IAR  145.31 PL 100 OFFSET - 32.21630096,-80.75260162' ,
                    }).addTo(fg).bindPopup('W4IAR W4IAR  145.31 PL 100 OFFSET - 32.21630096,-80.75260162' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var NE4SC = new L.marker(new L.LatLng(33.75859833,-79.72820282),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'NE4SC NE4SC  145.31 PL 123 OFFSET - 33.75859833,-79.72820282' ,
                    }).addTo(fg).bindPopup('NE4SC NE4SC  145.31 PL 123 OFFSET - 33.75859833,-79.72820282' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WB4TGK = new L.marker(new L.LatLng(33.29710007,-81.03479767),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WB4TGK WB4TGK  145.33 PL 156.7 OFFSET - 33.29710007,-81.03479767' ,
                    }).addTo(fg).bindPopup('WB4TGK WB4TGK  145.33 PL 156.7 OFFSET - 33.29710007,-81.03479767' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var N2ZZ = new L.marker(new L.LatLng(33.57089996,-81.76309967),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'N2ZZ N2ZZ  145.35 PL 156.7 OFFSET - 33.57089996,-81.76309967' ,
                    }).addTo(fg).bindPopup('N2ZZ N2ZZ  145.35 PL 156.7 OFFSET - 33.57089996,-81.76309967' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC = new L.marker(new L.LatLng(34.94060135,-82.41059875),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC WR4SC  145.37 PL 123 OFFSET - 34.94060135,-82.41059875' ,
                    }).addTo(fg).bindPopup('WR4SC WR4SC  145.37 PL 123 OFFSET - 34.94060135,-82.41059875' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KG4BZN = new L.marker(new L.LatLng(32.90520096,-80.66680145),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KG4BZN KG4BZN  145.39 PL  OFFSET - 32.90520096,-80.66680145' ,
                    }).addTo(fg).bindPopup('KG4BZN KG4BZN  145.39 PL  OFFSET - 32.90520096,-80.66680145' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KJ4BWK = new L.marker(new L.LatLng(34.0007019,-81.03479767),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KJ4BWK KJ4BWK  145.4 PL  OFFSET - 34.0007019,-81.03479767' ,
                    }).addTo(fg).bindPopup('KJ4BWK KJ4BWK  145.4 PL  OFFSET - 34.0007019,-81.03479767' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA4USN = new L.marker(new L.LatLng(32.58060074,-80.15969849),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA4USN WA4USN  145.41 PL 123 OFFSET - 32.58060074,-80.15969849' ,
                    }).addTo(fg).bindPopup('WA4USN WA4USN  145.41 PL 123 OFFSET - 32.58060074,-80.15969849' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KE4MDP = new L.marker(new L.LatLng(35.0461998,-81.58930206),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KE4MDP KE4MDP  145.43 PL 162.2 OFFSET - 35.0461998,-81.58930206' ,
                    }).addTo(fg).bindPopup('KE4MDP KE4MDP  145.43 PL 162.2 OFFSET - 35.0461998,-81.58930206' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GL = new L.marker(new L.LatLng(33.96319962,-80.40219879),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GL W4GL  145.43 PL 156.7 OFFSET - 33.96319962,-80.40219879' ,
                    }).addTo(fg).bindPopup('W4GL W4GL  145.43 PL 156.7 OFFSET - 33.96319962,-80.40219879' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4HRS = new L.marker(new L.LatLng(32.78419876,-79.94499969),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4HRS W4HRS  145.45 PL 123 OFFSET - 32.78419876,-79.94499969' ,
                    }).addTo(fg).bindPopup('W4HRS W4HRS  145.45 PL 123 OFFSET - 32.78419876,-79.94499969' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4ZKM = new L.marker(new L.LatLng(33.26150131,-81.65670013),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4ZKM W4ZKM  145.45 PL 123 OFFSET - 33.26150131,-81.65670013' ,
                    }).addTo(fg).bindPopup('W4ZKM W4ZKM  145.45 PL 123 OFFSET - 33.26150131,-81.65670013' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K9OH = new L.marker(new L.LatLng(35.10570145,-82.62760162),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K9OH K9OH  145.47 PL 91.5 OFFSET - 35.10570145,-82.62760162' ,
                    }).addTo(fg).bindPopup('K9OH K9OH  145.47 PL 91.5 OFFSET - 35.10570145,-82.62760162' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4APE = new L.marker(new L.LatLng(34.19979858,-79.23249817),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4APE W4APE  145.47 PL 123 OFFSET - 34.19979858,-79.23249817' ,
                    }).addTo(fg).bindPopup('W4APE W4APE  145.47 PL 123 OFFSET - 34.19979858,-79.23249817' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4APE = new L.marker(new L.LatLng(34.74810028,-79.84259796),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4APE W4APE  145.49 PL 123 OFFSET - 34.74810028,-79.84259796' ,
                    }).addTo(fg).bindPopup('W4APE W4APE  145.49 PL 123 OFFSET - 34.74810028,-79.84259796' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4HRS = new L.marker(new L.LatLng(33.19889832,-80.00689697),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4HRS W4HRS  145.49 PL 103.5 OFFSET - 33.19889832,-80.00689697' ,
                    }).addTo(fg).bindPopup('W4HRS W4HRS  145.49 PL 103.5 OFFSET - 33.19889832,-80.00689697' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4DV = new L.marker(new L.LatLng(33.68489838,-81.92639923),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4DV W4DV  145.49 PL 71.9 OFFSET - 33.68489838,-81.92639923' ,
                    }).addTo(fg).bindPopup('W4DV W4DV  145.49 PL 71.9 OFFSET - 33.68489838,-81.92639923' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KK4ONF = new L.marker(new L.LatLng(32.4276903,-81.0087199),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KK4ONF KK4ONF  146.06 PL 123 OFFSET + 32.4276903,-81.0087199' ,
                    }).addTo(fg).bindPopup('KK4ONF KK4ONF  146.06 PL 123 OFFSET + 32.4276903,-81.0087199' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4KNJ = new L.marker(new L.LatLng(34.28580093,-79.24590302),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4KNJ K4KNJ  146.535 PL CSQ OFFSET x 34.28580093,-79.24590302' ,
                    }).addTo(fg).bindPopup('K4KNJ K4KNJ  146.535 PL CSQ OFFSET x 34.28580093,-79.24590302' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KW4BET = new L.marker(new L.LatLng(33.8420316,-78.6400437),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KW4BET KW4BET  146.58 PL D023 OFFSET x 33.8420316,-78.6400437' ,
                    }).addTo(fg).bindPopup('KW4BET KW4BET  146.58 PL D023 OFFSET x 33.8420316,-78.6400437' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4NYK = new L.marker(new L.LatLng(35.05569839,-82.7845993),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4NYK W4NYK  146.61 PL  OFFSET - 35.05569839,-82.7845993' ,
                    }).addTo(fg).bindPopup('W4NYK W4NYK  146.61 PL  OFFSET - 35.05569839,-82.7845993' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4BRK = new L.marker(new L.LatLng(33.19599915,-80.01309967),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4BRK W4BRK  146.61 PL 123 OFFSET - 33.19599915,-80.01309967' ,
                    }).addTo(fg).bindPopup('W4BRK W4BRK  146.61 PL 123 OFFSET - 33.19599915,-80.01309967' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GL = new L.marker(new L.LatLng(33.92039871,-80.34149933),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GL W4GL  146.64 PL 156.7 OFFSET - 33.92039871,-80.34149933' ,
                    }).addTo(fg).bindPopup('W4GL W4GL  146.64 PL 156.7 OFFSET - 33.92039871,-80.34149933' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4BFT = new L.marker(new L.LatLng(32.41880035,-80.68859863),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4BFT W4BFT  146.655 PL  OFFSET - 32.41880035,-80.68859863' ,
                    }).addTo(fg).bindPopup('W4BFT W4BFT  146.655 PL  OFFSET - 32.41880035,-80.68859863' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var AD4U = new L.marker(new L.LatLng(33.66490173,-80.7779007),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'AD4U AD4U  146.67 PL 156.7 OFFSET - 33.66490173,-80.7779007' ,
                    }).addTo(fg).bindPopup('AD4U AD4U  146.67 PL 156.7 OFFSET - 33.66490173,-80.7779007' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC = new L.marker(new L.LatLng(34.28020096,-79.74279785),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC WR4SC  146.685 PL 91.5 OFFSET - 34.28020096,-79.74279785' ,
                    }).addTo(fg).bindPopup('WR4SC WR4SC  146.685 PL 91.5 OFFSET - 34.28020096,-79.74279785' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KK4ZBE = new L.marker(new L.LatLng(32.83229828,-79.82839966),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KK4ZBE KK4ZBE  146.685 PL 162.2 OFFSET - 32.83229828,-79.82839966' ,
                    }).addTo(fg).bindPopup('KK4ZBE KK4ZBE  146.685 PL 162.2 OFFSET - 32.83229828,-79.82839966' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4USC = new L.marker(new L.LatLng(34.72969818,-81.63749695),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4USC K4USC  146.685 PL  OFFSET - 34.72969818,-81.63749695' ,
                    }).addTo(fg).bindPopup('K4USC K4USC  146.685 PL  OFFSET - 34.72969818,-81.63749695' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4HRS = new L.marker(new L.LatLng(33.37939835,-79.28469849),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4HRS W4HRS  146.7 PL 123 OFFSET - 33.37939835,-79.28469849' ,
                    }).addTo(fg).bindPopup('W4HRS W4HRS  146.7 PL 123 OFFSET - 33.37939835,-79.28469849' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4PAX = new L.marker(new L.LatLng(34.72040176,-80.77089691),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4PAX W4PAX  146.7 PL 123 OFFSET - 34.72040176,-80.77089691' ,
                    }).addTo(fg).bindPopup('W4PAX W4PAX  146.7 PL 123 OFFSET - 34.72040176,-80.77089691' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WT4F = new L.marker(new L.LatLng(34.88339996,-82.70739746),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WT4F WT4F  146.7 PL 107.2 OFFSET - 34.88339996,-82.70739746' ,
                    }).addTo(fg).bindPopup('WT4F WT4F  146.7 PL 107.2 OFFSET - 34.88339996,-82.70739746' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC = new L.marker(new L.LatLng(33.9496994,-79.1085968),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC WR4SC  146.715 PL 162.2 OFFSET - 33.9496994,-79.1085968' ,
                    }).addTo(fg).bindPopup('WR4SC WR4SC  146.715 PL 162.2 OFFSET - 33.9496994,-79.1085968' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC = new L.marker(new L.LatLng(34.11859894,-80.93689728),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC WR4SC  146.715 PL 91.5 OFFSET - 34.11859894,-80.93689728' ,
                    }).addTo(fg).bindPopup('WR4SC WR4SC  146.715 PL 91.5 OFFSET - 34.11859894,-80.93689728' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC = new L.marker(new L.LatLng(32.90520096,-80.66680145),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC WR4SC  146.715 PL 123 OFFSET - 32.90520096,-80.66680145' ,
                    }).addTo(fg).bindPopup('WR4SC WR4SC  146.715 PL 123 OFFSET - 32.90520096,-80.66680145' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4NAB = new L.marker(new L.LatLng(33.50180054,-81.96510315),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4NAB K4NAB  146.73 PL  OFFSET - 33.50180054,-81.96510315' ,
                    }).addTo(fg).bindPopup('K4NAB K4NAB  146.73 PL  OFFSET - 33.50180054,-81.96510315' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4HRS = new L.marker(new L.LatLng(32.97570038,-80.07230377),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4HRS W4HRS  146.73 PL 123 OFFSET - 32.97570038,-80.07230377' ,
                    }).addTo(fg).bindPopup('W4HRS W4HRS  146.73 PL 123 OFFSET - 32.97570038,-80.07230377' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA4UKX = new L.marker(new L.LatLng(34.73709869,-82.25430298),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA4UKX WA4UKX  146.73 PL 100 OFFSET - 34.73709869,-82.25430298' ,
                    }).addTo(fg).bindPopup('WA4UKX WA4UKX  146.73 PL 100 OFFSET - 34.73709869,-82.25430298' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4PDE = new L.marker(new L.LatLng(34.3689003,-79.32839966),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4PDE W4PDE  146.745 PL 82.5 OFFSET - 34.3689003,-79.32839966' ,
                    }).addTo(fg).bindPopup('W4PDE W4PDE  146.745 PL 82.5 OFFSET - 34.3689003,-79.32839966' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4FTK = new L.marker(new L.LatLng(34.188721,-81.404594),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4FTK W4FTK  146.745 PL D315 OFFSET - 34.188721,-81.404594' ,
                    }).addTo(fg).bindPopup('W4FTK W4FTK  146.745 PL D315 OFFSET - 34.188721,-81.404594' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC = new L.marker(new L.LatLng(32.92440033,-79.69940186),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC WR4SC  146.76 PL 123 OFFSET - 32.92440033,-79.69940186' ,
                    }).addTo(fg).bindPopup('WR4SC WR4SC  146.76 PL 123 OFFSET - 32.92440033,-79.69940186' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4FTK = new L.marker(new L.LatLng(34.715431,-81.019479),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4FTK W4FTK  146.76 PL D315 OFFSET - 34.715431,-81.019479' ,
                    }).addTo(fg).bindPopup('W4FTK W4FTK  146.76 PL D315 OFFSET - 34.715431,-81.019479' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KCRHCV = new L.marker(new L.LatLng(38.8648222,-94.7789944),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KCRHCV Kansas City Room Host #28952  Hosts the Kansas City Room #28952 38.8648222,-94.7789944' ,
                    }).addTo(fg).bindPopup('KCRHCV Kansas City Room Host #28952  Hosts the Kansas City Room #28952 38.8648222,-94.7789944' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4CAE = new L.marker(new L.LatLng(34.05509949,-80.8321991),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4CAE W4CAE  146.775 PL 156.7 OFFSET - 34.05509949,-80.8321991' ,
                    }).addTo(fg).bindPopup('W4CAE W4CAE  146.775 PL 156.7 OFFSET - 34.05509949,-80.8321991' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA4USN = new L.marker(new L.LatLng(32.79059982,-79.90809631),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA4USN WA4USN  146.79 PL 123 OFFSET - 32.79059982,-79.90809631' ,
                    }).addTo(fg).bindPopup('WA4USN WA4USN  146.79 PL 123 OFFSET - 32.79059982,-79.90809631' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var N4AW = new L.marker(new L.LatLng(35.06480026,-82.77739716),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'N4AW N4AW  146.79 PL  OFFSET - 35.06480026,-82.77739716' ,
                    }).addTo(fg).bindPopup('N4AW N4AW  146.79 PL  OFFSET - 35.06480026,-82.77739716' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GS = new L.marker(new L.LatLng(33.55099869,-79.04139709),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GS W4GS  146.805 PL 85.4 OFFSET - 33.55099869,-79.04139709' ,
                    }).addTo(fg).bindPopup('W4GS W4GS  146.805 PL 85.4 OFFSET - 33.55099869,-79.04139709' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KJ4QLH = new L.marker(new L.LatLng(33.53,-80.82),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KJ4QLH KJ4QLH  146.805 PL 156.7 OFFSET - 33.53,-80.82' ,
                    }).addTo(fg).bindPopup('KJ4QLH KJ4QLH  146.805 PL 156.7 OFFSET - 33.53,-80.82' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4NYK = new L.marker(new L.LatLng(34.94120026,-82.41069794),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4NYK W4NYK  146.82 PL  OFFSET - 34.94120026,-82.41069794' ,
                    }).addTo(fg).bindPopup('W4NYK W4NYK  146.82 PL  OFFSET - 34.94120026,-82.41069794' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KI4RAX = new L.marker(new L.LatLng(34.20999908,-80.69000244),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KI4RAX KI4RAX  146.82 PL 91.5 OFFSET - 34.20999908,-80.69000244' ,
                    }).addTo(fg).bindPopup('KI4RAX KI4RAX  146.82 PL 91.5 OFFSET - 34.20999908,-80.69000244' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KA4GDW = new L.marker(new L.LatLng(33.35114,-80.68542),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KA4GDW KA4GDW  146.835 PL 179.9 OFFSET - 33.35114,-80.68542' ,
                    }).addTo(fg).bindPopup('KA4GDW KA4GDW  146.835 PL 179.9 OFFSET - 33.35114,-80.68542' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4ILT = new L.marker(new L.LatLng(33.18619919,-80.57939911),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4ILT K4ILT  146.835 PL 103.5 OFFSET - 33.18619919,-80.57939911' ,
                    }).addTo(fg).bindPopup('K4ILT K4ILT  146.835 PL 103.5 OFFSET - 33.18619919,-80.57939911' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4EC = new L.marker(new L.LatLng(33.7942009,-81.89029694),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4EC WR4EC  146.85 PL 91.5 OFFSET - 33.7942009,-81.89029694' ,
                    }).addTo(fg).bindPopup('WR4EC WR4EC  146.85 PL 91.5 OFFSET - 33.7942009,-81.89029694' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4ULH = new L.marker(new L.LatLng(34.28020096,-79.74279785),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4ULH W4ULH  146.85 PL 123 OFFSET - 34.28020096,-79.74279785' ,
                    }).addTo(fg).bindPopup('W4ULH W4ULH  146.85 PL 123 OFFSET - 34.28020096,-79.74279785' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var N2OBS = new L.marker(new L.LatLng(32.9856987,-80.10980225),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'N2OBS N2OBS  146.865 PL 123 OFFSET - 32.9856987,-80.10980225' ,
                    }).addTo(fg).bindPopup('N2OBS N2OBS  146.865 PL 123 OFFSET - 32.9856987,-80.10980225' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KD4HLH = new L.marker(new L.LatLng(34.57160187,-82.11209869),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KD4HLH KD4HLH  146.865 PL 107.2 OFFSET - 34.57160187,-82.11209869' ,
                    }).addTo(fg).bindPopup('KD4HLH KD4HLH  146.865 PL 107.2 OFFSET - 34.57160187,-82.11209869' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4NYR = new L.marker(new L.LatLng(35.12120056,-81.51589966),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4NYR W4NYR  146.88 PL  OFFSET - 35.12120056,-81.51589966' ,
                    }).addTo(fg).bindPopup('W4NYR W4NYR  146.88 PL  OFFSET - 35.12120056,-81.51589966' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC = new L.marker(new L.LatLng(33.54309845,-80.82420349),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC WR4SC  146.88 PL 123 OFFSET - 33.54309845,-80.82420349' ,
                    }).addTo(fg).bindPopup('WR4SC WR4SC  146.88 PL 123 OFFSET - 33.54309845,-80.82420349' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4APE = new L.marker(new L.LatLng(34.74850082,-80.41680145),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4APE W4APE  146.895 PL 123 OFFSET - 34.74850082,-80.41680145' ,
                    }).addTo(fg).bindPopup('W4APE W4APE  146.895 PL 123 OFFSET - 34.74850082,-80.41680145' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4DEW = new L.marker(new L.LatLng(34.00149918,-81.77200317),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4DEW W4DEW  146.91 PL 123 OFFSET - 34.00149918,-81.77200317' ,
                    }).addTo(fg).bindPopup('W4DEW W4DEW  146.91 PL 123 OFFSET - 34.00149918,-81.77200317' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA4SJS = new L.marker(new L.LatLng(32.7118988,-80.68170166),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA4SJS WA4SJS  146.91 PL 156.7 OFFSET - 32.7118988,-80.68170166' ,
                    }).addTo(fg).bindPopup('WA4SJS WA4SJS  146.91 PL 156.7 OFFSET - 32.7118988,-80.68170166' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4APE = new L.marker(new L.LatLng(34.29270172,-80.33760071),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4APE W4APE  146.925 PL 123 OFFSET - 34.29270172,-80.33760071' ,
                    }).addTo(fg).bindPopup('W4APE W4APE  146.925 PL 123 OFFSET - 34.29270172,-80.33760071' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4IQQ = new L.marker(new L.LatLng(34.8526001,-82.39399719),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4IQQ W4IQQ  146.94 PL 107.2 OFFSET - 34.8526001,-82.39399719' ,
                    }).addTo(fg).bindPopup('W4IQQ W4IQQ  146.94 PL 107.2 OFFSET - 34.8526001,-82.39399719' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA4USN = new L.marker(new L.LatLng(32.9939003,-80.26999664),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA4USN WA4USN  146.94 PL 123 OFFSET - 32.9939003,-80.26999664' ,
                    }).addTo(fg).bindPopup('WA4USN WA4USN  146.94 PL 123 OFFSET - 32.9939003,-80.26999664' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var N4AW = new L.marker(new L.LatLng(34.51079941,-82.64679718),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'N4AW N4AW  146.97 PL 127.3 OFFSET - 34.51079941,-82.64679718' ,
                    }).addTo(fg).bindPopup('N4AW N4AW  146.97 PL 127.3 OFFSET - 34.51079941,-82.64679718' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KB4RRC = new L.marker(new L.LatLng(34.19910049,-79.76779938),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KB4RRC KB4RRC  146.97 PL 167.9 OFFSET - 34.19910049,-79.76779938' ,
                    }).addTo(fg).bindPopup('KB4RRC KB4RRC  146.97 PL 167.9 OFFSET - 34.19910049,-79.76779938' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W1GRE = new L.marker(new L.LatLng(32.96580124,-80.15750122),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W1GRE W1GRE  146.985 PL 123 OFFSET - 32.96580124,-80.15750122' ,
                    }).addTo(fg).bindPopup('W1GRE W1GRE  146.985 PL 123 OFFSET - 32.96580124,-80.15750122' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KO4L = new L.marker(new L.LatLng(34.06060028,-79.3125),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KO4L KO4L  147 PL 91.5 OFFSET - 34.06060028,-79.3125' ,
                    }).addTo(fg).bindPopup('KO4L KO4L  147 PL 91.5 OFFSET - 34.06060028,-79.3125' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WB4YXZ = new L.marker(new L.LatLng(34.90100098,-82.65930176),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WB4YXZ WB4YXZ  147 PL 151.4 OFFSET - 34.90100098,-82.65930176' ,
                    }).addTo(fg).bindPopup('WB4YXZ WB4YXZ  147 PL 151.4 OFFSET - 34.90100098,-82.65930176' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GL = new L.marker(new L.LatLng(33.8810997,-80.27059937),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GL W4GL  147.015 PL 156.7 OFFSET + 33.8810997,-80.27059937' ,
                    }).addTo(fg).bindPopup('W4GL W4GL  147.015 PL 156.7 OFFSET + 33.8810997,-80.27059937' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KK4BQ = new L.marker(new L.LatLng(33.18780136,-81.39689636),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KK4BQ KK4BQ  147.03 PL 156.7 OFFSET + 33.18780136,-81.39689636' ,
                    }).addTo(fg).bindPopup('KK4BQ KK4BQ  147.03 PL 156.7 OFFSET + 33.18780136,-81.39689636' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KJ4YLP = new L.marker(new L.LatLng(34.88249969,-83.09750366),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KJ4YLP KJ4YLP  147.03 PL 123 OFFSET - 34.88249969,-83.09750366' ,
                    }).addTo(fg).bindPopup('KJ4YLP KJ4YLP  147.03 PL 123 OFFSET - 34.88249969,-83.09750366' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4YTZ = new L.marker(new L.LatLng(34.83969879,-81.01860046),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4YTZ K4YTZ  147.03 PL 88.5 OFFSET - 34.83969879,-81.01860046' ,
                    }).addTo(fg).bindPopup('K4YTZ K4YTZ  147.03 PL 88.5 OFFSET - 34.83969879,-81.01860046' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4ILT = new L.marker(new L.LatLng(33.17359924,-80.57389832),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4ILT K4ILT  147.045 PL 103.5 OFFSET + 33.17359924,-80.57389832' ,
                    }).addTo(fg).bindPopup('K4ILT K4ILT  147.045 PL 103.5 OFFSET + 33.17359924,-80.57389832' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KK4ONF = new L.marker(new L.LatLng(32.28710175,-81.08070374),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KK4ONF KK4ONF  147.06 PL 123 OFFSET + 32.28710175,-81.08070374' ,
                    }).addTo(fg).bindPopup('KK4ONF KK4ONF  147.06 PL 123 OFFSET + 32.28710175,-81.08070374' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4FTK = new L.marker(new L.LatLng(33.854465,-80.529466),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4FTK W4FTK  147.06 PL D315 OFFSET + 33.854465,-80.529466' ,
                    }).addTo(fg).bindPopup('W4FTK W4FTK  147.06 PL D315 OFFSET + 33.854465,-80.529466' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KJ4QLH = new L.marker(new L.LatLng(33.52,-81.08),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KJ4QLH KJ4QLH  147.09 PL 156.7 OFFSET + 33.52,-81.08' ,
                    }).addTo(fg).bindPopup('KJ4QLH KJ4QLH  147.09 PL 156.7 OFFSET + 33.52,-81.08' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC = new L.marker(new L.LatLng(34.88639832,-81.82080078),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC WR4SC  147.09 PL 162.2 OFFSET + 34.88639832,-81.82080078' ,
                    }).addTo(fg).bindPopup('WR4SC WR4SC  147.09 PL 162.2 OFFSET + 34.88639832,-81.82080078' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC = new L.marker(new L.LatLng(32.80220032,-80.02359772),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC WR4SC  147.105 PL 123 OFFSET + 32.80220032,-80.02359772' ,
                    }).addTo(fg).bindPopup('WR4SC WR4SC  147.105 PL 123 OFFSET + 32.80220032,-80.02359772' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GS = new L.marker(new L.LatLng(33.68909836,-78.88670349),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GS W4GS  147.12 PL 85.4 OFFSET + 33.68909836,-78.88670349' ,
                    }).addTo(fg).bindPopup('W4GS W4GS  147.12 PL 85.4 OFFSET + 33.68909836,-78.88670349' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4CCC = new L.marker(new L.LatLng(34.74860001,-79.84140015),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4CCC K4CCC  147.135 PL 123 OFFSET + 34.74860001,-79.84140015' ,
                    }).addTo(fg).bindPopup('K4CCC K4CCC  147.135 PL 123 OFFSET + 34.74860001,-79.84140015' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KG4BZN = new L.marker(new L.LatLng(32.90520096,-80.66680145),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KG4BZN KG4BZN  147.135 PL  OFFSET + 32.90520096,-80.66680145' ,
                    }).addTo(fg).bindPopup('KG4BZN KG4BZN  147.135 PL  OFFSET + 32.90520096,-80.66680145' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GWD = new L.marker(new L.LatLng(34.37239838,-82.1678009),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GWD W4GWD  147.165 PL 107.2 OFFSET + 34.37239838,-82.1678009' ,
                    }).addTo(fg).bindPopup('W4GWD W4GWD  147.165 PL 107.2 OFFSET + 34.37239838,-82.1678009' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4HNK = new L.marker(new L.LatLng(33.14189911,-80.35079956),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4HNK W4HNK  147.18 PL 123 OFFSET + 33.14189911,-80.35079956' ,
                    }).addTo(fg).bindPopup('W4HNK W4HNK  147.18 PL 123 OFFSET + 33.14189911,-80.35079956' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4APE = new L.marker(new L.LatLng(34.24779892,-79.81109619),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4APE W4APE  147.195 PL 123 OFFSET + 34.24779892,-79.81109619' ,
                    }).addTo(fg).bindPopup('W4APE W4APE  147.195 PL 123 OFFSET + 34.24779892,-79.81109619' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WX4PG = new L.marker(new L.LatLng(34.9009497,-82.6592992),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WX4PG WX4PG  147.195 PL 141.3 OFFSET + 34.9009497,-82.6592992' ,
                    }).addTo(fg).bindPopup('WX4PG WX4PG  147.195 PL 141.3 OFFSET + 34.9009497,-82.6592992' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4FTK = new L.marker(new L.LatLng(33.969955,-79.03414),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4FTK W4FTK  147.21 PL D315 OFFSET + 33.969955,-79.03414' ,
                    }).addTo(fg).bindPopup('W4FTK W4FTK  147.21 PL D315 OFFSET + 33.969955,-79.03414' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC = new L.marker(new L.LatLng(34.19630051,-81.41230011),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC WR4SC  147.21 PL 156.7 OFFSET + 34.19630051,-81.41230011' ,
                    }).addTo(fg).bindPopup('WR4SC WR4SC  147.21 PL 156.7 OFFSET + 34.19630051,-81.41230011' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA4NMW = new L.marker(new L.LatLng(33.01300049,-80.25800323),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA4NMW WA4NMW  147.225 PL 123 OFFSET + 33.01300049,-80.25800323' ,
                    }).addTo(fg).bindPopup('WA4NMW WA4NMW  147.225 PL 123 OFFSET + 33.01300049,-80.25800323' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4FTK  = new L.marker(new L.LatLng(34.92490005,-81.02510071),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4FTK  W4FTK   147.225 PL 110.9 OFFSET + 34.92490005,-81.02510071' ,
                    }).addTo(fg).bindPopup('W4FTK  W4FTK   147.225 PL 110.9 OFFSET + 34.92490005,-81.02510071' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4IAR = new L.marker(new L.LatLng(32.21630096,-80.75260162),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4IAR W4IAR  147.24 PL 100 OFFSET + 32.21630096,-80.75260162' ,
                    }).addTo(fg).bindPopup('W4IAR W4IAR  147.24 PL 100 OFFSET + 32.21630096,-80.75260162' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GS = new L.marker(new L.LatLng(33.70660019,-78.87419891),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GS W4GS  147.24 PL 85.4 OFFSET + 33.70660019,-78.87419891' ,
                    }).addTo(fg).bindPopup('W4GS W4GS  147.24 PL 85.4 OFFSET + 33.70660019,-78.87419891' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KB4RRC = new L.marker(new L.LatLng(34.24750137,-79.81719971),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KB4RRC KB4RRC  147.255 PL 162.2 OFFSET + 34.24750137,-79.81719971' ,
                    }).addTo(fg).bindPopup('KB4RRC KB4RRC  147.255 PL 162.2 OFFSET + 34.24750137,-79.81719971' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4RRC = new L.marker(new L.LatLng(33.91289902,-81.52559662),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4RRC W4RRC  147.255 PL 123 OFFSET + 33.91289902,-81.52559662' ,
                    }).addTo(fg).bindPopup('W4RRC W4RRC  147.255 PL 123 OFFSET + 33.91289902,-81.52559662' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4ANK = new L.marker(new L.LatLng(33.14369965,-80.35639954),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4ANK W4ANK  147.27 PL 123 OFFSET + 33.14369965,-80.35639954' ,
                    }).addTo(fg).bindPopup('W4ANK W4ANK  147.27 PL 123 OFFSET + 33.14369965,-80.35639954' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA4JRJ = new L.marker(new L.LatLng(34.68569946,-82.95320129),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA4JRJ WA4JRJ  147.27 PL 91.5 OFFSET + 34.68569946,-82.95320129' ,
                    }).addTo(fg).bindPopup('WA4JRJ WA4JRJ  147.27 PL 91.5 OFFSET + 34.68569946,-82.95320129' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var N4HRS = new L.marker(new L.LatLng(34.99430084,-81.24199677),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'N4HRS N4HRS  147.27 PL 110.9 OFFSET + 34.99430084,-81.24199677' ,
                    }).addTo(fg).bindPopup('N4HRS N4HRS  147.27 PL 110.9 OFFSET + 34.99430084,-81.24199677' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var N4ADM = new L.marker(new L.LatLng(33.5603981,-81.71959686),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'N4ADM N4ADM  147.285 PL 100 OFFSET + 33.5603981,-81.71959686' ,
                    }).addTo(fg).bindPopup('N4ADM N4ADM  147.285 PL 100 OFFSET + 33.5603981,-81.71959686' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K2PJ = new L.marker(new L.LatLng(34.08570099,-79.07150269),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K2PJ K2PJ  147.285 PL 85.4 OFFSET + 34.08570099,-79.07150269' ,
                    }).addTo(fg).bindPopup('K2PJ K2PJ  147.285 PL 85.4 OFFSET + 34.08570099,-79.07150269' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KK4B = new L.marker(new L.LatLng(33.39550018,-79.95809937),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KK4B KK4B  147.3 PL 162.2 OFFSET + 33.39550018,-79.95809937' ,
                    }).addTo(fg).bindPopup('KK4B KK4B  147.3 PL 162.2 OFFSET + 33.39550018,-79.95809937' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4JLA = new L.marker(new L.LatLng(34.88639832,-81.82080078),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4JLA K4JLA  147.315 PL 123 OFFSET + 34.88639832,-81.82080078' ,
                    }).addTo(fg).bindPopup('K4JLA K4JLA  147.315 PL 123 OFFSET + 34.88639832,-81.82080078' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4CAE = new L.marker(new L.LatLng(34.0007019,-81.03479767),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4CAE W4CAE  147.33 PL 156.7 OFFSET + 34.0007019,-81.03479767' ,
                    }).addTo(fg).bindPopup('W4CAE W4CAE  147.33 PL 156.7 OFFSET + 34.0007019,-81.03479767' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC = new L.marker(new L.LatLng(33.40499878,-81.83750153),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC WR4SC  147.345 PL 91.5 OFFSET + 33.40499878,-81.83750153' ,
                    }).addTo(fg).bindPopup('WR4SC WR4SC  147.345 PL 91.5 OFFSET + 33.40499878,-81.83750153' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4ANK = new L.marker(new L.LatLng(32.77659988,-79.93090057),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4ANK W4ANK  147.345 PL 123 OFFSET + 32.77659988,-79.93090057' ,
                    }).addTo(fg).bindPopup('W4ANK W4ANK  147.345 PL 123 OFFSET + 32.77659988,-79.93090057' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4HI = new L.marker(new L.LatLng(34.0007019,-81.03479767),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4HI K4HI  147.36 PL 100 OFFSET + 34.0007019,-81.03479767' ,
                    }).addTo(fg).bindPopup('K4HI K4HI  147.36 PL 100 OFFSET + 34.0007019,-81.03479767' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KK4BQ = new L.marker(new L.LatLng(33.2448733,-81.3587177),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KK4BQ KK4BQ  147.375 PL 91.5 OFFSET + 33.2448733,-81.3587177' ,
                    }).addTo(fg).bindPopup('KK4BQ KK4BQ  147.375 PL 91.5 OFFSET + 33.2448733,-81.3587177' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var NE4SC = new L.marker(new L.LatLng(33.44609833,-79.28469849),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'NE4SC NE4SC  147.375 PL 123 OFFSET + 33.44609833,-79.28469849' ,
                    }).addTo(fg).bindPopup('NE4SC NE4SC  147.375 PL 123 OFFSET + 33.44609833,-79.28469849' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KA4FEC = new L.marker(new L.LatLng(33.98149872,-81.23619843),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KA4FEC KA4FEC  147.39 PL 156.7 OFFSET + 33.98149872,-81.23619843' ,
                    }).addTo(fg).bindPopup('KA4FEC KA4FEC  147.39 PL 156.7 OFFSET + 33.98149872,-81.23619843' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var N1RCW = new L.marker(new L.LatLng(32.256,-80.9581),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'N1RCW N1RCW  147.435 PL 88.5 OFFSET x 32.256,-80.9581' ,
                    }).addTo(fg).bindPopup('N1RCW N1RCW  147.435 PL 88.5 OFFSET x 32.256,-80.9581' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var ACT = new L.marker(new L.LatLng(38.896175,-95.174838),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'ACT Douglas County Emergency Management  147.03+ 88.5 Narrow band 2.5KHz UFN 38.896175,-95.174838' ,
                    }).addTo(fg).bindPopup('ACT Douglas County Emergency Management  147.03+ 88.5 Narrow band 2.5KHz UFN 38.896175,-95.174838' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var DCARC = new L.marker(new L.LatLng(38.896175,-95.174838),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'DCARC Douglas County Amateur Radio Club  146.76- 88.5 Narrow band 2.5KHz UFN 38.896175,-95.174838' ,
                    }).addTo(fg).bindPopup('DCARC Douglas County Amateur Radio Club  146.76- 88.5 Narrow band 2.5KHz UFN 38.896175,-95.174838' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var SAXRPTR = new L.marker(new L.LatLng(39.3641,-93.48071),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'SAXRPTR N0SAX   39.3641,-93.48071' ,
                    }).addTo(fg).bindPopup('SAXRPTR N0SAX   39.3641,-93.48071' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var PRATT241 = new L.marker(new L.LatLng(40.1274,-123.69148),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'PRATT241 Pratt Mt.  "Sheriff, PG&E, Med Net, Fire Net, Caltrans, HCOE, FWRA (146.610 MHz NEG PL 103.5), Backup: Generato 40.1274,-123.69148' ,
                    }).addTo(fg).bindPopup('PRATT241 Pratt Mt.  "Sheriff, PG&E, Med Net, Fire Net, Caltrans, HCOE, FWRA (146.610 MHz NEG PL 103.5), Backup: Generato 40.1274,-123.69148' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var MP243 = new L.marker(new L.LatLng(40.41852,-124.12059),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'MP243 Mount Pierce  Sheriff, Arcata Fire/Ambulance, HCOE, FWRA (146.760 MHz NEG PL 103.5), Backup: Off-Site Generator 40.41852,-124.12059' ,
                    }).addTo(fg).bindPopup('MP243 Mount Pierce  Sheriff, Arcata Fire/Ambulance, HCOE, FWRA (146.760 MHz NEG PL 103.5), Backup: Off-Site Generator 40.41852,-124.12059' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var HH244 = new L.marker(new L.LatLng(40.72496,-124.19386),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'HH244 Humboldt Hill  FWRA (146.700 MHz NEG PL 103.5) 40.72496,-124.19386' ,
                    }).addTo(fg).bindPopup('HH244 Humboldt Hill  FWRA (146.700 MHz NEG PL 103.5) 40.72496,-124.19386' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var HORSE246 = new L.marker(new L.LatLng(40.87531,-123.7327),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'HORSE246 Horse Mt.  Sheriff, PG&E, Fire Net, FWRA (147.0000 MHz POS PL 103.5, 442.0000 MHz POS PL 100.0), Backup: Gener 40.87531,-123.7327' ,
                    }).addTo(fg).bindPopup('HORSE246 Horse Mt.  Sheriff, PG&E, Fire Net, FWRA (147.0000 MHz POS PL 103.5, 442.0000 MHz POS PL 100.0), Backup: Gener 40.87531,-123.7327' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var ROGERS248 = new L.marker(new L.LatLng(41.16941,-124.02483),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'ROGERS248 Rogers Peak   41.16941,-124.02483' ,
                    }).addTo(fg).bindPopup('ROGERS248 Rogers Peak   41.16941,-124.02483' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var RAINBOW249 = new L.marker(new L.LatLng(40.372,-124.12568),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'RAINBOW249 Rainbow Ridge  HARC (146.910 MHz NEG PL 103.5) 40.372,-124.12568' ,
                    }).addTo(fg).bindPopup('RAINBOW249 Rainbow Ridge  HARC (146.910 MHz NEG PL 103.5) 40.372,-124.12568' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var RFH_533 = new L.marker(new L.LatLng(39.202849,-94.602862),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'RFH_533 RF_HoleK1 533  Created: 2023-08-03 -- First RF Hole POI entry 39.202849,-94.602862' ,
                    }).addTo(fg).bindPopup('RFH_533 RF_HoleK1 533  Created: 2023-08-03 -- First RF Hole POI entry 39.202849,-94.602862' );                        
         
                $('rf_hole'._icon).addClass('flagmrkr');
            
            var RFH_568 = new L.marker(new L.LatLng(39.202849,-94.602862),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'RFH_568 RF_HoleK1 568  Created: 2023-08-03 -- test for new modal 39.202849,-94.602862' ,
                    }).addTo(fg).bindPopup('RFH_568 RF_HoleK1 568  Created: 2023-08-03 -- test for new modal 39.202849,-94.602862' );                        
         
                $('rf_hole'._icon).addClass('flagmrkr');
            
            var RFH_569 = new L.marker(new L.LatLng(39.202849,-94.602862),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'RFH_569 RF_HoleK1 569  Created: 2023-08-03 -- test the modal 2 39.202849,-94.602862' ,
                    }).addTo(fg).bindPopup('RFH_569 RF_HoleK1 569  Created: 2023-08-03 -- test the modal 2 39.202849,-94.602862' );                        
         
                $('rf_hole'._icon).addClass('flagmrkr');
            
            var JCSHRFF267 = new L.marker(new L.LatLng(48.024051,-122.763807),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'JCSHRFF267 JC SHERIFF   48.024051,-122.763807' ,
                    }).addTo(fg).bindPopup('JCSHRFF267 JC SHERIFF   48.024051,-122.763807' );                        
         
                $('sheriff'._icon).addClass('polmrkr');
            
            var CCSHERIFF = new L.marker(new L.LatLng(39.245231,-94.41976),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'CCSHERIFF Clay County Sheriff   39.245231,-94.41976' ,
                    }).addTo(fg).bindPopup('CCSHERIFF Clay County Sheriff   39.245231,-94.41976' );                        
         
                $('sheriff'._icon).addClass('polmrkr');
            
            var NARESEOC = new L.marker(new L.LatLng(39.245231,-94.41976),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'NARESEOC Clay County Sheriff & KCNARES EOC   39.245231,-94.41976' ,
                    }).addTo(fg).bindPopup('NARESEOC Clay County Sheriff & KCNARES EOC   39.245231,-94.41976' );                        
         
                $('sheriff'._icon).addClass('polmrkr');
            
            var Sheriff398 = new L.marker(new L.LatLng(34.226835,-80.680747),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'Sheriff398 A Sheriff   34.226835,-80.680747' ,
                    }).addTo(fg).bindPopup('Sheriff398 A Sheriff   34.226835,-80.680747' );                        
         
                $('sheriff'._icon).addClass('polmrkr');
            
            var Sheriff401 = new L.marker(new L.LatLng(34.244964,-80.602518),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'Sheriff401 B Sheriff  Kershaw County Fire / Sheriff 34.244964,-80.602518' ,
                    }).addTo(fg).bindPopup('Sheriff401 B Sheriff  Kershaw County Fire / Sheriff 34.244964,-80.602518' );                        
         
                $('sheriff'._icon).addClass('polmrkr');
            
            var HCSO224 = new L.marker(new L.LatLng(40.803,-124.16221),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'HCSO224 Humboldt County Sheriffs Office  County Jail, Sheriff Main Office of Emergency Services County CERT Mgt. 40.803,-124.16221' ,
                    }).addTo(fg).bindPopup('HCSO224 Humboldt County Sheriffs Office  County Jail, Sheriff Main Office of Emergency Services County CERT Mgt. 40.803,-124.16221' );                        
         
                $('sheriff'._icon).addClass('polmrkr');
            
            var HCSOMS225 = new L.marker(new L.LatLng(40.94431,-124.09901),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'HCSOMS225 Humboldt County Sheriffs Office_McKinleyville Station   40.94431,-124.09901' ,
                    }).addTo(fg).bindPopup('HCSOMS225 Humboldt County Sheriffs Office_McKinleyville Station   40.94431,-124.09901' );                        
         
                $('sheriff'._icon).addClass('polmrkr');
            
            var HCSDGS226 = new L.marker(new L.LatLng(40.10251,-123.79386),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'HCSDGS226 Humboldt County Sheriffs Department_Garberville Station   40.10251,-123.79386' ,
                    }).addTo(fg).bindPopup('HCSDGS226 Humboldt County Sheriffs Department_Garberville Station   40.10251,-123.79386' );                        
         
                $('sheriff'._icon).addClass('polmrkr');
            
            var SC242 = new L.marker(new L.LatLng(0,0),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'SC242 Shelter Cove  Sheriff 0,0' ,
                    }).addTo(fg).bindPopup('SC242 Shelter Cove  Sheriff 0,0' );                        
         
                $('sheriff'._icon).addClass('polmrkr');
            
            var SPM247 = new L.marker(new L.LatLng(41.03856,-123.74792),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'SPM247 Sugar Pine Mountain  Sheriff Backup: Solar Generator 41.03856,-123.74792' ,
                    }).addTo(fg).bindPopup('SPM247 Sugar Pine Mountain  Sheriff Backup: Solar Generator 41.03856,-123.74792' );                        
         
                $('sheriff backup: solar generator'._icon).addClass('flagmrkr');
            
            var HCCH245 = new L.marker(new L.LatLng(40.803,-124.16221),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'HCCH245 Humboldt County Court House  Sheriff, Public Work  40.803,-124.16221' ,
                    }).addTo(fg).bindPopup('HCCH245 Humboldt County Court House  Sheriff, Public Work  40.803,-124.16221' );                        
         
                $('sheriff, public work '._icon).addClass('flagmrkr');
            
            var RGSP221 = new L.marker(new L.LatLng(40.01975,-123.79269),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/gov.png', iconSize: [32, 34]}),
                title: 'RGSP221 Richardson Grove State Park   40.01975,-123.79269' ,
                    }).addTo(fg).bindPopup('RGSP221 Richardson Grove State Park   40.01975,-123.79269' );                        
         
                $('state'._icon).addClass('govmrkr');
           
var StationList = L.layerGroup([NWS240]);

var aviationList = L.layerGroup([KCI, MCI, PTIACPT, HMSPH, SVBPT]);


var EOCList = L.layerGroup([W0KCN3, W0KCN4]);

var fireList = L.layerGroup([FFD199, FFD198, LFS197, MCVF196, CFKHB, KFPD194, PESCH, PVFD214, WCFD192, SVFD208, CFICC200, RDVFD207, RESCH, MRFSUSFS205, PFD209, CDFMFS210, CFWS211, CFS204, MFFS212, MVFD213, HFD202, FVFDCH201, HFD190, CCFRWHQ189, CFCCFS188, FWESCH, SPFD171, HBFS2, HBFS5, HBFS3, HBFS4, HBFS1, LGBOH, LGWEI, LGDUE, CFPOBFS, LGLOH, AFD173, AFD174, CCFR187, KFD34, KFD35, CFTVS183, YFD182, OVFD181, CFTFFS180, TFD179, WVFD178, FFD177, BLFD176, AFD175, CARROLFD, BVFD215, RSIM, LGSTR, FIRE16257, FIRE15256, FIRE14255, FIRE13254, FIRE12253, FIRE11252, LGWOF, RMON, PMON, LGMON, LGSTE, LGSIM, PSIM, LGEIC, LGEIN, LGERK, LGDED, LGHAM, LGKES, LGLAM, LGROL, KSZW, LGRUR, LGHOE1, LHROH, LGMOE, LGGRE, LGWER, LGDON, LGATS, WGVF223, KVFDFS222, LGSMIT, GFPD220, CDFGF219, SCVFD218, WFS2217, LGVIC, LGZWE, LGKAL, RROE, PROE, LGROE, LGROT, RSTO, PSTO, HSTO, FWSTO, LGVEN, LGBRE, CFTFS216, LHKIN, KCMOFS8, LGSET, RALS, PALS, LGALS, LGHOE, LGBET, RAAC, PAAC, RWTH, FWAAC1, FWAAC2, LGOID, LGBEG, LGBAES, KCMOFS7, KCMOFS6, KCMOFS5, KCMOFS4, KCMOFS3, KCMOFS1]);

var hospitalList = L.layerGroup([JCC260, HSIM, SCH165, FWRW5, JPCH163, RMH162, FWRW4, JCC259, LMH, FWRW6, MARIEN, FWWEST, LUISEN, HESCH, TH164]);


var AuxCommList = L.layerGroup([HCES239]);

var repeaterList = L.layerGroup([KCRJCRAC1, KCRJCRAC2]);

var KCØKWList = L.layerGroup([KCRKW1, KCRHAM4, KCRKW2, KCRHAM3, KCRMED, KCRHAM2]);

var KCHEARTList = L.layerGroup([NORKC, SMMC, RMCBKS, RESRCH, RAYCO, PMC, PETTIS, OMC, MENORA, LSMED, STJOHN, STJOMC, STLEAS, WEMO, W0CPT, TRUHH, TRLKWD, STM, STLUSO, STLUBR, STLSMI, STLPLZ, LRHC, LCHD19, DCEC, CUSHNG, CMHS, CMH, CASS, CARROL, BRMC, BOTHWL, BATES, OPR, EXSPR, FITZ, GVMH, I70, KC0CBC, KCVA, LIBRTY, KU0MED, KINDRD]);


var policeList = L.layerGroup([EPD228, CHPGS227, USFSMRRDO206, CDFW250, FPD229, APD231, TPD232, RDPD234, HTP235, BLPD236, CHPDC237, PTPOLICE1925, FPD230, LTRD193, LTRDUSFS191, LKWKPD, FPD93721, RVRSPD, COMOPD, NRTPD, HSUCP233, GSTNPD, NKCPD, PKVLPD, KCNPPD, PLTCTYPD, KSZS, HPA172]);

var repeaterList = L.layerGroup([W4GS, KT4TF, W4DV, W4BFT, KM4ABW, W4CHR, K4LMD, K4WD, ON0RBO, W4APE, AA7MI270, ACT, DCARC, SAXRPTR, WT4F, W4GS, KCRHCV, PRATT241, MP243, HH244, HORSE246, ROGERS248, RAINBOW249, W7JCR268, AA7MI269, W4TWX, WA4SJS, N4AW, WA4USN, W4CAE, W4FTK, WR4SC, W4FTK, W4PDE, WA4UKX, W4HRS, K4NAB, WR4SC, WR4SC, W4GS, KJ4QLH, W4DEW, W4APE, WR4SC, W4NYR, KD4HLH, N2OBS, W4ULH, WR4EC, K4ILT, KA4GDW, KI4RAX, W4NYK, WR4SC, W4PAX, W4HRS, W4APE, K9OH, W4ZKM, W4HRS, W4GL, KE4MDP, WA4USN, KJ4BWK, KG4BZN, WR4SC, N2ZZ, WB4TGK, W4APE, W4HRS, K4USC, KK4ZBE, WR4SC, AD4U, W4BFT, W4GL, W4BRK, W4NYK, KW4BET, K4KNJ, KK4ONF, W4DV, NE4SC, W4APE, W4IAR, WA4JRJ, W4ANK, W4RRC, KB4RRC, W4IAR, W4FTK , WA4NMW, WR4SC, W4FTK, WX4PG, W4APE, N4HRS, N4ADM, N1RCW, KA4FEC, NE4SC, KK4BQ, K4HI, W4ANK, WR4SC, W4CAE, K4JLA, KK4B, K2PJ, W4HNK, W4GWD, KG4BZN, W4FTK, W1GRE, KK4ONF, K4ILT, K4YTZ, KO4L, KJ4YLP, WB4YXZ, KK4BQ, KB4RRC, KJ4QLH, K4CCC, W4GS, W4IQQ, WA4USN, WR4SC, N4AW, WR4SC, W4GL]);

var RF_HoleList = L.layerGroup([RFH_533, RFH_568, RFH_569]);

var sheriffList = L.layerGroup([CCSHERIFF, HCSDGS226, HCSOMS225, HCSO224, Sheriff401, Sheriff398, JCSHRFF267, SC242, NARESEOC]);

var GeneratorList = L.layerGroup([SPM247]);



var stateList = L.layerGroup([RGSP221]);
    
    //=======================================================================
    //======================= Station Markers ===============================
    //=======================================================================
        
    var Stations = L.layerGroup([_KD0NBH,_AA0DV,_K0RGB,_W4XJ,_WA0TJT,_KE0UXE,_KF0MEZ,_N0SMC,_AB0GD,_KF0DFC,_N0UYN,_N0BKE,_KF0BQY,_WY0O,_KA0OTL,_K0KEX]);
    // WA0TJT,W0DLK,KD0NBH,KC0YT,AA0JX,AA0DV

    // Add the stationmarkers to the map
    Stations.addTo(map);
    
    // ???
    // I don't know what this does but without it the POI menu items don't show
    map.fitBounds([[[39.2154688,-94.599025],[39.2628465,-94.569978],[39.4172253,-94.568527],[39.2148975,-94.633957],[39.2028965,-94.602876],[39.4244507,-94.896258],[39.21816,-94.7307],[39.2519092,-94.571180],[39.3476289,-94.768086],[39.0815025,-94.582671],[39.2762919,-94.582776],[39.220224,-94.518254],[39.4763031,-94.340813],[39.3582891,-94.638113],[39.233196,-94.642213],[39.4197989,-94.658092]]]);

    var bounds = L.latLngBounds([[[39.2154688,-94.599025],[39.2628465,-94.569978],[39.4172253,-94.568527],[39.2148975,-94.633957],[39.2028965,-94.602876],[39.4244507,-94.896258],[39.21816,-94.7307],[39.2519092,-94.571180],[39.3476289,-94.768086],[39.0815025,-94.582671],[39.2762919,-94.582776],[39.220224,-94.518254],[39.4763031,-94.340813],[39.3582891,-94.638113],[39.233196,-94.642213],[39.4197989,-94.658092]]]);
        //console.log('@371 bounds= '+JSON.stringify(bounds)); 


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
    
     //=================================================================================
    //================ APRS Like Object Marker Corners and all the Objects =============
    // ======= These are Objects created by APRS or W3W from the TimeLog table =========
    //==================================================================================
    
    
    // Object markers here
        
    // Corner and center flags for the object markers, 5 for each callsign that has objects
    
    // Object Marker List starts here
    var OBJMarkerList = L.layerGroup([]);
    // Add the OBJMarkerList to the map
    OBJMarkerList.addTo(map);
       
       // uniqueCallList is needed to so we can count how many color changes we need, always < 8
   var uniqueCallList = [];  
    
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
        
     var polyline = new L.Polyline([  ],{style: style}).addTo(map);
     
     /*
     var markerBounds = L.featureGroup(objmarkers).getBounds();
            console.log('markerBounds: '+markerBounds);
        
        map.fitBounds(markerBounds);
    */
     
     //console.log('@404');
     //console.log(polyline);

    
    //====================================================================== 
    //====================== Points of Interest ============================
    //======================================================================    
    // The classList is the list of POI types.

    var classList = 'Amatuer Radio StationL,aviationL,Cal Fire Fixed Wing Air Attack BaseL,Clay Co. Repeater ClubL,EOCL,fireL,hospitalL,HT CompatableL,HT Compatible w/staticL,HT Not compatible at this locationL,Humboldt County CERT AuxCommL,JCRAC club repeaterL,Jerry Dixon KCØKWL,KCHEARTL,KD0CNCL,Keith Little NØWWL,Kershaw County EOCL,Kershaw County Fire / SheriffL,Leavenworth club repeaterL,Lecompton Rest Stop L,Level 3 Trauma Center, HelipadL,Level 4 Trauma Center, HelipadL,No Known Repeater AvailableL,Operator DB9KN MaxL,Operator DF1VB JochenL,Operator DH6KQ AndreasL,Operator DJ2UN UliL,Operator DL8KBX KlausL,Operator DL8KCS WernerL,PCARG club repeaterL,policeL,repeaterL,RF_HoleL,Sheriff Backup: Solar GeneratorL,Sheriff, Public Work L,sheriffL,stateL, CornerL, ObjectL;'.split(',');
       console.log('@414 in map.php classList= '+classList);
    
    let station = {"<img src='markers/green_marker_hole.png' class='greenmarker' alt='green_marker_hole' align='middle' /><span class='biggreenmarker'> Stations</span>": Stations};

    // Each test below if satisfied creates a javascript object, each one connects the previous to the next 
    // THE FULL LIST (not in order):  TownHall, Hospital ,Repeater ,EOC ,Sheriff ,SkyWarn ,Fire ,CHP ,State ,Federal ,Aviation ,Police ,class
    var y = {...station};
    var x;
   // $var_a = $var_b = $same_var = $var_d = $some_var = 'A';
    for (x of classList) {
        
        if (x == 'AviationL') {
            let Aviation = {"<img src='images/markers/aviation.png' width='32' align='middle' /> <span class='aviation'>Aviation</span>": AviationList};
            y = {...y, ...Aviation}; 
            
        }else if (x == 'CHPL') {
            let CHP = {"<img src='images/markers/police.png' width='32' height='37' align='middle' /> <span class='polmarker'>Police</span>":  SheriffList};
            y = {...y, ...CHP}; 
            
        }else if (x == 'EOCL') {
            let EOC = {"<img src='images/markers/eoc.png' align='middle' /> <span class='eocmarker'>EOC</span>": EOCList};
            y = {...y, ...EOC};
            
        }else if (x == 'FederalL') {
            let Federal = {"<img src='images/markers/gov.png' width='32' height='37' align='middle' /> <span class='gov'>Fed</span>":  FederalList};
            y = {...y, ...Federal};
            
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
            y = {...y, ...Sheriff};
            
        }else if (x == 'SkyWarnL') {
            let SkyWarn = {"<img src='images/markers/skywarn.png' align='middle' /> <span class='skymarker'>SkyWarn</span>": SkyWarnList};
            y = {...y, ...SkyWarn};    
            
        }else if (x == 'StateL') {
            let State = {"<img src='images/markers/gov.png' width='32' height='37' align='middle' />                 <span class='polmarker'>State</span>":  SheriffList};
            y = {...y, ...State};
            
        }else if (x == 'townhallL') {
            let TownHall = {"<img src='images/markers/gov.png' width='32' height='37' align='middle' /> <span class='townhall'>Town Halls</span>":  townhallList};
            y = {...y, ...TownHall};       
            
        }else if (x == 'ObjectL') {
            let Objects = {"<img src='images/markers/marker00.png' align='middle' /> <span class='objmrkrs'>Objects</span>": ObjectList};
            y = {...y, ...Objects}; 
            
        }else if (x == ' CornerL') {
            let Corners = {"<img src='images/markers/red_50_flag.png' align='middle' /> <span class='corners'>Corners</span>": CornerList};
            y = {...y, ...Corners};
        }}; // End of for loop
        
        
        // Here we add the station object with the merged y objects from above
    var overlayMaps = {...y }; 
    
    // This must stay here to properly display on the map
    // The collapsed: true makes the POI's compress into a 'Markers' icon
    L.control.layers(baseMaps, overlayMaps, {position:'bottomright', collapsed:true}).addTo(map); 
    
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
        
        /*
        var markerBounds = L.featureGroup(objmarkers).getBounds();
            console.log('markerBounds: '+markerBounds);
        
        map.fitBounds(markerBounds);
        */

	    

</script>   <!-- End of javascript holding the map stuff -->


</body>
</html>
