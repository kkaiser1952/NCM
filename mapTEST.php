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
		    <b>MODES</b><br>
		    <a class='rowno' id='marker_1' href='#'>1 _KD0FIWH</a><br>
		    <a class='rowno' id='marker_2' href='#'>2 _AD0TU</a><br>
		    <a class='rowno' id='marker_3' href='#'>3 _KD0NBHA</a><br>
		    <a class='rowno' id='marker_4' href='#'>4 _W0WTS</a><br>
		    <a class='rowno' id='marker_5' href='#'>5 _K0OG</a><br>
		    <a class='rowno' id='marker_6' href='#'>6 _K0KEXA</a><br>
		    <a class='rowno' id='marker_7' href='#'>7 _N0SAXF</a><br>
		    <a class='rowno' id='marker_8' href='#'>8 _W0NRPA</a><br>
		    <a class='rowno' id='marker_9' href='#'>9 _WA0TJT</a><br>
		    <a class='rowno' id='marker_10' href='#'>10 _W0JWT</a><br>	</div>

    <!-- The title banner -->
    <div id="activity" class="activity">
    	<img src="images/NCM.png" alt="NCM" style="width: 35px; padding-left: 10px; padding-top: 5px;">
    	MODES Net #9657 Missouri Digital Emergency Service Weekly Net     </div>
    

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
            
   
    const baseMaps = {  
                       "<span style='color: blue; font-weight: bold;'>Streets": Streets,
                       "<span style='color: blue; font-weight: bold;'>Standard": Standard,
                       "<span style='color: blue; font-weight: bold;'>Default": Default                                
                     };
                     
                  
// =========  ADD Things to the Map ===============================================================
// ================================================================================================

    // Add what3words, shows w3w in a control
    var ww = new L.Control.w3w();
	    ww.addTo(map);
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
        skywarnicon   = new PoiIconClass({iconUrl: 'images/markers/skywarn.png'}),
        fireicon      = new PoiIconClass({iconUrl: 'images/markers/fire.png'}),
        repeatericon  = new PoiIconClass({iconUrl: 'markers/repeater.png'}),
        govicon       = new PoiIconClass({iconUrl: 'markers/gov.png'}),
        townhallicon  = new PoiIconClass({iconUrl: 'markers/gov.png'}),
        rfhole        = new PoiIconClass({iconUrl: 'markers/gov.png'}),
        
        objicon       = new ObjIconClass({iconURL: 'images/markers/marker00.png'}), //00 marker
    
        blueFlagicon  = new ObjIconClass({iconUrl: 'BRKMarkers/blue_flag.svg'}),
        greenFlagicon = new ObjIconClass({iconUrl: 'BRKMarkers/green_flag.svg'});
        
    
    // These are the markers that will appear on the map
    // Bring in the station and poi markers to appear on the map
    
			var _KD0FIWH = new L.marker(new L.latLng(39.2720374,-93.832865),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '1' }),
				title:`marker_1` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>1<br><b>Tactical: FIW/H<br>KD0FIW/H</b><br> ID: #000683<br>Paul Hayes<br>Ray Co., MO Dist: A<br>39.2720374, -93.832865<br>EM39CG<br><a href='https://what3words.com/simpler.blackberry.dull?maptype=osm' target='_blank'>///simpler.blackberry.dull</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2720374&lon=-93.832865&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_KD0FIWH`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_KD0FIWH);
				
			var _AD0TU = new L.marker(new L.latLng(39.7941892,-93.583108),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '2' }),
				title:`marker_2` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>2<br><b>Tactical: TU<br>AD0TU</b><br> ID: #000231<br>Craig Myers<br>Livingston Co., MO Dist: H<br>39.7941892, -93.583108<br>EM39FT<br><a href='https://what3words.com/events.armpit.craft?maptype=osm' target='_blank'>///events.armpit.craft</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.7941892&lon=-93.583108&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_AD0TU`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_AD0TU);
				
			var _KD0NBHA = new L.marker(new L.latLng(39.2154688,-94.599025),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedDivIcon({number: '3' }),
				title:`marker_3` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>3<br><b>Tactical: NBH/A<br>KD0NBH/A</b><br> ID: #001812<br>John Britton<br>Clay Co., MO Dist: A<br>39.2154688, -94.599025<br>EM29QF<br><a href='https://what3words.com/workflow.ships.derivative?maptype=osm' target='_blank'>///workflow.ships.derivative</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2154688&lon=-94.599025&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_KD0NBHA`._icon).addClass(`bluemrkr`);
                stationMarkers.push(_KD0NBHA);
				
			var _W0WTS = new L.marker(new L.latLng(39.3710869,-93.547969),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '4' }),
				title:`marker_4` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>4<br><b>Tactical: WTS<br>W0WTS</b><br> ID: #000237<br>Bill Sweeney<br>Carroll  Co., MO Dist: A<br>39.3710869, -93.547969<br>EM39FI<br><a href='https://what3words.com/grouping.native.citrus?maptype=osm' target='_blank'>///grouping.native.citrus</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.3710869&lon=-93.547969&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_W0WTS`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_W0WTS);
				
			var _K0OG = new L.marker(new L.latLng(37.9574854,-91.750868),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '5' }),
				title:`marker_5` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>5<br><b>Tactical: OG<br>K0OG</b><br> ID: #000238<br>Joseph Counsil<br>Phelps Co., MO Dist: I<br>37.9574854, -91.750868<br>EM47CW<br><a href='https://what3words.com/chef.order.influencing?maptype=osm' target='_blank'>///chef.order.influencing</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=37.9574854&lon=-91.750868&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_K0OG`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_K0OG);
				
			var _K0KEXA = new L.marker(new L.latLng(39.4197989,-94.658092),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '6' }),
				title:`marker_6` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>6<br><b>Tactical: KEX/A<br>K0KEX/A</b><br> ID: #000029<br>Rick Smith<br>Platte  Co., MO Dist: A<br>39.4197989, -94.658092<br>EM29QK<br><a href='https://what3words.com/hers.parrot.legions?maptype=osm' target='_blank'>///hers.parrot.legions</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.4197989&lon=-94.658092&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_K0KEXA`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_K0KEXA);
				
			var _N0SAXF = new L.marker(new L.latLng(39.3763041,-93.497272),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '7' }),
				title:`marker_7` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>7<br><b>Tactical: SAX/F<br>N0SAX/F</b><br> ID: #000229<br>Jack Vantrump<br>Carroll Co., MO Dist: A<br>39.3763041, -93.497272<br>EM39GJ<br><a href='https://what3words.com/tonality.spearing.company?maptype=osm' target='_blank'>///tonality.spearing.company</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.3763041&lon=-93.497272&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_N0SAXF`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_N0SAXF);
				
			var _W0NRPA = new L.marker(new L.latLng(38.8732866,-94.303351),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '8' }),
				title:`marker_8` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>8<br><b>Tactical: NRP/A<br>W0NRP/A</b><br> ID: #000820<br>Neil Preston<br>Jackson Co., MO Dist: A<br>38.8732866, -94.303351<br>EM28UU<br><a href='https://what3words.com/monday.butterflies.humans?maptype=osm' target='_blank'>///monday.butterflies.humans</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=38.8732866&lon=-94.303351&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_W0NRPA`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_W0NRPA);
				
			var _WA0TJT = new L.marker(new L.latLng(39.2028965,-94.602876),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedDivIcon({number: '9' }),
				title:`marker_9` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>9<br><b>Tactical: Net<br>WA0TJT</b><br> ID: #000013<br>Keith Kaiser<br>Platte  Co., MO Dist: A<br>39.2028965, -94.602876<br>EM29QE<br><a href='https://what3words.com/guiding.confusion.towards?maptype=osm' target='_blank'>///guiding.confusion.towards</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=39.2028965&lon=-94.602876&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_WA0TJT`._icon).addClass(`bluemrkr`);
                stationMarkers.push(_WA0TJT);
				
			var _W0JWT = new L.marker(new L.latLng(38.9127244,-94.351836),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '10' }),
				title:`marker_10` }).addTo(fg).bindPopup(`
				<div class='cc' style='text-transform:uppercase;'>10<br><b>Tactical: JWT<br>W0JWT</b><br> ID: #000363<br>John Totzke<br>Jackson Co., MO Dist: A<br>38.9127244, -94.351836<br>EM28TV<br><a href='https://what3words.com/rips.tested.remit?maptype=osm' target='_blank'>///rips.tested.remit</a></div><br><br>
				<div class='cc'> <a href='http://www.findu.com/cgi-bin/map-near.cgi?lat=38.9127244&lon=-94.351836&cnt=10' target='_blank'>Nearby APRS stations</a></div><br><br>
                `).openPopup();
				
				$(`_W0JWT`._icon).addClass(`greenmrkr`);
                stationMarkers.push(_W0JWT);
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
                    }).addTo(fg).bindPopup('MCI271 Kansas City International Airport   39.3003,-94.72721' );                        
         
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
                    }).addTo(fg).bindPopup('KCI272 Charles B Wheeler Downtown Airport   39.12051,-94.59077' );                        
         
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
                    }).addTo(fg).bindPopup('PTIACPT273 PT Intl Airport Cutoff   48.053802,-122.810628' );                        
         
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
                    }).addTo(fg).bindPopup('HMSPH274 Hadlock Mason St   48.034632,-122.775006' );                        
         
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
                    }).addTo(fg).bindPopup('SVBPT275 Sky Valley   48.077025,-122.840721' );                        
         
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
                    }).addTo(fg).bindPopup('RAAB203 Rohnerville Air Attack Base  Cal Fire Fixed Wing Air Attack Base 40.5555,-124.13204' );                        
         
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
                    }).addTo(fg).bindPopup('W0KCN446 Northland ARES Platte Co. EOC   39.3721733,-94.780929' );                        
         
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
                    }).addTo(fg).bindPopup('W0KCN347 Northland ARES Platte Co. Resource Center   39.2859182,-94.667236' );                        
         
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
                    }).addTo(fg).bindPopup('EOC399 A EOC  Kershaw County EOC 34.248206,-80.606327' );                        
         
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
                    }).addTo(fg).bindPopup('HCES239 Humboldt County Emergency Services  Humboldt County CERT AuxComm 40.803,-124.16221' );                        
         
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
                    }).addTo(fg).bindPopup('LGOBER512 Gerätehaus Oberhausen   50.512222,6.465568' );                        
         
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
                    }).addTo(fg).bindPopup('LGHARP514 Gerätehaus Harperscheid   50.518637,6.406335' );                        
         
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
                    }).addTo(fg).bindPopup('LGDREI515 Gerätehaus Dreiborn   50.542354,6.405359' );                        
         
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
                    }).addTo(fg).bindPopup('LGWAL517 Gerätehaus Wahlhem   50.71185,6.180236' );                        
         
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
                    }).addTo(fg).bindPopup('LGOBER518 Gerätehaus Kornelimuenster   50.72883,6.174868' );                        
         
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
                    }).addTo(fg).bindPopup('LGMAUS519 Gerätehaus Mausbach   50.755673,6.281836' );                        
         
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
                    }).addTo(fg).bindPopup('LGIMGE520 Gerätehaus Imgenbroich   50.577741,6.263472' );                        
         
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
                    }).addTo(fg).bindPopup('LGMALT521 Gerätehaus Monschau   50.553727,6.241281' );                        
         
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
                    }).addTo(fg).bindPopup('LGPUFF522 Gerätehaus Puffendorf   50.938861,6.212034' );                        
         
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
                    }).addTo(fg).bindPopup('LGLOVE523 Gerätehaus Loverich   50.933525,6.187821' );                        
         
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
                    }).addTo(fg).bindPopup('LGBEGG524 Gerätehaus Beggendorf   50.926302,6.169567' );                        
         
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
                    }).addTo(fg).bindPopup('W0KCN1588 Northland ARES Clay Co. Fire Station #2   39.363954,-94.584749' );                        
         
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
                    }).addTo(fg).bindPopup('RVRSDEFD89 Riverside, MO City Fire Department   39.175757,-94.616012' );                        
         
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
                    }).addTo(fg).bindPopup('BRVRCOFR2990 Brevard County Fire Rescue Station 29   28.431189,-80.805377' );                        
         
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
                    }).addTo(fg).bindPopup('TFESS1291 Titusville Fire & Emergency Services Station 12   28.589587,-80.831269' );                        
         
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
                    }).addTo(fg).bindPopup('GNSVFS192 Gainesville Fire Station 1   34.290941,-83.826461' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS196 KCMO Fire Station No. 1   38.84544806200006,-94.55557100699997' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS397 KCMO Fire Station No. 3   39.29502746500003,-94.57483520999995' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS498 KCMO Fire Station No. 4   39.21082648400005,-94.62698133999999' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS599 KCMO Fire Station No. 5   39.29465245500006,-94.72458748899999' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS6100 KCMO Fire Station No. 6   39.164872338000066,-94.54946718099995' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS7101 KCMO Fire Station No. 7   39.088027072000045,-94.59222542099997' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS8102 KCMO Fire Station No. 8   39.09503169800007,-94.57740912999998' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS10103 KCMO Fire Station No. 10   39.10270070000007,-94.56220495299999' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS16104 KCMO Fire Station No. 16   39.29508854300008,-94.68790113199998' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS17105 KCMO Fire Station No. 17   39.06448674100005,-94.56659040899996' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS18106 KCMO Fire Station No. 18   39.068426627000065,-94.54306673199994' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS19107 KCMO Fire Station No. 19   39.04970557900003,-94.59317453799997' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS23108 KCMO Fire Station No. 23   39.10519819800004,-94.52673633999996' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS24109 KCMO Fire Station No. 24   39.08534478900003,-94.51940024199996' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS25110 KCMO Fire Station No. 25   39.10791790600007,-94.57838314599996' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS27111 KCMO Fire Station No. 27   39.09423963200004,-94.50519189199997' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS28112 KCMO Fire Station No. 28   38.92612585100005,-94.57996235599995' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS29113 KCMO Fire Station No. 29   39.01353614300007,-94.56910049699997' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS30114 KCMO Fire Station No. 30   38.98954598500006,-94.55777761299998' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS33115 KCMO Fire Station No. 33   39.00341036400005,-94.49917701399994' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS34116 KCMO Fire Station No. 34   39.18216645700005,-94.52198633599994' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS35117 KCMO Fire Station No. 35   39.04105321900005,-94.54716372899998' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS36118 KCMO Fire Station No. 36   38.947990154000024,-94.58198512499996' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS37119 KCMO Fire Station No. 37   38.98838295400003,-94.59471418799995' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS38120 KCMO Fire Station No. 38   39.24114461900007,-94.57637879999999' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS39121 KCMO Fire Station No. 39   39.037389129000076,-94.44871189199995' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS40122 KCMO Fire Station No. 40   39.18825564000008,-94.57705538299996' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS41123 KCMO Fire Station No. 41   38.956671338000035,-94.52135318999996' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS42124 KCMO Fire Station No. 42   38.924447272000066,-94.51993356699995' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS43125 KCMO Fire Station No. 43   38.96734958800005,-94.43185910999995' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS44126 KCMO Fire Station No. 44   39.246423046000075,-94.66588993499994' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS45127 KCMO Fire Station No. 45   38.89023597400006,-94.58854005199998' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS47128 KCMO Fire Station No. 47   39.14034793800005,-94.52048369499994' );                        
         
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
                    }).addTo(fg).bindPopup('KCMOFS14129 KCMO Fire Station No. 14   39.24420365000003,-94.52101456199995' );                        
         
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
                    }).addTo(fg).bindPopup('RVRSFD134    Riverside City Fire Department   39.17579,-94.615947' );                        
         
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
                    }).addTo(fg).bindPopup('CARROLFD148 Carrollton Fire Department   39.364764,-93.482455' );                        
         
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
                    }).addTo(fg).bindPopup('KSZW405 DRK Fernmeldezug   50.813106,6.15943' );                        
         
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
                    }).addTo(fg).bindPopup('RSIM406 Gemeindeverwaltung Simmerath   50.606579,6.303835' );                        
         
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
                    }).addTo(fg).bindPopup('PSIM407 Wache Simmerath   50.61,6.302051' );                        
         
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
                    }).addTo(fg).bindPopup('LGEIC409 Gerätehaus Eicherscheid   50.579681,6.303993' );                        
         
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
                    }).addTo(fg).bindPopup('LGEIN410 Gerätehaus Einruhr   50.582916,6.37867' );                        
         
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
                    }).addTo(fg).bindPopup('LGERK411 Gerätehaus Erkensruhr   50.564697,6.361316' );                        
         
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
                    }).addTo(fg).bindPopup('LGDED412 Gerätehaus Dedenborn   50.583751,6.355568' );                        
         
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
                    }).addTo(fg).bindPopup('LGHAM413 Gerätehaus Hammer   50.564858,6.329027' );                        
         
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
                    }).addTo(fg).bindPopup('LGKES414 Gerätehaus Kesternich   50.606444,6.331613' );                        
         
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
                    }).addTo(fg).bindPopup('LGLAM415 Gerätehaus Lammersdorf   50.632156,6.271407' );                        
         
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
                    }).addTo(fg).bindPopup('LGROL416 Gerätehaus Rollesbroich   50.62973,6.311586' );                        
         
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
                    }).addTo(fg).bindPopup('LGRUR417 Gerätehaus Rurberg   50.614395,6.378801' );                        
         
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
                    }).addTo(fg).bindPopup('LGSIM418 Gerätehaus Simmerath   50.607846,6.297847' );                        
         
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
                    }).addTo(fg).bindPopup('LGSTE419 Gerätehaus Steckenborn   50.626846,6.354188' );                        
         
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
                    }).addTo(fg).bindPopup('LGSTR420 Gerätehaus Strauch   50.624717,6.334544' );                        
         
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
                    }).addTo(fg).bindPopup('LGWOF421 Gerätehaus Woffelsbach   50.62717,6.382292' );                        
         
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
                    }).addTo(fg).bindPopup('HBFS1166 Humboldt Bay Fire Station 1  HBF Main Office 40.80125,-124.16873' );                        
         
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
                    }).addTo(fg).bindPopup('RMON422 Stadtverwaltung Monschau   50.560007,6.237547' );                        
         
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
                    }).addTo(fg).bindPopup('HBFS4167 Humboldt Bay Fire Station 4   40.79978,-124.14866' );                        
         
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
                    }).addTo(fg).bindPopup('PMON423 Wache Monschau   50.558336,6.239711' );                        
         
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
                    }).addTo(fg).bindPopup('HBFS3168 Humboldt Bay Fire Station 3   40.78177,-124.18126' );                        
         
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
                    }).addTo(fg).bindPopup('LGMON424 Gerätehaus Altstadt   50.565182,6.25227' );                        
         
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
                    }).addTo(fg).bindPopup('HBFS5169 Humboldt Bay Fire Station 5   40.78097,-124.12982' );                        
         
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
                    }).addTo(fg).bindPopup('LGHOE1425 Gerätehaus Höfen   50.537637,6.254052' );                        
         
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
                    }).addTo(fg).bindPopup('HBFS2170 Humboldt Bay Fire Station 2   40.75793,-124.17967' );                        
         
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
                    }).addTo(fg).bindPopup('LHROH426 Gerätehaus Rohren   50.549038,6.283202' );                        
         
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
                    }).addTo(fg).bindPopup('LGMOE427 Gerätehaus Mützenich   50.566583,6.217732' );                        
         
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
                    }).addTo(fg).bindPopup('LGKAL428 Gerätehaus Kalterherberg   50.524809,6.219386' );                        
         
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
                    }).addTo(fg).bindPopup('RROE429 Gemeinde Verwaltung Roetgen   50.647679,6.195132' );                        
         
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
                    }).addTo(fg).bindPopup('PROE430 Wache Roetgen   50.647679,6.195132' );                        
         
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
                    }).addTo(fg).bindPopup('LGROE431 Gerätehaus Roetgen   50.645685,6.193941' );                        
         
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
                    }).addTo(fg).bindPopup('LGROT432 Gerätehaus Rott   50.679374,6.215632' );                        
         
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
                    }).addTo(fg).bindPopup('RSTO433 Stadtverwaltung Stolberg   50.772383,6.226992' );                        
         
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
                    }).addTo(fg).bindPopup('PSTO434 Polizeihauptwache Stolberg   50.771952,6.215136' );                        
         
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
                    }).addTo(fg).bindPopup('HSTO435 Bethlehem Health Center   50.772706,6.229039' );                        
         
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
                    }).addTo(fg).bindPopup('FWSTO436 Feuerwache Stolberg   50.772356,6.215903' );                        
         
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
                    }).addTo(fg).bindPopup('LGVEN437 Gerätehaus Vennwegen   50.706595,6.218356' );                        
         
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
                    }).addTo(fg).bindPopup('LGBRE438 Gerätehaus Breinig   50.730662,6.218026' );                        
         
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
                    }).addTo(fg).bindPopup('LGZWE439 Gerätehaus Zweifall   50.721203,6.253643' );                        
         
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
                    }).addTo(fg).bindPopup('KFD35184 Klamath Fire Station 35   41.57543,-124.04627' );                        
         
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
                    }).addTo(fg).bindPopup('LGVIC440 Gerätehaus Vicht   50.744947,6.263825' );                        
         
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
                    }).addTo(fg).bindPopup('KFD34185 Klamath Fire Station 34   41.57347,-124.07127' );                        
         
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
                    }).addTo(fg).bindPopup('LGGRE441 Gerätehaus Gressenich   50.771925,6.303416' );                        
         
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
                    }).addTo(fg).bindPopup('CFPOBFS186 CFPO Beatsch Fire station   41.75657,-124.15613' );                        
         
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
                    }).addTo(fg).bindPopup('LGWER442 Gerätehaus Werth   50.78098,6.286442' );                        
         
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
                    }).addTo(fg).bindPopup('LGDON443 Gerätehaus Donnerberg   50.781169,6.237568' );                        
         
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
                    }).addTo(fg).bindPopup('LGATS444 Gerätehaus Atsch   50.786182,6.217396' );                        
         
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
                    }).addTo(fg).bindPopup('LGSMIT445 Gerätehaus Stolberg Mitte   50.773596,6.233773' );                        
         
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
                    }).addTo(fg).bindPopup('RESCH446 Stadtverwaltung Eschweiler   50.817958,6.271965' );                        
         
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
                    }).addTo(fg).bindPopup('PESCH447 Polizeihauptwache Eschweiler   50.822081,6.27491' );                        
         
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
                    }).addTo(fg).bindPopup('FWESCH449 Feuerwache Eschweiler   50.81122,6.255358' );                        
         
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
                    }).addTo(fg).bindPopup('LGBOH450 Gerätehaus Bohl   50.798068,6.280844' );                        
         
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
                    }).addTo(fg).bindPopup('CFKHB195 Cal Fire Kneeland Helitack Base  Cal Fire Rotary Air Craft and refull Air Attack Base 40.71948,-123.92928' );                        
         
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
                    }).addTo(fg).bindPopup('LGWEI451 Gerätehaus Weisweilerl   50.825261,6.308295' );                        
         
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
                    }).addTo(fg).bindPopup('LGDUE452 Gerätehaus Dürwiss   50.835584,6.273568' );                        
         
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
                    }).addTo(fg).bindPopup('LGLOH453 Gerätehaus Neu_Lohn   50.863128,6.290406' );                        
         
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
                    }).addTo(fg).bindPopup('LHKIN454 Gerätehaus Kinsweiler   50.843966,6.229124' );                        
         
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
                    }).addTo(fg).bindPopup('LGROE1455 Gerätehaus Röhe   50.822782,6.235976' );                        
         
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
                    }).addTo(fg).bindPopup('RWUER456 Stadtverwaltung Würselen   50.819575,6.129974' );                        
         
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
                    }).addTo(fg).bindPopup('PWUER457 Polizeiwache Würselen   50.820841,6.128693' );                        
         
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
                    }).addTo(fg).bindPopup('HRMK458 Rhein_Maas Klinikum   50.815424,6.142567' );                        
         
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
                    }).addTo(fg).bindPopup('FWWUER459 Feuerwache Würselen   50.829789,6.136548' );                        
         
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
                    }).addTo(fg).bindPopup('LGBAR460 Gerätehaus Bardenberg   50.844639,6.112714' );                        
         
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
                    }).addTo(fg).bindPopup('LGBROI461 Gerätehaus Broichweiden   50.826609,6.174031' );                        
         
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
                    }).addTo(fg).bindPopup('LGWMIT462 Gerätehaus Mitte   50.829789,6.136548' );                        
         
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
                    }).addTo(fg).bindPopup('RHER463 Stadtverwaltung Herzogenrath   50.870513,6.101261' );                        
         
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
                    }).addTo(fg).bindPopup('UEHER464 Polizeiwache Herzogenrath   50.870836,6.102201' );                        
         
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
                    }).addTo(fg).bindPopup('FWHER465 Feuerwache Herzogenrath   50.866874,6.09844' );                        
         
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
                    }).addTo(fg).bindPopup('LGMER466 Gerätehaus Merkstein   50.887492,6.101902' );                        
         
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
                    }).addTo(fg).bindPopup('LGKOH467 Gerätehaus Kohlscheid   50.832215,6.085105' );                        
         
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
                    }).addTo(fg).bindPopup('RBAES468 Stadtverwaltung Baesweiler   50.908164,6.187756' );                        
         
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
                    }).addTo(fg).bindPopup('PBAES469 Polizeiwache Baesweiler   50.908164,6.187756' );                        
         
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
                    }).addTo(fg).bindPopup('LGBAES470 Gerätehaus Baesweiler   50.908164,6.187756' );                        
         
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
                    }).addTo(fg).bindPopup('LGBEG471 Gerätehaus Beggendorf   50.926302,6.169597' );                        
         
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
                    }).addTo(fg).bindPopup('LGOID472 Gerätehaus Oidtweiler   50.892694,6.18344' );                        
         
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
                    }).addTo(fg).bindPopup('LGSET473 Gerätehaus Setterich   50.925385,6.200954' );                        
         
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
                    }).addTo(fg).bindPopup('RALS474 Stadtverwaltung Alsdorf   50.875364,6.166517' );                        
         
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
                    }).addTo(fg).bindPopup('PALS475 Polizeiwache Alsdorf   50.871914,6.179722' );                        
         
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
                    }).addTo(fg).bindPopup('LGALS476 Gerätehaus Alsdorf   50.875067,6.173953' );                        
         
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
                    }).addTo(fg).bindPopup('LGHOE477 Gerätehaus Hoengen   50.860056,6.20485' );                        
         
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
                    }).addTo(fg).bindPopup('LGBET478 Gerätehaus Bettendorf   50.886872,6.198953' );                        
         
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
                    }).addTo(fg).bindPopup('RAAC479 Stadtverwaltung Aachen   50.768098,6.088472' );                        
         
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
                    }).addTo(fg).bindPopup('PAAC480 Polizeipräsidium Aachen   50.756751,6.149202' );                        
         
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
                    }).addTo(fg).bindPopup('RWTH481 Uni Klinik RWTH   50.776318,6.043778' );                        
         
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
                    }).addTo(fg).bindPopup('FWAAC1484 Feuerwache Aachen   50.7771,6.11679' );                        
         
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
                    }).addTo(fg).bindPopup('FWAAC2485 Feuerwache 2  Aachen   50.728695,6.175038' );                        
         
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
                    }).addTo(fg).bindPopup('FWAAC3486 Feuerwache 3 Aachen   50.789039,6.047787' );                        
         
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
                    }).addTo(fg).bindPopup('LGACMIT487 Gerätehaus Mitte   50.786317,6.135769' );                        
         
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
                    }).addTo(fg).bindPopup('LGLAU488 Gerätehaus Laurensberg   50.798014,6.060472' );                        
         
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
                    }).addTo(fg).bindPopup('LGBRA489 Gerätehaus Brand   50.747453,6.163663' );                        
         
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
                    }).addTo(fg).bindPopup('LGRICH490 Gerätehaus Richterich   50.814562,6.05599' );                        
         
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
                    }).addTo(fg).bindPopup('LGSIEF491 Gerätehaus Sief   50.694817,6.146472' );                        
         
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
                    }).addTo(fg).bindPopup('LGEILD492 Gerätehaus Eilendorf   50.77656,6.149927' );                        
         
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
                    }).addTo(fg).bindPopup('LGHAAR493 Gerätehaus Haaren   50.797582,6.123783' );                        
         
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
                    }).addTo(fg).bindPopup('LGVERL494 Gerätehaus Verlautenheide   50.797933,6.152941' );                        
         
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
                    }).addTo(fg).bindPopup('HSLE496 Krankenhaus Schleiden   50.533379,6.48691' );                        
         
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
                    }).addTo(fg).bindPopup('LGSLE497 Gerätehaus Schleiden   50.532139,6.479103' );                        
         
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
                    }).addTo(fg).bindPopup('LGGEMU498 Gerätehaus Gemuend   50.560923,6.497772' );                        
         
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
                    }).addTo(fg).bindPopup('LGOBER1499 Gerätehaus Oberhausen   50.512222,6.465568' );                        
         
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
                    }).addTo(fg).bindPopup('LGHER500 Gerätehaus Herhahn   50.554778,6.457676' );                        
         
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
                    }).addTo(fg).bindPopup('LGHARP506 Gerätehaus Harperscheid   50.518637,6.406335' );                        
         
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
                    }).addTo(fg).bindPopup('LGSCHM508 Gerätehaus Schmidt   50.657598,6.398873' );                        
         
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
                    }).addTo(fg).bindPopup('LGGEMU511 Gerätehaus Gemnd   50.560923,6.497772' );                        
         
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
                    }).addTo(fg).bindPopup('FWRW6525 Rettungswache 6   50.780334,6.097386' );                        
         
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
                    }).addTo(fg).bindPopup('FWRW5526 Rettungswache 5   50.78098,6.12967' );                        
         
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
                    }).addTo(fg).bindPopup('FWRW4527 Rettungswache 4   50.781304,6.134702' );                        
         
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
                    }).addTo(fg).bindPopup('LMH145 Lawrence Memorial Hospital  ACT staffs this location in emergencies  38.979225,-95.248259' );                        
         
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
                    }).addTo(fg).bindPopup('HSIM408 Eifel Clinic St. Brigida   50.604692,6.301457' );                        
         
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
                    }).addTo(fg).bindPopup('SJH160 St Joseph Hospital  Level 3 Trauma Center, Helipad 40.7841,-124.1422' );                        
         
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
                    }).addTo(fg).bindPopup('MRCH161 Mad River Community Hospital  Level 4 Trauma Center, Helipad 40.8963,-124.0917' );                        
         
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
                    }).addTo(fg).bindPopup('HESCH448 St._Antonius_Hospital   50.818443,6.264238' );                        
         
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
                    }).addTo(fg).bindPopup('MARIEN482 Marienhospital   50.762088,6.095381' );                        
         
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
                    }).addTo(fg).bindPopup('LUISEN483 Luisenhospital   50.767613,6.076744' );                        
         
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
                    }).addTo(fg).bindPopup('FWWEST495 Rettungswache West   50.769338,6.056529' );                        
         
                $('hospital'._icon).addClass('hosmrkr');
            
            var BATES1 = new L.marker(new L.LatLng(38.2498,-94.3432),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'BATES1 BATES COUNTY HOSPITAL  KCHEART 38.2498,-94.3432' ,
                    }).addTo(fg).bindPopup('BATES1 BATES COUNTY HOSPITAL  KCHEART 38.2498,-94.3432' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var BOTHWL2 = new L.marker(new L.LatLng(38.6993,-93.2208),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'BOTHWL2 BOTHWELL REGIONAL HEALTH CENTER   38.6993,-93.2208' ,
                    }).addTo(fg).bindPopup('BOTHWL2 BOTHWELL REGIONAL HEALTH CENTER   38.6993,-93.2208' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var BRMC3 = new L.marker(new L.LatLng(38.8158,-94.5033),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'BRMC3 Research Belton Hospital   38.8158,-94.5033' ,
                    }).addTo(fg).bindPopup('BRMC3 Research Belton Hospital   38.8158,-94.5033' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var CARROL4 = new L.marker(new L.LatLng(39.3762,-93.494),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'CARROL4 CARROLL COUNTY HOSPITAL   39.3762,-93.494' ,
                    }).addTo(fg).bindPopup('CARROL4 CARROLL COUNTY HOSPITAL   39.3762,-93.494' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var CASS5 = new L.marker(new L.LatLng(38.6645,-94.3725),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'CASS5 Cass Medical Center   38.6645,-94.3725' ,
                    }).addTo(fg).bindPopup('CASS5 Cass Medical Center   38.6645,-94.3725' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var CMH6 = new L.marker(new L.LatLng(39.852,-943.74),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'CMH6 Childrens Mercy Hospital   39.852,-943.74' ,
                    }).addTo(fg).bindPopup('CMH6 Childrens Mercy Hospital   39.852,-943.74' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var CMHS7 = new L.marker(new L.LatLng(38.9302,-94.6613),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'CMHS7 Childrens Mercy Hospital South   38.9302,-94.6613' ,
                    }).addTo(fg).bindPopup('CMHS7 Childrens Mercy Hospital South   38.9302,-94.6613' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var CUSHNG8 = new L.marker(new L.LatLng(39.3072,-94.9185),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'CUSHNG8 Cushing Memorial Hospital   39.3072,-94.9185' ,
                    }).addTo(fg).bindPopup('CUSHNG8 Cushing Memorial Hospital   39.3072,-94.9185' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var DCEC9 = new L.marker(new L.LatLng(39.862,-94.576),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'DCEC9 Metro Regional Healthcare Coord. Ctr   39.862,-94.576' ,
                    }).addTo(fg).bindPopup('DCEC9 Metro Regional Healthcare Coord. Ctr   39.862,-94.576' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var EXSPR10 = new L.marker(new L.LatLng(39.3568,-94.237),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'EXSPR10 Excelsior Springs Medical Center   39.3568,-94.237' ,
                    }).addTo(fg).bindPopup('EXSPR10 Excelsior Springs Medical Center   39.3568,-94.237' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var FITZ11 = new L.marker(new L.LatLng(39.928,-93.2143),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'FITZ11 FITZGIBBON HOSPITAL   39.928,-93.2143' ,
                    }).addTo(fg).bindPopup('FITZ11 FITZGIBBON HOSPITAL   39.928,-93.2143' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var GVMH12 = new L.marker(new L.LatLng(38.3892,-93.7702),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'GVMH12 GOLDEN VALLEY MEMORIAL HOSPITAL   38.3892,-93.7702' ,
                    }).addTo(fg).bindPopup('GVMH12 GOLDEN VALLEY MEMORIAL HOSPITAL   38.3892,-93.7702' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var I7013 = new L.marker(new L.LatLng(38.9783,-93.4162),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'I7013 I_70 MEDICAL CENTER   38.9783,-93.4162' ,
                    }).addTo(fg).bindPopup('I7013 I_70 MEDICAL CENTER   38.9783,-93.4162' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var KC0CBC14 = new L.marker(new L.LatLng(39.537,-94.5865),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KC0CBC14 Kansas City Blood Bank   39.537,-94.5865' ,
                    }).addTo(fg).bindPopup('KC0CBC14 Kansas City Blood Bank   39.537,-94.5865' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var KCVA15 = new L.marker(new L.LatLng(39.672,-94.5282),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KCVA15 Veterans Affairs Medical Center   39.672,-94.5282' ,
                    }).addTo(fg).bindPopup('KCVA15 Veterans Affairs Medical Center   39.672,-94.5282' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var KINDRD16 = new L.marker(new L.LatLng(38.968,-94.5745),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KINDRD16 Kindred Hospital Kansas City   38.968,-94.5745' ,
                    }).addTo(fg).bindPopup('KINDRD16 Kindred Hospital Kansas City   38.968,-94.5745' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var KU0MED17 = new L.marker(new L.LatLng(39.557,-94.6102),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'KU0MED17 University of Kansas Hospital   39.557,-94.6102' ,
                    }).addTo(fg).bindPopup('KU0MED17 University of Kansas Hospital   39.557,-94.6102' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var LIBRTY18 = new L.marker(new L.LatLng(39.274,-94.4233),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'LIBRTY18 Liberty Hospital   39.274,-94.4233' ,
                    }).addTo(fg).bindPopup('LIBRTY18 Liberty Hospital   39.274,-94.4233' );                        
         
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
            
            var LRHC20 = new L.marker(new L.LatLng(39.1893,-93.8768),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'LRHC20 LAFAYETTE REGIONAL HEALTH CENTER   39.1893,-93.8768' ,
                    }).addTo(fg).bindPopup('LRHC20 LAFAYETTE REGIONAL HEALTH CENTER   39.1893,-93.8768' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var LSMED21 = new L.marker(new L.LatLng(38.9035,-94.3327),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'LSMED21 Lee Summit Medical Center   38.9035,-94.3327' ,
                    }).addTo(fg).bindPopup('LSMED21 Lee Summit Medical Center   38.9035,-94.3327' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var MENORA22 = new L.marker(new L.LatLng(38.9107,-94.6512),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'MENORA22 Menorah Medical Center   38.9107,-94.6512' ,
                    }).addTo(fg).bindPopup('MENORA22 Menorah Medical Center   38.9107,-94.6512' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var NORKC23 = new L.marker(new L.LatLng(39.1495,-94.5513),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'NORKC23 North Kansas City Hospital   39.1495,-94.5513' ,
                    }).addTo(fg).bindPopup('NORKC23 North Kansas City Hospital   39.1495,-94.5513' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var OMC24 = new L.marker(new L.LatLng(38.853,-94.8235),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'OMC24 Olathe Medical Center, Inc.   38.853,-94.8235' ,
                    }).addTo(fg).bindPopup('OMC24 Olathe Medical Center, Inc.   38.853,-94.8235' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var OPR25 = new L.marker(new L.LatLng(39.9372,-94.7262),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'OPR25 Overland Park RMC   39.9372,-94.7262' ,
                    }).addTo(fg).bindPopup('OPR25 Overland Park RMC   39.9372,-94.7262' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var PETTIS26 = new L.marker(new L.LatLng(38.6973,-93.2163),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'PETTIS26 PETTIS Co Health Dept   38.6973,-93.2163' ,
                    }).addTo(fg).bindPopup('PETTIS26 PETTIS Co Health Dept   38.6973,-93.2163' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var PMC27 = new L.marker(new L.LatLng(39.127,-94.7865),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'PMC27 Providence Medical Center   39.127,-94.7865' ,
                    }).addTo(fg).bindPopup('PMC27 Providence Medical Center   39.127,-94.7865' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var RAYCO28 = new L.marker(new L.LatLng(39.2587,-93.9543),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'RAYCO28 RAY COUNTY HOSPITAL   39.2587,-93.9543' ,
                    }).addTo(fg).bindPopup('RAYCO28 RAY COUNTY HOSPITAL   39.2587,-93.9543' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var RESRCH29 = new L.marker(new L.LatLng(39.167,-94.6682),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'RESRCH29 Research Medical Center   39.167,-94.6682' ,
                    }).addTo(fg).bindPopup('RESRCH29 Research Medical Center   39.167,-94.6682' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var RMCBKS30 = new L.marker(new L.LatLng(39.8,-94.5778),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'RMCBKS30 Research Medical Center_ Brookside   39.8,-94.5778' ,
                    }).addTo(fg).bindPopup('RMCBKS30 Research Medical Center_ Brookside   39.8,-94.5778' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var SMMC31 = new L.marker(new L.LatLng(38.9955,-94.6908),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'SMMC31 Shawnee Mission Medical Center   38.9955,-94.6908' ,
                    }).addTo(fg).bindPopup('SMMC31 Shawnee Mission Medical Center   38.9955,-94.6908' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STJOHN32 = new L.marker(new L.LatLng(39.2822,-94.9058),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STJOHN32 Saint John Hospital   39.2822,-94.9058' ,
                    }).addTo(fg).bindPopup('STJOHN32 Saint John Hospital   39.2822,-94.9058' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STJOMC33 = new L.marker(new L.LatLng(38.9362,-94.6037),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STJOMC33 Saint Joseph Medical Center   38.9362,-94.6037' ,
                    }).addTo(fg).bindPopup('STJOMC33 Saint Joseph Medical Center   38.9362,-94.6037' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STLEAS34 = new L.marker(new L.LatLng(38.9415,-94.3813),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STLEAS34 Saint Lukes East_Lees Summit   38.9415,-94.3813' ,
                    }).addTo(fg).bindPopup('STLEAS34 Saint Lukes East_Lees Summit   38.9415,-94.3813' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STLPLZ35 = new L.marker(new L.LatLng(39.477,-94.5895),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STLPLZ35 Saint Lukes Hospital Plaza   39.477,-94.5895' ,
                    }).addTo(fg).bindPopup('STLPLZ35 Saint Lukes Hospital Plaza   39.477,-94.5895' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STLSMI36 = new L.marker(new L.LatLng(39.3758,-94.5807),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STLSMI36 Saint Lukes Smithville Campus   39.3758,-94.5807' ,
                    }).addTo(fg).bindPopup('STLSMI36 Saint Lukes Smithville Campus   39.3758,-94.5807' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STLUBR37 = new L.marker(new L.LatLng(39.2482,-94.6487),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STLUBR37 Saint Lukes Barry Road Campus   39.2482,-94.6487' ,
                    }).addTo(fg).bindPopup('STLUBR37 Saint Lukes Barry Road Campus   39.2482,-94.6487' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STLUSO38 = new L.marker(new L.LatLng(38.904,-94.6682),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STLUSO38 Saint Lukes South Hospital   38.904,-94.6682' ,
                    }).addTo(fg).bindPopup('STLUSO38 Saint Lukes South Hospital   38.904,-94.6682' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var STM39 = new L.marker(new L.LatLng(39.263,-94.2627),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'STM39 Saint Marys Medical Center   39.263,-94.2627' ,
                    }).addTo(fg).bindPopup('STM39 Saint Marys Medical Center   39.263,-94.2627' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var TRLKWD40 = new L.marker(new L.LatLng(38.9745,-94.3915),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'TRLKWD40 Truman Lakewood   38.9745,-94.3915' ,
                    }).addTo(fg).bindPopup('TRLKWD40 Truman Lakewood   38.9745,-94.3915' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var TRUHH41 = new L.marker(new L.LatLng(39.853,-94.5737),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'TRUHH41 Truman Medical Center_Hospital Hill   39.853,-94.5737' ,
                    }).addTo(fg).bindPopup('TRUHH41 Truman Medical Center_Hospital Hill   39.853,-94.5737' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var W0CPT42 = new L.marker(new L.LatLng(39.5,-94.3483),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'W0CPT42 Centerpoint Medical Center   39.5,-94.3483' ,
                    }).addTo(fg).bindPopup('W0CPT42 Centerpoint Medical Center   39.5,-94.3483' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
            var WEMO43 = new L.marker(new L.LatLng(38.7667,-93.7217),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/blue_50_flag.png', iconSize: [32, 34]}),
                title: 'WEMO43 WESTERN MISSOURI MEDICAL CENTER   38.7667,-93.7217' ,
                    }).addTo(fg).bindPopup('WEMO43 WESTERN MISSOURI MEDICAL CENTER   38.7667,-93.7217' );                        
         
                $('kcheart'._icon).addClass('flagmrkr');
            
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
                    }).addTo(fg).bindPopup('PTPOLICE1925279 PT POLICE   48.11464,-122.77136' );                        
         
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
                    }).addTo(fg).bindPopup('FPD93721130 Fresno Police Department   36.737611,-119.78787' );                        
         
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
                    }).addTo(fg).bindPopup('NRTPD132 Northmoor Police Department   39.183487,-94.605311' );                        
         
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
                    }).addTo(fg).bindPopup('RVRSPD133 Riverside City Police Department   39.175239,-94.616458' );                        
         
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
                    }).addTo(fg).bindPopup('PKVLPD135 Parkville Police Department   39.207055,-94.683832' );                        
         
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
                    }).addTo(fg).bindPopup('LKWKPD136 Lake Waukomis Police Department   39.227468,-94.634039' );                        
         
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
                    }).addTo(fg).bindPopup('GSTNPD137 Gladstone Police Department   39.221477,-94.57198' );                        
         
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
                    }).addTo(fg).bindPopup('NKCPD138 North Kansas City Police Department   39.143363,-94.573404' );                        
         
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
                    }).addTo(fg).bindPopup('COMOPD139 Claycomo Police Department   39.197769,-94.5038' );                        
         
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
                    }).addTo(fg).bindPopup('KCNPPD140 Kansas City Police North Patrol   39.291975,-94.684958' );                        
         
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
                    }).addTo(fg).bindPopup('PLTCTYPD141 Platte City Police Department   39.370039,-94.77987' );                        
         
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
                    }).addTo(fg).bindPopup('KSZS404 Katastrophenschutzzentrum   50.598817,6.289012' );                        
         
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
                    }).addTo(fg).bindPopup('DB0QA528 70cm Alsdorf  Operator DB9KN Max 50.875067,6.16656' );                        
         
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
                    }).addTo(fg).bindPopup('DJ2UB529 70cm Aachen Brand  Operator DJ2UN Uli 50.756536,6.158414' );                        
         
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
                    }).addTo(fg).bindPopup('DB0NIS530 70cm Nideggen_Schmidt  Operator DL8KCS Werner 50.65722,6.398236' );                        
         
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
                    }).addTo(fg).bindPopup('ON0RBO531 70cm Petergensfeld    50.653178,6.168431' );                        
         
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
                    }).addTo(fg).bindPopup('DB0SE532 70cm Kall  Operator DL8KBX Klaus 50.477617,6.52308' );                        
         
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
                    }).addTo(fg).bindPopup('W4GS280 W4GS  145.11 PL 85.4 OFFSET - 33.9137001,-79.04519653' );                        
         
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
                    }).addTo(fg).bindPopup('KT4TF281 KT4TF  145.11 PL 110.9 OFFSET - 34.99580002,-80.85500336' );                        
         
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
                    }).addTo(fg).bindPopup('W4DV282 W4DV  145.11 PL 71.9 OFFSET - 33.4734993,-82.01049805' );                        
         
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
                    }).addTo(fg).bindPopup('W4BFT283 W4BFT  145.13 PL 88.5 OFFSET - 32.39139938,-80.74849701' );                        
         
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
                    }).addTo(fg).bindPopup('KM4ABW284 KM4ABW  145.15 PL 91.5 OFFSET - 33.68700027,-80.21170044' );                        
         
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
                    }).addTo(fg).bindPopup('W4TWX285 W4TWX  145.17 PL 162.2 OFFSET - 34.88339996,-82.70739746' );                        
         
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
                    }).addTo(fg).bindPopup('K4LMD286 K4LMD  145.21 PL 100 OFFSET - 33.203402,-80.799942' );                        
         
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
                    }).addTo(fg).bindPopup('W4APE287 W4APE  145.23 PL 123 OFFSET - 33.58100128,-79.98899841' );                        
         
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
                    }).addTo(fg).bindPopup('K4WD288 K4WD  145.29 PL 162.2 OFFSET - 34.88100052,-83.09889984' );                        
         
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
                    }).addTo(fg).bindPopup('W4CHR289 W4CHR  145.31 PL 167.9 OFFSET - 34.68790054,-81.17980194' );                        
         
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
                    }).addTo(fg).bindPopup('W4IAR290 W4IAR  145.31 PL 100 OFFSET - 32.21630096,-80.75260162' );                        
         
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
                    }).addTo(fg).bindPopup('NE4SC291 NE4SC  145.31 PL 123 OFFSET - 33.75859833,-79.72820282' );                        
         
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
                    }).addTo(fg).bindPopup('WB4TGK292 WB4TGK  145.33 PL 156.7 OFFSET - 33.29710007,-81.03479767' );                        
         
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
                    }).addTo(fg).bindPopup('N2ZZ293 N2ZZ  145.35 PL 156.7 OFFSET - 33.57089996,-81.76309967' );                        
         
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
                    }).addTo(fg).bindPopup('WR4SC294 WR4SC  145.37 PL 123 OFFSET - 34.94060135,-82.41059875' );                        
         
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
                    }).addTo(fg).bindPopup('KG4BZN295 KG4BZN  145.39 PL  OFFSET - 32.90520096,-80.66680145' );                        
         
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
                    }).addTo(fg).bindPopup('KJ4BWK296 KJ4BWK  145.4 PL  OFFSET - 34.0007019,-81.03479767' );                        
         
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
                    }).addTo(fg).bindPopup('WA4USN297 WA4USN  145.41 PL 123 OFFSET - 32.58060074,-80.15969849' );                        
         
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
                    }).addTo(fg).bindPopup('KE4MDP298 KE4MDP  145.43 PL 162.2 OFFSET - 35.0461998,-81.58930206' );                        
         
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
                    }).addTo(fg).bindPopup('W4GL299 W4GL  145.43 PL 156.7 OFFSET - 33.96319962,-80.40219879' );                        
         
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
                    }).addTo(fg).bindPopup('WA0QFJ44 PCARG Repeater (147.330MHz T:151.4/444.550MHz )  PCARG club repeater 39.273172,-94.663137' );                        
         
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
                    }).addTo(fg).bindPopup('W4HRS300 W4HRS  145.45 PL 123 OFFSET - 32.78419876,-79.94499969' );                        
         
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
                    }).addTo(fg).bindPopup('WA0KHP45 Clay Co Repeater Club / KC Northland ARES Repeater (146.79Mhz T:107.2 )  Clay Co. Repeater Club 39.36392,-94.584721' );                        
         
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
                    }).addTo(fg).bindPopup('W4ZKM301 W4ZKM  145.45 PL 123 OFFSET - 33.26150131,-81.65670013' );                        
         
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
                    }).addTo(fg).bindPopup('K9OH302 K9OH  145.47 PL 91.5 OFFSET - 35.10570145,-82.62760162' );                        
         
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
                    }).addTo(fg).bindPopup('W4APE303 W4APE  145.47 PL 123 OFFSET - 34.19979858,-79.23249817' );                        
         
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
                    }).addTo(fg).bindPopup('W4APE304 W4APE  145.49 PL 123 OFFSET - 34.74810028,-79.84259796' );                        
         
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
                    }).addTo(fg).bindPopup('W4HRS305 W4HRS  145.49 PL 103.5 OFFSET - 33.19889832,-80.00689697' );                        
         
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
                    }).addTo(fg).bindPopup('W4DV306 W4DV  145.49 PL 71.9 OFFSET - 33.68489838,-81.92639923' );                        
         
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
                    }).addTo(fg).bindPopup('KK4ONF307 KK4ONF  146.06 PL 123 OFFSET + 32.4276903,-81.0087199' );                        
         
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
                    }).addTo(fg).bindPopup('K4KNJ308 K4KNJ  146.535 PL CSQ OFFSET x 34.28580093,-79.24590302' );                        
         
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
                    }).addTo(fg).bindPopup('KW4BET309 KW4BET  146.58 PL D023 OFFSET x 33.8420316,-78.6400437' );                        
         
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
                    }).addTo(fg).bindPopup('W4NYK310 W4NYK  146.61 PL  OFFSET - 35.05569839,-82.7845993' );                        
         
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
                    }).addTo(fg).bindPopup('W4BRK311 W4BRK  146.61 PL 123 OFFSET - 33.19599915,-80.01309967' );                        
         
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
                    }).addTo(fg).bindPopup('W4GL312 W4GL  146.64 PL 156.7 OFFSET - 33.92039871,-80.34149933' );                        
         
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
                    }).addTo(fg).bindPopup('W4BFT313 W4BFT  146.655 PL  OFFSET - 32.41880035,-80.68859863' );                        
         
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
                    }).addTo(fg).bindPopup('AD4U314 AD4U  146.67 PL 156.7 OFFSET - 33.66490173,-80.7779007' );                        
         
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
                    }).addTo(fg).bindPopup('WB4YXZ570 WB4YXZ  147 PL 151.4 OFFSET 34.90100098,-82.65930176' );                        
         
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
                    }).addTo(fg).bindPopup('WR4SC315 WR4SC  146.685 PL 91.5 OFFSET - 34.28020096,-79.74279785' );                        
         
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
                    }).addTo(fg).bindPopup('KK4ZBE316 KK4ZBE  146.685 PL 162.2 OFFSET - 32.83229828,-79.82839966' );                        
         
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
                    }).addTo(fg).bindPopup('K4USC317 K4USC  146.685 PL  OFFSET - 34.72969818,-81.63749695' );                        
         
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
                    }).addTo(fg).bindPopup('W4HRS318 W4HRS  146.7 PL 123 OFFSET - 33.37939835,-79.28469849' );                        
         
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
                    }).addTo(fg).bindPopup('W4PAX319 W4PAX  146.7 PL 123 OFFSET - 34.72040176,-80.77089691' );                        
         
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
                    }).addTo(fg).bindPopup('WT4F320 WT4F  146.7 PL 107.2 OFFSET - 34.88339996,-82.70739746' );                        
         
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
                    }).addTo(fg).bindPopup('WR4SC321 WR4SC  146.715 PL 162.2 OFFSET - 33.9496994,-79.1085968' );                        
         
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
                    }).addTo(fg).bindPopup('WR4SC322 WR4SC  146.715 PL 91.5 OFFSET - 34.11859894,-80.93689728' );                        
         
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
                    }).addTo(fg).bindPopup('WR4SC323 WR4SC  146.715 PL 123 OFFSET - 32.90520096,-80.66680145' );                        
         
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
                    }).addTo(fg).bindPopup('K4NAB324 K4NAB  146.73 PL  OFFSET - 33.50180054,-81.96510315' );                        
         
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
                    }).addTo(fg).bindPopup('W4HRS325 W4HRS  146.73 PL 123 OFFSET - 32.97570038,-80.07230377' );                        
         
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
                    }).addTo(fg).bindPopup('WA4UKX326 WA4UKX  146.73 PL 100 OFFSET - 34.73709869,-82.25430298' );                        
         
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
                    }).addTo(fg).bindPopup('W4PDE327 W4PDE  146.745 PL 82.5 OFFSET - 34.3689003,-79.32839966' );                        
         
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
                    }).addTo(fg).bindPopup('W4FTK328 W4FTK  146.745 PL D315 OFFSET - 34.188721,-81.404594' );                        
         
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
                    }).addTo(fg).bindPopup('WR4SC329 WR4SC  146.76 PL 123 OFFSET - 32.92440033,-79.69940186' );                        
         
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
                    }).addTo(fg).bindPopup('W4FTK330 W4FTK  146.76 PL D315 OFFSET - 34.715431,-81.019479' );                        
         
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
                    }).addTo(fg).bindPopup('KCRHCV75 Kansas City Room Host #28952  Hosts the Kansas City Room #28952 38.8648222,-94.7789944' );                        
         
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
                    }).addTo(fg).bindPopup('W4CAE331 W4CAE  146.775 PL 156.7 OFFSET - 34.05509949,-80.8321991' );                        
         
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
                    }).addTo(fg).bindPopup('KCRKW176 Kansas City Room, K0HAM  Jerry Dixon KCØKW 38.9879167,-94.67075' );                        
         
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
                    }).addTo(fg).bindPopup('WA4USN332 WA4USN  146.79 PL 123 OFFSET - 32.79059982,-79.90809631' );                        
         
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
                    }).addTo(fg).bindPopup('KCRJCRAC177 Kansas City Room, W0ERH  JCRAC club repeater 39.0106639,-94.7212972' );                        
         
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
                    }).addTo(fg).bindPopup('N4AW333 N4AW  146.79 PL  OFFSET - 35.06480026,-82.77739716' );                        
         
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
                    }).addTo(fg).bindPopup('KCRJCRAC278 Kansas City Room, W0ERH  JCRAC club repeater 38.9252611,-94.6553389' );                        
         
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
                    }).addTo(fg).bindPopup('W4GS334 W4GS  146.805 PL 85.4 OFFSET - 33.55099869,-79.04139709' );                        
         
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
                    }).addTo(fg).bindPopup('KCRKW279 Kansas City Room, K0HAM  Jerry Dixon KCØKW 38.5861611,-94.6204139' );                        
         
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
                    }).addTo(fg).bindPopup('KJ4QLH335 KJ4QLH  146.805 PL 156.7 OFFSET - 33.53,-80.82' );                        
         
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
                    }).addTo(fg).bindPopup('KCRWW80 N0WW  Keith Little NØWW 39.0465806,-94.5874444' );                        
         
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
                    }).addTo(fg).bindPopup('W4NYK336 W4NYK  146.82 PL  OFFSET - 34.94120026,-82.41069794' );                        
         
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
                    }).addTo(fg).bindPopup('KCRROO81 Kansas City Room, W0ROO  Leavenworth club repeater 39.2819722,-94.9058889' );                        
         
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
                    }).addTo(fg).bindPopup('KI4RAX337 KI4RAX  146.82 PL 91.5 OFFSET - 34.20999908,-80.69000244' );                        
         
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
                    }).addTo(fg).bindPopup('KCRHAM282 Kansas City Room, K0HAM  Jerry Dixon KCØKW 38.9084722,-94.4548056' );                        
         
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
                    }).addTo(fg).bindPopup('KA4GDW338 KA4GDW  146.835 PL 179.9 OFFSET - 33.35114,-80.68542' );                        
         
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
                    }).addTo(fg).bindPopup('KCRHAM383 Kansas City Room, K0HAM  Jerry Dixon KCØKW 39.0922333,-94.9453528' );                        
         
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
                    }).addTo(fg).bindPopup('K4ILT339 K4ILT  146.835 PL 103.5 OFFSET - 33.18619919,-80.57939911' );                        
         
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
                    }).addTo(fg).bindPopup('KCRQFJ84 Kansas City Room, WA0QFJ  PCARG Club Repeater 39.2731222,-94.6629583' );                        
         
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
                    }).addTo(fg).bindPopup('WR4EC340 WR4EC  146.85 PL 91.5 OFFSET - 33.7942009,-81.89029694' );                        
         
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
                    }).addTo(fg).bindPopup('KCRMED85 Kansas City Room, Ku0MED  Jerry Dixon KCØKW 39.0562778,-94.6095' );                        
         
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
                    }).addTo(fg).bindPopup('W4ULH341 W4ULH  146.85 PL 123 OFFSET - 34.28020096,-79.74279785' );                        
         
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
                    }).addTo(fg).bindPopup('KCRHAM486 Kansas City Room, K0HAM  Jerry Dixon KCØKW 39.2611111,-95.6558333' );                        
         
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
                    }).addTo(fg).bindPopup('N2OBS342 N2OBS  146.865 PL 123 OFFSET - 32.9856987,-80.10980225' );                        
         
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
                    }).addTo(fg).bindPopup('KCRCNC87 Kansas City Room, KD0CNC  KD0CNC 38.1788722,-93.3541889' );                        
         
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
                    }).addTo(fg).bindPopup('KD4HLH343 KD4HLH  146.865 PL 107.2 OFFSET - 34.57160187,-82.11209869' );                        
         
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
                    }).addTo(fg).bindPopup('W4NYR344 W4NYR  146.88 PL  OFFSET - 35.12120056,-81.51589966' );                        
         
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
                    }).addTo(fg).bindPopup('WR4SC345 WR4SC  146.88 PL 123 OFFSET - 33.54309845,-80.82420349' );                        
         
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
                    }).addTo(fg).bindPopup('W4APE346 W4APE  146.895 PL 123 OFFSET - 34.74850082,-80.41680145' );                        
         
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
                    }).addTo(fg).bindPopup('W4DEW347 W4DEW  146.91 PL 123 OFFSET - 34.00149918,-81.77200317' );                        
         
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
                    }).addTo(fg).bindPopup('WA4SJS348 WA4SJS  146.91 PL 156.7 OFFSET - 32.7118988,-80.68170166' );                        
         
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
                    }).addTo(fg).bindPopup('W4APE349 W4APE  146.925 PL 123 OFFSET - 34.29270172,-80.33760071' );                        
         
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
                    }).addTo(fg).bindPopup('W4IQQ350 W4IQQ  146.94 PL 107.2 OFFSET - 34.8526001,-82.39399719' );                        
         
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
                    }).addTo(fg).bindPopup('WA4USN351 WA4USN  146.94 PL 123 OFFSET - 32.9939003,-80.26999664' );                        
         
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
                    }).addTo(fg).bindPopup('N4AW352 N4AW  146.97 PL 127.3 OFFSET - 34.51079941,-82.64679718' );                        
         
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
                    }).addTo(fg).bindPopup('KB4RRC353 KB4RRC  146.97 PL 167.9 OFFSET - 34.19910049,-79.76779938' );                        
         
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
                    }).addTo(fg).bindPopup('W1GRE354 W1GRE  146.985 PL 123 OFFSET - 32.96580124,-80.15750122' );                        
         
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
                    }).addTo(fg).bindPopup('KO4L355 KO4L  147 PL 91.5 OFFSET - 34.06060028,-79.3125' );                        
         
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
                    }).addTo(fg).bindPopup('W4GL357 W4GL  147.015 PL 156.7 OFFSET + 33.8810997,-80.27059937' );                        
         
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
                    }).addTo(fg).bindPopup('KK4BQ358 KK4BQ  147.03 PL 156.7 OFFSET + 33.18780136,-81.39689636' );                        
         
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
                    }).addTo(fg).bindPopup('KJ4YLP359 KJ4YLP  147.03 PL 123 OFFSET - 34.88249969,-83.09750366' );                        
         
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
                    }).addTo(fg).bindPopup('K4YTZ360 K4YTZ  147.03 PL 88.5 OFFSET - 34.83969879,-81.01860046' );                        
         
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
                    }).addTo(fg).bindPopup('K4ILT361 K4ILT  147.045 PL 103.5 OFFSET + 33.17359924,-80.57389832' );                        
         
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
                    }).addTo(fg).bindPopup('KK4ONF362 KK4ONF  147.06 PL 123 OFFSET + 32.28710175,-81.08070374' );                        
         
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
                    }).addTo(fg).bindPopup('W4FTK363 W4FTK  147.06 PL D315 OFFSET + 33.854465,-80.529466' );                        
         
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
                    }).addTo(fg).bindPopup('KJ4QLH364 KJ4QLH  147.09 PL 156.7 OFFSET + 33.52,-81.08' );                        
         
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
                    }).addTo(fg).bindPopup('WR4SC365 WR4SC  147.09 PL 162.2 OFFSET + 34.88639832,-81.82080078' );                        
         
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
                    }).addTo(fg).bindPopup('WR4SC366 WR4SC  147.105 PL 123 OFFSET + 32.80220032,-80.02359772' );                        
         
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
                    }).addTo(fg).bindPopup('W4GS367 W4GS  147.12 PL 85.4 OFFSET + 33.68909836,-78.88670349' );                        
         
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
                    }).addTo(fg).bindPopup('K4CCC368 K4CCC  147.135 PL 123 OFFSET + 34.74860001,-79.84140015' );                        
         
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
                    }).addTo(fg).bindPopup('KG4BZN369 KG4BZN  147.135 PL  OFFSET + 32.90520096,-80.66680145' );                        
         
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
                    }).addTo(fg).bindPopup('W4GWD370 W4GWD  147.165 PL 107.2 OFFSET + 34.37239838,-82.1678009' );                        
         
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
                    }).addTo(fg).bindPopup('W4HNK371 W4HNK  147.18 PL 123 OFFSET + 33.14189911,-80.35079956' );                        
         
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
                    }).addTo(fg).bindPopup('W4APE372 W4APE  147.195 PL 123 OFFSET + 34.24779892,-79.81109619' );                        
         
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
                    }).addTo(fg).bindPopup('WX4PG373 WX4PG  147.195 PL 141.3 OFFSET + 34.9009497,-82.6592992' );                        
         
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
                    }).addTo(fg).bindPopup('W4FTK374 W4FTK  147.21 PL D315 OFFSET + 33.969955,-79.03414' );                        
         
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
                    }).addTo(fg).bindPopup('WR4SC375 WR4SC  147.21 PL 156.7 OFFSET + 34.19630051,-81.41230011' );                        
         
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
                    }).addTo(fg).bindPopup('WA4NMW376 WA4NMW  147.225 PL 123 OFFSET + 33.01300049,-80.25800323' );                        
         
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
                    }).addTo(fg).bindPopup('W4FTK377 W4FTK   147.225 PL 110.9 OFFSET + 34.92490005,-81.02510071' );                        
         
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
                    }).addTo(fg).bindPopup('W4IAR378 W4IAR  147.24 PL 100 OFFSET + 32.21630096,-80.75260162' );                        
         
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
                    }).addTo(fg).bindPopup('W4GS379 W4GS  147.24 PL 85.4 OFFSET + 33.70660019,-78.87419891' );                        
         
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
                    }).addTo(fg).bindPopup('KB4RRC380 KB4RRC  147.255 PL 162.2 OFFSET + 34.24750137,-79.81719971' );                        
         
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
                    }).addTo(fg).bindPopup('W4RRC381 W4RRC  147.255 PL 123 OFFSET + 33.91289902,-81.52559662' );                        
         
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
                    }).addTo(fg).bindPopup('W4ANK382 W4ANK  147.27 PL 123 OFFSET + 33.14369965,-80.35639954' );                        
         
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
                    }).addTo(fg).bindPopup('WA4JRJ383 WA4JRJ  147.27 PL 91.5 OFFSET + 34.68569946,-82.95320129' );                        
         
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
                    }).addTo(fg).bindPopup('N4HRS384 N4HRS  147.27 PL 110.9 OFFSET + 34.99430084,-81.24199677' );                        
         
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
                    }).addTo(fg).bindPopup('N4ADM385 N4ADM  147.285 PL 100 OFFSET + 33.5603981,-81.71959686' );                        
         
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
                    }).addTo(fg).bindPopup('K2PJ386 K2PJ  147.285 PL 85.4 OFFSET + 34.08570099,-79.07150269' );                        
         
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
                    }).addTo(fg).bindPopup('KK4B387 KK4B  147.3 PL 162.2 OFFSET + 33.39550018,-79.95809937' );                        
         
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
                    }).addTo(fg).bindPopup('K4JLA388 K4JLA  147.315 PL 123 OFFSET + 34.88639832,-81.82080078' );                        
         
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
                    }).addTo(fg).bindPopup('W4CAE389 W4CAE  147.33 PL 156.7 OFFSET + 34.0007019,-81.03479767' );                        
         
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
                    }).addTo(fg).bindPopup('WR4SC390 WR4SC  147.345 PL 91.5 OFFSET + 33.40499878,-81.83750153' );                        
         
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
                    }).addTo(fg).bindPopup('W4ANK391 W4ANK  147.345 PL 123 OFFSET + 32.77659988,-79.93090057' );                        
         
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
                    }).addTo(fg).bindPopup('K4HI392 K4HI  147.36 PL 100 OFFSET + 34.0007019,-81.03479767' );                        
         
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
                    }).addTo(fg).bindPopup('KK4BQ393 KK4BQ  147.375 PL 91.5 OFFSET + 33.2448733,-81.3587177' );                        
         
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
                    }).addTo(fg).bindPopup('NE4SC394 NE4SC  147.375 PL 123 OFFSET + 33.44609833,-79.28469849' );                        
         
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
                    }).addTo(fg).bindPopup('KA4FEC395 KA4FEC  147.39 PL 156.7 OFFSET + 33.98149872,-81.23619843' );                        
         
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
                    }).addTo(fg).bindPopup('N1RCW396 N1RCW  147.435 PL 88.5 OFFSET x 32.256,-80.9581' );                        
         
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
                    }).addTo(fg).bindPopup('ACT143 Douglas County Emergency Management  147.03+ 88.5 Narrow band 2.5KHz UFN 38.896175,-95.174838' );                        
         
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
                    }).addTo(fg).bindPopup('DCARC144 Douglas County Amateur Radio Club  146.76- 88.5 Narrow band 2.5KHz UFN 38.896175,-95.174838' );                        
         
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
                    }).addTo(fg).bindPopup('DB0AVR402 70cm Stolberg  Operator DH6KQ Andreas 50.764271,6.218675' );                        
         
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
                    }).addTo(fg).bindPopup('SAXRPTR147 N0SAX   39.3641,-93.48071' );                        
         
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
                    }).addTo(fg).bindPopup('DB0WA403 2m Aachen  Operator DF1VB Jochen 50.745647,6.043222' );                        
         
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
            
            var RFH_533567 = new L.marker(new L.LatLng(39.202849,-94.602862),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/aviation.png', iconSize: [32, 34]}),
                title: 'RFH_533567 RFHoleK1 533  Created: 2023-08-03 -- First RF Hole POI entry 39.202849,-94.602862' ,
                    }).addTo(fg).bindPopup('RFH_533567 RFHoleK1 533  Created: 2023-08-03 -- First RF Hole POI entry 39.202849,-94.602862' );                        
         
                $('rfhole'._icon).addClass('aviationmrkr');
            
            var RFH_568 = new L.marker(new L.LatLng(39.202849,-94.602862),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/aviation.png', iconSize: [32, 34]}),
                title: 'RFH_568 RFHoleK1 568  Created: 2023-08-03 -- test for new modal 39.202849,-94.602862' ,
                    }).addTo(fg).bindPopup('RFH_568 RFHoleK1 568  Created: 2023-08-03 -- test for new modal 39.202849,-94.602862' );                        
         
                $('rfhole'._icon).addClass('aviationmrkr');
            
            var RFH_569 = new L.marker(new L.LatLng(39.202849,-94.602862),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/aviation.png', iconSize: [32, 34]}),
                title: 'RFH_569 RFHoleK1 569  Created: 2023-08-03 -- test the modal 2 39.202849,-94.602862' ,
                    }).addTo(fg).bindPopup('RFH_569 RFHoleK1 569  Created: 2023-08-03 -- test the modal 2 39.202849,-94.602862' );                        
         
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
                    }).addTo(fg).bindPopup('JCSHRFF267 JC SHERIFF   48.024051,-122.763807' );                        
         
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
                    }).addTo(fg).bindPopup('CCSHERIFF48 Clay County Sheriff   39.245231,-94.41976' );                        
         
                $('sheriff'._icon).addClass('polmrkr');
            
            var NARESEOC131 = new L.marker(new L.LatLng(39.245231,-94.41976),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'NARESEOC131 Clay County Sheriff & KCNARES EOC   39.245231,-94.41976' ,
                    }).addTo(fg).bindPopup('NARESEOC131 Clay County Sheriff & KCNARES EOC   39.245231,-94.41976' );                        
         
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
                    }).addTo(fg).bindPopup('Fire400 Kershaw FD1  Kershaw County Fire / Sheriff 34.245217,-80.602271' );                        
         
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
            
            var HCCH245 = new L.marker(new L.LatLng(40.803,-124.16221),{ 
                rotationAngle: 0,
                rotationOrigin: 'bottom',
                opacity: 0.75,
                contextmenu: true, 
                contextmenuWidth: 140,
                contextmenuItems: [{ text: 'Click here to add mileage circles',
                    callback: circleKoords}],
                         
                icon: L.icon({iconUrl: 'images/markers/police.png', iconSize: [32, 34]}),
                title: 'HCCH245 Humboldt County Court House  Sheriff, Public Work  40.803,-124.16221' ,
                    }).addTo(fg).bindPopup('HCCH245 Humboldt County Court House  Sheriff, Public Work  40.803,-124.16221' );                        
         
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
                    }).addTo(fg).bindPopup('SPM247 Sugar Pine Mountain  Sheriff Backup: Solar Generator 41.03856,-123.74792' );                        
         
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
                    }).addTo(fg).bindPopup('NWS240 National Weather Service  Amatuer Radio Station 40.81001,-124.15964' );                        
         
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
                    }).addTo(fg).bindPopup('RGSP221 Richardson Grove State Park   40.01975,-123.79269' );                        
         
                $('state'._icon).addClass('govmrkr');
           ;
var aviationList = L.layerGroup([HMSPH274, RAAB203, MCI271, SVBPT275, KCI272, PTIACPT273, W0KCN446, W0KCN347, HCES239, EOC399, FFD198, LFS197, MCVF196, CFKHB195, KFPD194, LGWER442, WCFD192, LGDON443, HFD190, CCFRWHQ189, FFD199, MFFS212, SVFD208, RDVFD207, LGGRE441, MRFSUSFS205, CFS204, PFD209, CDFMFS210, FVFDCH201, CFICC200, CFWS211, HFD202, CFCCFS188, CCFR187, AFD173, LGATS444, SPFD171, HBFS2170, HBFS5169, HBFS3168, HBFS4167, HBFS1166, LGSMIT445, RESCH446, PESCH447, AFD174, AFD175, CFPOBFS186, KFD34185, KFD35184, CFTVS183, YFD182, OVFD181, CFTFFS180, TFD179, WVFD178, FFD177, BLFD176, FWESCH449, KSZW405, FIRE11252, LGLAM415, LGROL416, LGRUR417, LGSIM418, LGSTE419, LGSTR420, LGWOF421, RMON422, PMON423, FIRE12253, FIRE13254, FIRE14255, RSIM406, PSIM407, LGEIC409, LGEIN410, LGERK411, LGDED412, LGHAM413, LGKES414, FIRE16257, FIRE15256, LGMON424, LGHOE1425, LHROH426, WGVF223, KVFDFS222, LGVIC440, GFPD220, CDFGF219, SCVFD218, WFS2217, CFTFS216, BVFD215, PVFD214, LGZWE439, LGBRE438, LGVEN437, LGMOE427, LGKAL428, RROE429, PROE430, LGROE431, LGROT432]);;
    
    //=======================================================================
    //======================= Station Markers ===============================
    //=======================================================================
        
    var Stations = L.layerGroup([_KD0FIWH,_AD0TU,_KD0NBHA,_W0WTS,_K0OG,_K0KEXA,_N0SAXF,_W0NRPA,_WA0TJT,_W0JWT]);
    // WA0TJT,W0DLK,KD0NBH,KC0YT,AA0JX,AA0DV

    // Add the stationmarkers to the map
    Stations.addTo(map);
    
    // ???
    // I don't know what this does but without it the POI menu items don't show
    map.fitBounds([[[39.2720374,-93.832865],[39.7941892,-93.583108],[39.2154688,-94.599025],[39.3710869,-93.547969],[37.9574854,-91.750868],[39.4197989,-94.658092],[39.3763041,-93.497272],[38.8732866,-94.303351],[39.2028965,-94.602876],[38.9127244,-94.351836]]]);

    var bounds = L.latLngBounds([[[39.2720374,-93.832865],[39.7941892,-93.583108],[39.2154688,-94.599025],[39.3710869,-93.547969],[37.9574854,-91.750868],[39.4197989,-94.658092],[39.3763041,-93.497272],[38.8732866,-94.303351],[39.2028965,-94.602876],[38.9127244,-94.351836]]]);
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

    
    //====================================================================== 
    //====================== Points of Interest ============================
    //======================================================================   
    //====================== THERE MAY NOT BE ANY TO REPORT ================
        
    // The classList is the list of POI types.
    var classList = 'aviationL,EOCL,fireL,hospitalL,KCHEARTL,policeL,repeaterL,RFHoleL,sheriffL,skywarnL,stateL, CornerL, ObjectL;'.split(',');
       console.log('In map.php classList= '+classList);
    
    let station = {"<img src='markers/green_marker_hole.png' class='greenmarker' alt='green_marker_hole' align='middle' /><span class='biggreenmarker'> Stations</span>": Stations};

    // Each test below if satisfied creates a javascript object, each one connects the previous to the next 
    // THE FULL LIST (not in order):  TownHall, Hospital ,Repeater ,EOC ,Sheriff ,SkyWarn ,Fire ,CHP ,State ,Federal ,Aviation ,Police ,class, RFhole
    var y = {...station}; 
    var x;

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
            let State = {"<img src='images/markers/gov.png' width='32' height='37' align='middle' /> <span class='polmarker'>State</span>":  SheriffList};
            y = {...y, ...State};
            
        }else if (x == 'townhallL') {
            let TownHall = {"<img src='images/markers/gov.png' width='32' height='37' align='middle' /> <span class='townhall'>Town Halls</span>":  townhallList};
            y = {...y, ...TownHall};       
            
        }else if (x == 'ObjectL') {
            let Objects = {"<img src='images/markers/marker00.png' align='middle' /> <span class='objmrkrs'>Objects</span>": ObjectList};
            y = {...y, ...Objects}; 
            
        }else if (x == 'RFHoleL') {
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

</script>   <!-- End of javascript holding the map stuff -->


</body>
</html>
