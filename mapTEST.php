<!DOCTYPE html>

<!-- Leaflet is the primary mapping used here:
    Primary maping program, also uses poiMarkers.php, objMarkers.php and stationMarkers.php -->

<!-- This version 2021-10-16 -->
<!-- This version 2023-08-03 -->


  
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

    <link rel="stylesheet" href="js/leaflet/leaflet.mouseCoordinate-master/dist/leaflet.mousecoordinate.css">
    <link rel="stylesheet" href="css/control.w3w.css" />
    
    <link rel="stylesheet" href="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.css" />
    <link rel="stylesheet" type="text/css" href="css/maps.css">  
    <link rel="stylesheet" type="text/css" href="css/leaflet/leaflet.contextmenu.min.css">
    
        
    <!-- ******************************** What 3 Words *************************************** -->
    <script src="js/control.w3w.js"></script>

    
    <!-- circleKoords is the javascript program that calculates the number of rings and the distance between them -->
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
    
    <!-- the stations div holds a list of the stations marked on the map -->
    <!-- Under the banner in the upper left corner -->
    <div id="stations"> 
		<b style="color:red; text-decoration: underline;">
		    <b>TE0ST</b><br><a class='rowno' id='marker_1' href='#'>1 _WA0TJT</a><br><a class='rowno' id='marker_2' href='#'>2 _W0DLK</a><br><a class='rowno' id='marker_3' href='#'>3 _W0GPS</a><br><a class='rowno' id='marker_4' href='#'>4 _KD0NBH</a><br><a class='rowno' id='marker_5' href='#'>5 _K0KEX</a><br><a class='rowno' id='marker_6' href='#'>6 _KA0SXY</a><br><a class='rowno' id='marker_7' href='#'>7 _KA0OTL</a><br>	</div>

    <!-- The title banner -->
    <div id="activity" class="activity">
    	<img src="images/NCM.png" alt="NCM" style="width: 35px; padding-left: 10px; padding-top: 5px;">
    	TE0ST Net #9678 For Testing Only Testing Objects     </div>
    

<!-- Everything is inside a javascript, the script closing is near the end of the page -->
<script> 
    
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

    
// Define the beginning map
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
            .setContent("You clicked the map at:<br>" + e.latlng.toString() + "<br>"   )
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
        rfhole        = new PoiIconClass({iconUrl: 'markers/hole.png'}),
        
        objicon       = new ObjIconClass({iconURL: 'images/markers/marker00.png'}), //00 marker
    
        blueFlagicon  = new ObjIconClass({iconUrl: 'BRKMarkers/blue_flag.svg'}),
        greenFlagicon = new ObjIconClass({iconUrl: 'BRKMarkers/green_flag.svg'});
        
    
    // These are the markers that will appear on the map
    // Bring in the station and poi markers to appear on the map
    
			var _WA0TJT = new L.marker(new L.latLng(39.201500,-94.601670),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '1' }),
				title:`marker_1` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>1<br><b>Tactical: Net<br>WA0TJT</b><br> ID: #000013<br>Keith Kaiser<br>Platte  Co., MO Dist: A<br>39.201500, -94.601670<br>EM29QE<br><a href='https://what3words.com/modems.pretend.taxed?maptype=osm' target='_blank'>///modems.pretend.taxed</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.201500&lon=-94.601670&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_WA0TJT`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_WA0TJT);
				
			var _W0DLK = new L.marker(new L.latLng(39.2028965,-94.602876),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedDivIcon({number: '2' }),
				title:`marker_2` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>2<br><b>Tactical: DLK<br>W0DLK</b><br> ID: #000023<br>Deb Kaiser<br>Platte  Co., MO Dist: A<br>39.2028965, -94.602876<br>EM29QE<br><a href='https://what3words.com/guiding.confusion.towards?maptype=osm' target='_blank'>///guiding.confusion.towards</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2028965&lon=-94.602876&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_W0DLK`._icon).addClass(`bluemrkr`);
                stationMarkers.push(_W0DLK);
				
			var _W0GPS = new L.marker(new L.latLng(39.3682798,-94.770648),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '3' }),
				title:`marker_3` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>3<br><b>Tactical: GPS<br>W0GPS</b><br> ID: #000028<br>John Morelli<br>Platte  Co., MO Dist: A<br>39.3682798, -94.770648<br>EM29OI<br><a href='https://what3words.com/horses.cheat.pepper?maptype=osm' target='_blank'>///horses.cheat.pepper</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.3682798&lon=-94.770648&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_W0GPS`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_W0GPS);
				
			var _KD0NBH = new L.marker(new L.latLng(39.2154688,-94.599025),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '4' }),
				title:`marker_4` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>4<br><b>Tactical: NBH<br>KD0NBH</b><br> ID: #001812<br>John Britton<br>Clay Co., MO Dist: A<br>39.2154688, -94.599025<br>EM29QF<br><a href='https://what3words.com/workflow.ships.derivative?maptype=osm' target='_blank'>///workflow.ships.derivative</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2154688&lon=-94.599025&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_KD0NBH`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_KD0NBH);
				
			var _K0KEX = new L.marker(new L.latLng(39.4197989,-94.658092),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '5' }),
				title:`marker_5` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>5<br><b>Tactical: KEX<br>K0KEX</b><br> ID: #000029<br>Rick Smith<br>Platte  Co., MO Dist: A<br>39.4197989, -94.658092<br>EM29QK<br><a href='https://what3words.com/hers.parrot.legions?maptype=osm' target='_blank'>///hers.parrot.legions</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.4197989&lon=-94.658092&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_K0KEX`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_K0KEX);
				
			var _KA0SXY = new L.marker(new L.latLng(39.1495372,-94.557949),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '6' }),
				title:`marker_6` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>6<br><b>Tactical: SXY<br>KA0SXY</b><br> ID: #000011<br>Dennis Carpenter<br>Clay Co., MO Dist: G<br>39.1495372, -94.557949<br>EM29RD<br><a href='https://what3words.com/pull.charge.wizard?maptype=osm' target='_blank'>///pull.charge.wizard</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.1495372&lon=-94.557949&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_KA0SXY`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_KA0SXY);
				
			var _KA0OTL = new L.marker(new L.latLng(39.233048,-94.635470),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '7' }),
				title:`marker_7` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>7<br><b>Tactical: OTL<br>KA0OTL</b><br> ID: #000025<br>Jeff Libby<br>Platte Co., MO Dist: A<br>39.233048, -94.635470<br>EM29QF<br><a href='https://what3words.com/puppet.profiled.clear?maptype=osm' target='_blank'>///puppet.profiled.clear</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.233048&lon=-94.635470&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_KA0OTL`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_KA0OTL);
			;

            var MCI271 = new L.marker(new L.LatLng(39.3003,-94.72721),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/aviation.png', iconSize: [32, 34]}),
                title: 'MCI271 Kansas City International Airport   39.3003,-94.72721' ,
                    }).addTo(fg).bindPopup('MCI271<br> Kansas City International Airport <br> <br> 39.3003,-94.72721<br>Created: ' );                        
         
                $('aviation'._icon).addClass('aviationmrkr');
            
            var KCI272 = new L.marker(new L.LatLng(39.12051,-94.59077),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/aviation.png', iconSize: [32, 34]}),
                title: 'KCI272 Charles B Wheeler Downtown Airport   39.12051,-94.59077' ,
                    }).addTo(fg).bindPopup('KCI272<br> Charles B Wheeler Downtown Airport <br> <br> 39.12051,-94.59077<br>Created: ' );                        
         
                $('aviation'._icon).addClass('aviationmrkr');
            
            var PTIACPT273 = new L.marker(new L.LatLng(48.053802,-122.810628),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/aviation.png', iconSize: [32, 34]}),
                title: 'PTIACPT273 PT Intl Airport Cutoff   48.053802,-122.810628' ,
                    }).addTo(fg).bindPopup('PTIACPT273<br> PT Intl Airport Cutoff <br> <br> 48.053802,-122.810628<br>Created: ' );                        
         
                $('aviation'._icon).addClass('aviationmrkr');
            
            var HMSPH274 = new L.marker(new L.LatLng(48.034632,-122.775006),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/aviation.png', iconSize: [32, 34]}),
                title: 'HMSPH274 Hadlock Mason St   48.034632,-122.775006' ,
                    }).addTo(fg).bindPopup('HMSPH274<br> Hadlock Mason St <br> <br> 48.034632,-122.775006<br>Created: ' );                        
         
                $('aviation'._icon).addClass('aviationmrkr');
            
            var SVBPT275 = new L.marker(new L.LatLng(48.077025,-122.840721),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/aviation.png', iconSize: [32, 34]}),
                title: 'SVBPT275 Sky Valley   48.077025,-122.840721' ,
                    }).addTo(fg).bindPopup('SVBPT275<br> Sky Valley <br> <br> 48.077025,-122.840721<br>Created: ' );                        
         
                $('aviation'._icon).addClass('aviationmrkr');
            
            var RAAB203 = new L.marker(new L.LatLng(40.5555,-124.13204),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/aviation.png', iconSize: [32, 34]}),
                title: 'RAAB203 Rohnerville Air Attack Base  Cal Fire Fixed Wing Air Attack Base 40.5555,-124.13204' ,
                    }).addTo(fg).bindPopup('RAAB203<br> Rohnerville Air Attack Base <br> Cal Fire Fixed Wing Air Attack Base<br> 40.5555,-124.13204<br>Created: ' );                        
         
                $('aviation'._icon).addClass('aviationmrkr');
            
            var W0KCN446 = new L.marker(new L.LatLng(39.3721733,-94.780929),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/eoc.png', iconSize: [32, 34]}),
                title: 'W0KCN446 Northland ARES Platte Co. EOC   39.3721733,-94.780929' ,
                    }).addTo(fg).bindPopup('W0KCN446<br> Northland ARES Platte Co. EOC <br> <br> 39.3721733,-94.780929<br>Created: ' );                        
         
                $('eoc'._icon).addClass('eocmrkr');
            
            var W0KCN347 = new L.marker(new L.LatLng(39.2859182,-94.667236),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/eoc.png', iconSize: [32, 34]}),
                title: 'W0KCN347 Northland ARES Platte Co. Resource Center   39.2859182,-94.667236' ,
                    }).addTo(fg).bindPopup('W0KCN347<br> Northland ARES Platte Co. Resource Center <br> <br> 39.2859182,-94.667236<br>Created: ' );                        
         
                $('eoc'._icon).addClass('eocmrkr');
            
            var EOC399 = new L.marker(new L.LatLng(34.248206,-80.606327),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/eoc.png', iconSize: [32, 34]}),
                title: 'EOC399 A EOC  Kershaw County EOC 34.248206,-80.606327' ,
                    }).addTo(fg).bindPopup('EOC399<br> A EOC <br> Kershaw County EOC<br> 34.248206,-80.606327<br>Created: ' );                        
         
                $('eoc'._icon).addClass('eocmrkr');
            
            var HCES239 = new L.marker(new L.LatLng(40.803,-124.16221),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/eoc.png', iconSize: [32, 34]}),
                title: 'HCES239 Humboldt County Emergency Services  Humboldt County CERT AuxComm 40.803,-124.16221' ,
                    }).addTo(fg).bindPopup('HCES239<br> Humboldt County Emergency Services <br> Humboldt County CERT AuxComm<br> 40.803,-124.16221<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('FIRE15256<br> Fire15 <br> <br> 48.102685,-122.825696<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGOBER512 = new L.marker(new L.LatLng(50.512222,6.465568),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGOBER512 Gerätehaus Oberhausen   50.512222,6.465568' ,
                    }).addTo(fg).bindPopup('LGOBER512<br> Gerätehaus Oberhausen <br> <br> 50.512222,6.465568<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('FIRE16257<br> Fire16 <br> <br> 48.116172,-122.764327<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGHARP514 = new L.marker(new L.LatLng(50.518637,6.406335),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGHARP514 Gerätehaus Harperscheid   50.518637,6.406335' ,
                    }).addTo(fg).bindPopup('LGHARP514<br> Gerätehaus Harperscheid <br> <br> 50.518637,6.406335<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGDREI515 = new L.marker(new L.LatLng(50.542354,6.405359),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGDREI515 Gerätehaus Dreiborn   50.542354,6.405359' ,
                    }).addTo(fg).bindPopup('LGDREI515<br> Gerätehaus Dreiborn <br> <br> 50.542354,6.405359<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGWAL517 = new L.marker(new L.LatLng(50.71185,6.180236),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGWAL517 Gerätehaus Wahlhem   50.71185,6.180236' ,
                    }).addTo(fg).bindPopup('LGWAL517<br> Gerätehaus Wahlhem <br> <br> 50.71185,6.180236<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGOBER518 = new L.marker(new L.LatLng(50.72883,6.174868),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGOBER518 Gerätehaus Kornelimuenster   50.72883,6.174868' ,
                    }).addTo(fg).bindPopup('LGOBER518<br> Gerätehaus Kornelimuenster <br> <br> 50.72883,6.174868<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGMAUS519 = new L.marker(new L.LatLng(50.755673,6.281836),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGMAUS519 Gerätehaus Mausbach   50.755673,6.281836' ,
                    }).addTo(fg).bindPopup('LGMAUS519<br> Gerätehaus Mausbach <br> <br> 50.755673,6.281836<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGIMGE520 = new L.marker(new L.LatLng(50.577741,6.263472),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGIMGE520 Gerätehaus Imgenbroich   50.577741,6.263472' ,
                    }).addTo(fg).bindPopup('LGIMGE520<br> Gerätehaus Imgenbroich <br> <br> 50.577741,6.263472<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGMALT521 = new L.marker(new L.LatLng(50.553727,6.241281),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGMALT521 Gerätehaus Monschau   50.553727,6.241281' ,
                    }).addTo(fg).bindPopup('LGMALT521<br> Gerätehaus Monschau <br> <br> 50.553727,6.241281<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGPUFF522 = new L.marker(new L.LatLng(50.938861,6.212034),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGPUFF522 Gerätehaus Puffendorf   50.938861,6.212034' ,
                    }).addTo(fg).bindPopup('LGPUFF522<br> Gerätehaus Puffendorf <br> <br> 50.938861,6.212034<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGLOVE523 = new L.marker(new L.LatLng(50.933525,6.187821),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGLOVE523 Gerätehaus Loverich   50.933525,6.187821' ,
                    }).addTo(fg).bindPopup('LGLOVE523<br> Gerätehaus Loverich <br> <br> 50.933525,6.187821<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBEGG524 = new L.marker(new L.LatLng(50.926302,6.169567),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBEGG524 Gerätehaus Beggendorf   50.926302,6.169567' ,
                    }).addTo(fg).bindPopup('LGBEGG524<br> Gerätehaus Beggendorf <br> <br> 50.926302,6.169567<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var W0KCN1588 = new L.marker(new L.LatLng(39.363954,-94.584749),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'W0KCN1588 Northland ARES Clay Co. Fire Station #2   39.363954,-94.584749' ,
                    }).addTo(fg).bindPopup('W0KCN1588<br> Northland ARES Clay Co. Fire Station #2 <br> <br> 39.363954,-94.584749<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RVRSDEFD89 = new L.marker(new L.LatLng(39.175757,-94.616012),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RVRSDEFD89 Riverside, MO City Fire Department   39.175757,-94.616012' ,
                    }).addTo(fg).bindPopup('RVRSDEFD89<br> Riverside, MO City Fire Department <br> <br> 39.175757,-94.616012<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var BRVRCOFR2990 = new L.marker(new L.LatLng(28.431189,-80.805377),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'BRVRCOFR2990 Brevard County Fire Rescue Station 29   28.431189,-80.805377' ,
                    }).addTo(fg).bindPopup('BRVRCOFR2990<br> Brevard County Fire Rescue Station 29 <br> <br> 28.431189,-80.805377<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var TFESS1291 = new L.marker(new L.LatLng(28.589587,-80.831269),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'TFESS1291 Titusville Fire & Emergency Services Station 12   28.589587,-80.831269' ,
                    }).addTo(fg).bindPopup('TFESS1291<br> Titusville Fire & Emergency Services Station 12 <br> <br> 28.589587,-80.831269<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var GNSVFS192 = new L.marker(new L.LatLng(34.290941,-83.826461),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'GNSVFS192 Gainesville Fire Station 1   34.290941,-83.826461' ,
                    }).addTo(fg).bindPopup('GNSVFS192<br> Gainesville Fire Station 1 <br> <br> 34.290941,-83.826461<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS196 = new L.marker(new L.LatLng(38.84544806200006,-94.55557100699997),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS196 KCMO Fire Station No. 1   38.84544806200006,-94.55557100699997' ,
                    }).addTo(fg).bindPopup('KCMOFS196<br> KCMO Fire Station No. 1 <br> <br> 38.84544806200006,-94.55557100699997<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS397 = new L.marker(new L.LatLng(39.29502746500003,-94.57483520999995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS397 KCMO Fire Station No. 3   39.29502746500003,-94.57483520999995' ,
                    }).addTo(fg).bindPopup('KCMOFS397<br> KCMO Fire Station No. 3 <br> <br> 39.29502746500003,-94.57483520999995<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS498 = new L.marker(new L.LatLng(39.21082648400005,-94.62698133999999),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS498 KCMO Fire Station No. 4   39.21082648400005,-94.62698133999999' ,
                    }).addTo(fg).bindPopup('KCMOFS498<br> KCMO Fire Station No. 4 <br> <br> 39.21082648400005,-94.62698133999999<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS599 = new L.marker(new L.LatLng(39.29465245500006,-94.72458748899999),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS599 KCMO Fire Station No. 5   39.29465245500006,-94.72458748899999' ,
                    }).addTo(fg).bindPopup('KCMOFS599<br> KCMO Fire Station No. 5 <br> <br> 39.29465245500006,-94.72458748899999<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS6100 = new L.marker(new L.LatLng(39.164872338000066,-94.54946718099995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS6100 KCMO Fire Station No. 6   39.164872338000066,-94.54946718099995' ,
                    }).addTo(fg).bindPopup('KCMOFS6100<br> KCMO Fire Station No. 6 <br> <br> 39.164872338000066,-94.54946718099995<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS7101 = new L.marker(new L.LatLng(39.088027072000045,-94.59222542099997),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS7101 KCMO Fire Station No. 7   39.088027072000045,-94.59222542099997' ,
                    }).addTo(fg).bindPopup('KCMOFS7101<br> KCMO Fire Station No. 7 <br> <br> 39.088027072000045,-94.59222542099997<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS8102 = new L.marker(new L.LatLng(39.09503169800007,-94.57740912999998),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS8102 KCMO Fire Station No. 8   39.09503169800007,-94.57740912999998' ,
                    }).addTo(fg).bindPopup('KCMOFS8102<br> KCMO Fire Station No. 8 <br> <br> 39.09503169800007,-94.57740912999998<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS10103 = new L.marker(new L.LatLng(39.10270070000007,-94.56220495299999),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS10103 KCMO Fire Station No. 10   39.10270070000007,-94.56220495299999' ,
                    }).addTo(fg).bindPopup('KCMOFS10103<br> KCMO Fire Station No. 10 <br> <br> 39.10270070000007,-94.56220495299999<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS16104 = new L.marker(new L.LatLng(39.29508854300008,-94.68790113199998),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS16104 KCMO Fire Station No. 16   39.29508854300008,-94.68790113199998' ,
                    }).addTo(fg).bindPopup('KCMOFS16104<br> KCMO Fire Station No. 16 <br> <br> 39.29508854300008,-94.68790113199998<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS17105 = new L.marker(new L.LatLng(39.06448674100005,-94.56659040899996),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS17105 KCMO Fire Station No. 17   39.06448674100005,-94.56659040899996' ,
                    }).addTo(fg).bindPopup('KCMOFS17105<br> KCMO Fire Station No. 17 <br> <br> 39.06448674100005,-94.56659040899996<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS18106 = new L.marker(new L.LatLng(39.068426627000065,-94.54306673199994),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS18106 KCMO Fire Station No. 18   39.068426627000065,-94.54306673199994' ,
                    }).addTo(fg).bindPopup('KCMOFS18106<br> KCMO Fire Station No. 18 <br> <br> 39.068426627000065,-94.54306673199994<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS19107 = new L.marker(new L.LatLng(39.04970557900003,-94.59317453799997),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS19107 KCMO Fire Station No. 19   39.04970557900003,-94.59317453799997' ,
                    }).addTo(fg).bindPopup('KCMOFS19107<br> KCMO Fire Station No. 19 <br> <br> 39.04970557900003,-94.59317453799997<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS23108 = new L.marker(new L.LatLng(39.10519819800004,-94.52673633999996),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS23108 KCMO Fire Station No. 23   39.10519819800004,-94.52673633999996' ,
                    }).addTo(fg).bindPopup('KCMOFS23108<br> KCMO Fire Station No. 23 <br> <br> 39.10519819800004,-94.52673633999996<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS24109 = new L.marker(new L.LatLng(39.08534478900003,-94.51940024199996),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS24109 KCMO Fire Station No. 24   39.08534478900003,-94.51940024199996' ,
                    }).addTo(fg).bindPopup('KCMOFS24109<br> KCMO Fire Station No. 24 <br> <br> 39.08534478900003,-94.51940024199996<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS25110 = new L.marker(new L.LatLng(39.10791790600007,-94.57838314599996),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS25110 KCMO Fire Station No. 25   39.10791790600007,-94.57838314599996' ,
                    }).addTo(fg).bindPopup('KCMOFS25110<br> KCMO Fire Station No. 25 <br> <br> 39.10791790600007,-94.57838314599996<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS27111 = new L.marker(new L.LatLng(39.09423963200004,-94.50519189199997),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS27111 KCMO Fire Station No. 27   39.09423963200004,-94.50519189199997' ,
                    }).addTo(fg).bindPopup('KCMOFS27111<br> KCMO Fire Station No. 27 <br> <br> 39.09423963200004,-94.50519189199997<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS28112 = new L.marker(new L.LatLng(38.92612585100005,-94.57996235599995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS28112 KCMO Fire Station No. 28   38.92612585100005,-94.57996235599995' ,
                    }).addTo(fg).bindPopup('KCMOFS28112<br> KCMO Fire Station No. 28 <br> <br> 38.92612585100005,-94.57996235599995<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS29113 = new L.marker(new L.LatLng(39.01353614300007,-94.56910049699997),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS29113 KCMO Fire Station No. 29   39.01353614300007,-94.56910049699997' ,
                    }).addTo(fg).bindPopup('KCMOFS29113<br> KCMO Fire Station No. 29 <br> <br> 39.01353614300007,-94.56910049699997<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS30114 = new L.marker(new L.LatLng(38.98954598500006,-94.55777761299998),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS30114 KCMO Fire Station No. 30   38.98954598500006,-94.55777761299998' ,
                    }).addTo(fg).bindPopup('KCMOFS30114<br> KCMO Fire Station No. 30 <br> <br> 38.98954598500006,-94.55777761299998<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS33115 = new L.marker(new L.LatLng(39.00341036400005,-94.49917701399994),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS33115 KCMO Fire Station No. 33   39.00341036400005,-94.49917701399994' ,
                    }).addTo(fg).bindPopup('KCMOFS33115<br> KCMO Fire Station No. 33 <br> <br> 39.00341036400005,-94.49917701399994<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS34116 = new L.marker(new L.LatLng(39.18216645700005,-94.52198633599994),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS34116 KCMO Fire Station No. 34   39.18216645700005,-94.52198633599994' ,
                    }).addTo(fg).bindPopup('KCMOFS34116<br> KCMO Fire Station No. 34 <br> <br> 39.18216645700005,-94.52198633599994<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS35117 = new L.marker(new L.LatLng(39.04105321900005,-94.54716372899998),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS35117 KCMO Fire Station No. 35   39.04105321900005,-94.54716372899998' ,
                    }).addTo(fg).bindPopup('KCMOFS35117<br> KCMO Fire Station No. 35 <br> <br> 39.04105321900005,-94.54716372899998<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS36118 = new L.marker(new L.LatLng(38.947990154000024,-94.58198512499996),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS36118 KCMO Fire Station No. 36   38.947990154000024,-94.58198512499996' ,
                    }).addTo(fg).bindPopup('KCMOFS36118<br> KCMO Fire Station No. 36 <br> <br> 38.947990154000024,-94.58198512499996<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS37119 = new L.marker(new L.LatLng(38.98838295400003,-94.59471418799995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS37119 KCMO Fire Station No. 37   38.98838295400003,-94.59471418799995' ,
                    }).addTo(fg).bindPopup('KCMOFS37119<br> KCMO Fire Station No. 37 <br> <br> 38.98838295400003,-94.59471418799995<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS38120 = new L.marker(new L.LatLng(39.24114461900007,-94.57637879999999),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS38120 KCMO Fire Station No. 38   39.24114461900007,-94.57637879999999' ,
                    }).addTo(fg).bindPopup('KCMOFS38120<br> KCMO Fire Station No. 38 <br> <br> 39.24114461900007,-94.57637879999999<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS39121 = new L.marker(new L.LatLng(39.037389129000076,-94.44871189199995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS39121 KCMO Fire Station No. 39   39.037389129000076,-94.44871189199995' ,
                    }).addTo(fg).bindPopup('KCMOFS39121<br> KCMO Fire Station No. 39 <br> <br> 39.037389129000076,-94.44871189199995<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS40122 = new L.marker(new L.LatLng(39.18825564000008,-94.57705538299996),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS40122 KCMO Fire Station No. 40   39.18825564000008,-94.57705538299996' ,
                    }).addTo(fg).bindPopup('KCMOFS40122<br> KCMO Fire Station No. 40 <br> <br> 39.18825564000008,-94.57705538299996<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS41123 = new L.marker(new L.LatLng(38.956671338000035,-94.52135318999996),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS41123 KCMO Fire Station No. 41   38.956671338000035,-94.52135318999996' ,
                    }).addTo(fg).bindPopup('KCMOFS41123<br> KCMO Fire Station No. 41 <br> <br> 38.956671338000035,-94.52135318999996<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS42124 = new L.marker(new L.LatLng(38.924447272000066,-94.51993356699995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS42124 KCMO Fire Station No. 42   38.924447272000066,-94.51993356699995' ,
                    }).addTo(fg).bindPopup('KCMOFS42124<br> KCMO Fire Station No. 42 <br> <br> 38.924447272000066,-94.51993356699995<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS43125 = new L.marker(new L.LatLng(38.96734958800005,-94.43185910999995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS43125 KCMO Fire Station No. 43   38.96734958800005,-94.43185910999995' ,
                    }).addTo(fg).bindPopup('KCMOFS43125<br> KCMO Fire Station No. 43 <br> <br> 38.96734958800005,-94.43185910999995<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS44126 = new L.marker(new L.LatLng(39.246423046000075,-94.66588993499994),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS44126 KCMO Fire Station No. 44   39.246423046000075,-94.66588993499994' ,
                    }).addTo(fg).bindPopup('KCMOFS44126<br> KCMO Fire Station No. 44 <br> <br> 39.246423046000075,-94.66588993499994<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS45127 = new L.marker(new L.LatLng(38.89023597400006,-94.58854005199998),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS45127 KCMO Fire Station No. 45   38.89023597400006,-94.58854005199998' ,
                    }).addTo(fg).bindPopup('KCMOFS45127<br> KCMO Fire Station No. 45 <br> <br> 38.89023597400006,-94.58854005199998<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS47128 = new L.marker(new L.LatLng(39.14034793800005,-94.52048369499994),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS47128 KCMO Fire Station No. 47   39.14034793800005,-94.52048369499994' ,
                    }).addTo(fg).bindPopup('KCMOFS47128<br> KCMO Fire Station No. 47 <br> <br> 39.14034793800005,-94.52048369499994<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KCMOFS14129 = new L.marker(new L.LatLng(39.24420365000003,-94.52101456199995),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KCMOFS14129 KCMO Fire Station No. 14   39.24420365000003,-94.52101456199995' ,
                    }).addTo(fg).bindPopup('KCMOFS14129<br> KCMO Fire Station No. 14 <br> <br> 39.24420365000003,-94.52101456199995<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RVRSFD134 = new L.marker(new L.LatLng(39.17579,-94.615947),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RVRSFD134    Riverside City Fire Department   39.17579,-94.615947' ,
                    }).addTo(fg).bindPopup('RVRSFD134<br>    Riverside City Fire Department <br> <br> 39.17579,-94.615947<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CARROLFD148 = new L.marker(new L.LatLng(39.364764,-93.482455),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CARROLFD148 Carrollton Fire Department   39.364764,-93.482455' ,
                    }).addTo(fg).bindPopup('CARROLFD148<br> Carrollton Fire Department <br> <br> 39.364764,-93.482455<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KSZW405 = new L.marker(new L.LatLng(50.813106,6.15943),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KSZW405 DRK Fernmeldezug   50.813106,6.15943' ,
                    }).addTo(fg).bindPopup('KSZW405<br> DRK Fernmeldezug <br> <br> 50.813106,6.15943<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RSIM406 = new L.marker(new L.LatLng(50.606579,6.303835),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RSIM406 Gemeindeverwaltung Simmerath   50.606579,6.303835' ,
                    }).addTo(fg).bindPopup('RSIM406<br> Gemeindeverwaltung Simmerath <br> <br> 50.606579,6.303835<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PSIM407 = new L.marker(new L.LatLng(50.61,6.302051),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PSIM407 Wache Simmerath   50.61,6.302051' ,
                    }).addTo(fg).bindPopup('PSIM407<br> Wache Simmerath <br> <br> 50.61,6.302051<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGEIC409 = new L.marker(new L.LatLng(50.579681,6.303993),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGEIC409 Gerätehaus Eicherscheid   50.579681,6.303993' ,
                    }).addTo(fg).bindPopup('LGEIC409<br> Gerätehaus Eicherscheid <br> <br> 50.579681,6.303993<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGEIN410 = new L.marker(new L.LatLng(50.582916,6.37867),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGEIN410 Gerätehaus Einruhr   50.582916,6.37867' ,
                    }).addTo(fg).bindPopup('LGEIN410<br> Gerätehaus Einruhr <br> <br> 50.582916,6.37867<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGERK411 = new L.marker(new L.LatLng(50.564697,6.361316),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGERK411 Gerätehaus Erkensruhr   50.564697,6.361316' ,
                    }).addTo(fg).bindPopup('LGERK411<br> Gerätehaus Erkensruhr <br> <br> 50.564697,6.361316<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGDED412 = new L.marker(new L.LatLng(50.583751,6.355568),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGDED412 Gerätehaus Dedenborn   50.583751,6.355568' ,
                    }).addTo(fg).bindPopup('LGDED412<br> Gerätehaus Dedenborn <br> <br> 50.583751,6.355568<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGHAM413 = new L.marker(new L.LatLng(50.564858,6.329027),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGHAM413 Gerätehaus Hammer   50.564858,6.329027' ,
                    }).addTo(fg).bindPopup('LGHAM413<br> Gerätehaus Hammer <br> <br> 50.564858,6.329027<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGKES414 = new L.marker(new L.LatLng(50.606444,6.331613),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGKES414 Gerätehaus Kesternich   50.606444,6.331613' ,
                    }).addTo(fg).bindPopup('LGKES414<br> Gerätehaus Kesternich <br> <br> 50.606444,6.331613<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGLAM415 = new L.marker(new L.LatLng(50.632156,6.271407),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGLAM415 Gerätehaus Lammersdorf   50.632156,6.271407' ,
                    }).addTo(fg).bindPopup('LGLAM415<br> Gerätehaus Lammersdorf <br> <br> 50.632156,6.271407<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGROL416 = new L.marker(new L.LatLng(50.62973,6.311586),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGROL416 Gerätehaus Rollesbroich   50.62973,6.311586' ,
                    }).addTo(fg).bindPopup('LGROL416<br> Gerätehaus Rollesbroich <br> <br> 50.62973,6.311586<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGRUR417 = new L.marker(new L.LatLng(50.614395,6.378801),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGRUR417 Gerätehaus Rurberg   50.614395,6.378801' ,
                    }).addTo(fg).bindPopup('LGRUR417<br> Gerätehaus Rurberg <br> <br> 50.614395,6.378801<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSIM418 = new L.marker(new L.LatLng(50.607846,6.297847),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSIM418 Gerätehaus Simmerath   50.607846,6.297847' ,
                    }).addTo(fg).bindPopup('LGSIM418<br> Gerätehaus Simmerath <br> <br> 50.607846,6.297847<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSTE419 = new L.marker(new L.LatLng(50.626846,6.354188),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSTE419 Gerätehaus Steckenborn   50.626846,6.354188' ,
                    }).addTo(fg).bindPopup('LGSTE419<br> Gerätehaus Steckenborn <br> <br> 50.626846,6.354188<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSTR420 = new L.marker(new L.LatLng(50.624717,6.334544),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSTR420 Gerätehaus Strauch   50.624717,6.334544' ,
                    }).addTo(fg).bindPopup('LGSTR420<br> Gerätehaus Strauch <br> <br> 50.624717,6.334544<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGWOF421 = new L.marker(new L.LatLng(50.62717,6.382292),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGWOF421 Gerätehaus Woffelsbach   50.62717,6.382292' ,
                    }).addTo(fg).bindPopup('LGWOF421<br> Gerätehaus Woffelsbach <br> <br> 50.62717,6.382292<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HBFS1166 = new L.marker(new L.LatLng(40.80125,-124.16873),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HBFS1166 Humboldt Bay Fire Station 1  HBF Main Office 40.80125,-124.16873' ,
                    }).addTo(fg).bindPopup('HBFS1166<br> Humboldt Bay Fire Station 1 <br> HBF Main Office<br> 40.80125,-124.16873<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RMON422 = new L.marker(new L.LatLng(50.560007,6.237547),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RMON422 Stadtverwaltung Monschau   50.560007,6.237547' ,
                    }).addTo(fg).bindPopup('RMON422<br> Stadtverwaltung Monschau <br> <br> 50.560007,6.237547<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HBFS4167 = new L.marker(new L.LatLng(40.79978,-124.14866),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HBFS4167 Humboldt Bay Fire Station 4   40.79978,-124.14866' ,
                    }).addTo(fg).bindPopup('HBFS4167<br> Humboldt Bay Fire Station 4 <br> <br> 40.79978,-124.14866<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PMON423 = new L.marker(new L.LatLng(50.558336,6.239711),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PMON423 Wache Monschau   50.558336,6.239711' ,
                    }).addTo(fg).bindPopup('PMON423<br> Wache Monschau <br> <br> 50.558336,6.239711<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HBFS3168 = new L.marker(new L.LatLng(40.78177,-124.18126),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HBFS3168 Humboldt Bay Fire Station 3   40.78177,-124.18126' ,
                    }).addTo(fg).bindPopup('HBFS3168<br> Humboldt Bay Fire Station 3 <br> <br> 40.78177,-124.18126<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGMON424 = new L.marker(new L.LatLng(50.565182,6.25227),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGMON424 Gerätehaus Altstadt   50.565182,6.25227' ,
                    }).addTo(fg).bindPopup('LGMON424<br> Gerätehaus Altstadt <br> <br> 50.565182,6.25227<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HBFS5169 = new L.marker(new L.LatLng(40.78097,-124.12982),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HBFS5169 Humboldt Bay Fire Station 5   40.78097,-124.12982' ,
                    }).addTo(fg).bindPopup('HBFS5169<br> Humboldt Bay Fire Station 5 <br> <br> 40.78097,-124.12982<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGHOE1425 = new L.marker(new L.LatLng(50.537637,6.254052),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGHOE1425 Gerätehaus Höfen   50.537637,6.254052' ,
                    }).addTo(fg).bindPopup('LGHOE1425<br> Gerätehaus Höfen <br> <br> 50.537637,6.254052<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HBFS2170 = new L.marker(new L.LatLng(40.75793,-124.17967),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HBFS2170 Humboldt Bay Fire Station 2   40.75793,-124.17967' ,
                    }).addTo(fg).bindPopup('HBFS2170<br> Humboldt Bay Fire Station 2 <br> <br> 40.75793,-124.17967<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LHROH426 = new L.marker(new L.LatLng(50.549038,6.283202),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LHROH426 Gerätehaus Rohren   50.549038,6.283202' ,
                    }).addTo(fg).bindPopup('LHROH426<br> Gerätehaus Rohren <br> <br> 50.549038,6.283202<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('SPFD171<br> Samoa Peninsula Fire District <br> <br> 40.78639,-124.2<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGMOE427 = new L.marker(new L.LatLng(50.566583,6.217732),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGMOE427 Gerätehaus Mützenich   50.566583,6.217732' ,
                    }).addTo(fg).bindPopup('LGMOE427<br> Gerätehaus Mützenich <br> <br> 50.566583,6.217732<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGKAL428 = new L.marker(new L.LatLng(50.524809,6.219386),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGKAL428 Gerätehaus Kalterherberg   50.524809,6.219386' ,
                    }).addTo(fg).bindPopup('LGKAL428<br> Gerätehaus Kalterherberg <br> <br> 50.524809,6.219386<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('AFD173<br> Arcata Fire District / Arcata Station <br> <br> 40.86865,-124.08511<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RROE429 = new L.marker(new L.LatLng(50.647679,6.195132),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RROE429 Gemeinde Verwaltung Roetgen   50.647679,6.195132' ,
                    }).addTo(fg).bindPopup('RROE429<br> Gemeinde Verwaltung Roetgen <br> <br> 50.647679,6.195132<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('AFD174<br> Arcata Fire District / Mad River Station <br> <br> 40.89901,-124.09185<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PROE430 = new L.marker(new L.LatLng(50.647679,6.195132),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PROE430 Wache Roetgen   50.647679,6.195132' ,
                    }).addTo(fg).bindPopup('PROE430<br> Wache Roetgen <br> <br> 50.647679,6.195132<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('AFD175<br> Arcata Fire District / McKinleyville Station <br> <br> 40.94398,-124.10055<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGROE431 = new L.marker(new L.LatLng(50.645685,6.193941),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGROE431 Gerätehaus Roetgen   50.645685,6.193941' ,
                    }).addTo(fg).bindPopup('LGROE431<br> Gerätehaus Roetgen <br> <br> 50.645685,6.193941<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('BLFD176<br> Blue Lake Fire Department <br> <br> 40.88308,-123.99108<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGROT432 = new L.marker(new L.LatLng(50.679374,6.215632),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGROT432 Gerätehaus Rott   50.679374,6.215632' ,
                    }).addTo(fg).bindPopup('LGROT432<br> Gerätehaus Rott <br> <br> 50.679374,6.215632<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('FFD177<br> Fieldbrook Fire Department <br> <br> 40.96415,-124.03615<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RSTO433 = new L.marker(new L.LatLng(50.772383,6.226992),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RSTO433 Stadtverwaltung Stolberg   50.772383,6.226992' ,
                    }).addTo(fg).bindPopup('RSTO433<br> Stadtverwaltung Stolberg <br> <br> 50.772383,6.226992<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('WVFD178<br> Westhaven Volunteer Fire Department <br> <br> 41.03568,-124.1101<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PSTO434 = new L.marker(new L.LatLng(50.771952,6.215136),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PSTO434 Polizeihauptwache Stolberg   50.771952,6.215136' ,
                    }).addTo(fg).bindPopup('PSTO434<br> Polizeihauptwache Stolberg <br> <br> 50.771952,6.215136<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('TFD179<br> Trinidad Fire Department <br> <br> 41.06041,-124.14269<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HSTO435 = new L.marker(new L.LatLng(50.772706,6.229039),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HSTO435 Bethlehem Health Center   50.772706,6.229039' ,
                    }).addTo(fg).bindPopup('HSTO435<br> Bethlehem Health Center <br> <br> 50.772706,6.229039<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('CFTFFS180<br> CAL FIRE Trinidad Forest Fire Station <br> <br> 41.07636,-124.14483<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FWSTO436 = new L.marker(new L.LatLng(50.772356,6.215903),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FWSTO436 Feuerwache Stolberg   50.772356,6.215903' ,
                    }).addTo(fg).bindPopup('FWSTO436<br> Feuerwache Stolberg <br> <br> 50.772356,6.215903<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('OVFD181<br> Orick Volunteer Fire Department <br> <br> 41.29056,-124.05703<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGVEN437 = new L.marker(new L.LatLng(50.706595,6.218356),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGVEN437 Gerätehaus Vennwegen   50.706595,6.218356' ,
                    }).addTo(fg).bindPopup('LGVEN437<br> Gerätehaus Vennwegen <br> <br> 50.706595,6.218356<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('YFD182<br> Yurok Fire Dept <br> <br> 41.04817,-123.67285<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBRE438 = new L.marker(new L.LatLng(50.730662,6.218026),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBRE438 Gerätehaus Breinig   50.730662,6.218026' ,
                    }).addTo(fg).bindPopup('LGBRE438<br> Gerätehaus Breinig <br> <br> 50.730662,6.218026<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('CFTVS183<br> Cal Fire Terwer Valley Station <br> <br> 41.52502,-123.99436<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGZWE439 = new L.marker(new L.LatLng(50.721203,6.253643),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGZWE439 Gerätehaus Zweifall   50.721203,6.253643' ,
                    }).addTo(fg).bindPopup('LGZWE439<br> Gerätehaus Zweifall <br> <br> 50.721203,6.253643<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KFD35184 = new L.marker(new L.LatLng(41.57543,-124.04627),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KFD35184 Klamath Fire Station 35   41.57543,-124.04627' ,
                    }).addTo(fg).bindPopup('KFD35184<br> Klamath Fire Station 35 <br> <br> 41.57543,-124.04627<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGVIC440 = new L.marker(new L.LatLng(50.744947,6.263825),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGVIC440 Gerätehaus Vicht   50.744947,6.263825' ,
                    }).addTo(fg).bindPopup('LGVIC440<br> Gerätehaus Vicht <br> <br> 50.744947,6.263825<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var KFD34185 = new L.marker(new L.LatLng(41.57347,-124.07127),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'KFD34185 Klamath Fire Station 34   41.57347,-124.07127' ,
                    }).addTo(fg).bindPopup('KFD34185<br> Klamath Fire Station 34 <br> <br> 41.57347,-124.07127<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGGRE441 = new L.marker(new L.LatLng(50.771925,6.303416),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGGRE441 Gerätehaus Gressenich   50.771925,6.303416' ,
                    }).addTo(fg).bindPopup('LGGRE441<br> Gerätehaus Gressenich <br> <br> 50.771925,6.303416<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CFPOBFS186 = new L.marker(new L.LatLng(41.75657,-124.15613),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CFPOBFS186 CFPO Beatsch Fire station   41.75657,-124.15613' ,
                    }).addTo(fg).bindPopup('CFPOBFS186<br> CFPO Beatsch Fire station <br> <br> 41.75657,-124.15613<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGWER442 = new L.marker(new L.LatLng(50.78098,6.286442),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGWER442 Gerätehaus Werth   50.78098,6.286442' ,
                    }).addTo(fg).bindPopup('LGWER442<br> Gerätehaus Werth <br> <br> 50.78098,6.286442<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('CCFR187<br> Crescent City Fire and Rescue _ City Station <br> <br> 41.75428,-124.19869<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGDON443 = new L.marker(new L.LatLng(50.781169,6.237568),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGDON443 Gerätehaus Donnerberg   50.781169,6.237568' ,
                    }).addTo(fg).bindPopup('LGDON443<br> Gerätehaus Donnerberg <br> <br> 50.781169,6.237568<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('CFCCFS188<br> CAL Fire/Crescent City Fire Station <br> <br> 41.76493,-124.19461<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGATS444 = new L.marker(new L.LatLng(50.786182,6.217396),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGATS444 Gerätehaus Atsch   50.786182,6.217396' ,
                    }).addTo(fg).bindPopup('LGATS444<br> Gerätehaus Atsch <br> <br> 50.786182,6.217396<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('CCFRWHQ189<br> Crescent City Fire and Rescue _ Washington Headquarters <br> <br> 41.77253,-124.20543<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSMIT445 = new L.marker(new L.LatLng(50.773596,6.233773),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSMIT445 Gerätehaus Stolberg Mitte   50.773596,6.233773' ,
                    }).addTo(fg).bindPopup('LGSMIT445<br> Gerätehaus Stolberg Mitte <br> <br> 50.773596,6.233773<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('HFD190<br> Hoopa Fire Department <br> <br> 41.04795,-123.67271<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RESCH446 = new L.marker(new L.LatLng(50.817958,6.271965),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RESCH446 Stadtverwaltung Eschweiler   50.817958,6.271965' ,
                    }).addTo(fg).bindPopup('RESCH446<br> Stadtverwaltung Eschweiler <br> <br> 50.817958,6.271965<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PESCH447 = new L.marker(new L.LatLng(50.822081,6.27491),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PESCH447 Polizeihauptwache Eschweiler   50.822081,6.27491' ,
                    }).addTo(fg).bindPopup('PESCH447<br> Polizeihauptwache Eschweiler <br> <br> 50.822081,6.27491<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('WCFD192<br> Willow Creek Fire Department <br> <br> 40.94043,-123.6334<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FWESCH449 = new L.marker(new L.LatLng(50.81122,6.255358),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FWESCH449 Feuerwache Eschweiler   50.81122,6.255358' ,
                    }).addTo(fg).bindPopup('FWESCH449<br> Feuerwache Eschweiler <br> <br> 50.81122,6.255358<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('KFPD194<br> Kneeland Fire Protection Distribution <br> <br> 40.77186,-124.00153<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBOH450 = new L.marker(new L.LatLng(50.798068,6.280844),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBOH450 Gerätehaus Bohl   50.798068,6.280844' ,
                    }).addTo(fg).bindPopup('LGBOH450<br> Gerätehaus Bohl <br> <br> 50.798068,6.280844<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var CFKHB195 = new L.marker(new L.LatLng(40.71948,-123.92928),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'CFKHB195 Cal Fire Kneeland Helitack Base  Cal Fire Rotary Air Craft and refull Air Attack Base 40.71948,-123.92928' ,
                    }).addTo(fg).bindPopup('CFKHB195<br> Cal Fire Kneeland Helitack Base <br> Cal Fire Rotary Air Craft and refull Air Attack Base<br> 40.71948,-123.92928<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGWEI451 = new L.marker(new L.LatLng(50.825261,6.308295),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGWEI451 Gerätehaus Weisweilerl   50.825261,6.308295' ,
                    }).addTo(fg).bindPopup('LGWEI451<br> Gerätehaus Weisweilerl <br> <br> 50.825261,6.308295<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('MCVF196<br> Maple Creek Volunteer Fire <br> <br> 40.76064,-123.87006<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGDUE452 = new L.marker(new L.LatLng(50.835584,6.273568),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGDUE452 Gerätehaus Dürwiss   50.835584,6.273568' ,
                    }).addTo(fg).bindPopup('LGDUE452<br> Gerätehaus Dürwiss <br> <br> 50.835584,6.273568<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('LFS197<br> Loleta Fire Station <br> <br> 40.64431,-124.22063<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGLOH453 = new L.marker(new L.LatLng(50.863128,6.290406),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGLOH453 Gerätehaus Neu_Lohn   50.863128,6.290406' ,
                    }).addTo(fg).bindPopup('LGLOH453<br> Gerätehaus Neu_Lohn <br> <br> 50.863128,6.290406<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('FFD198<br> Ferndale Fire Department <br> <br> 40.57622,-124.2635<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LHKIN454 = new L.marker(new L.LatLng(50.843966,6.229124),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LHKIN454 Gerätehaus Kinsweiler   50.843966,6.229124' ,
                    }).addTo(fg).bindPopup('LHKIN454<br> Gerätehaus Kinsweiler <br> <br> 50.843966,6.229124<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('FFD199<br> Fortuna Fire Department <br> <br> 40.58939,-124.14762<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGROE1455 = new L.marker(new L.LatLng(50.822782,6.235976),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGROE1455 Gerätehaus Röhe   50.822782,6.235976' ,
                    }).addTo(fg).bindPopup('LGROE1455<br> Gerätehaus Röhe <br> <br> 50.822782,6.235976<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('CFICC200<br> CAL FIRE_Interagency Command Center <br> Cal Fire, U.S. Forestry, California Fish and Wild Life, National Parks<br> 40.5925,-124.14733<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RWUER456 = new L.marker(new L.LatLng(50.819575,6.129974),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RWUER456 Stadtverwaltung Würselen   50.819575,6.129974' ,
                    }).addTo(fg).bindPopup('RWUER456<br> Stadtverwaltung Würselen <br> <br> 50.819575,6.129974<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('FVFDCH201<br> Fortuna Volunteer Fire Department Campton Heights Station <br> <br> 40.57024,-124.13481<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PWUER457 = new L.marker(new L.LatLng(50.820841,6.128693),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PWUER457 Polizeiwache Würselen   50.820841,6.128693' ,
                    }).addTo(fg).bindPopup('PWUER457<br> Polizeiwache Würselen <br> <br> 50.820841,6.128693<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('HFD202<br> Hydesville Fire Department <br> <br> 40.54748,-124.09449<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HRMK458 = new L.marker(new L.LatLng(50.815424,6.142567),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HRMK458 Rhein_Maas Klinikum   50.815424,6.142567' ,
                    }).addTo(fg).bindPopup('HRMK458<br> Rhein_Maas Klinikum <br> <br> 50.815424,6.142567<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FWWUER459 = new L.marker(new L.LatLng(50.829789,6.136548),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FWWUER459 Feuerwache Würselen   50.829789,6.136548' ,
                    }).addTo(fg).bindPopup('FWWUER459<br> Feuerwache Würselen <br> <br> 50.829789,6.136548<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('CFS204<br> Carlotta Fire Station <br> <br> 40.51942,-124.02393<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBAR460 = new L.marker(new L.LatLng(50.844639,6.112714),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBAR460 Gerätehaus Bardenberg   50.844639,6.112714' ,
                    }).addTo(fg).bindPopup('LGBAR460<br> Gerätehaus Bardenberg <br> <br> 50.844639,6.112714<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('MRFSUSFS205<br> Mad River Fire Station, U.S.Forest Service <br> <br> 40.46022,-123.52366<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBROI461 = new L.marker(new L.LatLng(50.826609,6.174031),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBROI461 Gerätehaus Broichweiden   50.826609,6.174031' ,
                    }).addTo(fg).bindPopup('LGBROI461<br> Gerätehaus Broichweiden <br> <br> 50.826609,6.174031<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGWMIT462 = new L.marker(new L.LatLng(50.829789,6.136548),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGWMIT462 Gerätehaus Mitte   50.829789,6.136548' ,
                    }).addTo(fg).bindPopup('LGWMIT462<br> Gerätehaus Mitte <br> <br> 50.829789,6.136548<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('RDVFD207<br> Rio Dell Volunteer Fire Department <br> <br> 40.50129,-124.107<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RHER463 = new L.marker(new L.LatLng(50.870513,6.101261),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RHER463 Stadtverwaltung Herzogenrath   50.870513,6.101261' ,
                    }).addTo(fg).bindPopup('RHER463<br> Stadtverwaltung Herzogenrath <br> <br> 50.870513,6.101261<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('SVFD208<br> Scotia Volunteer Fire Department <br> <br> 40.48164,-124.10331<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var UEHER464 = new L.marker(new L.LatLng(50.870836,6.102201),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'UEHER464 Polizeiwache Herzogenrath   50.870836,6.102201' ,
                    }).addTo(fg).bindPopup('UEHER464<br> Polizeiwache Herzogenrath <br> <br> 50.870836,6.102201<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('PFD209<br> Petrolia Fire District <br> <br> 40.32522,-124.28753<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FWHER465 = new L.marker(new L.LatLng(50.866874,6.09844),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FWHER465 Feuerwache Herzogenrath   50.866874,6.09844' ,
                    }).addTo(fg).bindPopup('FWHER465<br> Feuerwache Herzogenrath <br> <br> 50.866874,6.09844<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('CDFMFS210<br> California Department of Forestry Mattole Fire Station <br> <br> 40.23787,-124.13246<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGMER466 = new L.marker(new L.LatLng(50.887492,6.101902),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGMER466 Gerätehaus Merkstein   50.887492,6.101902' ,
                    }).addTo(fg).bindPopup('LGMER466<br> Gerätehaus Merkstein <br> <br> 50.887492,6.101902<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('CFWS211<br> Cal Fire Weott Station <br> <br> 40.32164,-123.92413<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGKOH467 = new L.marker(new L.LatLng(50.832215,6.085105),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGKOH467 Gerätehaus Kohlscheid   50.832215,6.085105' ,
                    }).addTo(fg).bindPopup('LGKOH467<br> Gerätehaus Kohlscheid <br> <br> 50.832215,6.085105<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('MFFS212<br> Myers Flat Fire Station <br> <br> 40.26633,-123.87313<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RBAES468 = new L.marker(new L.LatLng(50.908164,6.187756),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RBAES468 Stadtverwaltung Baesweiler   50.908164,6.187756' ,
                    }).addTo(fg).bindPopup('RBAES468<br> Stadtverwaltung Baesweiler <br> <br> 50.908164,6.187756<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('MVFD213<br> Miranda Volunteer Fire Department <br> <br> 40.23615,-123.8219<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PBAES469 = new L.marker(new L.LatLng(50.908164,6.187756),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PBAES469 Polizeiwache Baesweiler   50.908164,6.187756' ,
                    }).addTo(fg).bindPopup('PBAES469<br> Polizeiwache Baesweiler <br> <br> 50.908164,6.187756<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('PVFD214<br> Phillipsville Volunteer Fire Department <br> <br> 40.21163,-123.78644<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBAES470 = new L.marker(new L.LatLng(50.908164,6.187756),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBAES470 Gerätehaus Baesweiler   50.908164,6.187756' ,
                    }).addTo(fg).bindPopup('LGBAES470<br> Gerätehaus Baesweiler <br> <br> 50.908164,6.187756<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('BVFD215<br> Briceland Volunteer Fire Department <br> <br> 40.10015,-123.85869<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBEG471 = new L.marker(new L.LatLng(50.926302,6.169597),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBEG471 Gerätehaus Beggendorf   50.926302,6.169597' ,
                    }).addTo(fg).bindPopup('LGBEG471<br> Gerätehaus Beggendorf <br> <br> 50.926302,6.169597<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('CFTFS216<br> Cal Fire Thorn Fire Station <br> <br> 40.05676,-123.9616<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGOID472 = new L.marker(new L.LatLng(50.892694,6.18344),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGOID472 Gerätehaus Oidtweiler   50.892694,6.18344' ,
                    }).addTo(fg).bindPopup('LGOID472<br> Gerätehaus Oidtweiler <br> <br> 50.892694,6.18344<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('WFS2217<br> Whitethorn Fire Station 2 <br> <br> 40.05841,-123.97026<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSET473 = new L.marker(new L.LatLng(50.925385,6.200954),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSET473 Gerätehaus Setterich   50.925385,6.200954' ,
                    }).addTo(fg).bindPopup('LGSET473<br> Gerätehaus Setterich <br> <br> 50.925385,6.200954<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('SCVFD218<br> Shelter Cove Volunteer Fire Department <br> <br> 40.02877,-124.06532<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RALS474 = new L.marker(new L.LatLng(50.875364,6.166517),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RALS474 Stadtverwaltung Alsdorf   50.875364,6.166517' ,
                    }).addTo(fg).bindPopup('RALS474<br> Stadtverwaltung Alsdorf <br> <br> 50.875364,6.166517<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('CDFGF219<br> California Department of Forestry Garberville Forest Fire Station <br> <br> 40.10613,-123.79055<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PALS475 = new L.marker(new L.LatLng(50.871914,6.179722),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PALS475 Polizeiwache Alsdorf   50.871914,6.179722' ,
                    }).addTo(fg).bindPopup('PALS475<br> Polizeiwache Alsdorf <br> <br> 50.871914,6.179722<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('GFPD220<br> Garberville Fire Protection District <br> <br> 40.10266,-123.79382<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGALS476 = new L.marker(new L.LatLng(50.875067,6.173953),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGALS476 Gerätehaus Alsdorf   50.875067,6.173953' ,
                    }).addTo(fg).bindPopup('LGALS476<br> Gerätehaus Alsdorf <br> <br> 50.875067,6.173953<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGHOE477 = new L.marker(new L.LatLng(50.860056,6.20485),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGHOE477 Gerätehaus Hoengen   50.860056,6.20485' ,
                    }).addTo(fg).bindPopup('LGHOE477<br> Gerätehaus Hoengen <br> <br> 50.860056,6.20485<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('KVFDFS222<br> Kettenpom Volunteer Fire Department Fire Station <br> <br> 40.15756,-123.46215<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBET478 = new L.marker(new L.LatLng(50.886872,6.198953),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBET478 Gerätehaus Bettendorf   50.886872,6.198953' ,
                    }).addTo(fg).bindPopup('LGBET478<br> Gerätehaus Bettendorf <br> <br> 50.886872,6.198953<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('WGVF223<br> Whale Gulch Volunteer Fire <br> <br> 39.98179,-123.97839<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RAAC479 = new L.marker(new L.LatLng(50.768098,6.088472),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RAAC479 Stadtverwaltung Aachen   50.768098,6.088472' ,
                    }).addTo(fg).bindPopup('RAAC479<br> Stadtverwaltung Aachen <br> <br> 50.768098,6.088472<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var PAAC480 = new L.marker(new L.LatLng(50.756751,6.149202),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'PAAC480 Polizeipräsidium Aachen   50.756751,6.149202' ,
                    }).addTo(fg).bindPopup('PAAC480<br> Polizeipräsidium Aachen <br> <br> 50.756751,6.149202<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var RWTH481 = new L.marker(new L.LatLng(50.776318,6.043778),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'RWTH481 Uni Klinik RWTH   50.776318,6.043778' ,
                    }).addTo(fg).bindPopup('RWTH481<br> Uni Klinik RWTH <br> <br> 50.776318,6.043778<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FWAAC1484 = new L.marker(new L.LatLng(50.7771,6.11679),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FWAAC1484 Feuerwache Aachen   50.7771,6.11679' ,
                    }).addTo(fg).bindPopup('FWAAC1484<br> Feuerwache Aachen <br> <br> 50.7771,6.11679<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FWAAC2485 = new L.marker(new L.LatLng(50.728695,6.175038),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FWAAC2485 Feuerwache 2  Aachen   50.728695,6.175038' ,
                    }).addTo(fg).bindPopup('FWAAC2485<br> Feuerwache 2  Aachen <br> <br> 50.728695,6.175038<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var FWAAC3486 = new L.marker(new L.LatLng(50.789039,6.047787),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'FWAAC3486 Feuerwache 3 Aachen   50.789039,6.047787' ,
                    }).addTo(fg).bindPopup('FWAAC3486<br> Feuerwache 3 Aachen <br> <br> 50.789039,6.047787<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGACMIT487 = new L.marker(new L.LatLng(50.786317,6.135769),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGACMIT487 Gerätehaus Mitte   50.786317,6.135769' ,
                    }).addTo(fg).bindPopup('LGACMIT487<br> Gerätehaus Mitte <br> <br> 50.786317,6.135769<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGLAU488 = new L.marker(new L.LatLng(50.798014,6.060472),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGLAU488 Gerätehaus Laurensberg   50.798014,6.060472' ,
                    }).addTo(fg).bindPopup('LGLAU488<br> Gerätehaus Laurensberg <br> <br> 50.798014,6.060472<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGBRA489 = new L.marker(new L.LatLng(50.747453,6.163663),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGBRA489 Gerätehaus Brand   50.747453,6.163663' ,
                    }).addTo(fg).bindPopup('LGBRA489<br> Gerätehaus Brand <br> <br> 50.747453,6.163663<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGRICH490 = new L.marker(new L.LatLng(50.814562,6.05599),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGRICH490 Gerätehaus Richterich   50.814562,6.05599' ,
                    }).addTo(fg).bindPopup('LGRICH490<br> Gerätehaus Richterich <br> <br> 50.814562,6.05599<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSIEF491 = new L.marker(new L.LatLng(50.694817,6.146472),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSIEF491 Gerätehaus Sief   50.694817,6.146472' ,
                    }).addTo(fg).bindPopup('LGSIEF491<br> Gerätehaus Sief <br> <br> 50.694817,6.146472<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGEILD492 = new L.marker(new L.LatLng(50.77656,6.149927),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGEILD492 Gerätehaus Eilendorf   50.77656,6.149927' ,
                    }).addTo(fg).bindPopup('LGEILD492<br> Gerätehaus Eilendorf <br> <br> 50.77656,6.149927<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGHAAR493 = new L.marker(new L.LatLng(50.797582,6.123783),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGHAAR493 Gerätehaus Haaren   50.797582,6.123783' ,
                    }).addTo(fg).bindPopup('LGHAAR493<br> Gerätehaus Haaren <br> <br> 50.797582,6.123783<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGVERL494 = new L.marker(new L.LatLng(50.797933,6.152941),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGVERL494 Gerätehaus Verlautenheide   50.797933,6.152941' ,
                    }).addTo(fg).bindPopup('LGVERL494<br> Gerätehaus Verlautenheide <br> <br> 50.797933,6.152941<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var HSLE496 = new L.marker(new L.LatLng(50.533379,6.48691),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'HSLE496 Krankenhaus Schleiden   50.533379,6.48691' ,
                    }).addTo(fg).bindPopup('HSLE496<br> Krankenhaus Schleiden <br> <br> 50.533379,6.48691<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSLE497 = new L.marker(new L.LatLng(50.532139,6.479103),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSLE497 Gerätehaus Schleiden   50.532139,6.479103' ,
                    }).addTo(fg).bindPopup('LGSLE497<br> Gerätehaus Schleiden <br> <br> 50.532139,6.479103<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGGEMU498 = new L.marker(new L.LatLng(50.560923,6.497772),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGGEMU498 Gerätehaus Gemuend   50.560923,6.497772' ,
                    }).addTo(fg).bindPopup('LGGEMU498<br> Gerätehaus Gemuend <br> <br> 50.560923,6.497772<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGOBER1499 = new L.marker(new L.LatLng(50.512222,6.465568),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGOBER1499 Gerätehaus Oberhausen   50.512222,6.465568' ,
                    }).addTo(fg).bindPopup('LGOBER1499<br> Gerätehaus Oberhausen <br> <br> 50.512222,6.465568<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGHER500 = new L.marker(new L.LatLng(50.554778,6.457676),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGHER500 Gerätehaus Herhahn   50.554778,6.457676' ,
                    }).addTo(fg).bindPopup('LGHER500<br> Gerätehaus Herhahn <br> <br> 50.554778,6.457676<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGHARP506 = new L.marker(new L.LatLng(50.518637,6.406335),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGHARP506 Gerätehaus Harperscheid   50.518637,6.406335' ,
                    }).addTo(fg).bindPopup('LGHARP506<br> Gerätehaus Harperscheid <br> <br> 50.518637,6.406335<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('FIRE11252<br> Fire11 <br> <br> 48.011343,-122.770733<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGSCHM508 = new L.marker(new L.LatLng(50.657598,6.398873),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGSCHM508 Gerätehaus Schmidt   50.657598,6.398873' ,
                    }).addTo(fg).bindPopup('LGSCHM508<br> Gerätehaus Schmidt <br> <br> 50.657598,6.398873<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('FIRE12253<br> Fire12 <br> <br> 48.043012,-122.691671<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('FIRE13254<br> Fire13 <br> <br> 48.057266,-122.80605<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('FIRE14255<br> Fire14 <br> <br> 48.088759,-122.868354<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var LGGEMU511 = new L.marker(new L.LatLng(50.560923,6.497772),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/fire.png', iconSize: [32, 34]}),
                title: 'LGGEMU511 Gerätehaus Gemnd   50.560923,6.497772' ,
                    }).addTo(fg).bindPopup('LGGEMU511<br> Gerätehaus Gemnd <br> <br> 50.560923,6.497772<br>Created: ' );                        
         
                $('fire'._icon).addClass('firemrkr');
            
            var BATES1 = new L.marker(new L.LatLng(38.2498,-94.3432),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'BATES1 BATES COUNTY HOSPITAL  KCHEART 38.2498,-94.3432' ,
                    }).addTo(fg).bindPopup('BATES1<br> BATES COUNTY HOSPITAL <br> KCHEART<br> 38.2498,-94.3432<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var BOTHWL2 = new L.marker(new L.LatLng(38.6993,-93.2208),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'BOTHWL2 BOTHWELL REGIONAL HEALTH CENTER   38.6993,-93.2208' ,
                    }).addTo(fg).bindPopup('BOTHWL2<br> BOTHWELL REGIONAL HEALTH CENTER <br> <br> 38.6993,-93.2208<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var BRMC3 = new L.marker(new L.LatLng(38.8158,-94.5033),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'BRMC3 Research Belton Hospital   38.8158,-94.5033' ,
                    }).addTo(fg).bindPopup('BRMC3<br> Research Belton Hospital <br> <br> 38.8158,-94.5033<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
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
                    }).addTo(fg).bindPopup('JCC259<br> JC CLINIC <br> <br> 47.919701,-122.702967<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var CARROL4 = new L.marker(new L.LatLng(39.3762,-93.494),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'CARROL4 CARROLL COUNTY HOSPITAL   39.3762,-93.494' ,
                    }).addTo(fg).bindPopup('CARROL4<br> CARROLL COUNTY HOSPITAL <br> <br> 39.3762,-93.494<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('JCC260<br> JC CLINIC <br> <br> 47.821937,-122.875899<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var CASS5 = new L.marker(new L.LatLng(38.6645,-94.3725),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'CASS5 Cass Medical Center   38.6645,-94.3725' ,
                    }).addTo(fg).bindPopup('CASS5<br> Cass Medical Center <br> <br> 38.6645,-94.3725<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var CMH6 = new L.marker(new L.LatLng(39.852,-943.74),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'CMH6 Childrens Mercy Hospital   39.852,-943.74' ,
                    }).addTo(fg).bindPopup('CMH6<br> Childrens Mercy Hospital <br> <br> 39.852,-943.74<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var CMHS7 = new L.marker(new L.LatLng(38.9302,-94.6613),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'CMHS7 Childrens Mercy Hospital South   38.9302,-94.6613' ,
                    }).addTo(fg).bindPopup('CMHS7<br> Childrens Mercy Hospital South <br> <br> 38.9302,-94.6613<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var CUSHNG8 = new L.marker(new L.LatLng(39.3072,-94.9185),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'CUSHNG8 Cushing Memorial Hospital   39.3072,-94.9185' ,
                    }).addTo(fg).bindPopup('CUSHNG8<br> Cushing Memorial Hospital <br> <br> 39.3072,-94.9185<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var DCEC9 = new L.marker(new L.LatLng(39.862,-94.576),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'DCEC9 Metro Regional Healthcare Coord. Ctr   39.862,-94.576' ,
                    }).addTo(fg).bindPopup('DCEC9<br> Metro Regional Healthcare Coord. Ctr <br> <br> 39.862,-94.576<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var EXSPR10 = new L.marker(new L.LatLng(39.3568,-94.237),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'EXSPR10 Excelsior Springs Medical Center   39.3568,-94.237' ,
                    }).addTo(fg).bindPopup('EXSPR10<br> Excelsior Springs Medical Center <br> <br> 39.3568,-94.237<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var FITZ11 = new L.marker(new L.LatLng(39.928,-93.2143),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'FITZ11 FITZGIBBON HOSPITAL   39.928,-93.2143' ,
                    }).addTo(fg).bindPopup('FITZ11<br> FITZGIBBON HOSPITAL <br> <br> 39.928,-93.2143<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var GVMH12 = new L.marker(new L.LatLng(38.3892,-93.7702),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'GVMH12 GOLDEN VALLEY MEMORIAL HOSPITAL   38.3892,-93.7702' ,
                    }).addTo(fg).bindPopup('GVMH12<br> GOLDEN VALLEY MEMORIAL HOSPITAL <br> <br> 38.3892,-93.7702<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var I7013 = new L.marker(new L.LatLng(38.9783,-93.4162),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'I7013 I_70 MEDICAL CENTER   38.9783,-93.4162' ,
                    }).addTo(fg).bindPopup('I7013<br> I_70 MEDICAL CENTER <br> <br> 38.9783,-93.4162<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var FWRW6525 = new L.marker(new L.LatLng(50.780334,6.097386),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'FWRW6525 Rettungswache 6   50.780334,6.097386' ,
                    }).addTo(fg).bindPopup('FWRW6525<br> Rettungswache 6 <br> <br> 50.780334,6.097386<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var KC0CBC14 = new L.marker(new L.LatLng(39.537,-94.5865),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'KC0CBC14 Kansas City Blood Bank   39.537,-94.5865' ,
                    }).addTo(fg).bindPopup('KC0CBC14<br> Kansas City Blood Bank <br> <br> 39.537,-94.5865<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var FWRW5526 = new L.marker(new L.LatLng(50.78098,6.12967),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'FWRW5526 Rettungswache 5   50.78098,6.12967' ,
                    }).addTo(fg).bindPopup('FWRW5526<br> Rettungswache 5 <br> <br> 50.78098,6.12967<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var KCVA15 = new L.marker(new L.LatLng(39.672,-94.5282),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'KCVA15 Veterans Affairs Medical Center   39.672,-94.5282' ,
                    }).addTo(fg).bindPopup('KCVA15<br> Veterans Affairs Medical Center <br> <br> 39.672,-94.5282<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var FWRW4527 = new L.marker(new L.LatLng(50.781304,6.134702),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'FWRW4527 Rettungswache 4   50.781304,6.134702' ,
                    }).addTo(fg).bindPopup('FWRW4527<br> Rettungswache 4 <br> <br> 50.781304,6.134702<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var KINDRD16 = new L.marker(new L.LatLng(38.968,-94.5745),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'KINDRD16 Kindred Hospital Kansas City   38.968,-94.5745' ,
                    }).addTo(fg).bindPopup('KINDRD16<br> Kindred Hospital Kansas City <br> <br> 38.968,-94.5745<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var KU0MED17 = new L.marker(new L.LatLng(39.557,-94.6102),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'KU0MED17 University of Kansas Hospital   39.557,-94.6102' ,
                    }).addTo(fg).bindPopup('KU0MED17<br> University of Kansas Hospital <br> <br> 39.557,-94.6102<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var LIBRTY18 = new L.marker(new L.LatLng(39.274,-94.4233),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'LIBRTY18 Liberty Hospital   39.274,-94.4233' ,
                    }).addTo(fg).bindPopup('LIBRTY18<br> Liberty Hospital <br> <br> 39.274,-94.4233<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var LCHD19 = new L.marker(new L.LatLng(39.1732,-93.8748),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'LCHD19 LAFAYETTE CO HEALTH DEPT   39.1732,-93.8748' ,
                    }).addTo(fg).bindPopup('LCHD19<br> LAFAYETTE CO HEALTH DEPT <br> <br> 39.1732,-93.8748<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var LRHC20 = new L.marker(new L.LatLng(39.1893,-93.8768),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'LRHC20 LAFAYETTE REGIONAL HEALTH CENTER   39.1893,-93.8768' ,
                    }).addTo(fg).bindPopup('LRHC20<br> LAFAYETTE REGIONAL HEALTH CENTER <br> <br> 39.1893,-93.8768<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var LSMED21 = new L.marker(new L.LatLng(38.9035,-94.3327),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'LSMED21 Lee Summit Medical Center   38.9035,-94.3327' ,
                    }).addTo(fg).bindPopup('LSMED21<br> Lee Summit Medical Center <br> <br> 38.9035,-94.3327<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var MENORA22 = new L.marker(new L.LatLng(38.9107,-94.6512),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'MENORA22 Menorah Medical Center   38.9107,-94.6512' ,
                    }).addTo(fg).bindPopup('MENORA22<br> Menorah Medical Center <br> <br> 38.9107,-94.6512<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var NORKC23 = new L.marker(new L.LatLng(39.1495,-94.5513),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'NORKC23 North Kansas City Hospital   39.1495,-94.5513' ,
                    }).addTo(fg).bindPopup('NORKC23<br> North Kansas City Hospital <br> <br> 39.1495,-94.5513<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var OMC24 = new L.marker(new L.LatLng(38.853,-94.8235),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'OMC24 Olathe Medical Center, Inc.   38.853,-94.8235' ,
                    }).addTo(fg).bindPopup('OMC24<br> Olathe Medical Center, Inc. <br> <br> 38.853,-94.8235<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var OPR25 = new L.marker(new L.LatLng(39.9372,-94.7262),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'OPR25 Overland Park RMC   39.9372,-94.7262' ,
                    }).addTo(fg).bindPopup('OPR25<br> Overland Park RMC <br> <br> 39.9372,-94.7262<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var PETTIS26 = new L.marker(new L.LatLng(38.6973,-93.2163),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'PETTIS26 PETTIS Co Health Dept   38.6973,-93.2163' ,
                    }).addTo(fg).bindPopup('PETTIS26<br> PETTIS Co Health Dept <br> <br> 38.6973,-93.2163<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var PMC27 = new L.marker(new L.LatLng(39.127,-94.7865),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'PMC27 Providence Medical Center   39.127,-94.7865' ,
                    }).addTo(fg).bindPopup('PMC27<br> Providence Medical Center <br> <br> 39.127,-94.7865<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var RAYCO28 = new L.marker(new L.LatLng(39.2587,-93.9543),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'RAYCO28 RAY COUNTY HOSPITAL   39.2587,-93.9543' ,
                    }).addTo(fg).bindPopup('RAYCO28<br> RAY COUNTY HOSPITAL <br> <br> 39.2587,-93.9543<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var RESRCH29 = new L.marker(new L.LatLng(39.167,-94.6682),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'RESRCH29 Research Medical Center   39.167,-94.6682' ,
                    }).addTo(fg).bindPopup('RESRCH29<br> Research Medical Center <br> <br> 39.167,-94.6682<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var RMCBKS30 = new L.marker(new L.LatLng(39.8,-94.5778),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'RMCBKS30 Research Medical Center_ Brookside   39.8,-94.5778' ,
                    }).addTo(fg).bindPopup('RMCBKS30<br> Research Medical Center_ Brookside <br> <br> 39.8,-94.5778<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var SMMC31 = new L.marker(new L.LatLng(38.9955,-94.6908),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'SMMC31 Shawnee Mission Medical Center   38.9955,-94.6908' ,
                    }).addTo(fg).bindPopup('SMMC31<br> Shawnee Mission Medical Center <br> <br> 38.9955,-94.6908<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var STJOHN32 = new L.marker(new L.LatLng(39.2822,-94.9058),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'STJOHN32 Saint John Hospital   39.2822,-94.9058' ,
                    }).addTo(fg).bindPopup('STJOHN32<br> Saint John Hospital <br> <br> 39.2822,-94.9058<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var STJOMC33 = new L.marker(new L.LatLng(38.9362,-94.6037),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'STJOMC33 Saint Joseph Medical Center   38.9362,-94.6037' ,
                    }).addTo(fg).bindPopup('STJOMC33<br> Saint Joseph Medical Center <br> <br> 38.9362,-94.6037<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var STLEAS34 = new L.marker(new L.LatLng(38.9415,-94.3813),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'STLEAS34 Saint Lukes East_Lees Summit   38.9415,-94.3813' ,
                    }).addTo(fg).bindPopup('STLEAS34<br> Saint Lukes East_Lees Summit <br> <br> 38.9415,-94.3813<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var STLPLZ35 = new L.marker(new L.LatLng(39.477,-94.5895),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'STLPLZ35 Saint Lukes Hospital Plaza   39.477,-94.5895' ,
                    }).addTo(fg).bindPopup('STLPLZ35<br> Saint Lukes Hospital Plaza <br> <br> 39.477,-94.5895<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var STLSMI36 = new L.marker(new L.LatLng(39.3758,-94.5807),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'STLSMI36 Saint Lukes Smithville Campus   39.3758,-94.5807' ,
                    }).addTo(fg).bindPopup('STLSMI36<br> Saint Lukes Smithville Campus <br> <br> 39.3758,-94.5807<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var STLUBR37 = new L.marker(new L.LatLng(39.2482,-94.6487),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'STLUBR37 Saint Lukes Barry Road Campus   39.2482,-94.6487' ,
                    }).addTo(fg).bindPopup('STLUBR37<br> Saint Lukes Barry Road Campus <br> <br> 39.2482,-94.6487<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var STLUSO38 = new L.marker(new L.LatLng(38.904,-94.6682),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'STLUSO38 Saint Lukes South Hospital   38.904,-94.6682' ,
                    }).addTo(fg).bindPopup('STLUSO38<br> Saint Lukes South Hospital <br> <br> 38.904,-94.6682<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var STM39 = new L.marker(new L.LatLng(39.263,-94.2627),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'STM39 Saint Marys Medical Center   39.263,-94.2627' ,
                    }).addTo(fg).bindPopup('STM39<br> Saint Marys Medical Center <br> <br> 39.263,-94.2627<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var TRLKWD40 = new L.marker(new L.LatLng(38.9745,-94.3915),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'TRLKWD40 Truman Lakewood   38.9745,-94.3915' ,
                    }).addTo(fg).bindPopup('TRLKWD40<br> Truman Lakewood <br> <br> 38.9745,-94.3915<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var TRUHH41 = new L.marker(new L.LatLng(39.853,-94.5737),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'TRUHH41 Truman Medical Center_Hospital Hill   39.853,-94.5737' ,
                    }).addTo(fg).bindPopup('TRUHH41<br> Truman Medical Center_Hospital Hill <br> <br> 39.853,-94.5737<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var W0CPT42 = new L.marker(new L.LatLng(39.5,-94.3483),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'W0CPT42 Centerpoint Medical Center   39.5,-94.3483' ,
                    }).addTo(fg).bindPopup('W0CPT42<br> Centerpoint Medical Center <br> <br> 39.5,-94.3483<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var WEMO43 = new L.marker(new L.LatLng(38.7667,-93.7217),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'WEMO43 WESTERN MISSOURI MEDICAL CENTER   38.7667,-93.7217' ,
                    }).addTo(fg).bindPopup('WEMO43<br> WESTERN MISSOURI MEDICAL CENTER <br> <br> 38.7667,-93.7217<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var LMH145 = new L.marker(new L.LatLng(38.979225,-95.248259),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'LMH145 Lawrence Memorial Hospital  ACT staffs this location in emergencies  38.979225,-95.248259' ,
                    }).addTo(fg).bindPopup('LMH145<br> Lawrence Memorial Hospital <br> ACT staffs this location in emergencies <br> 38.979225,-95.248259<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var HSIM408 = new L.marker(new L.LatLng(50.604692,6.301457),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'HSIM408 Eifel Clinic St. Brigida   50.604692,6.301457' ,
                    }).addTo(fg).bindPopup('HSIM408<br> Eifel Clinic St. Brigida <br> <br> 50.604692,6.301457<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var SJH160 = new L.marker(new L.LatLng(40.7841,-124.1422),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'SJH160 St Joseph Hospital  Level 3 Trauma Center, Helipad 40.7841,-124.1422' ,
                    }).addTo(fg).bindPopup('SJH160<br> St Joseph Hospital <br> Level 3 Trauma Center, Helipad<br> 40.7841,-124.1422<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var MRCH161 = new L.marker(new L.LatLng(40.8963,-124.0917),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'MRCH161 Mad River Community Hospital  Level 4 Trauma Center, Helipad 40.8963,-124.0917' ,
                    }).addTo(fg).bindPopup('MRCH161<br> Mad River Community Hospital <br> Level 4 Trauma Center, Helipad<br> 40.8963,-124.0917<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('RMH162<br> Redwood Memorial Hospital <br> <br> 40.5823,-124.1364<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('JPCH163<br> Jerold Phelps Community Hospital <br> <br> 40.1016,-123.7922<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('TH164<br> Trinity Hospital <br> <br> 40.7381,-122.9396<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('SCH165<br> Sutter Coast Hospital <br> <br> 41.7737,-124.1942<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var HESCH448 = new L.marker(new L.LatLng(50.818443,6.264238),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'HESCH448 St._Antonius_Hospital   50.818443,6.264238' ,
                    }).addTo(fg).bindPopup('HESCH448<br> St._Antonius_Hospital <br> <br> 50.818443,6.264238<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var MARIEN482 = new L.marker(new L.LatLng(50.762088,6.095381),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'MARIEN482 Marienhospital   50.762088,6.095381' ,
                    }).addTo(fg).bindPopup('MARIEN482<br> Marienhospital <br> <br> 50.762088,6.095381<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var LUISEN483 = new L.marker(new L.LatLng(50.767613,6.076744),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'LUISEN483 Luisenhospital   50.767613,6.076744' ,
                    }).addTo(fg).bindPopup('LUISEN483<br> Luisenhospital <br> <br> 50.767613,6.076744<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var FWWEST495 = new L.marker(new L.LatLng(50.769338,6.056529),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/firstaid.png', iconSize: [32, 34]}),
                title: 'FWWEST495 Rettungswache West   50.769338,6.056529' ,
                    }).addTo(fg).bindPopup('FWWEST495<br> Rettungswache West <br> <br> 50.769338,6.056529<br>Created: ' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var PTPOLICE1925279 = new L.marker(new L.LatLng(48.11464,-122.77136),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'PTPOLICE1925279 PT POLICE   48.11464,-122.77136' ,
                    }).addTo(fg).bindPopup('PTPOLICE1925279<br> PT POLICE <br> <br> 48.11464,-122.77136<br>Created: ' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var FPD93721130 = new L.marker(new L.LatLng(36.737611,-119.78787),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'FPD93721130 Fresno Police Department   36.737611,-119.78787' ,
                    }).addTo(fg).bindPopup('FPD93721130<br> Fresno Police Department <br> <br> 36.737611,-119.78787<br>Created: ' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var NRTPD132 = new L.marker(new L.LatLng(39.183487,-94.605311),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'NRTPD132 Northmoor Police Department   39.183487,-94.605311' ,
                    }).addTo(fg).bindPopup('NRTPD132<br> Northmoor Police Department <br> <br> 39.183487,-94.605311<br>Created: ' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var RVRSPD133 = new L.marker(new L.LatLng(39.175239,-94.616458),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'RVRSPD133 Riverside City Police Department   39.175239,-94.616458' ,
                    }).addTo(fg).bindPopup('RVRSPD133<br> Riverside City Police Department <br> <br> 39.175239,-94.616458<br>Created: ' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var PKVLPD135 = new L.marker(new L.LatLng(39.207055,-94.683832),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'PKVLPD135 Parkville Police Department   39.207055,-94.683832' ,
                    }).addTo(fg).bindPopup('PKVLPD135<br> Parkville Police Department <br> <br> 39.207055,-94.683832<br>Created: ' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var LKWKPD136 = new L.marker(new L.LatLng(39.227468,-94.634039),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'LKWKPD136 Lake Waukomis Police Department   39.227468,-94.634039' ,
                    }).addTo(fg).bindPopup('LKWKPD136<br> Lake Waukomis Police Department <br> <br> 39.227468,-94.634039<br>Created: ' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var GSTNPD137 = new L.marker(new L.LatLng(39.221477,-94.57198),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'GSTNPD137 Gladstone Police Department   39.221477,-94.57198' ,
                    }).addTo(fg).bindPopup('GSTNPD137<br> Gladstone Police Department <br> <br> 39.221477,-94.57198<br>Created: ' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var NKCPD138 = new L.marker(new L.LatLng(39.143363,-94.573404),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'NKCPD138 North Kansas City Police Department   39.143363,-94.573404' ,
                    }).addTo(fg).bindPopup('NKCPD138<br> North Kansas City Police Department <br> <br> 39.143363,-94.573404<br>Created: ' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var COMOPD139 = new L.marker(new L.LatLng(39.197769,-94.5038),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'COMOPD139 Claycomo Police Department   39.197769,-94.5038' ,
                    }).addTo(fg).bindPopup('COMOPD139<br> Claycomo Police Department <br> <br> 39.197769,-94.5038<br>Created: ' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var KCNPPD140 = new L.marker(new L.LatLng(39.291975,-94.684958),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'KCNPPD140 Kansas City Police North Patrol   39.291975,-94.684958' ,
                    }).addTo(fg).bindPopup('KCNPPD140<br> Kansas City Police North Patrol <br> <br> 39.291975,-94.684958<br>Created: ' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var PLTCTYPD141 = new L.marker(new L.LatLng(39.370039,-94.77987),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'PLTCTYPD141 Platte City Police Department   39.370039,-94.77987' ,
                    }).addTo(fg).bindPopup('PLTCTYPD141<br> Platte City Police Department <br> <br> 39.370039,-94.77987<br>Created: ' );                        
         
                $('police'._icon).addClass('polmrkr');
            
            var KSZS404 = new L.marker(new L.LatLng(50.598817,6.289012),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'KSZS404 Katastrophenschutzzentrum   50.598817,6.289012' ,
                    }).addTo(fg).bindPopup('KSZS404<br> Katastrophenschutzzentrum <br> <br> 50.598817,6.289012<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('HPA172<br> Highway Patrol_Arcata <br> <br> 40.86155,-124.07923<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('LTRDUSFS191<br> Lower Trinity Ranger District U.S. Forest Service <br> <br> 40.9472,-123.63672<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('LTRD193<br> Lower Trinity Ranger District <br> <br> 40.88817,-123.58598<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('USFSMRRDO206<br> US Forest Service Mad River Ranger District Office <br> <br> 40.46494,-123.53175<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('CHPGS227<br> California Highway Patrol_Garberville Station <br> <br> 40.11593,-123.81354<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('EPD228<br> Eureka Police Department <br> <br> 40.8006,-124.16932<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('FPD229<br> Ferndale Police Department <br> CERT governing body<br> 40.57692,-124.26119<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('FPD230<br> Fortuna Police Department <br> <br> 40.59758,-124.15494<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('APD231<br> Arcata Police Department <br> CERT governing body<br> 40.86734,-124.08477<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('TPD232<br> Trinidad Police Department <br> <br> 41.05984,-124.14284<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('HSUCP233<br> Humboldt State University Campus Police <br> <br> 40.87461,-124.07913<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('RDPD234<br> Rio Dell Police Department <br> <br> 40.4991,-124.10674<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('HTP235<br> Hoopa Tribal Police <br> <br> 41.06548,-123.68557<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('BLPD236<br> Blue Lake Police Department <br> <br> 40.8827,-123.99215<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('CHPDC237<br> California Highway Patrol Dispatch Center <br> <br> 40.79191,-124.17572<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('CDFW250<br> California Department of Fish and Wildlife <br> <br> 40.80494,-124.16492<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('W7JCR268<br> W7JCR <br> 145.15- 114.8<br> 48.124567,-122.76529<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('AA7MI269<br> AA7MI <br> 440.725+ 114.8<br> 48.040336,-122.687109<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('AA7MI270<br> AA7MI <br> 443.825+ CC1<br> 48.116172,-122.764327<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var DB0QA528 = new L.marker(new L.LatLng(50.875067,6.16656),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'DB0QA528 70cm Alsdorf  Operator DB9KN Max 50.875067,6.16656' ,
                    }).addTo(fg).bindPopup('DB0QA528<br> 70cm Alsdorf <br> Operator DB9KN Max<br> 50.875067,6.16656<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var DJ2UB529 = new L.marker(new L.LatLng(50.756536,6.158414),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'DJ2UB529 70cm Aachen Brand  Operator DJ2UN Uli 50.756536,6.158414' ,
                    }).addTo(fg).bindPopup('DJ2UB529<br> 70cm Aachen Brand <br> Operator DJ2UN Uli<br> 50.756536,6.158414<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var DB0NIS530 = new L.marker(new L.LatLng(50.65722,6.398236),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'DB0NIS530 70cm Nideggen_Schmidt  Operator DL8KCS Werner 50.65722,6.398236' ,
                    }).addTo(fg).bindPopup('DB0NIS530<br> 70cm Nideggen_Schmidt <br> Operator DL8KCS Werner<br> 50.65722,6.398236<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var ON0RBO531 = new L.marker(new L.LatLng(50.653178,6.168431),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'ON0RBO531 70cm Petergensfeld    50.653178,6.168431' ,
                    }).addTo(fg).bindPopup('ON0RBO531<br> 70cm Petergensfeld <br>  <br> 50.653178,6.168431<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var DB0SE532 = new L.marker(new L.LatLng(50.477617,6.52308),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'DB0SE532 70cm Kall  Operator DL8KBX Klaus 50.477617,6.52308' ,
                    }).addTo(fg).bindPopup('DB0SE532<br> 70cm Kall <br> Operator DL8KBX Klaus<br> 50.477617,6.52308<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GS280 = new L.marker(new L.LatLng(33.9137001,-79.04519653),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GS280 W4GS  145.11 PL 85.4 OFFSET - 33.9137001,-79.04519653' ,
                    }).addTo(fg).bindPopup('W4GS280<br> W4GS <br> 145.11 PL 85.4 OFFSET -<br> 33.9137001,-79.04519653<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KT4TF281 = new L.marker(new L.LatLng(34.99580002,-80.85500336),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KT4TF281 KT4TF  145.11 PL 110.9 OFFSET - 34.99580002,-80.85500336' ,
                    }).addTo(fg).bindPopup('KT4TF281<br> KT4TF <br> 145.11 PL 110.9 OFFSET -<br> 34.99580002,-80.85500336<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4DV282 = new L.marker(new L.LatLng(33.4734993,-82.01049805),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4DV282 W4DV  145.11 PL 71.9 OFFSET - 33.4734993,-82.01049805' ,
                    }).addTo(fg).bindPopup('W4DV282<br> W4DV <br> 145.11 PL 71.9 OFFSET -<br> 33.4734993,-82.01049805<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4BFT283 = new L.marker(new L.LatLng(32.39139938,-80.74849701),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4BFT283 W4BFT  145.13 PL 88.5 OFFSET - 32.39139938,-80.74849701' ,
                    }).addTo(fg).bindPopup('W4BFT283<br> W4BFT <br> 145.13 PL 88.5 OFFSET -<br> 32.39139938,-80.74849701<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KM4ABW284 = new L.marker(new L.LatLng(33.68700027,-80.21170044),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KM4ABW284 KM4ABW  145.15 PL 91.5 OFFSET - 33.68700027,-80.21170044' ,
                    }).addTo(fg).bindPopup('KM4ABW284<br> KM4ABW <br> 145.15 PL 91.5 OFFSET -<br> 33.68700027,-80.21170044<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4TWX285 = new L.marker(new L.LatLng(34.88339996,-82.70739746),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4TWX285 W4TWX  145.17 PL 162.2 OFFSET - 34.88339996,-82.70739746' ,
                    }).addTo(fg).bindPopup('W4TWX285<br> W4TWX <br> 145.17 PL 162.2 OFFSET -<br> 34.88339996,-82.70739746<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4LMD286 = new L.marker(new L.LatLng(33.203402,-80.799942),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4LMD286 K4LMD  145.21 PL 100 OFFSET - 33.203402,-80.799942' ,
                    }).addTo(fg).bindPopup('K4LMD286<br> K4LMD <br> 145.21 PL 100 OFFSET -<br> 33.203402,-80.799942<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4APE287 = new L.marker(new L.LatLng(33.58100128,-79.98899841),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4APE287 W4APE  145.23 PL 123 OFFSET - 33.58100128,-79.98899841' ,
                    }).addTo(fg).bindPopup('W4APE287<br> W4APE <br> 145.23 PL 123 OFFSET -<br> 33.58100128,-79.98899841<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4WD288 = new L.marker(new L.LatLng(34.88100052,-83.09889984),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4WD288 K4WD  145.29 PL 162.2 OFFSET - 34.88100052,-83.09889984' ,
                    }).addTo(fg).bindPopup('K4WD288<br> K4WD <br> 145.29 PL 162.2 OFFSET -<br> 34.88100052,-83.09889984<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4CHR289 = new L.marker(new L.LatLng(34.68790054,-81.17980194),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4CHR289 W4CHR  145.31 PL 167.9 OFFSET - 34.68790054,-81.17980194' ,
                    }).addTo(fg).bindPopup('W4CHR289<br> W4CHR <br> 145.31 PL 167.9 OFFSET -<br> 34.68790054,-81.17980194<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4IAR290 = new L.marker(new L.LatLng(32.21630096,-80.75260162),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4IAR290 W4IAR  145.31 PL 100 OFFSET - 32.21630096,-80.75260162' ,
                    }).addTo(fg).bindPopup('W4IAR290<br> W4IAR <br> 145.31 PL 100 OFFSET -<br> 32.21630096,-80.75260162<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var NE4SC291 = new L.marker(new L.LatLng(33.75859833,-79.72820282),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'NE4SC291 NE4SC  145.31 PL 123 OFFSET - 33.75859833,-79.72820282' ,
                    }).addTo(fg).bindPopup('NE4SC291<br> NE4SC <br> 145.31 PL 123 OFFSET -<br> 33.75859833,-79.72820282<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WB4TGK292 = new L.marker(new L.LatLng(33.29710007,-81.03479767),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WB4TGK292 WB4TGK  145.33 PL 156.7 OFFSET - 33.29710007,-81.03479767' ,
                    }).addTo(fg).bindPopup('WB4TGK292<br> WB4TGK <br> 145.33 PL 156.7 OFFSET -<br> 33.29710007,-81.03479767<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var N2ZZ293 = new L.marker(new L.LatLng(33.57089996,-81.76309967),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'N2ZZ293 N2ZZ  145.35 PL 156.7 OFFSET - 33.57089996,-81.76309967' ,
                    }).addTo(fg).bindPopup('N2ZZ293<br> N2ZZ <br> 145.35 PL 156.7 OFFSET -<br> 33.57089996,-81.76309967<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC294 = new L.marker(new L.LatLng(34.94060135,-82.41059875),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC294 WR4SC  145.37 PL 123 OFFSET - 34.94060135,-82.41059875' ,
                    }).addTo(fg).bindPopup('WR4SC294<br> WR4SC <br> 145.37 PL 123 OFFSET -<br> 34.94060135,-82.41059875<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KG4BZN295 = new L.marker(new L.LatLng(32.90520096,-80.66680145),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KG4BZN295 KG4BZN  145.39 PL  OFFSET - 32.90520096,-80.66680145' ,
                    }).addTo(fg).bindPopup('KG4BZN295<br> KG4BZN <br> 145.39 PL  OFFSET -<br> 32.90520096,-80.66680145<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KJ4BWK296 = new L.marker(new L.LatLng(34.0007019,-81.03479767),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KJ4BWK296 KJ4BWK  145.4 PL  OFFSET - 34.0007019,-81.03479767' ,
                    }).addTo(fg).bindPopup('KJ4BWK296<br> KJ4BWK <br> 145.4 PL  OFFSET -<br> 34.0007019,-81.03479767<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA4USN297 = new L.marker(new L.LatLng(32.58060074,-80.15969849),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA4USN297 WA4USN  145.41 PL 123 OFFSET - 32.58060074,-80.15969849' ,
                    }).addTo(fg).bindPopup('WA4USN297<br> WA4USN <br> 145.41 PL 123 OFFSET -<br> 32.58060074,-80.15969849<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KE4MDP298 = new L.marker(new L.LatLng(35.0461998,-81.58930206),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KE4MDP298 KE4MDP  145.43 PL 162.2 OFFSET - 35.0461998,-81.58930206' ,
                    }).addTo(fg).bindPopup('KE4MDP298<br> KE4MDP <br> 145.43 PL 162.2 OFFSET -<br> 35.0461998,-81.58930206<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GL299 = new L.marker(new L.LatLng(33.96319962,-80.40219879),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GL299 W4GL  145.43 PL 156.7 OFFSET - 33.96319962,-80.40219879' ,
                    }).addTo(fg).bindPopup('W4GL299<br> W4GL <br> 145.43 PL 156.7 OFFSET -<br> 33.96319962,-80.40219879<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA0QFJ44 = new L.marker(new L.LatLng(39.273172,-94.663137),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA0QFJ44 PCARG Repeater (147.330MHz T:151.4/444.550MHz )  PCARG club repeater 39.273172,-94.663137' ,
                    }).addTo(fg).bindPopup('WA0QFJ44<br> PCARG Repeater (147.330MHz T:151.4/444.550MHz ) <br> PCARG club repeater<br> 39.273172,-94.663137<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4HRS300 = new L.marker(new L.LatLng(32.78419876,-79.94499969),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4HRS300 W4HRS  145.45 PL 123 OFFSET - 32.78419876,-79.94499969' ,
                    }).addTo(fg).bindPopup('W4HRS300<br> W4HRS <br> 145.45 PL 123 OFFSET -<br> 32.78419876,-79.94499969<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA0KHP45 = new L.marker(new L.LatLng(39.36392,-94.584721),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA0KHP45 Clay Co Repeater Club / KC Northland ARES Repeater (146.79Mhz T:107.2 )  Clay Co. Repeater Club 39.36392,-94.584721' ,
                    }).addTo(fg).bindPopup('WA0KHP45<br> Clay Co Repeater Club / KC Northland ARES Repeater (146.79Mhz T:107.2 ) <br> Clay Co. Repeater Club<br> 39.36392,-94.584721<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4ZKM301 = new L.marker(new L.LatLng(33.26150131,-81.65670013),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4ZKM301 W4ZKM  145.45 PL 123 OFFSET - 33.26150131,-81.65670013' ,
                    }).addTo(fg).bindPopup('W4ZKM301<br> W4ZKM <br> 145.45 PL 123 OFFSET -<br> 33.26150131,-81.65670013<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K9OH302 = new L.marker(new L.LatLng(35.10570145,-82.62760162),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K9OH302 K9OH  145.47 PL 91.5 OFFSET - 35.10570145,-82.62760162' ,
                    }).addTo(fg).bindPopup('K9OH302<br> K9OH <br> 145.47 PL 91.5 OFFSET -<br> 35.10570145,-82.62760162<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4APE303 = new L.marker(new L.LatLng(34.19979858,-79.23249817),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4APE303 W4APE  145.47 PL 123 OFFSET - 34.19979858,-79.23249817' ,
                    }).addTo(fg).bindPopup('W4APE303<br> W4APE <br> 145.47 PL 123 OFFSET -<br> 34.19979858,-79.23249817<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4APE304 = new L.marker(new L.LatLng(34.74810028,-79.84259796),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4APE304 W4APE  145.49 PL 123 OFFSET - 34.74810028,-79.84259796' ,
                    }).addTo(fg).bindPopup('W4APE304<br> W4APE <br> 145.49 PL 123 OFFSET -<br> 34.74810028,-79.84259796<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4HRS305 = new L.marker(new L.LatLng(33.19889832,-80.00689697),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4HRS305 W4HRS  145.49 PL 103.5 OFFSET - 33.19889832,-80.00689697' ,
                    }).addTo(fg).bindPopup('W4HRS305<br> W4HRS <br> 145.49 PL 103.5 OFFSET -<br> 33.19889832,-80.00689697<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4DV306 = new L.marker(new L.LatLng(33.68489838,-81.92639923),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4DV306 W4DV  145.49 PL 71.9 OFFSET - 33.68489838,-81.92639923' ,
                    }).addTo(fg).bindPopup('W4DV306<br> W4DV <br> 145.49 PL 71.9 OFFSET -<br> 33.68489838,-81.92639923<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KK4ONF307 = new L.marker(new L.LatLng(32.4276903,-81.0087199),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KK4ONF307 KK4ONF  146.06 PL 123 OFFSET + 32.4276903,-81.0087199' ,
                    }).addTo(fg).bindPopup('KK4ONF307<br> KK4ONF <br> 146.06 PL 123 OFFSET +<br> 32.4276903,-81.0087199<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4KNJ308 = new L.marker(new L.LatLng(34.28580093,-79.24590302),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4KNJ308 K4KNJ  146.535 PL CSQ OFFSET x 34.28580093,-79.24590302' ,
                    }).addTo(fg).bindPopup('K4KNJ308<br> K4KNJ <br> 146.535 PL CSQ OFFSET x<br> 34.28580093,-79.24590302<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KW4BET309 = new L.marker(new L.LatLng(33.8420316,-78.6400437),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KW4BET309 KW4BET  146.58 PL D023 OFFSET x 33.8420316,-78.6400437' ,
                    }).addTo(fg).bindPopup('KW4BET309<br> KW4BET <br> 146.58 PL D023 OFFSET x<br> 33.8420316,-78.6400437<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4NYK310 = new L.marker(new L.LatLng(35.05569839,-82.7845993),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4NYK310 W4NYK  146.61 PL  OFFSET - 35.05569839,-82.7845993' ,
                    }).addTo(fg).bindPopup('W4NYK310<br> W4NYK <br> 146.61 PL  OFFSET -<br> 35.05569839,-82.7845993<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4BRK311 = new L.marker(new L.LatLng(33.19599915,-80.01309967),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4BRK311 W4BRK  146.61 PL 123 OFFSET - 33.19599915,-80.01309967' ,
                    }).addTo(fg).bindPopup('W4BRK311<br> W4BRK <br> 146.61 PL 123 OFFSET -<br> 33.19599915,-80.01309967<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GL312 = new L.marker(new L.LatLng(33.92039871,-80.34149933),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GL312 W4GL  146.64 PL 156.7 OFFSET - 33.92039871,-80.34149933' ,
                    }).addTo(fg).bindPopup('W4GL312<br> W4GL <br> 146.64 PL 156.7 OFFSET -<br> 33.92039871,-80.34149933<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4BFT313 = new L.marker(new L.LatLng(32.41880035,-80.68859863),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4BFT313 W4BFT  146.655 PL  OFFSET - 32.41880035,-80.68859863' ,
                    }).addTo(fg).bindPopup('W4BFT313<br> W4BFT <br> 146.655 PL  OFFSET -<br> 32.41880035,-80.68859863<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var AD4U314 = new L.marker(new L.LatLng(33.66490173,-80.7779007),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'AD4U314 AD4U  146.67 PL 156.7 OFFSET - 33.66490173,-80.7779007' ,
                    }).addTo(fg).bindPopup('AD4U314<br> AD4U <br> 146.67 PL 156.7 OFFSET -<br> 33.66490173,-80.7779007<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WB4YXZ570 = new L.marker(new L.LatLng(34.90100098,-82.65930176),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WB4YXZ570 WB4YXZ  147 PL 151.4 OFFSET 34.90100098,-82.65930176' ,
                    }).addTo(fg).bindPopup('WB4YXZ570<br> WB4YXZ <br> 147 PL 151.4 OFFSET<br> 34.90100098,-82.65930176<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC315 = new L.marker(new L.LatLng(34.28020096,-79.74279785),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC315 WR4SC  146.685 PL 91.5 OFFSET - 34.28020096,-79.74279785' ,
                    }).addTo(fg).bindPopup('WR4SC315<br> WR4SC <br> 146.685 PL 91.5 OFFSET -<br> 34.28020096,-79.74279785<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KK4ZBE316 = new L.marker(new L.LatLng(32.83229828,-79.82839966),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KK4ZBE316 KK4ZBE  146.685 PL 162.2 OFFSET - 32.83229828,-79.82839966' ,
                    }).addTo(fg).bindPopup('KK4ZBE316<br> KK4ZBE <br> 146.685 PL 162.2 OFFSET -<br> 32.83229828,-79.82839966<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4USC317 = new L.marker(new L.LatLng(34.72969818,-81.63749695),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4USC317 K4USC  146.685 PL  OFFSET - 34.72969818,-81.63749695' ,
                    }).addTo(fg).bindPopup('K4USC317<br> K4USC <br> 146.685 PL  OFFSET -<br> 34.72969818,-81.63749695<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4HRS318 = new L.marker(new L.LatLng(33.37939835,-79.28469849),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4HRS318 W4HRS  146.7 PL 123 OFFSET - 33.37939835,-79.28469849' ,
                    }).addTo(fg).bindPopup('W4HRS318<br> W4HRS <br> 146.7 PL 123 OFFSET -<br> 33.37939835,-79.28469849<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4PAX319 = new L.marker(new L.LatLng(34.72040176,-80.77089691),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4PAX319 W4PAX  146.7 PL 123 OFFSET - 34.72040176,-80.77089691' ,
                    }).addTo(fg).bindPopup('W4PAX319<br> W4PAX <br> 146.7 PL 123 OFFSET -<br> 34.72040176,-80.77089691<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WT4F320 = new L.marker(new L.LatLng(34.88339996,-82.70739746),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WT4F320 WT4F  146.7 PL 107.2 OFFSET - 34.88339996,-82.70739746' ,
                    }).addTo(fg).bindPopup('WT4F320<br> WT4F <br> 146.7 PL 107.2 OFFSET -<br> 34.88339996,-82.70739746<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC321 = new L.marker(new L.LatLng(33.9496994,-79.1085968),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC321 WR4SC  146.715 PL 162.2 OFFSET - 33.9496994,-79.1085968' ,
                    }).addTo(fg).bindPopup('WR4SC321<br> WR4SC <br> 146.715 PL 162.2 OFFSET -<br> 33.9496994,-79.1085968<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC322 = new L.marker(new L.LatLng(34.11859894,-80.93689728),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC322 WR4SC  146.715 PL 91.5 OFFSET - 34.11859894,-80.93689728' ,
                    }).addTo(fg).bindPopup('WR4SC322<br> WR4SC <br> 146.715 PL 91.5 OFFSET -<br> 34.11859894,-80.93689728<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC323 = new L.marker(new L.LatLng(32.90520096,-80.66680145),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC323 WR4SC  146.715 PL 123 OFFSET - 32.90520096,-80.66680145' ,
                    }).addTo(fg).bindPopup('WR4SC323<br> WR4SC <br> 146.715 PL 123 OFFSET -<br> 32.90520096,-80.66680145<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4NAB324 = new L.marker(new L.LatLng(33.50180054,-81.96510315),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4NAB324 K4NAB  146.73 PL  OFFSET - 33.50180054,-81.96510315' ,
                    }).addTo(fg).bindPopup('K4NAB324<br> K4NAB <br> 146.73 PL  OFFSET -<br> 33.50180054,-81.96510315<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4HRS325 = new L.marker(new L.LatLng(32.97570038,-80.07230377),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4HRS325 W4HRS  146.73 PL 123 OFFSET - 32.97570038,-80.07230377' ,
                    }).addTo(fg).bindPopup('W4HRS325<br> W4HRS <br> 146.73 PL 123 OFFSET -<br> 32.97570038,-80.07230377<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA4UKX326 = new L.marker(new L.LatLng(34.73709869,-82.25430298),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA4UKX326 WA4UKX  146.73 PL 100 OFFSET - 34.73709869,-82.25430298' ,
                    }).addTo(fg).bindPopup('WA4UKX326<br> WA4UKX <br> 146.73 PL 100 OFFSET -<br> 34.73709869,-82.25430298<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4PDE327 = new L.marker(new L.LatLng(34.3689003,-79.32839966),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4PDE327 W4PDE  146.745 PL 82.5 OFFSET - 34.3689003,-79.32839966' ,
                    }).addTo(fg).bindPopup('W4PDE327<br> W4PDE <br> 146.745 PL 82.5 OFFSET -<br> 34.3689003,-79.32839966<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4FTK328 = new L.marker(new L.LatLng(34.188721,-81.404594),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4FTK328 W4FTK  146.745 PL D315 OFFSET - 34.188721,-81.404594' ,
                    }).addTo(fg).bindPopup('W4FTK328<br> W4FTK <br> 146.745 PL D315 OFFSET -<br> 34.188721,-81.404594<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC329 = new L.marker(new L.LatLng(32.92440033,-79.69940186),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC329 WR4SC  146.76 PL 123 OFFSET - 32.92440033,-79.69940186' ,
                    }).addTo(fg).bindPopup('WR4SC329<br> WR4SC <br> 146.76 PL 123 OFFSET -<br> 32.92440033,-79.69940186<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4FTK330 = new L.marker(new L.LatLng(34.715431,-81.019479),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4FTK330 W4FTK  146.76 PL D315 OFFSET - 34.715431,-81.019479' ,
                    }).addTo(fg).bindPopup('W4FTK330<br> W4FTK <br> 146.76 PL D315 OFFSET -<br> 34.715431,-81.019479<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KCRHCV75 = new L.marker(new L.LatLng(38.8648222,-94.7789944),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KCRHCV75 Kansas City Room Host #28952  Hosts the Kansas City Room #28952 38.8648222,-94.7789944' ,
                    }).addTo(fg).bindPopup('KCRHCV75<br> Kansas City Room Host #28952 <br> Hosts the Kansas City Room #28952<br> 38.8648222,-94.7789944<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4CAE331 = new L.marker(new L.LatLng(34.05509949,-80.8321991),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4CAE331 W4CAE  146.775 PL 156.7 OFFSET - 34.05509949,-80.8321991' ,
                    }).addTo(fg).bindPopup('W4CAE331<br> W4CAE <br> 146.775 PL 156.7 OFFSET -<br> 34.05509949,-80.8321991<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KCRKW176 = new L.marker(new L.LatLng(38.9879167,-94.67075),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KCRKW176 Kansas City Room, K0HAM  Jerry Dixon KCØKW 38.9879167,-94.67075' ,
                    }).addTo(fg).bindPopup('KCRKW176<br> Kansas City Room, K0HAM <br> Jerry Dixon KCØKW<br> 38.9879167,-94.67075<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA4USN332 = new L.marker(new L.LatLng(32.79059982,-79.90809631),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA4USN332 WA4USN  146.79 PL 123 OFFSET - 32.79059982,-79.90809631' ,
                    }).addTo(fg).bindPopup('WA4USN332<br> WA4USN <br> 146.79 PL 123 OFFSET -<br> 32.79059982,-79.90809631<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KCRJCRAC177 = new L.marker(new L.LatLng(39.0106639,-94.7212972),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KCRJCRAC177 Kansas City Room, W0ERH  JCRAC club repeater 39.0106639,-94.7212972' ,
                    }).addTo(fg).bindPopup('KCRJCRAC177<br> Kansas City Room, W0ERH <br> JCRAC club repeater<br> 39.0106639,-94.7212972<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var N4AW333 = new L.marker(new L.LatLng(35.06480026,-82.77739716),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'N4AW333 N4AW  146.79 PL  OFFSET - 35.06480026,-82.77739716' ,
                    }).addTo(fg).bindPopup('N4AW333<br> N4AW <br> 146.79 PL  OFFSET -<br> 35.06480026,-82.77739716<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KCRJCRAC278 = new L.marker(new L.LatLng(38.9252611,-94.6553389),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KCRJCRAC278 Kansas City Room, W0ERH  JCRAC club repeater 38.9252611,-94.6553389' ,
                    }).addTo(fg).bindPopup('KCRJCRAC278<br> Kansas City Room, W0ERH <br> JCRAC club repeater<br> 38.9252611,-94.6553389<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GS334 = new L.marker(new L.LatLng(33.55099869,-79.04139709),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GS334 W4GS  146.805 PL 85.4 OFFSET - 33.55099869,-79.04139709' ,
                    }).addTo(fg).bindPopup('W4GS334<br> W4GS <br> 146.805 PL 85.4 OFFSET -<br> 33.55099869,-79.04139709<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KCRKW279 = new L.marker(new L.LatLng(38.5861611,-94.6204139),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KCRKW279 Kansas City Room, K0HAM  Jerry Dixon KCØKW 38.5861611,-94.6204139' ,
                    }).addTo(fg).bindPopup('KCRKW279<br> Kansas City Room, K0HAM <br> Jerry Dixon KCØKW<br> 38.5861611,-94.6204139<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KJ4QLH335 = new L.marker(new L.LatLng(33.53,-80.82),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KJ4QLH335 KJ4QLH  146.805 PL 156.7 OFFSET - 33.53,-80.82' ,
                    }).addTo(fg).bindPopup('KJ4QLH335<br> KJ4QLH <br> 146.805 PL 156.7 OFFSET -<br> 33.53,-80.82<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KCRWW80 = new L.marker(new L.LatLng(39.0465806,-94.5874444),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KCRWW80 N0WW  Keith Little NØWW 39.0465806,-94.5874444' ,
                    }).addTo(fg).bindPopup('KCRWW80<br> N0WW <br> Keith Little NØWW<br> 39.0465806,-94.5874444<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4NYK336 = new L.marker(new L.LatLng(34.94120026,-82.41069794),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4NYK336 W4NYK  146.82 PL  OFFSET - 34.94120026,-82.41069794' ,
                    }).addTo(fg).bindPopup('W4NYK336<br> W4NYK <br> 146.82 PL  OFFSET -<br> 34.94120026,-82.41069794<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KCRROO81 = new L.marker(new L.LatLng(39.2819722,-94.9058889),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KCRROO81 Kansas City Room, W0ROO  Leavenworth club repeater 39.2819722,-94.9058889' ,
                    }).addTo(fg).bindPopup('KCRROO81<br> Kansas City Room, W0ROO <br> Leavenworth club repeater<br> 39.2819722,-94.9058889<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KI4RAX337 = new L.marker(new L.LatLng(34.20999908,-80.69000244),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KI4RAX337 KI4RAX  146.82 PL 91.5 OFFSET - 34.20999908,-80.69000244' ,
                    }).addTo(fg).bindPopup('KI4RAX337<br> KI4RAX <br> 146.82 PL 91.5 OFFSET -<br> 34.20999908,-80.69000244<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KCRHAM282 = new L.marker(new L.LatLng(38.9084722,-94.4548056),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KCRHAM282 Kansas City Room, K0HAM  Jerry Dixon KCØKW 38.9084722,-94.4548056' ,
                    }).addTo(fg).bindPopup('KCRHAM282<br> Kansas City Room, K0HAM <br> Jerry Dixon KCØKW<br> 38.9084722,-94.4548056<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KA4GDW338 = new L.marker(new L.LatLng(33.35114,-80.68542),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KA4GDW338 KA4GDW  146.835 PL 179.9 OFFSET - 33.35114,-80.68542' ,
                    }).addTo(fg).bindPopup('KA4GDW338<br> KA4GDW <br> 146.835 PL 179.9 OFFSET -<br> 33.35114,-80.68542<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KCRHAM383 = new L.marker(new L.LatLng(39.0922333,-94.9453528),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KCRHAM383 Kansas City Room, K0HAM  Jerry Dixon KCØKW 39.0922333,-94.9453528' ,
                    }).addTo(fg).bindPopup('KCRHAM383<br> Kansas City Room, K0HAM <br> Jerry Dixon KCØKW<br> 39.0922333,-94.9453528<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4ILT339 = new L.marker(new L.LatLng(33.18619919,-80.57939911),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4ILT339 K4ILT  146.835 PL 103.5 OFFSET - 33.18619919,-80.57939911' ,
                    }).addTo(fg).bindPopup('K4ILT339<br> K4ILT <br> 146.835 PL 103.5 OFFSET -<br> 33.18619919,-80.57939911<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KCRQFJ84 = new L.marker(new L.LatLng(39.2731222,-94.6629583),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KCRQFJ84 Kansas City Room, WA0QFJ  PCARG Club Repeater 39.2731222,-94.6629583' ,
                    }).addTo(fg).bindPopup('KCRQFJ84<br> Kansas City Room, WA0QFJ <br> PCARG Club Repeater<br> 39.2731222,-94.6629583<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4EC340 = new L.marker(new L.LatLng(33.7942009,-81.89029694),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4EC340 WR4EC  146.85 PL 91.5 OFFSET - 33.7942009,-81.89029694' ,
                    }).addTo(fg).bindPopup('WR4EC340<br> WR4EC <br> 146.85 PL 91.5 OFFSET -<br> 33.7942009,-81.89029694<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KCRMED85 = new L.marker(new L.LatLng(39.0562778,-94.6095),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KCRMED85 Kansas City Room, Ku0MED  Jerry Dixon KCØKW 39.0562778,-94.6095' ,
                    }).addTo(fg).bindPopup('KCRMED85<br> Kansas City Room, Ku0MED <br> Jerry Dixon KCØKW<br> 39.0562778,-94.6095<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4ULH341 = new L.marker(new L.LatLng(34.28020096,-79.74279785),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4ULH341 W4ULH  146.85 PL 123 OFFSET - 34.28020096,-79.74279785' ,
                    }).addTo(fg).bindPopup('W4ULH341<br> W4ULH <br> 146.85 PL 123 OFFSET -<br> 34.28020096,-79.74279785<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KCRHAM486 = new L.marker(new L.LatLng(39.2611111,-95.6558333),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KCRHAM486 Kansas City Room, K0HAM  Jerry Dixon KCØKW 39.2611111,-95.6558333' ,
                    }).addTo(fg).bindPopup('KCRHAM486<br> Kansas City Room, K0HAM <br> Jerry Dixon KCØKW<br> 39.2611111,-95.6558333<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var N2OBS342 = new L.marker(new L.LatLng(32.9856987,-80.10980225),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'N2OBS342 N2OBS  146.865 PL 123 OFFSET - 32.9856987,-80.10980225' ,
                    }).addTo(fg).bindPopup('N2OBS342<br> N2OBS <br> 146.865 PL 123 OFFSET -<br> 32.9856987,-80.10980225<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KCRCNC87 = new L.marker(new L.LatLng(38.1788722,-93.3541889),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KCRCNC87 Kansas City Room, KD0CNC  KD0CNC 38.1788722,-93.3541889' ,
                    }).addTo(fg).bindPopup('KCRCNC87<br> Kansas City Room, KD0CNC <br> KD0CNC<br> 38.1788722,-93.3541889<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KD4HLH343 = new L.marker(new L.LatLng(34.57160187,-82.11209869),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KD4HLH343 KD4HLH  146.865 PL 107.2 OFFSET - 34.57160187,-82.11209869' ,
                    }).addTo(fg).bindPopup('KD4HLH343<br> KD4HLH <br> 146.865 PL 107.2 OFFSET -<br> 34.57160187,-82.11209869<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4NYR344 = new L.marker(new L.LatLng(35.12120056,-81.51589966),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4NYR344 W4NYR  146.88 PL  OFFSET - 35.12120056,-81.51589966' ,
                    }).addTo(fg).bindPopup('W4NYR344<br> W4NYR <br> 146.88 PL  OFFSET -<br> 35.12120056,-81.51589966<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC345 = new L.marker(new L.LatLng(33.54309845,-80.82420349),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC345 WR4SC  146.88 PL 123 OFFSET - 33.54309845,-80.82420349' ,
                    }).addTo(fg).bindPopup('WR4SC345<br> WR4SC <br> 146.88 PL 123 OFFSET -<br> 33.54309845,-80.82420349<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4APE346 = new L.marker(new L.LatLng(34.74850082,-80.41680145),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4APE346 W4APE  146.895 PL 123 OFFSET - 34.74850082,-80.41680145' ,
                    }).addTo(fg).bindPopup('W4APE346<br> W4APE <br> 146.895 PL 123 OFFSET -<br> 34.74850082,-80.41680145<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4DEW347 = new L.marker(new L.LatLng(34.00149918,-81.77200317),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4DEW347 W4DEW  146.91 PL 123 OFFSET - 34.00149918,-81.77200317' ,
                    }).addTo(fg).bindPopup('W4DEW347<br> W4DEW <br> 146.91 PL 123 OFFSET -<br> 34.00149918,-81.77200317<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA4SJS348 = new L.marker(new L.LatLng(32.7118988,-80.68170166),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA4SJS348 WA4SJS  146.91 PL 156.7 OFFSET - 32.7118988,-80.68170166' ,
                    }).addTo(fg).bindPopup('WA4SJS348<br> WA4SJS <br> 146.91 PL 156.7 OFFSET -<br> 32.7118988,-80.68170166<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4APE349 = new L.marker(new L.LatLng(34.29270172,-80.33760071),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4APE349 W4APE  146.925 PL 123 OFFSET - 34.29270172,-80.33760071' ,
                    }).addTo(fg).bindPopup('W4APE349<br> W4APE <br> 146.925 PL 123 OFFSET -<br> 34.29270172,-80.33760071<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4IQQ350 = new L.marker(new L.LatLng(34.8526001,-82.39399719),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4IQQ350 W4IQQ  146.94 PL 107.2 OFFSET - 34.8526001,-82.39399719' ,
                    }).addTo(fg).bindPopup('W4IQQ350<br> W4IQQ <br> 146.94 PL 107.2 OFFSET -<br> 34.8526001,-82.39399719<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA4USN351 = new L.marker(new L.LatLng(32.9939003,-80.26999664),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA4USN351 WA4USN  146.94 PL 123 OFFSET - 32.9939003,-80.26999664' ,
                    }).addTo(fg).bindPopup('WA4USN351<br> WA4USN <br> 146.94 PL 123 OFFSET -<br> 32.9939003,-80.26999664<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var N4AW352 = new L.marker(new L.LatLng(34.51079941,-82.64679718),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'N4AW352 N4AW  146.97 PL 127.3 OFFSET - 34.51079941,-82.64679718' ,
                    }).addTo(fg).bindPopup('N4AW352<br> N4AW <br> 146.97 PL 127.3 OFFSET -<br> 34.51079941,-82.64679718<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KB4RRC353 = new L.marker(new L.LatLng(34.19910049,-79.76779938),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KB4RRC353 KB4RRC  146.97 PL 167.9 OFFSET - 34.19910049,-79.76779938' ,
                    }).addTo(fg).bindPopup('KB4RRC353<br> KB4RRC <br> 146.97 PL 167.9 OFFSET -<br> 34.19910049,-79.76779938<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W1GRE354 = new L.marker(new L.LatLng(32.96580124,-80.15750122),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W1GRE354 W1GRE  146.985 PL 123 OFFSET - 32.96580124,-80.15750122' ,
                    }).addTo(fg).bindPopup('W1GRE354<br> W1GRE <br> 146.985 PL 123 OFFSET -<br> 32.96580124,-80.15750122<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KO4L355 = new L.marker(new L.LatLng(34.06060028,-79.3125),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KO4L355 KO4L  147 PL 91.5 OFFSET - 34.06060028,-79.3125' ,
                    }).addTo(fg).bindPopup('KO4L355<br> KO4L <br> 147 PL 91.5 OFFSET -<br> 34.06060028,-79.3125<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GL357 = new L.marker(new L.LatLng(33.8810997,-80.27059937),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GL357 W4GL  147.015 PL 156.7 OFFSET + 33.8810997,-80.27059937' ,
                    }).addTo(fg).bindPopup('W4GL357<br> W4GL <br> 147.015 PL 156.7 OFFSET +<br> 33.8810997,-80.27059937<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KK4BQ358 = new L.marker(new L.LatLng(33.18780136,-81.39689636),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KK4BQ358 KK4BQ  147.03 PL 156.7 OFFSET + 33.18780136,-81.39689636' ,
                    }).addTo(fg).bindPopup('KK4BQ358<br> KK4BQ <br> 147.03 PL 156.7 OFFSET +<br> 33.18780136,-81.39689636<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KJ4YLP359 = new L.marker(new L.LatLng(34.88249969,-83.09750366),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KJ4YLP359 KJ4YLP  147.03 PL 123 OFFSET - 34.88249969,-83.09750366' ,
                    }).addTo(fg).bindPopup('KJ4YLP359<br> KJ4YLP <br> 147.03 PL 123 OFFSET -<br> 34.88249969,-83.09750366<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4YTZ360 = new L.marker(new L.LatLng(34.83969879,-81.01860046),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4YTZ360 K4YTZ  147.03 PL 88.5 OFFSET - 34.83969879,-81.01860046' ,
                    }).addTo(fg).bindPopup('K4YTZ360<br> K4YTZ <br> 147.03 PL 88.5 OFFSET -<br> 34.83969879,-81.01860046<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4ILT361 = new L.marker(new L.LatLng(33.17359924,-80.57389832),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4ILT361 K4ILT  147.045 PL 103.5 OFFSET + 33.17359924,-80.57389832' ,
                    }).addTo(fg).bindPopup('K4ILT361<br> K4ILT <br> 147.045 PL 103.5 OFFSET +<br> 33.17359924,-80.57389832<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KK4ONF362 = new L.marker(new L.LatLng(32.28710175,-81.08070374),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KK4ONF362 KK4ONF  147.06 PL 123 OFFSET + 32.28710175,-81.08070374' ,
                    }).addTo(fg).bindPopup('KK4ONF362<br> KK4ONF <br> 147.06 PL 123 OFFSET +<br> 32.28710175,-81.08070374<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4FTK363 = new L.marker(new L.LatLng(33.854465,-80.529466),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4FTK363 W4FTK  147.06 PL D315 OFFSET + 33.854465,-80.529466' ,
                    }).addTo(fg).bindPopup('W4FTK363<br> W4FTK <br> 147.06 PL D315 OFFSET +<br> 33.854465,-80.529466<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KJ4QLH364 = new L.marker(new L.LatLng(33.52,-81.08),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KJ4QLH364 KJ4QLH  147.09 PL 156.7 OFFSET + 33.52,-81.08' ,
                    }).addTo(fg).bindPopup('KJ4QLH364<br> KJ4QLH <br> 147.09 PL 156.7 OFFSET +<br> 33.52,-81.08<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC365 = new L.marker(new L.LatLng(34.88639832,-81.82080078),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC365 WR4SC  147.09 PL 162.2 OFFSET + 34.88639832,-81.82080078' ,
                    }).addTo(fg).bindPopup('WR4SC365<br> WR4SC <br> 147.09 PL 162.2 OFFSET +<br> 34.88639832,-81.82080078<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC366 = new L.marker(new L.LatLng(32.80220032,-80.02359772),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC366 WR4SC  147.105 PL 123 OFFSET + 32.80220032,-80.02359772' ,
                    }).addTo(fg).bindPopup('WR4SC366<br> WR4SC <br> 147.105 PL 123 OFFSET +<br> 32.80220032,-80.02359772<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GS367 = new L.marker(new L.LatLng(33.68909836,-78.88670349),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GS367 W4GS  147.12 PL 85.4 OFFSET + 33.68909836,-78.88670349' ,
                    }).addTo(fg).bindPopup('W4GS367<br> W4GS <br> 147.12 PL 85.4 OFFSET +<br> 33.68909836,-78.88670349<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4CCC368 = new L.marker(new L.LatLng(34.74860001,-79.84140015),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4CCC368 K4CCC  147.135 PL 123 OFFSET + 34.74860001,-79.84140015' ,
                    }).addTo(fg).bindPopup('K4CCC368<br> K4CCC <br> 147.135 PL 123 OFFSET +<br> 34.74860001,-79.84140015<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KG4BZN369 = new L.marker(new L.LatLng(32.90520096,-80.66680145),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KG4BZN369 KG4BZN  147.135 PL  OFFSET + 32.90520096,-80.66680145' ,
                    }).addTo(fg).bindPopup('KG4BZN369<br> KG4BZN <br> 147.135 PL  OFFSET +<br> 32.90520096,-80.66680145<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GWD370 = new L.marker(new L.LatLng(34.37239838,-82.1678009),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GWD370 W4GWD  147.165 PL 107.2 OFFSET + 34.37239838,-82.1678009' ,
                    }).addTo(fg).bindPopup('W4GWD370<br> W4GWD <br> 147.165 PL 107.2 OFFSET +<br> 34.37239838,-82.1678009<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4HNK371 = new L.marker(new L.LatLng(33.14189911,-80.35079956),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4HNK371 W4HNK  147.18 PL 123 OFFSET + 33.14189911,-80.35079956' ,
                    }).addTo(fg).bindPopup('W4HNK371<br> W4HNK <br> 147.18 PL 123 OFFSET +<br> 33.14189911,-80.35079956<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4APE372 = new L.marker(new L.LatLng(34.24779892,-79.81109619),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4APE372 W4APE  147.195 PL 123 OFFSET + 34.24779892,-79.81109619' ,
                    }).addTo(fg).bindPopup('W4APE372<br> W4APE <br> 147.195 PL 123 OFFSET +<br> 34.24779892,-79.81109619<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WX4PG373 = new L.marker(new L.LatLng(34.9009497,-82.6592992),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WX4PG373 WX4PG  147.195 PL 141.3 OFFSET + 34.9009497,-82.6592992' ,
                    }).addTo(fg).bindPopup('WX4PG373<br> WX4PG <br> 147.195 PL 141.3 OFFSET +<br> 34.9009497,-82.6592992<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4FTK374 = new L.marker(new L.LatLng(33.969955,-79.03414),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4FTK374 W4FTK  147.21 PL D315 OFFSET + 33.969955,-79.03414' ,
                    }).addTo(fg).bindPopup('W4FTK374<br> W4FTK <br> 147.21 PL D315 OFFSET +<br> 33.969955,-79.03414<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC375 = new L.marker(new L.LatLng(34.19630051,-81.41230011),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC375 WR4SC  147.21 PL 156.7 OFFSET + 34.19630051,-81.41230011' ,
                    }).addTo(fg).bindPopup('WR4SC375<br> WR4SC <br> 147.21 PL 156.7 OFFSET +<br> 34.19630051,-81.41230011<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA4NMW376 = new L.marker(new L.LatLng(33.01300049,-80.25800323),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA4NMW376 WA4NMW  147.225 PL 123 OFFSET + 33.01300049,-80.25800323' ,
                    }).addTo(fg).bindPopup('WA4NMW376<br> WA4NMW <br> 147.225 PL 123 OFFSET +<br> 33.01300049,-80.25800323<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4FTK377 = new L.marker(new L.LatLng(34.92490005,-81.02510071),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4FTK377 W4FTK   147.225 PL 110.9 OFFSET + 34.92490005,-81.02510071' ,
                    }).addTo(fg).bindPopup('W4FTK377<br> W4FTK  <br> 147.225 PL 110.9 OFFSET +<br> 34.92490005,-81.02510071<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4IAR378 = new L.marker(new L.LatLng(32.21630096,-80.75260162),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4IAR378 W4IAR  147.24 PL 100 OFFSET + 32.21630096,-80.75260162' ,
                    }).addTo(fg).bindPopup('W4IAR378<br> W4IAR <br> 147.24 PL 100 OFFSET +<br> 32.21630096,-80.75260162<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4GS379 = new L.marker(new L.LatLng(33.70660019,-78.87419891),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4GS379 W4GS  147.24 PL 85.4 OFFSET + 33.70660019,-78.87419891' ,
                    }).addTo(fg).bindPopup('W4GS379<br> W4GS <br> 147.24 PL 85.4 OFFSET +<br> 33.70660019,-78.87419891<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KB4RRC380 = new L.marker(new L.LatLng(34.24750137,-79.81719971),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KB4RRC380 KB4RRC  147.255 PL 162.2 OFFSET + 34.24750137,-79.81719971' ,
                    }).addTo(fg).bindPopup('KB4RRC380<br> KB4RRC <br> 147.255 PL 162.2 OFFSET +<br> 34.24750137,-79.81719971<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4RRC381 = new L.marker(new L.LatLng(33.91289902,-81.52559662),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4RRC381 W4RRC  147.255 PL 123 OFFSET + 33.91289902,-81.52559662' ,
                    }).addTo(fg).bindPopup('W4RRC381<br> W4RRC <br> 147.255 PL 123 OFFSET +<br> 33.91289902,-81.52559662<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4ANK382 = new L.marker(new L.LatLng(33.14369965,-80.35639954),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4ANK382 W4ANK  147.27 PL 123 OFFSET + 33.14369965,-80.35639954' ,
                    }).addTo(fg).bindPopup('W4ANK382<br> W4ANK <br> 147.27 PL 123 OFFSET +<br> 33.14369965,-80.35639954<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WA4JRJ383 = new L.marker(new L.LatLng(34.68569946,-82.95320129),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WA4JRJ383 WA4JRJ  147.27 PL 91.5 OFFSET + 34.68569946,-82.95320129' ,
                    }).addTo(fg).bindPopup('WA4JRJ383<br> WA4JRJ <br> 147.27 PL 91.5 OFFSET +<br> 34.68569946,-82.95320129<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var N4HRS384 = new L.marker(new L.LatLng(34.99430084,-81.24199677),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'N4HRS384 N4HRS  147.27 PL 110.9 OFFSET + 34.99430084,-81.24199677' ,
                    }).addTo(fg).bindPopup('N4HRS384<br> N4HRS <br> 147.27 PL 110.9 OFFSET +<br> 34.99430084,-81.24199677<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var N4ADM385 = new L.marker(new L.LatLng(33.5603981,-81.71959686),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'N4ADM385 N4ADM  147.285 PL 100 OFFSET + 33.5603981,-81.71959686' ,
                    }).addTo(fg).bindPopup('N4ADM385<br> N4ADM <br> 147.285 PL 100 OFFSET +<br> 33.5603981,-81.71959686<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K2PJ386 = new L.marker(new L.LatLng(34.08570099,-79.07150269),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K2PJ386 K2PJ  147.285 PL 85.4 OFFSET + 34.08570099,-79.07150269' ,
                    }).addTo(fg).bindPopup('K2PJ386<br> K2PJ <br> 147.285 PL 85.4 OFFSET +<br> 34.08570099,-79.07150269<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KK4B387 = new L.marker(new L.LatLng(33.39550018,-79.95809937),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KK4B387 KK4B  147.3 PL 162.2 OFFSET + 33.39550018,-79.95809937' ,
                    }).addTo(fg).bindPopup('KK4B387<br> KK4B <br> 147.3 PL 162.2 OFFSET +<br> 33.39550018,-79.95809937<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4JLA388 = new L.marker(new L.LatLng(34.88639832,-81.82080078),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4JLA388 K4JLA  147.315 PL 123 OFFSET + 34.88639832,-81.82080078' ,
                    }).addTo(fg).bindPopup('K4JLA388<br> K4JLA <br> 147.315 PL 123 OFFSET +<br> 34.88639832,-81.82080078<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4CAE389 = new L.marker(new L.LatLng(34.0007019,-81.03479767),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4CAE389 W4CAE  147.33 PL 156.7 OFFSET + 34.0007019,-81.03479767' ,
                    }).addTo(fg).bindPopup('W4CAE389<br> W4CAE <br> 147.33 PL 156.7 OFFSET +<br> 34.0007019,-81.03479767<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var WR4SC390 = new L.marker(new L.LatLng(33.40499878,-81.83750153),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'WR4SC390 WR4SC  147.345 PL 91.5 OFFSET + 33.40499878,-81.83750153' ,
                    }).addTo(fg).bindPopup('WR4SC390<br> WR4SC <br> 147.345 PL 91.5 OFFSET +<br> 33.40499878,-81.83750153<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var W4ANK391 = new L.marker(new L.LatLng(32.77659988,-79.93090057),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'W4ANK391 W4ANK  147.345 PL 123 OFFSET + 32.77659988,-79.93090057' ,
                    }).addTo(fg).bindPopup('W4ANK391<br> W4ANK <br> 147.345 PL 123 OFFSET +<br> 32.77659988,-79.93090057<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var K4HI392 = new L.marker(new L.LatLng(34.0007019,-81.03479767),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'K4HI392 K4HI  147.36 PL 100 OFFSET + 34.0007019,-81.03479767' ,
                    }).addTo(fg).bindPopup('K4HI392<br> K4HI <br> 147.36 PL 100 OFFSET +<br> 34.0007019,-81.03479767<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KK4BQ393 = new L.marker(new L.LatLng(33.2448733,-81.3587177),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KK4BQ393 KK4BQ  147.375 PL 91.5 OFFSET + 33.2448733,-81.3587177' ,
                    }).addTo(fg).bindPopup('KK4BQ393<br> KK4BQ <br> 147.375 PL 91.5 OFFSET +<br> 33.2448733,-81.3587177<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var NE4SC394 = new L.marker(new L.LatLng(33.44609833,-79.28469849),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'NE4SC394 NE4SC  147.375 PL 123 OFFSET + 33.44609833,-79.28469849' ,
                    }).addTo(fg).bindPopup('NE4SC394<br> NE4SC <br> 147.375 PL 123 OFFSET +<br> 33.44609833,-79.28469849<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var KA4FEC395 = new L.marker(new L.LatLng(33.98149872,-81.23619843),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'KA4FEC395 KA4FEC  147.39 PL 156.7 OFFSET + 33.98149872,-81.23619843' ,
                    }).addTo(fg).bindPopup('KA4FEC395<br> KA4FEC <br> 147.39 PL 156.7 OFFSET +<br> 33.98149872,-81.23619843<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var N1RCW396 = new L.marker(new L.LatLng(32.256,-80.9581),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'N1RCW396 N1RCW  147.435 PL 88.5 OFFSET x 32.256,-80.9581' ,
                    }).addTo(fg).bindPopup('N1RCW396<br> N1RCW <br> 147.435 PL 88.5 OFFSET x<br> 32.256,-80.9581<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var ACT143 = new L.marker(new L.LatLng(38.896175,-95.174838),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'ACT143 Douglas County Emergency Management  147.03+ 88.5 Narrow band 2.5KHz UFN 38.896175,-95.174838' ,
                    }).addTo(fg).bindPopup('ACT143<br> Douglas County Emergency Management <br> 147.03+ 88.5 Narrow band 2.5KHz UFN<br> 38.896175,-95.174838<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var DCARC144 = new L.marker(new L.LatLng(38.896175,-95.174838),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'DCARC144 Douglas County Amateur Radio Club  146.76- 88.5 Narrow band 2.5KHz UFN 38.896175,-95.174838' ,
                    }).addTo(fg).bindPopup('DCARC144<br> Douglas County Amateur Radio Club <br> 146.76- 88.5 Narrow band 2.5KHz UFN<br> 38.896175,-95.174838<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var DB0AVR402 = new L.marker(new L.LatLng(50.764271,6.218675),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'DB0AVR402 70cm Stolberg  Operator DH6KQ Andreas 50.764271,6.218675' ,
                    }).addTo(fg).bindPopup('DB0AVR402<br> 70cm Stolberg <br> Operator DH6KQ Andreas<br> 50.764271,6.218675<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var SAXRPTR147 = new L.marker(new L.LatLng(39.3641,-93.48071),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'SAXRPTR147 N0SAX   39.3641,-93.48071' ,
                    }).addTo(fg).bindPopup('SAXRPTR147<br> N0SAX <br> <br> 39.3641,-93.48071<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var DB0WA403 = new L.marker(new L.LatLng(50.745647,6.043222),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'markers/repeater.png', iconSize: [32, 34]}),
                title: 'DB0WA403 2m Aachen  Operator DF1VB Jochen 50.745647,6.043222' ,
                    }).addTo(fg).bindPopup('DB0WA403<br> 2m Aachen <br> Operator DF1VB Jochen<br> 50.745647,6.043222<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('PRATT241<br> Pratt Mt. <br> "Sheriff, PG&E, Med Net, Fire Net, Caltrans, HCOE, FWRA (146.610 MHz NEG PL 103.5), Backup: Generato<br> 40.1274,-123.69148<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('MP243<br> Mount Pierce <br> Sheriff, Arcata Fire/Ambulance, HCOE, FWRA (146.760 MHz NEG PL 103.5), Backup: Off-Site Generator<br> 40.41852,-124.12059<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('HH244<br> Humboldt Hill <br> FWRA (146.700 MHz NEG PL 103.5)<br> 40.72496,-124.19386<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('HORSE246<br> Horse Mt. <br> Sheriff, PG&E, Fire Net, FWRA (147.0000 MHz POS PL 103.5, 442.0000 MHz POS PL 100.0), Backup: Gener<br> 40.87531,-123.7327<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('ROGERS248<br> Rogers Peak <br> <br> 41.16941,-124.02483<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('RAINBOW249<br> Rainbow Ridge <br> HARC (146.910 MHz NEG PL 103.5)<br> 40.372,-124.12568<br>Created: ' );                        
         
                $('repeater'._icon).addClass('rptmrkr');
            
            var RFH_571 = new L.marker(new L.LatLng(39.183309,-94.383817),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/hole.png', iconSize: [32, 34]}),
                title: 'RFH_571 RFHoleK1 571  Created: 2023-08-05 -- Another test of the new RF Holes POI 39.183309,-94.383817' ,
                    }).addTo(fg).bindPopup('RFH_571<br> RFHoleK1 571 <br> Created: 2023-08-05 -- Another test of the new RF Holes POI<br> 39.183309,-94.383817<br>Created: ' );                        
         
                $('rfhole'._icon).addClass('aviationmrkr');
            
            var RFH_572 = new L.marker(new L.LatLng(39.356013,-94.777911),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/hole.png', iconSize: [32, 34]}),
                title: 'RFH_572 RFHoleK1 572  Created: 2023-08-06 -- Adding in Platte City 39.356013,-94.777911' ,
                    }).addTo(fg).bindPopup('RFH_572<br> RFHoleK1 572 <br> Created: 2023-08-06 -- Adding in Platte City<br> 39.356013,-94.777911<br>Created: 2023-08-06 15:47:18' );                        
         
                $('rfhole'._icon).addClass('aviationmrkr');
            
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
                    }).addTo(fg).bindPopup('JCSHRFF267<br> JC SHERIFF <br> <br> 48.024051,-122.763807<br>Created: ' );                        
         
                $('sheriff'._icon).addClass('polmrkr');
            
            var CCSHERIFF48 = new L.marker(new L.LatLng(39.245231,-94.41976),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'CCSHERIFF48 Clay County Sheriff   39.245231,-94.41976' ,
                    }).addTo(fg).bindPopup('CCSHERIFF48<br> Clay County Sheriff <br> <br> 39.245231,-94.41976<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('Sheriff398<br> A Sheriff <br> <br> 34.226835,-80.680747<br>Created: ' );                        
         
                $('sheriff'._icon).addClass('polmrkr');
            
            var Fire400 = new L.marker(new L.LatLng(34.245217,-80.602271),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'Fire400 Kershaw FD1  Kershaw County Fire / Sheriff 34.245217,-80.602271' ,
                    }).addTo(fg).bindPopup('Fire400<br> Kershaw FD1 <br> Kershaw County Fire / Sheriff<br> 34.245217,-80.602271<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('Sheriff401<br> B Sheriff <br> Kershaw County Fire / Sheriff<br> 34.244964,-80.602518<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('HCSO224<br> Humboldt County Sheriffs Office <br> County Jail, Sheriff Main Office of Emergency Services County CERT Mgt.<br> 40.803,-124.16221<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('HCSOMS225<br> Humboldt County Sheriffs Office_McKinleyville Station <br> <br> 40.94431,-124.09901<br>Created: ' );                        
         
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
                    }).addTo(fg).bindPopup('HCSDGS226<br> Humboldt County Sheriffs Department_Garberville Station <br> <br> 40.10251,-123.79386<br>Created: ' );                        
         
                $('sheriff'._icon).addClass('polmrkr');
            
            var SPM247 = new L.marker(new L.LatLng(41.03856,-123.74792),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'SPM247 Sugar Pine Mountain  Sheriff Backup: Solar Generator 41.03856,-123.74792' ,
                    }).addTo(fg).bindPopup('SPM247<br> Sugar Pine Mountain <br> Sheriff Backup: Solar Generator<br> 41.03856,-123.74792<br>Created: ' );                        
         
                $('sheriff'._icon).addClass('polmrkr');
            
            var NWS240 = new L.marker(new L.LatLng(40.81001,-124.15964),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/skywarn.png', iconSize: [32, 34]}),
                title: 'NWS240 National Weather Service  Amatuer Radio Station 40.81001,-124.15964' ,
                    }).addTo(fg).bindPopup('NWS240<br> National Weather Service <br> Amatuer Radio Station<br> 40.81001,-124.15964<br>Created: ' );                        
         
                $('skywarn'._icon).addClass('skymrkr');
            
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
                    }).addTo(fg).bindPopup('RGSP221<br> Richardson Grove State Park <br> <br> 40.01975,-123.79269<br>Created: ' );                        
         
                $('state'._icon).addClass('govmrkr');
           ;
var aviationList = L.layerGroup([RAAB203, MCI271, KCI272, PTIACPT273, HMSPH274, SVBPT275]);var eocList = L.layerGroup([W0KCN446, HCES239, W0KCN347, EOC399]);var fireList = L.layerGroup([CFPOBFS186, KFD35184, FWSTO436, WCFD192, LGVEN437, HFD190, KFD34185, CCFRWHQ189, CFCCFS188, CCFR187, KFPD194, HSTO435, MRFSUSFS205, CFS204, HFD202, FVFDCH201, CFICC200, FFD199, FFD198, LFS197, MCVF196, CFKHB195, CFTVS183, OVFD181, CFTFFS180, HBFS1166, LGZWE439, LGVIC440, LGGRE441, LGWER442, LGDON443, LGATS444, CARROLFD148, LGSMIT445, RESCH446, PESCH447, HBFS4167, HBFS3168, TFD179, WVFD178, FFD177, BLFD176, AFD175, AFD174, AFD173, LGBRE438, SPFD171, HBFS2170, HBFS5169, YFD182, KSZW405, LGLAM415, LGROL416, LGRUR417, LGSIM418, LGSTE419, FIRE14255, LGSTR420, LGWOF421, RMON422, PMON423, LGKES414, LGHAM413, LGDED412, RSIM406, PSIM407, LGEIC409, LGEIN410, FIRE16257, FIRE15256, FIRE13254, FIRE12253, FIRE11252, LGERK411, LGMON424, LGHOE1425, LHROH426, WFS2217, CFTFS216, BVFD215, PVFD214, MVFD213, MFFS212, CFWS211, CDFMFS210, PFD209, SVFD208, SCVFD218, CDFGF219, GFPD220, LGMOE427, LGKAL428, RROE429, PROE430, LGROE431, LGROT432, RSTO433, WGVF223, KVFDFS222, PSTO434, RDVFD207, LGBAR460, PALS475, LGALS476, LGHOE477, LGBET478, RAAC479, PAAC480, RWTH481, FWAAC1484, FWAAC2485, FWAAC3486, LGACMIT487, RALS474, LGSET473, LGKOH467, LGBROI461, LGWMIT462, RHER463, FWHER465, LGMER466, RBAES468, PBAES469, LGBAES470, LGBEG471, LGOID472, LGLAU488, LGBRA489, LGOBER512, LGHARP514, LGDREI515, LGWAL517, LGOBER518, LGMAUS519, LGIMGE520, LGMALT521, LGPUFF522, LGLOVE523, LGBEGG524, LGGEMU511, LGSCHM508, LGRICH490, LGSIEF491, LGEILD492, LGHAAR493, LGVERL494, HSLE496, LGSLE497, LGGEMU498, LGOBER1499, LGHER500, LGHARP506, UEHER464, FWESCH449, KCMOFS44126, KCMOFS43125, KCMOFS42124, KCMOFS41123, KCMOFS39121, KCMOFS38120, KCMOFS37119, KCMOFS36118, KCMOFS35117, KCMOFS34116, KCMOFS33115, KCMOFS45127, KCMOFS47128, LGBOH450, LGWEI451, LGDUE452, LGLOH453, LHKIN454, LGROE1455, RVRSFD134, RWUER456, PWUER457, HRMK458, KCMOFS14129, KCMOFS30114, KCMOFS29113, KCMOFS7101, KCMOFS10103, KCMOFS8102, W0KCN1588, KCMOFS6100, KCMOFS599, KCMOFS498, KCMOFS397, KCMOFS196, RVRSDEFD89, GNSVFS192, BRVRCOFR2990, KCMOFS16104, KCMOFS17105, KCMOFS28112, KCMOFS27111, KCMOFS40122, FWWUER459, KCMOFS25110, KCMOFS24109, KCMOFS23108, KCMOFS19107, KCMOFS18106, TFESS1291]);var hospitalList = L.layerGroup([FWRW5526, FWRW6525, FWRW4527, HSIM408, HESCH448, LUISEN483, FWWEST495, MARIEN482, SJH160, LMH145, STLPLZ35, STLEAS34, STJOMC33, STJOHN32, SMMC31, RMCBKS30, RESRCH29, RAYCO28, PMC27, PETTIS26, OPR25, STLSMI36, STLUBR37, STLUSO38, MRCH161, RMH162, JPCH163, TH164, SCH165, NORKC23, WEMO43, W0CPT42, TRUHH41, TRLKWD40, STM39, OMC24, MENORA22, GVMH12, CMHS7, CMH6, CASS5, CARROL4, BRMC3, BOTHWL2, DCEC9, JCC260, JCC259, BATES1, CUSHNG8, EXSPR10, LCHD19, LRHC20, LIBRTY18, KU0MED17, KINDRD16, KCVA15, KC0CBC14, I7013, LSMED21, FITZ11]);var policeList = L.layerGroup([LTRDUSFS191, HPA172, BLPD236, CHPDC237, CDFW250, PLTCTYPD141, COMOPD139, LTRD193, USFSMRRDO206, HTP235, HSUCP233, TPD232, APD231, FPD230, KSZS404, FPD229, EPD228, CHPGS227, RDPD234, NKCPD138, GSTNPD137, KCNPPD140, PTPOLICE1925279, FPD93721130, NRTPD132, RVRSPD133, PKVLPD135, LKWKPD136]);var repeaterList = L.layerGroup([WX4PG373, ROGERS248, HORSE246, HH244, WB4YXZ570, PRATT241, DJ2UB529, DB0QA528, RAINBOW249, MP243, DB0NIS530, ON0RBO531, W7JCR268, AA7MI269, DB0AVR402, DB0WA403, AA7MI270, DB0SE532, KCRWW80, ACT143, DCARC144, SAXRPTR147, KCRMED85, KCRCNC87, KCRHAM486, KCRQFJ84, KCRHAM383, KCRHAM282, KCRKW279, NE4SC291, KCRJCRAC278, KCRJCRAC177, KCRKW176, KCRHCV75, WA0KHP45, WA0QFJ44, KCRROO81, N2OBS342, WA4UKX326, W4HRS325, K4NAB324, WR4SC323, WR4SC322, WR4SC321, WT4F320, W4PAX319, W4HRS318, K4USC317, KK4ZBE316, WR4SC315, AD4U314, W4PDE327, W4FTK328, W4ULH341, WR4EC340, K4ILT339, KA4GDW338, KI4RAX337, W4NYK336, KJ4QLH335, W4GS334, N4AW333, WA4USN332, W4CAE331, W4FTK330, WR4SC329, W4BFT313, W4GL312, W4BRK311, KG4BZN295, N2ZZ293, WB4TGK292, W4GS280, W4IAR290, W4CHR289, K4WD288, W4APE287, K4LMD286, W4TWX285, KM4ABW284, W4BFT283, W4DV282, KJ4BWK296, WA4USN297, W4NYK310, KW4BET309, K4KNJ308, KK4ONF307, W4DV306, W4HRS305, W4APE304, W4APE303, K9OH302, W4ZKM301, W4HRS300, W4GL299, KE4MDP298, KT4TF281, KD4HLH343, W4HNK371, WA4JRJ383, W4ANK382, W4RRC381, KB4RRC380, W4GS379, W4IAR378, W4FTK377, WA4NMW376, WR4SC375, W4FTK374, W4APE372, N4HRS384, N4ADM385, WR4SC294, N1RCW396, KA4FEC395, NE4SC394, KK4BQ393, K4HI392, W4ANK391, WR4SC390, W4CAE389, K4JLA388, KK4B387, K2PJ386, W4GWD370, KO4L355, W4DEW347, K4YTZ360, KJ4YLP359, KK4BQ358, W4GL357, WA4SJS348, W4APE349, W1GRE354, W4IQQ350, KB4RRC353, N4AW352, K4ILT361, KK4ONF362, W4NYR344, WR4SC345, W4APE346, KG4BZN369, K4CCC368, W4GS367, WR4SC366, WR4SC365, KJ4QLH364, W4FTK363, WA4USN351]);var rfholeList = L.layerGroup([RFH_571, RFH_572]);var sheriffList = L.layerGroup([JCSHRFF267, HCSOMS225, HCSDGS226, Fire400, Sheriff401, HCSO224, Sheriff398, CCSHERIFF48, SPM247]);var skywarnList = L.layerGroup([NWS240]);var stateList = L.layerGroup([RGSP221]);
    
    //=======================================================================
    //======================= Station Markers ===============================
    //=======================================================================
        
    var Stations = L.layerGroup([_WA0TJT,_W0DLK,_W0GPS,_KD0NBH,_K0KEX,_KA0SXY,_KA0OTL]);
    // WA0TJT,W0DLK,KD0NBH,KC0YT,AA0JX,AA0DV

    // Add the stationmarkers to the map
    Stations.addTo(map);
    
    // ???
    // I don't know what this does but without it the POI menu items don't show
    map.fitBounds([[[39.201500,-94.601670],[39.2028965,-94.602876],[39.3682798,-94.770648],[39.2154688,-94.599025],[39.4197989,-94.658092],[39.1495372,-94.557949],[39.233048,-94.635470]]]);

    var bounds = L.latLngBounds([[[39.201500,-94.601670],[39.2028965,-94.602876],[39.3682798,-94.770648],[39.2154688,-94.599025],[39.4197989,-94.658092],[39.1495372,-94.557949],[39.233048,-94.635470]]]);
        console.log('fitBounds as bounds= '+JSON.stringify(bounds)); 


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
    //====================== THERE MAY NOT BE ANY TO REPORT ============================
    
    var WA0TJTOBJ = L.latLngBounds( [[39.20283,-94.6025],[39.20250,-94.6025],[39.20167,-94.6016],[39.19950,-94.6015],[39.19783,-94.6020],[39.19683,-94.6016],[39.19667,-94.6018],[39.19667,-94.6023],[39.19700,-94.6033],[39.19600,-94.6038],[39.19567,-94.6023],[39.19683,-94.6005],[39.19817,-94.5998],[39.19817,-94.5970],[39.19750,-94.5965],[39.19600,-94.5951],[39.19600,-94.5988],[39.19567,-94.6073],[39.19683,-94.6031],[39.19850,-94.6015],[39.20150,-94.6016]]);WA0TJTOBJ.getCenter();var WA0TJTPAD    = WA0TJTOBJ.pad(.075);
    // Object markers here
     var WA0TJT01 = new L.marker(new L.LatLng(39.20283,-94.6025),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker01.png', iconSize: [32, 34]}),
                            title:`marker_001`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT01
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> N Ames Ave & NW 60th Ct & 39.20283,-94.60250;
                 <br><br>
                    What3Words:<br> ///nominations.surely.interprets
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.20283,-94.6025
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>driveway
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1219 WA0TJT-1 : driveway : Keith and Deb from KCMO : ///nominations.surely.interprets : N Ames Ave & NW 60th Ct : 39.20283,-94.60250
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:19:56
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT02 = new L.marker(new L.LatLng(39.20250,-94.6025),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker02.png', iconSize: [32, 34]}),
                            title:`marker_002`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT02
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> N Ames Ave & NW 60th Ct & 39.20250,-94.60250;
                 <br><br>
                    What3Words:<br> ///hindering.will.hotter
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.20250,-94.6025
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>Bedford
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1220 WA0TJT-1 : Bedford : Keith and Deb from KCMO : ///hindering.will.hotter : N Ames Ave & NW 60th Ct : 39.20250,-94.60250
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:20:16
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT03 = new L.marker(new L.LatLng(39.20167,-94.6016),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker03.png', iconSize: [32, 34]}),
                            title:`marker_003`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT03
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> N Ames Ave & NW 59 St & 39.20167,-94.60167;
                 <br><br>
                    What3Words:<br> ///impulses.litter.overhear
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.20167,-94.6016
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>59th St
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1220 WA0TJT-1 : 59th St : Keith and Deb from KCMO : ///impulses.litter.overhear : N Ames Ave & NW 59 St : 39.20167,-94.60167
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:20:50
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT04 = new L.marker(new L.LatLng(39.19950,-94.6015),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker04.png', iconSize: [32, 34]}),
                            title:`marker_004`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT04
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> N Ames Ave & NW 58 Ct & 39.19950,-94.60150;
                 <br><br>
                    What3Words:<br> ///pasta.oceans.intrusions
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19950,-94.6015
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>58th ct
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1221 WA0TJT-1 : 58th ct : Keith and Deb from KCMO : ///pasta.oceans.intrusions : N Ames Ave & NW 58 Ct : 39.19950,-94.60150
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:21:20
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT05 = new L.marker(new L.LatLng(39.19783,-94.6020),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker05.png', iconSize: [32, 34]}),
                            title:`marker_005`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT05
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> N Ames Ave & 56th & 39.19783,-94.60200;
                 <br><br>
                    What3Words:<br> ///jeep.groups.folder
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19783,-94.6020
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>56th ct
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1222 WA0TJT-1 : 56th ct : Keith and Deb from KCMO : ///jeep.groups.folder : N Ames Ave & 56th : 39.19783,-94.60200
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:22:08
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT06 = new L.marker(new L.LatLng(39.19683,-94.6016),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker06.png', iconSize: [32, 34]}),
                            title:`marker_006`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT06
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> 56th & N Ames Ave & 39.19683,-94.60167;
                 <br><br>
                    What3Words:<br> ///volley.racing.actions
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19683,-94.6016
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>Top of 56th Ct
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1222 WA0TJT-1 : Top of 56th Ct : Keith and Deb from KCMO : ///volley.racing.actions : 56th & N Ames Ave : 39.19683,-94.60167
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:22:27
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT07 = new L.marker(new L.LatLng(39.19667,-94.6018),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker07.png', iconSize: [32, 34]}),
                            title:`marker_007`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT07
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> NW 56th St & NW Englewood Rd & 39.19667,-94.60183;
                 <br><br>
                    What3Words:<br> ///belts.warmer.televise
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19667,-94.6018
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>bottom of 56th ct
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1222 WA0TJT-1 : bottom of 56th ct : Keith and Deb from KCMO : ///belts.warmer.televise : NW 56th St & NW Englewood Rd : 39.19667,-94.60183
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:22:53
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT08 = new L.marker(new L.LatLng(39.19667,-94.6023),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker08.png', iconSize: [32, 34]}),
                            title:`marker_008`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT08
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> 56th & N Ames Ave & 39.19667,-94.60233;
                 <br><br>
                    What3Words:<br> ///motion.hesitation.campaigning
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19667,-94.6023
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>56th ct- 2
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1223 WA0TJT-1 : 56th ct- 2 : Keith and Deb from KCMO : ///motion.hesitation.campaigning : 56th & N Ames Ave : 39.19667,-94.60233
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:23:35
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT09 = new L.marker(new L.LatLng(39.19700,-94.6033),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker09.png', iconSize: [32, 34]}),
                            title:`marker_009`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT09
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> N Ames Ave & 56th & 39.19700,-94.60333;
                 <br><br>
                    What3Words:<br> ///dishwasher.coasted.deposit
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19700,-94.6033
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>pool
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1224 WA0TJT-1 : pool  : Keith and Deb from KCMO : ///dishwasher.coasted.deposit : N Ames Ave & 56th : 39.19700,-94.60333
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:24:20
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT10 = new L.marker(new L.LatLng(39.19600,-94.6038),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker10.png', iconSize: [32, 34]}),
                            title:`marker_010`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT10
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> NW 55th Ter & N Bell St & 39.19600,-94.60383;
                 <br><br>
                    What3Words:<br> ///burger.swift.stretch
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19600,-94.6038
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>Englewood
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1225 WA0TJT-1 : Englewood : Keith and Deb from KCMO : ///burger.swift.stretch : NW 55th Ter & N Bell St : 39.19600,-94.60383
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:25:10
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT11 = new L.marker(new L.LatLng(39.19567,-94.6023),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker11.png', iconSize: [32, 34]}),
                            title:`marker_011`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT11
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> NW 55th Ter & N Bell St & 39.19567,-94.60233;
                 <br><br>
                    What3Words:<br> ///crafted.aquatic.rigorously
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19567,-94.6023
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>Wyoming
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1225 WA0TJT-1 : Wyoming : Keith and Deb from KCMO : ///crafted.aquatic.rigorously : NW 55th Ter & N Bell St : 39.19567,-94.60233
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:25:43
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT12 = new L.marker(new L.LatLng(39.19683,-94.6005),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker12.png', iconSize: [32, 34]}),
                            title:`marker_012`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT12
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> N Wyoming Ave & NW 57th Ter & 39.19683,-94.60050;
                 <br><br>
                    What3Words:<br> ///arrests.different.dorms
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19683,-94.6005
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>top of Wyoming
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1226 WA0TJT-1 : top of Wyoming : Keith and Deb from KCMO : ///arrests.different.dorms : N Wyoming Ave & NW 57th Ter : 39.19683,-94.60050
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:26:26
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT13 = new L.marker(new L.LatLng(39.19817,-94.5998),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker13.png', iconSize: [32, 34]}),
                            title:`marker_013`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT13
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> NW 57th Ter & N Wyoming Ave & 39.19817,-94.59983;
                 <br><br>
                    What3Words:<br> ///december.novice.barons
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19817,-94.5998
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>Mulberry
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1227 WA0TJT-1 : Mulberry : Keith and Deb from KCMO : ///december.novice.barons : NW 57th Ter & N Wyoming Ave : 39.19817,-94.59983
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:27:26
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT14 = new L.marker(new L.LatLng(39.19817,-94.5970),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker14.png', iconSize: [32, 34]}),
                            title:`marker_014`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT14
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> NW 57th Ter & N Mulberry St & 39.19817,-94.59700;
                 <br><br>
                    What3Words:<br> ///renovating.booming.restless
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19817,-94.5970
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>Mercier
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1227 WA0TJT-1 : Mercier : Keith and Deb from KCMO : ///renovating.booming.restless : NW 57th Ter & N Mulberry St : 39.19817,-94.59700
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:27:43
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT15 = new L.marker(new L.LatLng(39.19750,-94.5965),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker15.png', iconSize: [32, 34]}),
                            title:`marker_015`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT15
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> NW 57 Ct & N Mercier Dr & 39.19750,-94.59650;
                 <br><br>
                    What3Words:<br> ///numbed.stretches.pelted
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19750,-94.5965
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>57th ct mercier
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1228 WA0TJT-1 : 57th ct mercier : Keith and Deb from KCMO : ///numbed.stretches.pelted : NW 57 Ct & N Mercier Dr : 39.19750,-94.59650
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:28:17
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT16 = new L.marker(new L.LatLng(39.19600,-94.5951),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker16.png', iconSize: [32, 34]}),
                            title:`marker_016`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT16
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> N Mercier Dr & NW Englewood Rd & 39.19600,-94.59517;
                 <br><br>
                    What3Words:<br> ///asks.rehearsing.lasts
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19600,-94.5951
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>Englewood 2
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1228 WA0TJT-1 : Englewood 2 : Keith and Deb from KCMO : ///asks.rehearsing.lasts : N Mercier Dr & NW Englewood Rd : 39.19600,-94.59517
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:28:59
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT17 = new L.marker(new L.LatLng(39.19600,-94.5988),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker17.png', iconSize: [32, 34]}),
                            title:`marker_017`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT17
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> NW Englewood Rd & N Liberty Ave & 39.19600,-94.59883;
                 <br><br>
                    What3Words:<br> ///fright.regulations.projection
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19600,-94.5988
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>school
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1229 WA0TJT-1 : school : Keith and Deb from KCMO : ///fright.regulations.projection : NW Englewood Rd & N Liberty Ave : 39.19600,-94.59883
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:29:59
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT18 = new L.marker(new L.LatLng(39.19567,-94.6073),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker18.png', iconSize: [32, 34]}),
                            title:`marker_018`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT18
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> NW Waukomis Dr & NW 56th St & 39.19567,-94.60733;
                 <br><br>
                    What3Words:<br> ///fruit.serenade.hopeful
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19567,-94.6073
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>Roundabout
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1231 WA0TJT-1 : Roundabout  : Keith and Deb from KCMO : ///fruit.serenade.hopeful : NW Waukomis Dr & NW 56th St : 39.19567,-94.60733
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:31:32
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT19 = new L.marker(new L.LatLng(39.19683,-94.6031),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker19.png', iconSize: [32, 34]}),
                            title:`marker_019`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT19
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> N Ames Ave & NW 56th St & 39.19683,-94.60317;
                 <br><br>
                    What3Words:<br> ///inspecting.scorpions.simple
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19683,-94.6031
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>by mailbox on Ames
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1233 WA0TJT-1 : by mailbox on Ames : Keith and Deb from KCMO : ///inspecting.scorpions.simple : N Ames Ave & NW 56th St : 39.19683,-94.60317
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:33:17
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT20 = new L.marker(new L.LatLng(39.19850,-94.6015),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker20.png', iconSize: [32, 34]}),
                            title:`marker_020`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT20
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> N Ames Ave & NW 57 Ct & 39.19850,-94.60150;
                 <br><br>
                    What3Words:<br> ///bouquet.decency.waving
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.19850,-94.6015
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>57th CT
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1233 WA0TJT-1 : 57th CT  : Keith and Deb from KCMO : ///bouquet.decency.waving : N Ames Ave & NW 57 Ct : 39.19850,-94.60150
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:33:40
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                        var WA0TJT21 = new L.marker(new L.LatLng(39.20150,-94.6016),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker21.png', iconSize: [32, 34]}),
                            title:`marker_021`}).addTo(fg).bindPopup(`<div class='xx' style='text-transform:uppercase;'>
                    OBJ: WA0TJT21
                 </div>
                 
                 <div class='gg'>
                 <br>
                    Cross Roads:<br> N Ames Ave & NW 59 St & 39.20150,-94.60167;
                 <br><br>
                    What3Words:<br> ///modems.pretend.taxed
                 <br><br>
                    Grid Square:<br> EM29QE &nbsp;&nbsp;&nbsp; AT: 39.20150,-94.6016
                 <br>
                 </div>
                 
                 <div style='color:red; font-weight: bold;'>
                 <br>
                    APRS Comment:<br>Keith and Deb from KCMO
                 <br>
                 </div>
                 <div style='color:blue; font-weight: bold;'>
                 <br>
                    Station Comment:<br>in front of house
                 <br>
                 </div>
                <br><br><div class='cc'>
                    Full Comment:<br>1234 WA0TJT-1 : in front of house : Keith and Deb from KCMO : ///modems.pretend.taxed : N Ames Ave & NW 59 St : 39.20150,-94.60167
                 <br><br>
                 </div>
                 <div class='xx'>
                    Captured:<br>2023-08-07 17:34:36
                 </div>
                `).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr');    
                            $('Objects'._icon).addClass('huechange');                                          
                           
    // Corner and center flags for the object markers, 5 for each callsign that has objects
    var WA0TJTob1 = new L.marker(new L.latLng( WA0TJTPAD.getSouthWest() ),{   
    		contextmenu: true, 
    		contextmenuWidth: 140, 
    		contextmenuItems: [{ 
            text: 'Click here to add mileage circles', 
            callback: circleKoords}], 
            icon: L.icon({iconUrl: bluemarkername , iconSize: [200,200] }),
            title:'ob1'}).addTo(map).bindPopup('OBJ:<br> WA0TJTSW<br>'+38.94567+','+-94.8573+'<br>The Objects SW Corner');
                        
        var WA0TJTob2 = new L.marker(new L.latLng( WA0TJTPAD.getNorthWest() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], 
           icon: L.icon({iconUrl: bluemarkername , iconSize: [200,200] }),
           title:'ob2'}).addTo(map).bindPopup('OBJ:<br> WA0TJTNW<br>'+39.45283+','+-94.8573+'<br>The Objects NW Corner');
                           
        var WA0TJTob3 = new L.marker(new L.latLng( WA0TJTPAD.getNorthEast() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}], 
           icon: L.icon({iconUrl: bluemarkername , iconSize: [200,200] }),
           title:'ob3'}).addTo(map).bindPopup('OBJ:<br> WA0TJTNE<br>'+39.45283+','+-94.3451+'<br>The Objects NE Corner');
                           
        var WA0TJTob4 = new L.marker(new L.latLng( WA0TJTPAD.getSouthEast() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
           icon: L.icon({iconUrl: bluemarkername , iconSize: [200,200] }),
           title:'ob4'}).addTo(map).bindPopup('OBJ:<br> WA0TJTSE<br>'+38.94567+','+-94.3451+'<br>The Objects SE Corner');
                           
        var WA0TJTob5 = new L.marker(new L.latLng( WA0TJTPAD.getCenter() ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],   
           icon: L.icon({iconUrl: bluemanInTheMiddle , iconSize: [200,200] }),     
           title:'ob5'}).addTo(map).bindPopup('OBJ:<br> WA0TJTCT<br>'+38.94567+','+-94.3451+'<br>The Objects Center Marker');
           
        var WA0TJTob6 = new L.marker(new L.latLng( WA0TJTPAD.getSouthWest() ),{
           icon: L.icon({iconUrl: bluemarkername , iconSize: [200,200] }),
           title:'ob6'}).addTo(map).bindPopup('OBJ:<br> WA0TJTSW<br>'+38.94567+','+-94.8573+'<br>The Objects SW Corner');
           
    // Object Marker List starts here
    var OBJMarkerList = L.layerGroup([WA0TJT01,WA0TJT02,WA0TJT03,WA0TJT04,WA0TJT05,WA0TJT06,WA0TJT07,WA0TJT08,WA0TJT09,WA0TJT10,WA0TJT11,WA0TJT12,WA0TJT13,WA0TJT14,WA0TJT15,WA0TJT16,WA0TJT17,WA0TJT18,WA0TJT19,WA0TJT20,WA0TJT21,]);
    // Add the OBJMarkerList to the map
    OBJMarkerList.addTo(map);
       
    // uniqueCallList is needed to so we can count how many color changes we need, always < 8
    var uniqueCallList = ['WA0TJT',];  
    
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
        
    var polyline = new L.Polyline([  [[39.20283,-94.6025],[39.20250,-94.6025],[39.20167,-94.6016],[39.19950,-94.6015],[39.19783,-94.6020],[39.19683,-94.6016],[39.19667,-94.6018],[39.19667,-94.6023],[39.19700,-94.6033],[39.19600,-94.6038],[39.19567,-94.6023],[39.19683,-94.6005],[39.19817,-94.5998],[39.19817,-94.5970],[39.19750,-94.5965],[39.19600,-94.5951],[39.19600,-94.5988],[39.19567,-94.6073],[39.19683,-94.6031],[39.19850,-94.6015],[39.20150,-94.6016]] ],{style: style}).addTo(map);

    
    //====================================================================== 
    //====================== Points of Interest ============================
    //======================================================================   
    //====================== THERE MAY NOT BE ANY TO REPORT ================
        
       // was classList now classNames to avoid a JS conflict of names
    // The classNames is the list of POI types.
     var classNames = 'aviationL,eocL,fireL,hospitalL,policeL,repeaterL,rfholeL,sheriffL,skywarnL,stateL CornerL, ObjectL;'.split(',');
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
    addToClassMap('rfholeL',    'rfholeList',   'hole.png');
    addToClassMap('sheriffL',   'sheriffList',  'police.png');
    addToClassMap('stateL',     'stateList',    'gov.png');
    
    addToClassMap('chpL',       'chpList',      'police.png');
    addToClassMap('federalL',   'federalList',  'gov.png');
    addToClassMap('skyWarnL',   'skyWarnList',  'skywarn.png');
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

</script>   <!-- End of javascript holding the map stuff -->

</body>
</html>
