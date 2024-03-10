<!DOCTYPE html>

<!-- IDEA: Create ability to draw lines from one marker to all other markers show bearing and distance.
    http://embed.plnkr.co/2XSeS1/
-->


<!-- Primary maping program, also uses poimarkers.php and stationmarkers.php -->


<html lang="en">
<head>
	<!-- https://esri.github.io/esri-leaflet/tutorials/create-your-first-app.html -->
	<title>NCM Map of Station Locations</title>

	<meta charset="utf-8" />
  <title>Switching basemaps</title>
  <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />

  <!-- Load Leaflet from CDN -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>

  <!-- Load Esri Leaflet from CDN -->
  <script src="https://unpkg.com/esri-leaflet@3.0.1/dist/esri-leaflet.js"
    integrity="sha512-JmpptMCcCg+Rd6x0Dbg6w+mmyzs1M7chHCd9W8HPovnImG2nLAQWn3yltwxXRM7WjKKFFHOAKjjF2SC4CgiFBg=="
    crossorigin=""></script>

     
     <!-- ******************************** Added Functionality *************************************** -->
    <link rel="stylesheet" href="css/leaflet_numbered_markers.css" />
    <link rel="stylesheet" href="css/L.Grid.css" />   
    <link rel="stylesheet" href="css/L.Control.MousePosition.css" />
    <link rel="stylesheet" href="css/control.w3w.css" />
    
    <link rel="stylesheet" href="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.css" />
    <link rel="stylesheet" type="text/css" href="css/maps.css">  
    <link rel="stylesheet" type="text/css" href="css/leaflet/leaflet.contextmenu.min.css">
    
    <script src="js/leaflet_numbered_markers.js"></script>
    <script src="js/L.Grid.js"></script>                    <!-- https://github.com/jieter/Leaflet.Grid -->
    <script src="js/L.Control.MousePosition.js"></script>   <!-- https://github.com/ardhi/Leaflet.MousePosition -->
    <script src="js/hamgridsquare.js"></script>
    
 <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/OverlappingMarkerSpiderfier-Leaflet/0.2.6/oms.min.js"></script>-->
    <script src="js/control.w3w.js"></script>
    <script src="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.js"></script>
    
    <script src="js/leaflet/leaflet.contextmenu.min.js"></script>
    
    <!-- Allows for rotating markers when more than one at the same place -->
    <script src="js/leaflet.rotatedMarker.js"></script>
    
     <!-- Adds grid lines marked with the gridsquare on the map -->
     <!-- https://gitlab.com/IvanSanchez/leaflet.maidenhead/-/blob/master/README.md -->
     <!--<script src="https://unpkg.com/leaflet.maidenhead@1.0.0/src/maidenhead.js"></script>-->
    
    <script src="https://cdn.jsdelivr.net/npm/leaflet-geometryutil@0.9.1/src/leaflet.geometryutil.min.js"></script>
    
    <!-- https://github.com/Turfjs/turf -->
    <!-- The use of transformScale from below may allow the groth of the polygon better than gussing like i do now. -->
    <!-- See https://stackoverflow.com/questions/61860963/how-to-enlarge-a-leaflet-polygon-box-by-5 -->
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@5/turf.min.js"></script>
    
    
    <!-- Check https://dotscrapbook.wordpress.com/2014/11/28/simple-numbered-markers-with-leaflet-js/ to make cusbom markers -->
    

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
        
        .leaflet-control-layers-overlays{
            
        }            
        
		
	</style>
	
</head>

<body>
    
    <!-- the map div holds the map -->
    <div id="map"></div>
    
    <!-- the stations div holds a list of the stations marked on the map -->
    <div id="stations"> 
		<b style="color:red; text-decoration: underline;">TE0ST
    		</b><br><a class='rowno' id='marker_1' href='#'>1 WA0TJT</a><br><a class='rowno' id='marker_2' href='#'>2 W0DLK</a><br>	</div>

    <!-- The title banner -->
    <div id="activity" class="activity">
    	<img src="images/NCM.png" alt="NCM" style="width: 35px; padding-left: 10px; padding-top: 5px;">
    	TE0ST Net #3818 $5[activity]     </div>
    
<!-- this script must stay here for some reason i don't know -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    
 // If you click on the 'Show Cross Rodads' in a popup
 // Not yet implemented
$(document).ready(function() {
    $('#map').on('click', '.cc', function() {
        $(".cc").html('Coming Soon');
        alert('This feature is coming soon ');
    });
}); 
    
    var stationMarkers = [];
    var fg = new L.featureGroup();
    
// These are the markers that will appear on the map

			var WA0TJT = new L.marker(new L.LatLng(39.2028965,-94.602876),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedDivIcon({number: '1' }),
				title:`marker_1` }).addTo(fg).bindPopup(`
				<div>1<br><b>WA0TJT</b><br> ID: #0013<br>Keith Kaiser<br>Platte Co., MO Dist: A<br>39.2028965, -94.602876<br>EM29QE<br>guiding.confusion.towards</div><br>
                <div class='cc'>Show Cross Roads</div>
                `).openPopup();
				
				$(`WA0TJT`._icon).addClass(`bluemrkr`); 
                stationMarkers.push(WA0TJT);
				
			var W0DLK = new L.marker(new L.LatLng(39.2028965,-94.602876),{ 
			    rotationAngle: 45,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '2' }),
				title:`marker_2` }).addTo(fg).bindPopup(`
				<div>2<br><b>W0DLK</b><br> ID: #0023<br>Deb Kaiser<br>Platte  Co., MO Dist: A<br>39.2028965, -94.602876<br>EM29QE<br>guiding.confusion.towards</div><br>
                <div class='cc'>Show Cross Roads</div>
                `).openPopup();
				
				$(`W0DLK`._icon).addClass(`greenmrkr`); 
                stationMarkers.push(W0DLK);
			;

            var W0KCN4 = new L.marker(new L.LatLng(39.3721733,-94.780929),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E1`}).addTo(fg).bindPopup(`W0KCN4<br>Northland ARES Platte Co. EOC<br><br>Platte City, MO<br><b style='color:red;'></b><br>39.3721733, -94.780929,  0 Ft.<br>EM29OI`).openPopup();                        
 
                        $(`EOC`._icon).addClass(`eocmrkr`);
            var W0KCN3 = new L.marker(new L.LatLng(39.2859182,-94.667236),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E2`}).addTo(fg).bindPopup(`W0KCN3<br>Northland ARES Platte Co. Resource Center<br><br>Kansas City, MO<br><b style='color:red;'></b><br>39.2859182, -94.667236,  0 Ft.<br>EM29PG`).openPopup();                        
 
                        $(`EOC`._icon).addClass(`eocmrkr`);
            var W0KCN15 = new L.marker(new L.LatLng(39.363954,-94.584749),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E3`}).addTo(fg).bindPopup(`W0KCN15<br>Northland ARES Clay Co. Fire Station #2<br>6569 N Prospect Ave<br>Smithville, MO<br><b style='color:red;'></b><br>39.363954, -94.584749,  0 Ft.<br>EM29QI`).openPopup();                        
 
                        $(`EOC`._icon).addClass(`eocmrkr`);
            var NARESEOC = new L.marker(new L.LatLng(39.245231,-94.41976),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/eoc.png`, iconSize: [32, 34]}),
                        title:`marker_E4`}).addTo(fg).bindPopup(`NARESEOC<br>Clay County Sheriff & KCNARES EOC<br><br>Liberty, MO<br><b style='color:red;'></b><br>39.245231, -94.41976,  0 Ft.<br>EM29SF`).openPopup();                        
 
                        $(`EOC`._icon).addClass(`eocmrkr`);
            var RVRSDEFD = new L.marker(new L.LatLng(39.175757,-94.616012),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F1`}).addTo(fg).bindPopup(`RVRSDEFD<br>Riverside, MO City Fire Department<br>2990 NW Vivion Rd. <br>Riverside, MO 64150<br><b style='color:red;'></b><br>39.175757, -94.616012,  0 Ft.<br>EM29QE`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS3 = new L.marker(new L.LatLng(39.29502746500003,-94.57483520999995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F2`}).addTo(fg).bindPopup(`KCMOFS3<br>KCMO Fire Station No. 3<br>11101 N Oak St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.29502746500003, -94.57483520999995,  0 Ft.<br>EM29RH`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS4 = new L.marker(new L.LatLng(39.21082648400005,-94.62698133999999),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F3`}).addTo(fg).bindPopup(`KCMOFS4<br>KCMO Fire Station No. 4<br>4000 NW 64th St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.21082648400005, -94.62698133999999,  0 Ft.<br>EM29QF`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS5 = new L.marker(new L.LatLng(39.29465245500006,-94.72458748899999),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F4`}).addTo(fg).bindPopup(`KCMOFS5<br>KCMO Fire Station No. 5<br>173 N Ottawa Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.29465245500006, -94.72458748899999,  0 Ft.<br>EM29PH`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS6 = new L.marker(new L.LatLng(39.164872338000066,-94.54946718099995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F5`}).addTo(fg).bindPopup(`KCMOFS6<br>KCMO Fire Station No. 6<br>2600 NE Parvin Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>39.164872338000066, -94.54946718099995,  0 Ft.<br>EM29RD`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS7 = new L.marker(new L.LatLng(39.088027072000045,-94.59222542099997),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F6`}).addTo(fg).bindPopup(`KCMOFS7<br>KCMO Fire Station No. 7<br>616 West Pennway St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.088027072000045, -94.59222542099997,  0 Ft.<br>EM29QC`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS8 = new L.marker(new L.LatLng(39.09503169800007,-94.57740912999998),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F7`}).addTo(fg).bindPopup(`KCMOFS8<br>KCMO Fire Station No. 8<br>1517 Locust St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.09503169800007, -94.57740912999998,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS10 = new L.marker(new L.LatLng(39.10270070000007,-94.56220495299999),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F8`}).addTo(fg).bindPopup(`KCMOFS10<br>KCMO Fire Station No. 10<br>1505 E 9th St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.10270070000007, -94.56220495299999,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS16 = new L.marker(new L.LatLng(39.29508854300008,-94.68790113199998),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F9`}).addTo(fg).bindPopup(`KCMOFS16<br>KCMO Fire Station No. 16<br>9205 NW 112th St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.29508854300008, -94.68790113199998,  0 Ft.<br>EM29PH`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS17 = new L.marker(new L.LatLng(39.06448674100005,-94.56659040899996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F10`}).addTo(fg).bindPopup(`KCMOFS17<br>KCMO Fire Station No. 17<br>3401 Paseo<br>Kansas City, MO<br><b style='color:red;'></b><br>39.06448674100005, -94.56659040899996,  0 Ft.<br>EM29RB`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS18 = new L.marker(new L.LatLng(39.068426627000065,-94.54306673199994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F11`}).addTo(fg).bindPopup(`KCMOFS18<br>KCMO Fire Station No. 18<br>3211 Indiana Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.068426627000065, -94.54306673199994,  0 Ft.<br>EM29RB`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS19 = new L.marker(new L.LatLng(39.04970557900003,-94.59317453799997),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F12`}).addTo(fg).bindPopup(`KCMOFS19<br>KCMO Fire Station No. 19<br>550 W 43rd St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.04970557900003, -94.59317453799997,  0 Ft.<br>EM29QB`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS23 = new L.marker(new L.LatLng(39.10519819800004,-94.52673633999996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F13`}).addTo(fg).bindPopup(`KCMOFS23<br>KCMO Fire Station No. 23<br>4777 Independence Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.10519819800004, -94.52673633999996,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS24 = new L.marker(new L.LatLng(39.08534478900003,-94.51940024199996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F14`}).addTo(fg).bindPopup(`KCMOFS24<br>KCMO Fire Station No. 24<br>2039 Hardesty Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.08534478900003, -94.51940024199996,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS25 = new L.marker(new L.LatLng(39.10791790600007,-94.57838314599996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F15`}).addTo(fg).bindPopup(`KCMOFS25<br>KCMO Fire Station No. 25<br>401 E Missouri Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.10791790600007, -94.57838314599996,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS27 = new L.marker(new L.LatLng(39.09423963200004,-94.50519189199997),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F16`}).addTo(fg).bindPopup(`KCMOFS27<br>KCMO Fire Station No. 27<br>6600 E Truman Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>39.09423963200004, -94.50519189199997,  0 Ft.<br>EM29RC`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS29 = new L.marker(new L.LatLng(39.01353614300007,-94.56910049699997),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F17`}).addTo(fg).bindPopup(`KCMOFS29<br>KCMO Fire Station No. 29<br>1414 E 63rd St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.01353614300007, -94.56910049699997,  0 Ft.<br>EM29RA`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS30 = new L.marker(new L.LatLng(38.98954598500006,-94.55777761299998),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F18`}).addTo(fg).bindPopup(`KCMOFS30<br>KCMO Fire Station No. 30<br>7534 Prospect Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>38.98954598500006, -94.55777761299998,  0 Ft.<br>EM28RX`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS33 = new L.marker(new L.LatLng(39.00341036400005,-94.49917701399994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F19`}).addTo(fg).bindPopup(`KCMOFS33<br>KCMO Fire Station No. 33<br>7504 E 67th St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.00341036400005, -94.49917701399994,  0 Ft.<br>EM29SA`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS34 = new L.marker(new L.LatLng(39.18216645700005,-94.52198633599994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F20`}).addTo(fg).bindPopup(`KCMOFS34<br>KCMO Fire Station No. 34<br>4836 N Brighton Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.18216645700005, -94.52198633599994,  0 Ft.<br>EM29RE`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS35 = new L.marker(new L.LatLng(39.04105321900005,-94.54716372899998),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F21`}).addTo(fg).bindPopup(`KCMOFS35<br>KCMO Fire Station No. 35<br>3200 Emanuel Cleaver II Blvd<br>Kansas City, MO<br><b style='color:red;'></b><br>39.04105321900005, -94.54716372899998,  0 Ft.<br>EM29RA`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS37 = new L.marker(new L.LatLng(38.98838295400003,-94.59471418799995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F22`}).addTo(fg).bindPopup(`KCMOFS37<br>KCMO Fire Station No. 37<br>7708 Wornall Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>38.98838295400003, -94.59471418799995,  0 Ft.<br>EM28QX`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS38 = new L.marker(new L.LatLng(39.24114461900007,-94.57637879999999),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F23`}).addTo(fg).bindPopup(`KCMOFS38<br>KCMO Fire Station No. 38<br>8100 N Oak Tfwy<br>Kansas City, MO<br><b style='color:red;'></b><br>39.24114461900007, -94.57637879999999,  0 Ft.<br>EM29RF`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS39 = new L.marker(new L.LatLng(39.037389129000076,-94.44871189199995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F24`}).addTo(fg).bindPopup(`KCMOFS39<br>KCMO Fire Station No. 39<br>11100 E 47th St<br>Kansas City, MO<br><b style='color:red;'></b><br>39.037389129000076, -94.44871189199995,  0 Ft.<br>EM29SA`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS40 = new L.marker(new L.LatLng(39.18825564000008,-94.57705538299996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F25`}).addTo(fg).bindPopup(`KCMOFS40<br>KCMO Fire Station No. 40<br>5200 N Oak Tfwy<br>Kansas City, MO<br><b style='color:red;'></b><br>39.18825564000008, -94.57705538299996,  0 Ft.<br>EM29RE`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS41 = new L.marker(new L.LatLng(38.956671338000035,-94.52135318999996),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F26`}).addTo(fg).bindPopup(`KCMOFS41<br>KCMO Fire Station No. 41<br>9300 Hillcrest Rd<br>Kansas City, MO<br><b style='color:red;'></b><br>38.956671338000035, -94.52135318999996,  0 Ft.<br>EM28RW`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
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
 
                        $(`Fire`._icon).addClass(`firemrkr`);
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
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS47 = new L.marker(new L.LatLng(39.14034793800005,-94.52048369499994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F29`}).addTo(fg).bindPopup(`KCMOFS47<br>KCMO Fire Station No. 47<br>5130 Deramus Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.14034793800005, -94.52048369499994,  0 Ft.<br>EM29RD`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KCMOFS14 = new L.marker(new L.LatLng(39.24420365000003,-94.52101456199995),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/fire.png`, iconSize: [32, 34]}),
                        title:`marker_F30`}).addTo(fg).bindPopup(`KCMOFS14<br>KCMO Fire Station No. 14<br>8300 N Brighton Ave<br>Kansas City, MO<br><b style='color:red;'></b><br>39.24420365000003, -94.52101456199995,  0 Ft.<br>EM29RF`).openPopup();                        
 
                        $(`Fire`._icon).addClass(`firemrkr`);
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
 
                        $(`Fire`._icon).addClass(`firemrkr`);
            var KINDRD = new L.marker(new L.LatLng(38.968,-94.5745),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H1`}).addTo(fg).bindPopup(`KINDRD<br>Kindred Hospital Kansas City<br>8701 Troost Ave<br>Kansas City, MO 64131-2767<br><b style='color:red;'></b><br>38.968, -94.5745,  0 Ft.<br>EM28RX`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var LIBRTY = new L.marker(new L.LatLng(39.274,-94.4233),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H2`}).addTo(fg).bindPopup(`LIBRTY<br>Liberty Hospital<br>2525 Glen Hendren<br>Liberty, MO 64068<br><b style='color:red;'></b><br>39.274, -94.4233,  0 Ft.<br>EM29SG`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var NORKC = new L.marker(new L.LatLng(39.1495,-94.5513),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H3`}).addTo(fg).bindPopup(`NORKC<br>North Kansas City Hospital<br>2800 Clay Edwards Dr<br>North Kansas City, MO 64116<br><b style='color:red;'></b><br>39.1495, -94.5513,  0 Ft.<br>EM29RD`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var PMC = new L.marker(new L.LatLng(39.127,-94.7865),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H4`}).addTo(fg).bindPopup(`PMC<br>Providence Medical Center<br>8929 Parallel Parkway<br>Kansas City, KS 66212-1689<br><b style='color:red;'></b><br>39.127, -94.7865,  0 Ft.<br>EM29OD`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var RESRCH = new L.marker(new L.LatLng(39.167,-94.6682),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H5`}).addTo(fg).bindPopup(`RESRCH<br>Research Medical Center<br>2316 E. Meyer Blvd<br>Kansas City, MO 64132<br><b style='color:red;'></b><br>39.167, -94.6682,  0 Ft.<br>EM29PE`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var SMMC = new L.marker(new L.LatLng(38.9955,-94.6908),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H6`}).addTo(fg).bindPopup(`SMMC<br>Shawnee Mission Medical Center<br>9100 W. 74th St<br>Shawnee Mission, KS 66204-4004<br><b style='color:red;'></b><br>38.9955, -94.6908,  0 Ft.<br>EM28PX`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var STLSMI = new L.marker(new L.LatLng(39.3758,-94.5807),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H7`}).addTo(fg).bindPopup(`STLSMI<br>Saint Lukes Smithville Campus<br>601 south 169 Highway<br>Smithville, MO 64089<br><b style='color:red;'></b><br>39.3758, -94.5807,  0 Ft.<br>EM29RJ`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var STLUBR = new L.marker(new L.LatLng(39.2482,-94.6487),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H8`}).addTo(fg).bindPopup(`STLUBR<br>Saint Lukes Barry Road Campus<br>5830 Northwest Barry Rd<br>Kansas City, MO 64154-2778<br><b style='color:red;'></b><br>39.2482, -94.6487,  0 Ft.<br>EM29QF`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var TRLKWD = new L.marker(new L.LatLng(38.9745,-94.3915),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/firstaid.png`, iconSize: [32, 34]}),
                        title:`marker_H9`}).addTo(fg).bindPopup(`TRLKWD<br>Truman Lakewood<br><br><br><b style='color:red;'></b><br>38.9745, -94.3915,  0 Ft.<br>EM28TX`).openPopup();                        
 
                        $(`Hospital`._icon).addClass(`hosmrkr`);
            var WA0QFJ = new L.marker(new L.LatLng(39.273172,-94.663137),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R1`}).addTo(fg).bindPopup(`WA0QFJ<br>PCARG Repeater (147.330MHz T:151.4/444.550MHz )<br>147.330MHz T:151.4/444.550MHz<br>Kansas City, MO<br><b style='color:red;'>PCARG club repeater</b><br>39.273172, -94.663137,  0 Ft.<br>EM29QG`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var WA0KHP = new L.marker(new L.LatLng(39.36392,-94.584721),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R2`}).addTo(fg).bindPopup(`WA0KHP<br>Clay Co Repeater Club / KC Northland ARES Repeater (146.79Mhz T:107.2 )<br>146.79Mhz T:107.2<br>Kansas City, MO<br><b style='color:red;'>Clay Co. Repeater Club</b><br>39.36392, -94.584721,  0 Ft.<br>EM29QI`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRKW1 = new L.marker(new L.LatLng(38.9879167,-94.67075),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R3`}).addTo(fg).bindPopup(`KCRKW1<br>Kansas City Room, K0HAM<br>146.910-MHz



<br>Overland Park, KS<br><b style='color:red;'>Jerry Dixon KCØKW</b><br>38.9879167, -94.67075,  0 Ft.<br>EM28PX`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRJCRAC1 = new L.marker(new L.LatLng(39.0106639,-94.7212972),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R4`}).addTo(fg).bindPopup(`KCRJCRAC1<br>Kansas City Room, W0ERH<br>442.600+MHz
<br>Shawnee, KS<br><b style='color:red;'>JCRAC club repeater</b><br>39.0106639, -94.7212972,  0 Ft.<br>EM29PA`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRWW = new L.marker(new L.LatLng(39.0465806,-94.5874444),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R5`}).addTo(fg).bindPopup(`KCRWW<br>Kansas City Room, N0WW<br>The Plaza 443.275+MHz
<br>Kansas City, MO<br><b style='color:red;'>Keith Little NØWW</b><br>39.0465806, -94.5874444,  0 Ft.<br>EM29QB`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRQFJ = new L.marker(new L.LatLng(39.2731222,-94.6629583),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R6`}).addTo(fg).bindPopup(`KCRQFJ<br>Kansas City Room, WA0QFJ<br>Tiffany Springs 444.550+MHz
<br>Kansas City, MO<br><b style='color:red;'>PCARG Club Repeater</b><br>39.2731222, -94.6629583,  0 Ft.<br>EM29QG`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var KCRMED = new L.marker(new L.LatLng(39.0562778,-94.6095),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `markers/repeater.png`, iconSize: [32, 34]}),
                        title:`marker_R7`}).addTo(fg).bindPopup(`KCRMED<br>Kansas City Room, Ku0MED<br>KU Medical Center 442.325+MHz
<br>Kansas City, KS<br><b style='color:red;'>Jerry Dixon KCØKW</b><br>39.0562778, -94.6095,  0 Ft.<br>EM29QB`).openPopup();                        
 
                        $(`Repeater`._icon).addClass(`rptmrkr`);
            var CCSHERIFF = new L.marker(new L.LatLng(39.245231,-94.41976),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P1`}).addTo(fg).bindPopup(`CCSHERIFF<br>Clay County Sheriff<br><br>Liberty, MO<br><b style='color:red;'></b><br>39.245231, -94.41976,  0 Ft.<br>EM29SF`).openPopup();                        
 
                        $(`Sheriff`._icon).addClass(`polmrkr`);
            var NRTPD = new L.marker(new L.LatLng(39.183487,-94.605311),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P2`}).addTo(fg).bindPopup(`NRTPD<br>Northmoor Police Department<br> 2039 NW 49th Terrace<br>    Northmoor MO 64151<br><b style='color:red;'></b><br>39.183487, -94.605311,  0 Ft.<br>EM29QE`).openPopup();                        
 
                        $(`Sheriff`._icon).addClass(`polmrkr`);
            var RVRSPD = new L.marker(new L.LatLng(39.175239,-94.616458),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P3`}).addTo(fg).bindPopup(`RVRSPD<br>Riverside City Police Department<br> 2990 NW Vivion Rd<br>	   Riverside MO 64150<br><b style='color:red;'></b><br>39.175239, -94.616458,  0 Ft.<br>EM29QE`).openPopup();                        
 
                        $(`Sheriff`._icon).addClass(`polmrkr`);
            var PKVLPD = new L.marker(new L.LatLng(39.207055,-94.683832),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P4`}).addTo(fg).bindPopup(`PKVLPD<br>Parkville Police Department<br> 8880 Clark Ave<br>	   Parkville MO 64152<br><b style='color:red;'></b><br>39.207055, -94.683832,  0 Ft.<br>EM29PE`).openPopup();                        
 
                        $(`Sheriff`._icon).addClass(`polmrkr`);
            var LKWKPD = new L.marker(new L.LatLng(39.227468,-94.634039),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P5`}).addTo(fg).bindPopup(`LKWKPD<br>Lake Waukomis Police Department<br> 1147 NW South Shore Dr<br>  Lake Waukomis MO 64151<br><b style='color:red;'></b><br>39.227468, -94.634039,  0 Ft.<br>EM29QF`).openPopup();                        
 
                        $(`Sheriff`._icon).addClass(`polmrkr`);
            var GSTNPD = new L.marker(new L.LatLng(39.221477,-94.57198),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P6`}).addTo(fg).bindPopup(`GSTNPD<br>Gladstone Police Department<br>	7010 N Holmes St<br>	   Gladstone MO 64118<br><b style='color:red;'></b><br>39.221477, -94.57198,  0 Ft.<br>EM29RF`).openPopup();                        
 
                        $(`Sheriff`._icon).addClass(`polmrkr`);
            var NKCPD = new L.marker(new L.LatLng(39.143363,-94.573404),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P7`}).addTo(fg).bindPopup(`NKCPD<br>North Kansas City Police Department<br>   2020 Howell St<br>	   North Kansas City MO 64116<br><b style='color:red;'></b><br>39.143363, -94.573404,  0 Ft.<br>EM29RD`).openPopup();                        
 
                        $(`Sheriff`._icon).addClass(`polmrkr`);
            var COMOPD = new L.marker(new L.LatLng(39.197769,-94.5038),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P8`}).addTo(fg).bindPopup(`COMOPD<br>Claycomo Police Department<br>   115 US-69<br>		   Claycomo MO 64119<br><b style='color:red;'></b><br>39.197769, -94.5038,  0 Ft.<br>EM29RE`).openPopup();                        
 
                        $(`Sheriff`._icon).addClass(`polmrkr`);
            var KCNPPD = new L.marker(new L.LatLng(39.291975,-94.684958),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P9`}).addTo(fg).bindPopup(`KCNPPD<br>Kansas City Police North Patrol<br> 11000 NW Prairie View Rd<br>Kansas City MO 64153<br><b style='color:red;'></b><br>39.291975, -94.684958,  0 Ft.<br>EM29PH`).openPopup();                        
 
                        $(`Sheriff`._icon).addClass(`polmrkr`);
            var PLTCTYPD = new L.marker(new L.LatLng(39.370039,-94.77987),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/police.png`, iconSize: [32, 34]}),
                        title:`marker_P10`}).addTo(fg).bindPopup(`PLTCTYPD<br>Platte City Police Department<br>355 Main St<br>Platte City, MO 64079<br><b style='color:red;'></b><br>39.370039, -94.77987,  0 Ft.<br>EM29OI`).openPopup();                        
 
                        $(`Sheriff`._icon).addClass(`polmrkr`);
            var P3 = new L.marker(new L.LatLng(39.451409,-94.787076),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S1`}).addTo(fg).bindPopup(`P3<br>P3-Camden Point (I-29 & E Hwy)<br>17805 NW Co Rd E<br>Camden Point, MO<br><b style='color:red;'></b><br>39.451409, -94.787076,  0 Ft.<br>EM29OK`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var P5 = new L.marker(new L.LatLng(39.354489,-94.766264),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S2`}).addTo(fg).bindPopup(`P5<br>P5 - QuikTrip, I-29 and 92 Hwy (Platte City)<br>QuikTrip 1850 Branch Street<br>Platte City, MO 64079<br><b style='color:red;'></b><br>39.354489, -94.766264,  0 Ft.<br>EM29OI`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var P6 = new L.marker(new L.LatLng(39.354489,-94.766264),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S3`}).addTo(fg).bindPopup(`P6<br>P6 - I-435 & NW 120th Street<br><br><br><b style='color:red;'></b><br>39.354489, -94.766264,  0 Ft.<br>EM29OI`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var P7 = new L.marker(new L.LatLng(39.307052,-94.602296),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S4`}).addTo(fg).bindPopup(`P7<br>P7 - Overpass, Cookingham Dr./291 & 435<br>Cookingham Drive/291 crossing over 435<br>Kansas City, MO<br><b style='color:red;'></b><br>39.307052, -94.602296,  0 Ft.<br>EM29QH`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var P8 = new L.marker(new L.LatLng(39.279242,-94.606069),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S5`}).addTo(fg).bindPopup(`P8<br>P8 - Platte Purchase Park<br>N Platte Purchase Dr & NW 100 St<br>Kansas City, MO 64154<br><b style='color:red;'></b><br>39.279242, -94.606069,  0 Ft.<br>EM29QG`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var P9 = new L.marker(new L.LatLng(39.245307,-94.758275),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S6`}).addTo(fg).bindPopup(`P9<br>P9 - 152 Hwy at NW I-435<br>Exit 24 on I-435<br>Kansas City, MO 64154<br><b style='color:red;'></b><br>39.245307, -94.758275,  0 Ft.<br>EM29OF`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var P10 = new L.marker(new L.LatLng(39.225043,-94.762684),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S7`}).addTo(fg).bindPopup(`P10<br>P10 - I-435 & 45 Hwy<br>Exit 22 on I-435<br>Kansas City, MO 64154<br><b style='color:red;'></b><br>39.225043, -94.762684,  0 Ft.<br>EM29OF`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var P11 = new L.marker(new L.LatLng(39.188631,-94.679035),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S8`}).addTo(fg).bindPopup(`P11<br>P11 - Park University<br>8700 NW River Park Dr<br>Parkville, MO 64152<br><b style='color:red;'></b><br>39.188631, -94.679035,  0 Ft.<br>EM29PE`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var P12 = new L.marker(new L.LatLng(39.174753,-94.624798),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S9`}).addTo(fg).bindPopup(`P12<br>P12 - Park Hill South High School, SE Parking Lot<br>4500 NW Riverpark Drive<br>Riverside, MO 64150 <br><b style='color:red;'></b><br>39.174753, -94.624798,  0 Ft.<br>EM29QE`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var P13 = new L.marker(new L.LatLng(39.170833,-94.608147),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S10`}).addTo(fg).bindPopup(`P13<br>P13 - The Palisades Subdivision-Riverside<br>4300 NW Riverview Drive<br>Riverside, MO 64150 <br><b style='color:red;'></b><br>39.170833, -94.608147,  0 Ft.<br>EM29QE`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var C1 = new L.marker(new L.LatLng(39.325553,-94.583868),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S11`}).addTo(fg).bindPopup(`C1<br>C1 - 169 & 128th Street<br><br><br><b style='color:red;'></b><br>39.325553, -94.583868,  0 Ft.<br>EM29QH`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var C2 = new L.marker(new L.LatLng(39.309645,-94.584606),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S12`}).addTo(fg).bindPopup(`C2<br>C2 - Overpass, 169 & 435<br><br><br><b style='color:red;'></b><br>39.309645, -94.584606,  0 Ft.<br>EM29QH`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var C3 = new L.marker(new L.LatLng(39.324398,-94.395751),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S13`}).addTo(fg).bindPopup(`C3<br>C3 - Overpass, 128th St. & I35<br>128th crossing over N/S i35<br><br><b style='color:red;'></b><br>39.324398, -94.395751,  0 Ft.<br>EM29TH`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var C5 = new L.marker(new L.LatLng(39.293429,-94.556897),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S14`}).addTo(fg).bindPopup(`C5<br>C5 - N. Woodland Dr. & Shoal Creek Pkwy<br>Anne Garney Park Dr<br>Kansas City, MO 64155<br><b style='color:red;'></b><br>39.293429, -94.556897,  0 Ft.<br>EM29RH`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var C6 = new L.marker(new L.LatLng(39.273379,-94.583606),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S15`}).addTo(fg).bindPopup(`C6<br>C6 - Northland Cathedral<br>101 NW 99th St<br>Kansas City, MO 64155<br><b style='color:red;'></b><br>39.273379, -94.583606,  0 Ft.<br>EM29QG`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var C7 = new L.marker(new L.LatLng(39.266411,-94.450781),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S16`}).addTo(fg).bindPopup(`C7<br>C7 - Pleasant Valley Baptist Church<br>1600 MO-291<br>Liberty, MO 64068<br><b style='color:red;'></b><br>39.266411, -94.450781,  0 Ft.<br>EM29SG`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var C8 = new L.marker(new L.LatLng(39.257306,-94.448994),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S17`}).addTo(fg).bindPopup(`C8<br>C8 - 219 Highway, .25 mile south of 291 crossing I-35 in Liberty<br>1005 MO-291<br>Liberty, MO 64068<br><b style='color:red;'></b><br>39.257306, -94.448994,  0 Ft.<br>EM29SG`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var C9 = new L.marker(new L.LatLng(39.224454,-94.499699),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S18`}).addTo(fg).bindPopup(`C9<br>C9 - Overpass, NE Shoal Creek Pkwy & 435<br>Near the Mormon Church<br><br><b style='color:red;'></b><br>39.224454, -94.499699,  0 Ft.<br>EM29SF`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var C10 = new L.marker(new L.LatLng(39.196726,-94.599145),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S19`}).addTo(fg).bindPopup(`C10<br>C10 - West Englewood Elementary School<br>1506 NW Englewood Rd<br>Kansas City, MO 64118<br><b style='color:red;'></b><br>39.196726, -94.599145,  0 Ft.<br>EM29QE`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var C11 = new L.marker(new L.LatLng(39.179323,-94.509957),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S20`}).addTo(fg).bindPopup(`C11<br>C11 - Winnetonka High School<br>5815 NE 48th St,<br>Kansas City, MO 64119<br><b style='color:red;'></b><br>39.179323, -94.509957,  0 Ft.<br>EM29RE`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var C12 = new L.marker(new L.LatLng(39.173509,-94.46439),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S21`}).addTo(fg).bindPopup(`C12<br>C12 - NE Parvin and N Arlington Ave<br>NE Parvin and N Doniphan Ave (Near Worlds/Oceans of Fun)<br>Kansas City, MO<br><b style='color:red;'></b><br>39.173509, -94.46439,  0 Ft.<br>EM29SE`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var TANEY210 = new L.marker(new L.LatLng(39.144788,-94.558242),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S22`}).addTo(fg).bindPopup(`TANEY210<br>KK1 - Taney Ave on 210 Highway<br>Taney Ave on 210 Highway<br>North Kansas City, MO<br><b style='color:red;'>HT Compatable</b><br>39.144788, -94.558242,  0 Ft.<br>EM29RD`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var CTEAUELV = new L.marker(new L.LatLng(39.150823,-94.523884),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S23`}).addTo(fg).bindPopup(`CTEAUELV<br>KK2 - Chouteau Elevator<br>4801 NE Birmingham Rd<br>Kansas City, MO 64117<br><b style='color:red;'>HT Compatible w/static</b><br>39.150823, -94.523884,  0 Ft.<br>EM29RD`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
            var HWY291on210 = new L.marker(new L.LatLng(39.18423,-94.396235),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S24`}).addTo(fg).bindPopup(`HWY291on210<br>KK3 - Highway 210 @ Highway 291<br><br>Kansas City, MO 64117<br><b style='color:red;'>HT Compatible w/static</b><br>39.18423, -94.396235,  0 Ft.<br>EM29TE`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
var EOCList = L.layerGroup([W0KCN4, W0KCN3, W0KCN15, NARESEOC]);var FireList = L.layerGroup([RVRSDEFD, KCMOFS3, KCMOFS4, KCMOFS5, KCMOFS6, KCMOFS7, KCMOFS8, KCMOFS10, KCMOFS16, KCMOFS17, KCMOFS18, KCMOFS19, KCMOFS23, KCMOFS24, KCMOFS25, KCMOFS27, KCMOFS29, KCMOFS30, KCMOFS33, KCMOFS34, KCMOFS35, KCMOFS37, KCMOFS38, KCMOFS39, KCMOFS40, KCMOFS41, KCMOFS43, KCMOFS44, KCMOFS47, KCMOFS14, RVRSFD]);var HospitalList = L.layerGroup([KINDRD, LIBRTY, NORKC, PMC, RESRCH, SMMC, STLSMI, STLUBR, TRLKWD]);var RepeaterList = L.layerGroup([WA0QFJ, WA0KHP, KCRKW1, KCRJCRAC1, KCRWW, KCRQFJ, KCRMED]);var SheriffList = L.layerGroup([CCSHERIFF, NRTPD, RVRSPD, PKVLPD, LKWKPD, GSTNPD, NKCPD, COMOPD, KCNPPD, PLTCTYPD]);var SkyWarnList = L.layerGroup([P3, P5, P6, P7, P8, P9, P10, P11, P12, P13, C1, C2, C3, C5, C6, C7, C8, C9, C10, C11, C12, TANEY210, CTEAUELV, HWY291on210]); var W0DLK01 = new L.marker(new L.LatLng(39.202903,-94.602897),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker01.png', iconSize: [32, 34]}),
                            title:`marker_O01`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK01<br></div><div class='gg'>W3W: easily.hardest.ended </div><br><div class='cc'>Comment:<br> across the street from home</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 60th Ct </div><br><div class='gg'>39.202903,-94.602897<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:31:26</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK02 = new L.marker(new L.LatLng(39.202876,-94.602445),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker02.png', iconSize: [32, 34]}),
                            title:`marker_O02`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK02<br></div><div class='gg'>W3W: mathematics.seasonal.eaters </div><br><div class='cc'>Comment:<br> red door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 60th Ct </div><br><div class='gg'>39.202876,-94.602445<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:32:17</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK03 = new L.marker(new L.LatLng(39.202579,-94.60241),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker03.png', iconSize: [32, 34]}),
                            title:`marker_O03`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK03<br></div><div class='gg'>W3W: typhoon.barrage.knots </div><br><div class='cc'>Comment:<br> green door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 60th Ct </div><br><div class='gg'>39.202579,-94.60241<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:32:50</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK04 = new L.marker(new L.LatLng(39.202418,-94.601923),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker04.png', iconSize: [32, 34]}),
                            title:`marker_O04`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK04<br></div><div class='gg'>W3W: sufferings.shifters.truffles </div><br><div class='cc'>Comment:<br> blue door</div><br><div class='bb'><br>Cross Roads:<br>NW 60th Ct &amp; N Ames Ave </div><br><div class='gg'>39.202418,-94.601923<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:34:15</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK05 = new L.marker(new L.LatLng(39.201636,-94.601749),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker05.png', iconSize: [32, 34]}),
                            title:`marker_O05`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK05<br></div><div class='gg'>W3W: dished.relaxation.marked </div><br><div class='cc'>Comment:<br> white door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 59 St </div><br><div class='gg'>39.201636,-94.601749<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:34:34</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK06 = new L.marker(new L.LatLng(39.200908,-94.601471),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker06.png', iconSize: [32, 34]}),
                            title:`marker_O06`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK06<br></div><div class='gg'>W3W: posters.sheep.pretty </div><br><div class='cc'>Comment:<br> who know?</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 59 St </div><br><div class='gg'>39.200908,-94.601471<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:34:58</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK07 = new L.marker(new L.LatLng(39.200639,-94.601471),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker07.png', iconSize: [32, 34]}),
                            title:`marker_O07`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK07<br></div><div class='gg'>W3W: evolves.shorthand.doorway </div><br><div class='cc'>Comment:<br> red door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 59 St </div><br><div class='gg'>39.200639,-94.601471<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:35:28</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK08 = new L.marker(new L.LatLng(39.200477,-94.601471),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker08.png', iconSize: [32, 34]}),
                            title:`marker_O08`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK08<br></div><div class='gg'>W3W: strawberry.aunts.frocks </div><br><div class='cc'>Comment:<br> green door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 59 St </div><br><div class='gg'>39.200477,-94.601471<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:35:43</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK09 = new L.marker(new L.LatLng(39.19948,-94.601471),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker09.png', iconSize: [32, 34]}),
                            title:`marker_O09`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK09<br></div><div class='gg'>W3W: enjoys.gallery.served </div><br><div class='cc'>Comment:<br> pink door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 58 Ct </div><br><div class='gg'>39.19948,-94.601471<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:36:04</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK10 = new L.marker(new L.LatLng(39.198779,-94.601541),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker10.png', iconSize: [32, 34]}),
                            title:`marker_O10`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK10<br></div><div class='gg'>W3W: trill.photons.pills </div><br><div class='cc'>Comment:<br> purple door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 57 Ct </div><br><div class='gg'>39.198779,-94.601541<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:36:23</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK11 = new L.marker(new L.LatLng(39.198159,-94.601576),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker11.png', iconSize: [32, 34]}),
                            title:`marker_O11`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK11<br></div><div class='gg'>W3W: spray.shudder.opting </div><br><div class='cc'>Comment:<br> yellow door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 57 Ct </div><br><div class='gg'>39.198159,-94.601576<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:36:45</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK12 = new L.marker(new L.LatLng(39.197539,-94.602375),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker12.png', iconSize: [32, 34]}),
                            title:`marker_O12`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK12<br></div><div class='gg'>W3W: bogus.daunted.overlapping </div><br><div class='cc'>Comment:<br> door is missing</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; 56th </div><br><div class='gg'>39.197539,-94.602375<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:37:04</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK13 = new L.marker(new L.LatLng(39.197647,-94.602689),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker13.png', iconSize: [32, 34]}),
                            title:`marker_O13`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK13<br></div><div class='gg'>W3W: confirm.backer.ministries </div><br><div class='cc'>Comment:<br> get the time</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; 56th </div><br><div class='gg'>39.197647,-94.602689<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:39:42</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK14 = new L.marker(new L.LatLng(39.197782,-94.602167),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker14.png', iconSize: [32, 34]}),
                            title:`marker_O14`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK14<br></div><div class='gg'>W3W: collateral.tomorrow.flop </div><br><div class='cc'>Comment:<br> flop my ass</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; 56th </div><br><div class='gg'>39.197782,-94.602167<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:39:59</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK15 = new L.marker(new L.LatLng(39.197917,-94.601923),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker15.png', iconSize: [32, 34]}),
                            title:`marker_O15`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK15<br></div><div class='gg'>W3W: vindicated.hygiene.doing </div><br><div class='cc'>Comment:<br> pink door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; 56th </div><br><div class='gg'>39.197917,-94.601923<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:40:20</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK16 = new L.marker(new L.LatLng(39.19851,-94.601784),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker16.png', iconSize: [32, 34]}),
                            title:`marker_O16`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK16<br></div><div class='gg'>W3W: scorching.hygiene.spurned </div><br><div class='cc'>Comment:<br> blue door</div><br><div class='bb'><br>Cross Roads:<br>NW 57 Ct &amp; N Ames Ave </div><br><div class='gg'>39.19851,-94.601784<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:40:34</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK17 = new L.marker(new L.LatLng(39.199022,-94.601715),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker17.png', iconSize: [32, 34]}),
                            title:`marker_O17`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK17<br></div><div class='gg'>W3W: puts.available.folder </div><br><div class='cc'>Comment:<br> pole in road</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 57 Ct </div><br><div class='gg'>39.199022,-94.601715<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:40:51</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK18 = new L.marker(new L.LatLng(39.199534,-94.601715),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker18.png', iconSize: [32, 34]}),
                            title:`marker_O18`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK18<br></div><div class='gg'>W3W: buckets.tumblers.rehearsing </div><br><div class='cc'>Comment:<br> tree in driveway</div><br><div class='bb'><br>Cross Roads:<br>NW 58 Ct &amp; N Ames Ave </div><br><div class='gg'>39.199534,-94.601715<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:41:09</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK19 = new L.marker(new L.LatLng(39.200127,-94.601715),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker19.png', iconSize: [32, 34]}),
                            title:`marker_O19`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK19<br></div><div class='gg'>W3W: forecast.snack.upshot </div><br><div class='cc'>Comment:<br> tree on roof of house</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 58 Ct </div><br><div class='gg'>39.200127,-94.601715<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:41:26</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK20 = new L.marker(new L.LatLng(39.200558,-94.601715),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker20.png', iconSize: [32, 34]}),
                            title:`marker_O20`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK20<br></div><div class='gg'>W3W: ever.insects.monarch </div><br><div class='cc'>Comment:<br> used spaces</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 59 St </div><br><div class='gg'>39.200558,-94.601715<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:41:39</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK21 = new L.marker(new L.LatLng(39.201474,-94.601889),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker21.png', iconSize: [32, 34]}),
                            title:`marker_O21`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK21<br></div><div class='gg'>W3W: spinach.spaceship.scouts </div><br><div class='cc'>Comment:<br> Boy Scouts in the airea</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 59 St </div><br><div class='gg'>39.201474,-94.601889<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:42:40</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                        var W0DLK22 = new L.marker(new L.LatLng(39.202013,-94.602515),{
                            rotationAngle: 0, 
                            rotationOrigin: 'bottom', 
                            opacity: 0.75,
                            contextmenu: true, 
                            contextmenuWidth: 140,
                            contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                            
                            icon: L.icon({iconUrl: 'images/markers/marker22.png', iconSize: [32, 34]}),
                            title:`marker_O22`}).addTo(fg).bindPopup(`<div class='xx'>W0DLK22<br></div><div class='gg'>W3W: peanuts.cafeteria.hamstrings </div><br><div class='cc'>Comment:<br> food on the table</div><br><div class='bb'><br>Cross Roads:<br>N Bedford Ave &amp; N Ames Ave </div><br><div class='gg'>39.202013,-94.602515<br>Grid: EM29QE<br><br>Captured:<br>2021-04-18 19:42:57</div>`).openPopup();                    
                            
                            $('Objects'._icon).addClass('objmrkr'); 
                                       
                      ;
var OBJMarkerList = L.layerGroup([W0DLK01,W0DLK02,W0DLK03,W0DLK04,W0DLK05,W0DLK06,W0DLK07,W0DLK08,W0DLK09,W0DLK10,W0DLK11,W0DLK12,W0DLK13,W0DLK14,W0DLK15,W0DLK16,W0DLK17,W0DLK18,W0DLK19,W0DLK20,W0DLK21,W0DLK22,]);var callsList = L.layerGroup([WA0TJT, W0DLK]);

// Define a PoiIcon class
var PoiIconClass = L.Icon.extend({
    options: {
        iconSize: [32, 37]
    }
});

// Define a PoiIcon class
var ObjIconClass = L.Icon.extend({
    options: {
        iconSize: [32, 37]
    }
});

// Create five icons from the above PoiIconClass class
var firstaidicon = new PoiIconClass({iconUrl: 'images/markers/firstaid.png'}),
    eocicon = new PoiIconClass({iconUrl: 'images/markers/eoc.png'}),
    policeicon = new PoiIconClass({iconUrl: 'images/markers/police.png'}),
    skywarnicon = new PoiIconClass({iconUrl: 'images/markers/skywarn.png'}),
    fireicon = new PoiIconClass({iconUrl: 'images/markers/fire.png'}),
    repeatericon = new PoiIconClass({iconUrl: 'markers/repeater.png'}),
    blueFlagicon = new PoiIconClass({iconUrl: 'images/markers/blue_50_flag.png'});

var Stations = L.layerGroup([WA0TJT,W0DLK]);

    // Define the map
    const map = L.map('map', {
    	drawControl: true,
		zoom: 12
	}); 
	
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
      
// The overlay markers to show by default                 
Stations.addTo(map);
OBJMarkerList.addTo(map);

// Temp markers to mark the corners of the viewable map, uncomment to use
		

var bounds = L.latLngBounds([[39.2028965,-94.602876],[39.2028965,-94.602876]]); 
var middle = bounds.getCenter(); // alert(middle); //LatLng(-93.20448, 38.902475)
var padit  = bounds.pad(.075);   // add a little bit to the corner bounding box
var sw = padit.getSouthWest();   // get the SouthWest most point
var nw = padit.getNorthWest();
var ne = padit.getNorthEast();
var se = padit.getSouthEast();

var redmarkername = "images/markers/red_50_flag.png";
var bluemarkername = "images/markers/blue_50_flag.png";

    // These are the corner markers of the extended bounds of the stations
    var mk1 = new L.marker(new L.latLng( sw ),{
        icon: L.icon({iconUrl: bluemarkername , iconSize: [32,36] }),
        title:'mk1'}).addTo(map).bindPopup('MK1<br>The SW Corner<br>'+sw).openPopup();
    
    var mk2 = new L.marker(new L.latLng( nw ),{
       icon: L.icon({iconUrl: bluemarkername , iconSize: [32,36] }),
       title:'mk2'}).addTo(map).bindPopup('MK2<br>The NW Corner<br>'+nw).openPopup();
    
    var mk3 = new L.marker(new L.latLng( ne ),{
       icon: L.icon({iconUrl: bluemarkername , iconSize: [32,36] }),
       title:'mk3'}).addTo(map).bindPopup('MK3<br>The NE Corner<br>'+ne).openPopup();
    
    var mk4 = new L.marker(new L.latLng( se ),{
       icon: L.icon({iconUrl: bluemarkername , iconSize: [32,36] }),
       title:'mk4'}).addTo(map).bindPopup('MK4<br>The SE Corner<br>'+se).openPopup();
	
    // Add the temp center marker to the map here in the javascript code allows it to use the current map view,
    // When its earlier in the stack, it centers on our house becaue that is the default map location
    var mk5 = new L.marker(new L.latLng( middle ),{
        contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
        text: 'Click here to add mileage circles', callback: circleKoords}],   
        icon: L.icon({iconUrl: redmarkername , iconSize: [32, 36] }),     
        title:'mk5'}).addTo(map).bindPopup('MK5<br>The Center Marker<br>'+middle).openPopup();
    
    // Definition of the 5 markers above, corners plus middle    
    var CornerList = L.layerGroup([mk1, mk2, mk3, mk4, mk5]);

// From poiMarkers.php
//var listfrompioMarkers = 'EOCL,FireL,HospitalL,RepeaterL,SheriffL,SkyWarnL,'; 
//var classList = listfrompioMarkers.split(",");
var classList = 'EOCL,FireL,HospitalL,RepeaterL,SheriffL,SkyWarnL,  ObjectL, CornerL'.split(','); //alert(classList); // EOCL,FireL,HospitalL,RepeaterL,SheriffL,SkyWarnL,
// var classList = 'EOCL,FireL,HospitalL,RepeaterL,SheriffL,SkyWarnL,ObjectL,CornerL'.split(',');
   // alert(classList);
   //console.log(classList);

let station = {"<img src='markers/green_marker_hole.png' class='greenmarker' alt='green_marker_hole' align='middle' /><span class='biggreenmarker'> Stations</span>": Stations};

// Each test below if satisfied creates a javascript object, each one connects the previous to the next 
var y = {...station};
var x;
for (x of classList) {

    if (x == 'EOCL') {
        let EOC = {"<img src='images/markers/eoc.png' align='middle' /> <span class='eocmarker'>EOC</span>": EOCList};
        y = {...y, ...EOC};     
        
    }else if (x == 'FireL') {
        let Fire = {"<img src='images/markers/fire.png' align='middle' /> <span class='firemarker'>Fire Station</span>": FireList};
        y = {...y, ...Fire};
        
    }else if (x == 'HospitalL') {
        let Hospital = {"<img src='images/markers/firstaid.png' align='middle' /> <span class='hosmarker'>Hospitals</span>": HospitalList};
        y = {...y, ...Hospital};
        
    }else if (x == 'SheriffL') {
        let Sheriff = {"<img src='images/markers/police.png' width='32' height='37' align='middle' /> <span class='polmarker'>Police</span>":  SheriffList};
        y = {...y,...Sheriff};
        
    }else if (x == 'RepeaterL') {
        let Repeater = {"<img src='images/markers/repeater.png' align='middle' /> <span class='rptmarker'>Repeaters</span>": RepeaterList};
        y = {...y, ...Repeater};
        
    }else if (x == 'SkyWarnL') {
        let SkyWarn = {"<img src='images/markers/skywarn.png' align='middle' /> <span class='skymarker'>SkyWarn</span>": SkyWarnList};
        y = {...y, ...SkyWarn};     
        
    }else if (x == ' ObjectL') {
        let Objects = {"<img src='images/markers/marker00.png' align='middle' /> <span class='objmrkrs'>Objects</span>": ObjectsList};
        y = {...y, ...Objects};    //console.log(ObjectsList);
        
    }else if (x == ' CornerL') {
        let Corners = {"<img src='images/markers/red_50_flag.png' align='middle' /> <span class='corners'>Corners</span>":
            CornerList};
        y = {...y, ...Corners};
    }}; 
    
    
    
// Here we add the station object with the merged y objects from above
var overlayMaps = {...y };  //alert(JSON.stringify(overlayMaps));

//console.log(overlayMaps);

// Set the center point of the map based on the coordinates
map.fitBounds([[39.2028965,-94.602876],[39.2028965,-94.602876]], {
  pad: 0.5
});

L.control.layers(baseMaps, overlayMaps, {position:'bottomright', collapsed:false}).addTo(map);


// Define the Plus and Minus for zooming and its location
map.scrollWheelZoom.disable();  // prevents the map from zooming with the mouse wheel

//var arcgisOnline = L.esri.Geocoding.arcgisOnlineProvider();

// Add what3words, shows w3w in a control
var w = new L.Control.w3w();
	w.addTo(map);
	map.on('click', function(e) {
		console.log(e);
		w.setCoordinates(e);
	});
	
// Adds a temp marker popup to show location of click
var popup = L.popup();
function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at:<br>" + e.latlng.toString() + "<br>"  )
        .openOn(map);
}
map.on('click', onMapClick);



// adds the lat/lon grid lines
L.grid().addTo(map);  

// Add the lat/lon mouse position 
L.control.mousePosition({separator:',',position:'topright',prefix:''}).addTo(map);

 // https://github.com/ppete2/Leaflet.PolylineMeasure
        // Position to show the control. Values: 'topright', 'topleft', 'bottomright', 'bottomleft'
        // Show imperial or metric distances. Values: 'metres', 'landmiles', 'nauticalmiles'
    L.control.polylineMeasure ({position:'topright', unit:'landmiles', showBearings:true, clearMeasurementsOnStop: false, showClearControl: true, showUnitControl: true}).addTo (map);
     
      // Same as above but does NOT includes a mi for miles box or other measures
  //  L.control.scale ({maxWidth:240, metric:false, imperial:true, position: 'bottomleft'}).addTo (map);
   //         L.control.polylineMeasure ({position:'topright', unit:'landmiles', showBearings:false, clearMeasurementsOnStop: false, showClearControl: true, showUnitControl: false}).addTo (map);

// To use the getCenter() of latLngBounds you need to set a var = to it, then define it in another var
//var bounds = L.latLngBounds([[39.4528965, -94.852876], [39.4528965, -94.352876 ], [38.9528965, -94.352876 ], [38.9528965, -94.852876 ], [39.4528965, -94.852876]]); 
//var middle = bounds.getCenter();
//var sw = bounds.getSouthWest();       
//var E  = bounds.getEast();  
//var tBBS = bounds.toBBoxString();
//alert('tBBS: '+tBBS);                   // 38.8183241,-95.433417,39.5697989,-94.259896
//alert('E: '+E);                         // 39.5697989
//alert('sw: '+sw);                       // LatLng(-95.433417, 38.818324)
//alert('middle: '+middle);               // LatLng(-94.846656, 39.194062)
//alert('Map middle: '+map.getCenter());  // LatLng(39.194424, -94.846656)


var circfeqcnt = 0; // Sets a variable to count how many times the circleKoords() function is called
function circleKoords(e) {
   circfeqcnt = circfeqcnt + 1; //alert(circfeqcnt);
    
   if (circfeqcnt <= 1) { var circolor  = 'blue';  }
   else if (circfeqcnt == 2) { var circolor  = 'red'; }
   else if (circfeqcnt == 3) { var circolor  = 'green'; }
   else if (circfeqcnt == 4) { var circolor  = 'yellow'; }
   else if (circfeqcnt > 4) { var circolor  = 'purple'; }
   
   var myJSON = JSON.stringify(e.latlng); 
   //alert("myJSON "+myJSON); 
   
   var LatLng = e.latlng;
   var lat = e.latlng["lat"]; 
   var lng = e.latlng["lng"]; 
   
   var i; var j;
   var r = 1609.34;  // in meters = 1 mile, 4,828.03 meters in 3 miles
   
   //https://jsfiddle.net/3u09g2mf/2/   
   //https://gis.stackexchange.com/questions/240169/leaflet-onclick-add-remove-circles
   var group1 = L.featureGroup(); // Allows us to group the circles for easy removal
   
   var circleOptions = {
       color: circolor,
       fillOpacity: 0.005 ,
       fillColor: '#69e'
   }  
   
   var milesbetween = 0; 
   var numberofrings = 0;  
   
   
   // This routine sets a default number of miles between circles and the number of circles
   // Based on the number of circles selected and marker that was clicked it calculates 
   // the distance to the furthest corner and returns an appropriate number of circles
   // to draw to reach it, auto magically.
   // Variable mbc is the default number of miles between circles.
   // Variable nor is the calculated number of cirles. Based on the furthest corner from the clicked marker.
   var mbc = 5; // Overall default for miles between circles
      
      // Calculate distance from clicked marker to each of the corner markers
   var nor = Math.max( LatLng.distanceTo( se ), LatLng.distanceTo( ne ), 
                       LatLng.distanceTo( nw ), LatLng.distanceTo( sw ))/1609.34;
            // Set the new calculated distance between markers, 5 is the default mbc
        if (nor >= 50) {mbc = 25;}
        else if (nor <= 10) {mbc = 2;}
        else {mbc = 5;}
      
   var milesbetween = prompt("How many miles between circles?", mbc);
   		if (milesbetween <= 0) {milesbetween = 1;} 
   		//if (milesbetween > 0 && milesbetween <= 10) {milesbetween = 2;}
   		
   var nor = nor/milesbetween;
   
   var numberofrings = prompt("How many circles do you want to see?", Math.round(nor));
   		if (numberofrings <= 0) {numberofrings = 5;}	
   		
    
   angle1 = 90;  // mileage boxes going East
   angle2 = 270; // mileage boxes going West
   angle3 = 0;   // degree markers
   
     
   // The actual circles are created here at the var Cname =
   for (i=0 ; i < numberofrings; i++ ) {
         var Cname = 'circle'+i; 
            r = (r * i) + r; 
            r = r*milesbetween; //alert(Cname r);
         var Cname = L.circle([lat, lng], r, circleOptions);
            Cname.addTo(group1); 
          map.addLayer(group1);
         //90° from top
                  // angle1, angle2 puts the mileage markers on the lines p_c1 and p_c2
         angle1 = angle1 + 10;
         angle2 = angle2 + 10;
         
            // i is the number of rings, depending how many have been requested the delta between bears
            // will be adjusted from 15 degrees at the 2nd circle to 5 degrees at the furthest.
            if ( i === 0  ) { //alert(numberofrings);
                for (j=0; j < 360; j+=20) {
                    // j in the icon definition is the degrees 
                    var p_c0 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle3,r);
                    var icon = L.divIcon({ className: 'deg-marger', html: j , iconSize: [40,null] });
                    var marker0 = L.marker(p_c0, { title: 'degrees', icon: icon});
                        marker0.addTo(map);
                            angle3 = angle3 + 20;
                }
            }   else if ( i === 5 ) {
                    for (j=0; j < 360; j+=10) {
                    // j in the icon definition is the degrees 
                    var p_c0 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle3,r);
                    var icon = L.divIcon({ className: 'deg-marger', html: j , iconSize: [40,null] });
                    var marker0 = L.marker(p_c0, { title: 'degrees', icon: icon});
                        marker0.addTo(map);
                            angle3 = angle3 + 10;
                }         
            }   else if ( i === 2 ) {
                    for (j=0; j < 360; j+=10) {
                    // j in the icon definition is the degrees 
                    var p_c0 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle3,r);
                    var icon = L.divIcon({ className: 'deg-marger', html: j , iconSize: [40,null] });
                    var marker0 = L.marker(p_c0, { title: 'degrees', icon: icon});
                        marker0.addTo(map);
                            angle3 = angle3 + 10;
                }
            }   else if ( i === numberofrings-1 ) {
                    for (j=0; j < 360; j+=5) {
                    // j in the icon definition is the degrees 
                    var p_c0 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle3,r);
                    var icon = L.divIcon({ className: 'deg-marger', html: j , iconSize: [40,null] });
                    var marker0 = L.marker(p_c0, { title: 'degrees', icon: icon});
                        marker0.addTo(map);
                            angle3 = angle3 + 5;
                } // End for loop         
            } // end of else if
        
         var p_c1 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle1,r);
         var p_c2 = L.GeometryUtil.destination(L.latLng([lat, lng]),angle2,r);
         //var inMiles = (toFixed(0)/1609.34)*.5;
         var inMiles = Math.round(r.toFixed(0)/1609.34);
         var inKM = Math.round(r.toFixed(0)/1000);
         // Put mile markers on the circles
         
         var icon = L.divIcon({ className: 'dist-marker-'+circolor, html: inMiles+' Mi <br> '+inKM+' Km', iconSize: [60, null] });
         
         var marker = L.marker(p_c1, { title: inMiles+'Miles', icon: icon});
         var marker2 = L.marker(p_c2, { title: inMiles+'Miles', icon: icon});
      
         //$(".dist-marker").css("color", circolor);
         marker.addTo(map);
         marker2.addTo(map);
         //$(".dist-marker").css("color", circolor);
         
        // reset r so r calculation above works for each 1 mile step 
        r = 1609.34;     
    }
    
    // This part allows us to delete the circles by simply clicking anywhere in the circles.
    group1.on('click', function() {
        if(map.hasLayer(group1)) {map.removeLayer(group1);}
    });
} // end circleKoords function


// Change the position of the Zoom Control to a newly created placeholder.
map.zoomControl.setPosition('topright');

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
	    

</script>

</body>
</html>

