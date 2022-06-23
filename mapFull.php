<!DOCTYPE html>

<!-- Primary maping program, also uses poiMarkers.php, objMarkers.php and stationMarkers.php -->


<html lang="en">
<head>
	<!-- https://esri.github.io/esri-leaflet/tutorials/create-your-first-app.html -->
	<title>NCM Map of Station Locations</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon-32x32.png" >
	<!--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    -->
     <!-- ******************************** Load LEAFLET from CDN *********************************** -->
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
     integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
     crossorigin=""/>
     
     <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
         integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
             crossorigin=""></script>
     <!-- ********************************* End Load LEAFLET **************************************** -->
     
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
    
    <script src="js/circleKoords.js"></script>
    
    
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
        
        .leaflet-control-zoom {
           
        }
        
		
	</style>
	
</head>

<body>
    
    <!-- the map div holds the map -->
    <div id="map"></div>
    
    <!-- the stations div holds a list of the stations marked on the map -->
    <div id="stations"> 
		<b style="color:red; text-decoration: underline;">TE0ST
    		</b><br><a class='rowno' id='marker_1' href='#'>1 WA0TJT</a><br><a class='rowno' id='marker_2' href='#'>2 W0DLK</a><br><a class='rowno' id='marker_3' href='#'>3 KD0NBH</a><br><a class='rowno' id='marker_4' href='#'>4 KC0YT</a><br><a class='rowno' id='marker_5' href='#'>5 AA0JX</a><br>	</div>

    <!-- The title banner -->
    <div id="activity" class="activity">
    	<img src="images/NCM.png" alt="NCM" style="width: 35px; padding-left: 10px; padding-top: 5px;">
    	TE0ST Net #3818 For Testing Only Testing new Object Map     </div>
    
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

			var WA0TJT = new L.marker(new L.LatLng(39.201825,-94.602723),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedDivIcon({number: '1' }),
				title:`marker_1` }).addTo(fg).bindPopup(`
				<div>1<br><b>WA0TJT</b><br> ID: #0013<br>Keith Kaiser<br>Platte Co., MO Dist: A<br>39.201825, -94.602723<br>EM29QE<br>forthright.valid.protects</div><br>
                <div class='cc'>Show Cross Roads</div>
                `).openPopup();
				
				$(`WA0TJT`._icon).addClass(`bluemrkr`); 
                stationMarkers.push(WA0TJT);
				
			var W0DLK = new L.marker(new L.LatLng(39.2028965,-94.602876),{ 
			    rotationAngle: 0,
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
				
			var KD0NBH = new L.marker(new L.LatLng(39.204385,-94.606862),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '3' }),
				title:`marker_3` }).addTo(fg).bindPopup(`
				<div>3<br><b>KD0NBH</b><br> ID: #1812<br>John Britton<br>Clay Co., MO Dist: A<br>39.204385, -94.606862<br>EM29QE<br>craving.since.duchess</div><br>
                <div class='cc'>Show Cross Roads</div>
                `).openPopup();
				
				$(`KD0NBH`._icon).addClass(`greenmrkr`); 
                stationMarkers.push(KD0NBH);
				
			var KC0YT = new L.marker(new L.LatLng(39.2002636,-94.641221),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '4' }),
				title:`marker_4` }).addTo(fg).bindPopup(`
				<div>4<br><b>KC0YT</b><br> ID: #0050<br>Charlotte Hoverder<br>Platte Co., MO Dist: A<br>39.2002636, -94.641221<br>EM29QE<br>divider.hooking.altering</div><br>
                <div class='cc'>Show Cross Roads</div>
                `).openPopup();
				
				$(`KC0YT`._icon).addClass(`greenmrkr`); 
                stationMarkers.push(KC0YT);
				
			var AA0JX = new L.marker(new L.LatLng(39.2232199,-94.568932),{ 
			    rotationAngle: 0,
			    rotationOrigin: 'bottom',
    			contextmenu: true,
			    contextmenuWidth: 140,
			    contextmenuItems: [{ text: 'Click here to add mileage circles', callback: circleKoords}],  
			                 
				icon: new L.NumberedGreenDivIcon({number: '5' }),
				title:`marker_5` }).addTo(fg).bindPopup(`
				<div>5<br><b>AA0JX</b><br> ID: #0270<br>Mike Mc Donald<br>Clay Co., MO Dist: A<br>39.2232199, -94.568932<br>EM29RF<br>begins.theme.locals</div><br>
                <div class='cc'>Show Cross Roads</div>
                `).openPopup();
				
				$(`AA0JX`._icon).addClass(`greenmrkr`); 
                stationMarkers.push(AA0JX);
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
            var P4 = new L.marker(new L.LatLng(39.387704,-94.880363),{ 
                        rotationAngle: 0,
                        rotationOrigin: 'bottom',
                        opacity: 0.75,
                        contextmenu: true, 
                        contextmenuWidth: 140,
                        contextmenuItems: [{ text: 'Click here to add mileage circles',
                            callback: circleKoords}],
                     
                        icon: L.icon({iconUrl: `images/markers/skywarn.png`, iconSize: [32, 34]}),
                        title:`marker_S2`}).addTo(fg).bindPopup(`P4<br>P4-West Bend State Park, Scenic Overlook<br>State Park, Weston Bend<br>Weston, MO<br><b style='color:red;'></b><br>39.387704, -94.880363,  0 Ft.<br>EM29NJ`).openPopup();                        
 
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
                        title:`marker_S3`}).addTo(fg).bindPopup(`P5<br>P5 - QuikTrip, I-29 and 92 Hwy (Platte City)<br>QuikTrip 1850 Branch Street<br>Platte City, MO 64079<br><b style='color:red;'></b><br>39.354489, -94.766264,  0 Ft.<br>EM29OI`).openPopup();                        
 
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
                        title:`marker_S4`}).addTo(fg).bindPopup(`P6<br>P6 - I-435 & NW 120th Street<br><br><br><b style='color:red;'></b><br>39.354489, -94.766264,  0 Ft.<br>EM29OI`).openPopup();                        
 
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
                        title:`marker_S5`}).addTo(fg).bindPopup(`P7<br>P7 - Overpass, Cookingham Dr./291 & 435<br>Cookingham Drive/291 crossing over 435<br>Kansas City, MO<br><b style='color:red;'></b><br>39.307052, -94.602296,  0 Ft.<br>EM29QH`).openPopup();                        
 
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
                        title:`marker_S6`}).addTo(fg).bindPopup(`P8<br>P8 - Platte Purchase Park<br>N Platte Purchase Dr & NW 100 St<br>Kansas City, MO 64154<br><b style='color:red;'></b><br>39.279242, -94.606069,  0 Ft.<br>EM29QG`).openPopup();                        
 
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
                        title:`marker_S7`}).addTo(fg).bindPopup(`P9<br>P9 - 152 Hwy at NW I-435<br>Exit 24 on I-435<br>Kansas City, MO 64154<br><b style='color:red;'></b><br>39.245307, -94.758275,  0 Ft.<br>EM29OF`).openPopup();                        
 
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
                        title:`marker_S8`}).addTo(fg).bindPopup(`P10<br>P10 - I-435 & 45 Hwy<br>Exit 22 on I-435<br>Kansas City, MO 64154<br><b style='color:red;'></b><br>39.225043, -94.762684,  0 Ft.<br>EM29OF`).openPopup();                        
 
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
                        title:`marker_S9`}).addTo(fg).bindPopup(`P11<br>P11 - Park University<br>8700 NW River Park Dr<br>Parkville, MO 64152<br><b style='color:red;'></b><br>39.188631, -94.679035,  0 Ft.<br>EM29PE`).openPopup();                        
 
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
                        title:`marker_S10`}).addTo(fg).bindPopup(`P12<br>P12 - Park Hill South High School, SE Parking Lot<br>4500 NW Riverpark Drive<br>Riverside, MO 64150 <br><b style='color:red;'></b><br>39.174753, -94.624798,  0 Ft.<br>EM29QE`).openPopup();                        
 
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
                        title:`marker_S11`}).addTo(fg).bindPopup(`P13<br>P13 - The Palisades Subdivision-Riverside<br>4300 NW Riverview Drive<br>Riverside, MO 64150 <br><b style='color:red;'></b><br>39.170833, -94.608147,  0 Ft.<br>EM29QE`).openPopup();                        
 
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
                        title:`marker_S12`}).addTo(fg).bindPopup(`C1<br>C1 - 169 & 128th Street<br><br><br><b style='color:red;'></b><br>39.325553, -94.583868,  0 Ft.<br>EM29QH`).openPopup();                        
 
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
                        title:`marker_S13`}).addTo(fg).bindPopup(`C2<br>C2 - Overpass, 169 & 435<br><br><br><b style='color:red;'></b><br>39.309645, -94.584606,  0 Ft.<br>EM29QH`).openPopup();                        
 
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
                        title:`marker_S14`}).addTo(fg).bindPopup(`C3<br>C3 - Overpass, 128th St. & I35<br>128th crossing over N/S i35<br><br><b style='color:red;'></b><br>39.324398, -94.395751,  0 Ft.<br>EM29TH`).openPopup();                        
 
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
                        title:`marker_S15`}).addTo(fg).bindPopup(`C5<br>C5 - N. Woodland Dr. & Shoal Creek Pkwy<br>Anne Garney Park Dr<br>Kansas City, MO 64155<br><b style='color:red;'></b><br>39.293429, -94.556897,  0 Ft.<br>EM29RH`).openPopup();                        
 
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
                        title:`marker_S16`}).addTo(fg).bindPopup(`C6<br>C6 - Northland Cathedral<br>101 NW 99th St<br>Kansas City, MO 64155<br><b style='color:red;'></b><br>39.273379, -94.583606,  0 Ft.<br>EM29QG`).openPopup();                        
 
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
                        title:`marker_S17`}).addTo(fg).bindPopup(`C7<br>C7 - Pleasant Valley Baptist Church<br>1600 MO-291<br>Liberty, MO 64068<br><b style='color:red;'></b><br>39.266411, -94.450781,  0 Ft.<br>EM29SG`).openPopup();                        
 
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
                        title:`marker_S18`}).addTo(fg).bindPopup(`C8<br>C8 - 219 Highway, .25 mile south of 291 crossing I-35 in Liberty<br>1005 MO-291<br>Liberty, MO 64068<br><b style='color:red;'></b><br>39.257306, -94.448994,  0 Ft.<br>EM29SG`).openPopup();                        
 
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
                        title:`marker_S19`}).addTo(fg).bindPopup(`C9<br>C9 - Overpass, NE Shoal Creek Pkwy & 435<br>Near the Mormon Church<br><br><b style='color:red;'></b><br>39.224454, -94.499699,  0 Ft.<br>EM29SF`).openPopup();                        
 
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
                        title:`marker_S20`}).addTo(fg).bindPopup(`C10<br>C10 - West Englewood Elementary School<br>1506 NW Englewood Rd<br>Kansas City, MO 64118<br><b style='color:red;'></b><br>39.196726, -94.599145,  0 Ft.<br>EM29QE`).openPopup();                        
 
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
                        title:`marker_S21`}).addTo(fg).bindPopup(`C11<br>C11 - Winnetonka High School<br>5815 NE 48th St,<br>Kansas City, MO 64119<br><b style='color:red;'></b><br>39.179323, -94.509957,  0 Ft.<br>EM29RE`).openPopup();                        
 
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
                        title:`marker_S22`}).addTo(fg).bindPopup(`C12<br>C12 - NE Parvin and N Arlington Ave<br>NE Parvin and N Doniphan Ave (Near Worlds/Oceans of Fun)<br>Kansas City, MO<br><b style='color:red;'></b><br>39.173509, -94.46439,  0 Ft.<br>EM29SE`).openPopup();                        
 
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
                        title:`marker_S23`}).addTo(fg).bindPopup(`TANEY210<br>KK1 - Taney Ave on 210 Highway<br>Taney Ave on 210 Highway<br>North Kansas City, MO<br><b style='color:red;'>HT Compatable</b><br>39.144788, -94.558242,  0 Ft.<br>EM29RD`).openPopup();                        
 
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
                        title:`marker_S24`}).addTo(fg).bindPopup(`CTEAUELV<br>KK2 - Chouteau Elevator<br>4801 NE Birmingham Rd<br>Kansas City, MO 64117<br><b style='color:red;'>HT Compatible w/static</b><br>39.150823, -94.523884,  0 Ft.<br>EM29RD`).openPopup();                        
 
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
                        title:`marker_S25`}).addTo(fg).bindPopup(`HWY291on210<br>KK3 - Highway 210 @ Highway 291<br><br>Kansas City, MO 64117<br><b style='color:red;'>HT Compatible w/static</b><br>39.18423, -94.396235,  0 Ft.<br>EM29TE`).openPopup();                        
 
                        $(`SkyWarn`._icon).addClass(`skymrkr`);
var EOCList = L.layerGroup([W0KCN4, W0KCN3, W0KCN15, NARESEOC]);
var FireList = L.layerGroup([RVRSDEFD, KCMOFS3, KCMOFS4, KCMOFS5, KCMOFS6, KCMOFS7, KCMOFS8, KCMOFS10, KCMOFS16, KCMOFS17, KCMOFS18, KCMOFS19, KCMOFS23, KCMOFS24, KCMOFS25, KCMOFS27, KCMOFS29, KCMOFS30, KCMOFS33, KCMOFS34, KCMOFS35, KCMOFS37, KCMOFS38, KCMOFS39, KCMOFS40, KCMOFS41, KCMOFS43, KCMOFS44, KCMOFS47, KCMOFS14, RVRSFD]);
var HospitalList = L.layerGroup([KINDRD, LIBRTY, NORKC, PMC, RESRCH, SMMC, STLSMI, STLUBR, TRLKWD]);
var RepeaterList = L.layerGroup([WA0QFJ, WA0KHP, KCRKW1, KCRJCRAC1, KCRWW, KCRQFJ, KCRMED]);
var SheriffList = L.layerGroup([CCSHERIFF, NRTPD, RVRSPD, PKVLPD, LKWKPD, GSTNPD, NKCPD, COMOPD, KCNPPD, PLTCTYPD]);
var SkyWarnList = L.layerGroup([P3, P4, P5, P6, P7, P8, P9, P10, P11, P12, P13, C1, C2, C3, C5, C6, C7, C8, C9, C10, C11, C12, TANEY210, CTEAUELV, HWY291on210]);
var callsList = L.layerGroup([WA0TJT, W0DLK, KC0YT, AA0JX, KD0NBH]);

                            var KD0NBH01 = new L.marker(new L.LatLng(39.20646,-94.605575),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker01.png', iconSize: [32, 34]}),
                                title:`marker_O01`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: KD0NBH01<br></div><div class='gg'>W3W: undergoing.arrival.hobble </div><br><div class='cc'>Comment:<br> Black Chevy</div><br><div class='bb'><br>Cross Roads:<br>NW 62nd St &amp; N Harden Ct </div><br><div class='gg'>39.20646,-94.605575<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:32:04</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var KD0NBH02 = new L.marker(new L.LatLng(39.206272,-94.60481),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker02.png', iconSize: [32, 34]}),
                                title:`marker_O02`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: KD0NBH02<br></div><div class='gg'>W3W: converter.admitting.shovels </div><br><div class='cc'>Comment:<br>  White Ford</div><br><div class='bb'><br>Cross Roads:<br>N Harden Ct &amp; NW 62nd St </div><br><div class='gg'>39.206272,-94.60481<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:32:29</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var KD0NBH03 = new L.marker(new L.LatLng(39.205679,-94.605854),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker03.png', iconSize: [32, 34]}),
                                title:`marker_O03`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: KD0NBH03<br></div><div class='gg'>W3W: mincing.starring.engineering </div><br><div class='cc'>Comment:<br> Green Toyota</div><br><div class='bb'><br>Cross Roads:<br>NW 62nd St &amp; N Harden Ct </div><br><div class='gg'>39.205679,-94.605854<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:32:55</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var KD0NBH04 = new L.marker(new L.LatLng(39.205544,-94.60714),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker04.png', iconSize: [32, 34]}),
                                title:`marker_O04`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: KD0NBH04<br></div><div class='gg'>W3W: fussed.westerner.ratty </div><br><div class='cc'>Comment:<br> Red Honda</div><br><div class='bb'><br>Cross Roads:<br>NW 62nd St &amp; N Evans Ave </div><br><div class='gg'>39.205544,-94.60714<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:33:19</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var KD0NBH05 = new L.marker(new L.LatLng(39.205032,-94.606201),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker05.png', iconSize: [32, 34]}),
                                title:`marker_O05`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: KD0NBH05<br></div><div class='gg'>W3W: falsely.help.delight </div><br><div class='cc'>Comment:<br> Black Chevy Truck</div><br><div class='bb'><br>Cross Roads:<br>N Evans Ave &amp; NW 62nd St </div><br><div class='gg'>39.205032,-94.606201<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:34:14</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var KD0NBH06 = new L.marker(new L.LatLng(39.204385,-94.606862),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker06.png', iconSize: [32, 34]}),
                                title:`marker_O06`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: KD0NBH06<br></div><div class='gg'>W3W: craving.since.duchess </div><br><div class='cc'>Comment:<br> White Chevy Truck</div><br><div class='bb'><br>Cross Roads:<br>NW 62nd St &amp; N Evans Ave </div><br><div class='gg'>39.204385,-94.606862<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:34:36</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK01 = new L.marker(new L.LatLng(39.198159,-94.601576),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker01.png', iconSize: [32, 34]}),
                                title:`marker_O01`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK01<br></div><div class='gg'>W3W: spray.shudder.opting </div><br><div class='cc'>Comment:<br> yellow door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 57 Ct </div><br><div class='gg'>39.198159,-94.601576<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK02 = new L.marker(new L.LatLng(39.197539,-94.602375),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker02.png', iconSize: [32, 34]}),
                                title:`marker_O02`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK02<br></div><div class='gg'>W3W: bogus.daunted.overlapping </div><br><div class='cc'>Comment:<br> door is missing</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; 56th </div><br><div class='gg'>39.197539,-94.602375<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK03 = new L.marker(new L.LatLng(39.198779,-94.601541),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker03.png', iconSize: [32, 34]}),
                                title:`marker_O03`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK03<br></div><div class='gg'>W3W: trill.photons.pills </div><br><div class='cc'>Comment:<br> purple door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 57 Ct </div><br><div class='gg'>39.198779,-94.601541<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK04 = new L.marker(new L.LatLng(39.200908,-94.601471),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker04.png', iconSize: [32, 34]}),
                                title:`marker_O04`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK04<br></div><div class='gg'>W3W: posters.sheep.pretty </div><br><div class='cc'>Comment:<br> who know?</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 59 St </div><br><div class='gg'>39.200908,-94.601471<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK05 = new L.marker(new L.LatLng(39.200639,-94.601471),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker05.png', iconSize: [32, 34]}),
                                title:`marker_O05`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK05<br></div><div class='gg'>W3W: evolves.shorthand.doorway </div><br><div class='cc'>Comment:<br> red door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 59 St </div><br><div class='gg'>39.200639,-94.601471<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK06 = new L.marker(new L.LatLng(39.200477,-94.601471),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker06.png', iconSize: [32, 34]}),
                                title:`marker_O06`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK06<br></div><div class='gg'>W3W: strawberry.aunts.frocks </div><br><div class='cc'>Comment:<br> green door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 59 St </div><br><div class='gg'>39.200477,-94.601471<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK07 = new L.marker(new L.LatLng(39.19948,-94.601471),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker07.png', iconSize: [32, 34]}),
                                title:`marker_O07`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK07<br></div><div class='gg'>W3W: enjoys.gallery.served </div><br><div class='cc'>Comment:<br> pink door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 58 Ct </div><br><div class='gg'>39.19948,-94.601471<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK08 = new L.marker(new L.LatLng(39.201636,-94.601749),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker08.png', iconSize: [32, 34]}),
                                title:`marker_O08`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK08<br></div><div class='gg'>W3W: dished.relaxation.marked </div><br><div class='cc'>Comment:<br> white door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 59 St </div><br><div class='gg'>39.201636,-94.601749<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK09 = new L.marker(new L.LatLng(39.202418,-94.601923),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker09.png', iconSize: [32, 34]}),
                                title:`marker_O09`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK09<br></div><div class='gg'>W3W: sufferings.shifters.truffles </div><br><div class='cc'>Comment:<br> blue door</div><br><div class='bb'><br>Cross Roads:<br>NW 60th Ct &amp; N Ames Ave </div><br><div class='gg'>39.202418,-94.601923<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK10 = new L.marker(new L.LatLng(39.202579,-94.60241),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker10.png', iconSize: [32, 34]}),
                                title:`marker_O10`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK10<br></div><div class='gg'>W3W: typhoon.barrage.knots </div><br><div class='cc'>Comment:<br> green door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 60th Ct </div><br><div class='gg'>39.202579,-94.60241<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK11 = new L.marker(new L.LatLng(39.202876,-94.602445),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker11.png', iconSize: [32, 34]}),
                                title:`marker_O11`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK11<br></div><div class='gg'>W3W: mathematics.seasonal.eaters </div><br><div class='cc'>Comment:<br> red door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 60th Ct </div><br><div class='gg'>39.202876,-94.602445<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK12 = new L.marker(new L.LatLng(39.202903,-94.602897),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker12.png', iconSize: [32, 34]}),
                                title:`marker_O12`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK12<br></div><div class='gg'>W3W: easily.hardest.ended </div><br><div class='cc'>Comment:<br> across the street from home</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 60th Ct </div><br><div class='gg'>39.202903,-94.602897<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK13 = new L.marker(new L.LatLng(39.197647,-94.602689),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker13.png', iconSize: [32, 34]}),
                                title:`marker_O13`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK13<br></div><div class='gg'>W3W: confirm.backer.ministries </div><br><div class='cc'>Comment:<br> get the time</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; 56th </div><br><div class='gg'>39.197647,-94.602689<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK14 = new L.marker(new L.LatLng(39.197782,-94.602167),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker14.png', iconSize: [32, 34]}),
                                title:`marker_O14`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK14<br></div><div class='gg'>W3W: collateral.tomorrow.flop </div><br><div class='cc'>Comment:<br> flop my ass</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; 56th </div><br><div class='gg'>39.197782,-94.602167<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK15 = new L.marker(new L.LatLng(39.197917,-94.601923),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker15.png', iconSize: [32, 34]}),
                                title:`marker_O15`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK15<br></div><div class='gg'>W3W: vindicated.hygiene.doing </div><br><div class='cc'>Comment:<br> pink door</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; 56th </div><br><div class='gg'>39.197917,-94.601923<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK16 = new L.marker(new L.LatLng(39.19851,-94.601784),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker16.png', iconSize: [32, 34]}),
                                title:`marker_O16`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK16<br></div><div class='gg'>W3W: scorching.hygiene.spurned </div><br><div class='cc'>Comment:<br> blue door</div><br><div class='bb'><br>Cross Roads:<br>NW 57 Ct &amp; N Ames Ave </div><br><div class='gg'>39.19851,-94.601784<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK17 = new L.marker(new L.LatLng(39.199022,-94.601715),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker17.png', iconSize: [32, 34]}),
                                title:`marker_O17`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK17<br></div><div class='gg'>W3W: puts.available.folder </div><br><div class='cc'>Comment:<br> pole in road</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 57 Ct </div><br><div class='gg'>39.199022,-94.601715<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK18 = new L.marker(new L.LatLng(39.199534,-94.601715),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker18.png', iconSize: [32, 34]}),
                                title:`marker_O18`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK18<br></div><div class='gg'>W3W: buckets.tumblers.rehearsing </div><br><div class='cc'>Comment:<br> tree in driveway</div><br><div class='bb'><br>Cross Roads:<br>NW 58 Ct &amp; N Ames Ave </div><br><div class='gg'>39.199534,-94.601715<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK19 = new L.marker(new L.LatLng(39.200127,-94.601715),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker19.png', iconSize: [32, 34]}),
                                title:`marker_O19`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK19<br></div><div class='gg'>W3W: forecast.snack.upshot </div><br><div class='cc'>Comment:<br> tree on roof of house</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 58 Ct </div><br><div class='gg'>39.200127,-94.601715<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK20 = new L.marker(new L.LatLng(39.200558,-94.601715),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker20.png', iconSize: [32, 34]}),
                                title:`marker_O20`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK20<br></div><div class='gg'>W3W: ever.insects.monarch </div><br><div class='cc'>Comment:<br> used spaces</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 59 St </div><br><div class='gg'>39.200558,-94.601715<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK21 = new L.marker(new L.LatLng(39.201474,-94.601889),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker21.png', iconSize: [32, 34]}),
                                title:`marker_O21`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK21<br></div><div class='gg'>W3W: spinach.spaceship.scouts </div><br><div class='cc'>Comment:<br> Boy Scouts in the airea</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 59 St </div><br><div class='gg'>39.201474,-94.601889<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var W0DLK22 = new L.marker(new L.LatLng(39.202013,-94.602515),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker22.png', iconSize: [32, 34]}),
                                title:`marker_O22`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: W0DLK22<br></div><div class='gg'>W3W: peanuts.cafeteria.hamstrings </div><br><div class='cc'>Comment:<br> food on the table</div><br><div class='bb'><br>Cross Roads:<br>N Bedford Ave &amp; N Ames Ave </div><br><div class='gg'>39.202013,-94.602515<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT01 = new L.marker(new L.LatLng(39.202579,-94.602515),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker01.png', iconSize: [32, 34]}),
                                title:`marker_O01`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT01<br></div><div class='gg'>W3W: mathematics.crunched.respectful </div><br><div class='cc'>Comment:<br> First marker</div><br><div class='bb'><br>Cross Roads:<br>N Ames Ave &amp; NW 60th Ct </div><br><div class='gg'>39.202579,-94.602515<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT02 = new L.marker(new L.LatLng(39.201879,-94.602689),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker02.png', iconSize: [32, 34]}),
                                title:`marker_O02`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT02<br></div><div class='gg'>W3W: browser.protesting.reward </div><br><div class='cc'>Comment:<br> Mail box</div><br><div class='bb'><br>Cross Roads:<br>N Bedford Ave &amp; N Ames Ave </div><br><div class='gg'>39.201879,-94.602689<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT03 = new L.marker(new L.LatLng(39.201582,-94.603315),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker03.png', iconSize: [32, 34]}),
                                title:`marker_O03`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT03<br></div><div class='gg'>W3W: royals.oddly.relating </div><br><div class='cc'>Comment:<br> The next marker</div><br><div class='bb'><br>Cross Roads:<br>N Bedford Ave &amp; NW 59th Ct </div><br><div class='gg'>39.201582,-94.603315<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT04 = new L.marker(new L.LatLng(39.201313,-94.603488),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker04.png', iconSize: [32, 34]}),
                                title:`marker_O04`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT04<br></div><div class='gg'>W3W: invaluable.resumes.thumbnail </div><br><div class='cc'>Comment:<br> Marker next again</div><br><div class='bb'><br>Cross Roads:<br>N Bedford Ave &amp; NW 59th Ct </div><br><div class='gg'>39.201313,-94.603488<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT05 = new L.marker(new L.LatLng(39.201097,-94.604184),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker05.png', iconSize: [32, 34]}),
                                title:`marker_O05`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT05<br></div><div class='gg'>W3W: student.downgraded.satisfy </div><br><div class='cc'>Comment:<br> Holding hands</div><br><div class='bb'><br>Cross Roads:<br>NW 59th Ct &amp; N Bedford Ave </div><br><div class='gg'>39.201097,-94.604184<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT06 = new L.marker(new L.LatLng(39.201286,-94.604532),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker06.png', iconSize: [32, 34]}),
                                title:`marker_O06`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT06<br></div><div class='gg'>W3W: transmitted.reward.loners </div><br><div class='cc'>Comment:<br> Still on the way down</div><br><div class='bb'><br>Cross Roads:<br>NW 59th Ct &amp; N Bedford Ave </div><br><div class='gg'>39.201286,-94.604532<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT07 = new L.marker(new L.LatLng(39.20169,-94.604567),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker07.png', iconSize: [32, 34]}),
                                title:`marker_O07`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT07<br></div><div class='gg'>W3W: powerful.ongoing.rigid </div><br><div class='cc'>Comment:<br> Big red door</div><br><div class='bb'><br>Cross Roads:<br>NW 59th Ct &amp; N Bedford Ave </div><br><div class='gg'>39.20169,-94.604567<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT08 = new L.marker(new L.LatLng(39.201366,-94.604428),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker08.png', iconSize: [32, 34]}),
                                title:`marker_O08`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT08<br></div><div class='gg'>W3W: blinked.surcharge.lays </div><br><div class='cc'>Comment:<br> More walking downhill</div><br><div class='bb'><br>Cross Roads:<br>NW 59th Ct &amp; N Bedford Ave </div><br><div class='gg'>39.201366,-94.604428<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT09 = new L.marker(new L.LatLng(39.201097,-94.604219),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker09.png', iconSize: [32, 34]}),
                                title:`marker_O09`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT09<br></div><div class='gg'>W3W: bookshelf.morphing.awarded </div><br><div class='cc'>Comment:<br> Still holding hands</div><br><div class='bb'><br>Cross Roads:<br>NW 59th Ct &amp; N Bedford Ave </div><br><div class='gg'>39.201097,-94.604219<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT10 = new L.marker(new L.LatLng(39.201016,-94.603732),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker10.png', iconSize: [32, 34]}),
                                title:`marker_O10`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT10<br></div><div class='gg'>W3W: merchandise.trendy.dynamic </div><br><div class='cc'>Comment:<br> Blue door now</div><br><div class='bb'><br>Cross Roads:<br>NW 59th Ct &amp; N Bedford Ave </div><br><div class='gg'>39.201016,-94.603732<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT11 = new L.marker(new L.LatLng(39.200154,-94.603697),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker11.png', iconSize: [32, 34]}),
                                title:`marker_O11`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT11<br></div><div class='gg'>W3W: toasted.extremes.continental </div><br><div class='cc'>Comment:<br> Middle of the street</div><br><div class='bb'><br>Cross Roads:<br>Bedford &amp; N Bedford Ave </div><br><div class='gg'>39.200154,-94.603697<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT12 = new L.marker(new L.LatLng(39.199749,-94.603975),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker12.png', iconSize: [32, 34]}),
                                title:`marker_O12`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT12<br></div><div class='gg'>W3W: reception.nickname.tremor </div><br><div class='cc'>Comment:<br> Green door</div><br><div class='bb'><br>Cross Roads:<br>NW 58th St &amp; N Bedford Ave </div><br><div class='gg'>39.199749,-94.603975<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT13 = new L.marker(new L.LatLng(39.199561,-94.604497),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker13.png', iconSize: [32, 34]}),
                                title:`marker_O13`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT13<br></div><div class='gg'>W3W: powered.repelled.magically </div><br><div class='cc'>Comment:<br> Dorr is missing</div><br><div class='bb'><br>Cross Roads:<br>NW 58th St &amp; N Delta Ave </div><br><div class='gg'>39.199561,-94.604497<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT14 = new L.marker(new L.LatLng(39.199426,-94.605019),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker14.png', iconSize: [32, 34]}),
                                title:`marker_O14`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT14<br></div><div class='gg'>W3W: gravy.planet.discharged </div><br><div class='cc'>Comment:<br> At the cross roads</div><br><div class='bb'><br>Cross Roads:<br>NW 58th St &amp; N Delta Ave </div><br><div class='gg'>39.199426,-94.605019<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT15 = new L.marker(new L.LatLng(39.199318,-94.604984),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker15.png', iconSize: [32, 34]}),
                                title:`marker_O15`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT15<br></div><div class='gg'>W3W: rescuer.shrink.founder </div><br><div class='cc'>Comment:<br> Red door maybe</div><br><div class='bb'><br>Cross Roads:<br>N Delta Ave &amp; NW 58th St </div><br><div class='gg'>39.199318,-94.604984<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT16 = new L.marker(new L.LatLng(39.199695,-94.604149),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker16.png', iconSize: [32, 34]}),
                                title:`marker_O16`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT16<br></div><div class='gg'>W3W: spurned.formed.schoolwork </div><br><div class='cc'>Comment:<br> Red door again</div><br><div class='bb'><br>Cross Roads:<br>NW 58th St &amp; N Bedford Ave </div><br><div class='gg'>39.199695,-94.604149<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT17 = new L.marker(new L.LatLng(39.19983,-94.603836),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker17.png', iconSize: [32, 34]}),
                                title:`marker_O17`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT17<br></div><div class='gg'>W3W: cringe.gets.resumes </div><br><div class='cc'>Comment:<br> Telephone pole in street</div><br><div class='bb'><br>Cross Roads:<br>NW 58th St &amp; N Bedford Ave </div><br><div class='gg'>39.19983,-94.603836<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT18 = new L.marker(new L.LatLng(39.200127,-94.603628),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker18.png', iconSize: [32, 34]}),
                                title:`marker_O18`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT18<br></div><div class='gg'>W3W: included.dentures.wishful </div><br><div class='cc'>Comment:<br> Tree down in yard</div><br><div class='bb'><br>Cross Roads:<br>N Bedford Ave &amp; Bedford </div><br><div class='gg'>39.200127,-94.603628<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT19 = new L.marker(new L.LatLng(39.200774,-94.603697),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker19.png', iconSize: [32, 34]}),
                                title:`marker_O19`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT19<br></div><div class='gg'>W3W: enzymes.texts.elevates </div><br><div class='cc'>Comment:<br> At the mailbox again</div><br><div class='bb'><br>Cross Roads:<br>N Bedford Ave &amp; NW 59th Ct </div><br><div class='gg'>39.200774,-94.603697<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT20 = new L.marker(new L.LatLng(39.201259,-94.603454),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker20.png', iconSize: [32, 34]}),
                                title:`marker_O20`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT20<br></div><div class='gg'>W3W: deviations.barks.shapeless </div><br><div class='cc'>Comment:<br> Walking up the hill</div><br><div class='bb'><br>Cross Roads:<br>N Bedford Ave &amp; NW 59th Ct </div><br><div class='gg'>39.201259,-94.603454<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT21 = new L.marker(new L.LatLng(39.201501,-94.603245),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker21.png', iconSize: [32, 34]}),
                                title:`marker_O21`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT21<br></div><div class='gg'>W3W: unsuitable.manliness.plums </div><br><div class='cc'>Comment:<br> Pretty flowering trees</div><br><div class='bb'><br>Cross Roads:<br>N Bedford Ave &amp; NW 59th Ct </div><br><div class='gg'>39.201501,-94.603245<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                            var WA0TJT22 = new L.marker(new L.LatLng(39.201825,-94.602723),{
                                rotationAngle: 0, 
                                rotationOrigin: 'bottom', 
                                opacity: 0.75,
                                contextmenu: true, 
                                contextmenuWidth: 140,
                                contextmenuItems: [{ text: 'Click here to add mileage circles',callback: circleKoords}],
                                
                                icon: L.icon({iconUrl: 'images/markers/marker22.png', iconSize: [32, 34]}),
                                title:`marker_O22`}).addTo(fg).bindPopup(`<div class='xx'>OBJ: WA0TJT22<br></div><div class='gg'>W3W: forthright.valid.protects </div><br><div class='cc'>Comment:<br> Back at the corner of Ames</div><br><div class='bb'><br>Cross Roads:<br>N Bedford Ave &amp; N Ames Ave </div><br><div class='gg'>39.201825,-94.602723<br>Grid: EM29QE<br><br>Captured:<br>2021-07-28 16:07:27</div>`).openPopup();                    
                                
                                $('Objects'._icon).addClass('objmrkr');                                               
                          ;
var OBJMarkerList = L.layerGroup([KD0NBH01,KD0NBH02,KD0NBH03,KD0NBH04,KD0NBH05,KD0NBH06,W0DLK01,W0DLK02,W0DLK03,W0DLK04,W0DLK05,W0DLK06,W0DLK07,W0DLK08,W0DLK09,W0DLK10,W0DLK11,W0DLK12,W0DLK13,W0DLK14,W0DLK15,W0DLK16,W0DLK17,W0DLK18,W0DLK19,W0DLK20,W0DLK21,W0DLK22,WA0TJT01,WA0TJT02,WA0TJT03,WA0TJT04,WA0TJT05,WA0TJT06,WA0TJT07,WA0TJT08,WA0TJT09,WA0TJT10,WA0TJT11,WA0TJT12,WA0TJT13,WA0TJT14,WA0TJT15,WA0TJT16,WA0TJT17,WA0TJT18,WA0TJT19,WA0TJT20,WA0TJT21,WA0TJT22,]);

/*
var OBJMarkerList1 = 
    L.layerGroup([KD0NBH01,KD0NBH02,KD0NBH03,KD0NBH04,KD0NBH05,KD0NBH06,]);

var OBJMarkerList2 = L.layerGroup([W0DLK01,W0DLK02,W0DLK03,W0DLK04,W0DLK05,W0DLK06,W0DLK07,W0DLK08,W0DLK09,W0DLK10,W0DLK11,W0DLK12,W0DLK13,W0DLK14,W0DLK15,W0DLK16,W0DLK17,W0DLK18,W0DLK19,W0DLK20,W0DLK21,W0DLK22,]);

var OBJMarkerList3 =    L.layerGroup([WA0TJT01,WA0TJT02,WA0TJT03,WA0TJT04,WA0TJT05,WA0TJT06,WA0TJT07,WA0TJT08,WA0TJT09,WA0TJT10,WA0TJT11,WA0TJT12,WA0TJT13,WA0TJT14,WA0TJT15,WA0TJT16,WA0TJT17,WA0TJT18,WA0TJT19,WA0TJT20,WA0TJT21,WA0TJT22,]);
*/

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
    blueFlagicon = new PoiIconClass({iconUrl: 'images/markers/blue_50_flag.png'}),  // used as corners of the bounds
    
    objicon = new ObjIconClass({iconURL: 'images/markers/marker00.png'}),          // the 00 marker
    greenFlagicon = new ObjIconClass({iconUrl: 'images/markers/green_50_flag.png'});  // used as corners of the bounds

var Stations = L.layerGroup([WA0TJT,W0DLK,KD0NBH,KC0YT,AA0JX]);

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
		

// The fitBounds data comes from stationMarkers.php
var bounds = L.latLngBounds([[39.201825,-94.602723],[39.2028965,-94.602876],[39.204385,-94.606862],[39.2002636,-94.641221],[39.2232199,-94.568932]]); 
var middle = bounds.getCenter(); // alert(middle); //LatLng(-93.20448, 38.902475)
var padit  = bounds.pad(.075);   // add a little bit to the corner bounding box
var sw = padit.getSouthWest();   // get the SouthWest most point
var nw = padit.getNorthWest();
var ne = padit.getNorthEast();
var se = padit.getSouthEast();

var redmarkername = "images/markers/red_50_flag.png";
var bluemarkername = "images/markers/blue_50_flag.png";
// these two are used by the objects, if there are any
var greenmarkername = "images/markers/green_50_flag.png";
var manInTheMiddle_50 = "images/markers/manInTheMiddle_50.png";

    // ================== Station Marker Corners =======================
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
    // ================== End Station Marker Corners =======================
    
    //====================================================================== 
    // ===================== Object Marker Corners =========================
    //====================================================================== 
       
    // These are from objMarkers.php
     var objbounds = L.latLngBounds([[39.20646,-94.605575],[39.206272,-94.60481],[39.205679,-94.605854],[39.205544,-94.60714],[39.205032,-94.606201],[39.204385,-94.606862],[39.198159,-94.601576],[39.197539,-94.602375],[39.198779,-94.601541],[39.200908,-94.601471],[39.200639,-94.601471],[39.200477,-94.601471],[39.19948,-94.601471],[39.201636,-94.601749],[39.202418,-94.601923],[39.202579,-94.60241],[39.202876,-94.602445],[39.202903,-94.602897],[39.197647,-94.602689],[39.197782,-94.602167],[39.197917,-94.601923],[39.19851,-94.601784],[39.199022,-94.601715],[39.199534,-94.601715],[39.200127,-94.601715],[39.200558,-94.601715],[39.201474,-94.601889],[39.202013,-94.602515],[39.202579,-94.602515],[39.201879,-94.602689],[39.201582,-94.603315],[39.201313,-94.603488],[39.201097,-94.604184],[39.201286,-94.604532],[39.20169,-94.604567],[39.201366,-94.604428],[39.201097,-94.604219],[39.201016,-94.603732],[39.200154,-94.603697],[39.199749,-94.603975],[39.199561,-94.604497],[39.199426,-94.605019],[39.199318,-94.604984],[39.199695,-94.604149],[39.19983,-94.603836],[39.200127,-94.603628],[39.200774,-94.603697],[39.201259,-94.603454],[39.201501,-94.603245],[39.201825,-94.602723]]);  
    // alert(JSON.stringify(objbounds)); 
    // {"_southWest":{"lat":39.197539,"lng":-94.605019},"_northEast":{"lat":39.202903,"lng":-94.601471}}
    
     var KD0NBHOBJ = L.latLngBounds([[39.20646,-94.605575],[39.206272,-94.60481],[39.205679,-94.605854],[39.205544,-94.60714],[39.205032,-94.606201],[39.204385,-94.606862]]);
         
     var W0DLKOBJ = L.latLngBounds([[39.202903,-94.602897],[39.202876,-94.602445],[39.202579,-94.60241],[39.202418,-94.601923],[39.201636,-94.601749],[39.200908,-94.601471],[39.200639,-94.601471],[39.200477,-94.601471],[39.19948,-94.601471],[39.198779,-94.601541],[39.198159,-94.601576],[39.197539,-94.602375],[39.197647,-94.602689],[39.197782,-94.602167],[39.197917,-94.601923],[39.19851,-94.601784],[39.199022,-94.601715],[39.199534,-94.601715],[39.200127,-94.601715],[39.200558,-94.601715],[39.201474,-94.601889],[39.202013,-94.602515]]);
     
     var WA0TJTOBJ = L.latLngBounds([[39.202579,-94.602515],[39.201879,-94.602689],[39.201582,-94.603315],[39.201313,-94.603488],[39.201097,-94.604184],[39.201286,-94.604532],[39.20169,-94.604567],[39.201366,-94.604428],[39.201097,-94.604219],[39.201016,-94.603732],[39.200154,-94.603697],[39.199749,-94.603975],[39.199561,-94.604497],[39.199426,-94.605019],[39.199318,-94.604984],[39.199695,-94.604149],[39.19983,-94.603836],[39.200127,-94.603628],[39.200774,-94.603697],[39.201259,-94.603454],[39.201501,-94.603245],[39.201825,-94.602723]]);


    // Test if there were any objects created in this net, this function is at the bottom of this code.
    if(isEmpty(objbounds)) {console.log('There are no objects in this net')} else { console.log('Net has objects'); 

        var middle = KD0NBHOBJ.getCenter();
        var padit  = KD0NBHOBJ.pad(.015);
        var Onw = padit.getNorthWest();
        var One = padit.getNorthEast();
        var Ose = padit.getSouthEast();
        var Osw = padit.getSouthWest();      
        
        var middle1 = KD0NBHOBJ.getCenter();  
        var padit1  = KD0NBHOBJ.pad(.015);    
        var Osw1 = padit1.getSouthWest();
        var Onw1 = padit1.getNorthWest();
        var One1 = padit1.getNorthEast();
        var Ose1 = padit1.getSouthEast();
        
        var middle2 = W0DLKOBJ.getCenter();
        var padit2  = W0DLKOBJ.pad(.015);    
        var Osw2 = padit2.getSouthWest();      
        var Onw2 = padit2.getNorthWest();
        var One2 = padit2.getNorthEast();
        var Ose2 = padit2.getSouthEast();
        
        var middle3 = WA0TJTOBJ.getCenter();  
        var padit3  = WA0TJTOBJ.pad(.015);    
        var Osw3 = padit3.getSouthWest();    
        var Onw3 = padit3.getNorthWest();
        var One3 = padit3.getNorthEast();
        var Ose3 = padit3.getSouthEast();

   // for (let i = 1; i <= 3; i++ ) {
    /*    var middle1 = KD0NBHOBJ.getCenter();  // console.log('MitM: '+middle); //LatLng(-93.20448, 38.902475)
        var Opadit1  = KD0NBHOBJ.pad(.015);    // add a little bit to the corner bounding box
        var Osw1 = Opadit1.getSouthWest();      // get the SouthWest most point
        var Onw1 = Opadit1.getNorthWest();
        var One1 = Opadit1.getNorthEast();
        var Ose1 = Opadit1.getSouthEast();
        
        var middle2 = W0DLKOBJ.getCenter();  // console.log('MitM: '+middle); //LatLng(-93.20448, 38.902475)
        var Opadit2  = W0DLKOBJ.pad(.015);    // add a little bit to the corner bounding box
        var Osw2 = Opadit2.getSouthWest();      // get the SouthWest most point
        var Onw2 = Opadit2.getNorthWest();
        var One2 = Opadit2.getNorthEast();
        var Ose2 = Opadit2.getSouthEast();
        
        var middle3 = WA0TJTOBJ.getCenter();  // console.log('MitM: '+middle); //LatLng(-93.20448, 38.902475)
        var Opadit3  = WA0TJTOBJ.pad(.015);    // add a little bit to the corner bounding box
        var Osw3 = Opadit3.getSouthWest();      // get the SouthWest most point
        var Onw3 = Opadit3.getNorthWest();
        var One3 = Opadit3.getNorthEast();
        var Ose3 = Opadit3.getSouthEast(); */
   
        // These are the corner markers of the extended bounds of the objects
        var ob11 = new L.marker(new L.latLng( Osw1 ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
            icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
            title:'ob1'}).addTo(map).bindPopup('OBJ: OB1<br>The Objects SW Corner<br>'+Osw1).openPopup();
        
        var ob21 = new L.marker(new L.latLng( Onw1 ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
           icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
           title:'ob2'}).addTo(map).bindPopup('OBJ: OB2<br>The Objects NW Corner<br>'+Onw1).openPopup();
        
        var ob31 = new L.marker(new L.latLng( One1 ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
           icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
           title:'ob3'}).addTo(map).bindPopup('OBJ: OB3<br>The Objects NE Corner<br>'+One1).openPopup();
        
        var ob41 = new L.marker(new L.latLng( Ose1 ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
           icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
           title:'ob4'}).addTo(map).bindPopup('OBJ: OB4<br>The Objects SE Corner<br>'+Ose1).openPopup();
    	
        // Add the temp center marker to the map here in the javascript code allows it to use the current map view,
        // When its earlier in the stack, it centers on our house becaue that is the default map location
        var ob51 = new L.marker(new L.latLng( middle1 ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
            text: 'Click here to add mileage circles', callback: circleKoords}],   
            icon: L.icon({iconUrl: manInTheMiddle_50 , iconSize: [32, 36] }),     
            title:'ob51'}).addTo(map).bindPopup('OBJ: OB51<br>The Objects Center Marker<br>'+middle1).openPopup();
            
            // Definition of the 5 markers above, corners plus middle    
            var ObjCornerList1 = L.layerGroup([ob11, ob21, ob31, ob41, ob51]);
  //2          
        var ob12 = new L.marker(new L.latLng( Osw2 ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
            icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
            title:'ob12'}).addTo(map).bindPopup('OBJ: OB12<br>The Objects SW Corner<br>'+Osw2).openPopup();
        
        var ob22 = new L.marker(new L.latLng( Onw2 ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
           icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
           title:'ob22'}).addTo(map).bindPopup('OBJ: OB22<br>The Objects NW Corner<br>'+Onw2).openPopup();
        
        var ob32 = new L.marker(new L.latLng( One2 ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
           icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
           title:'ob32'}).addTo(map).bindPopup('OBJ: OB32<br>The Objects NE Corner<br>'+One2).openPopup();
        
        var ob42 = new L.marker(new L.latLng( Ose2 ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
           icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
           title:'ob42'}).addTo(map).bindPopup('OBJ: OB42<br>The Objects SE Corner<br>'+Ose2).openPopup();
    	
        // Add the temp center marker to the map here in the javascript code allows it to use the current map view,
        // When its earlier in the stack, it centers on our house becaue that is the default map location
        var ob52 = new L.marker(new L.latLng( middle2 ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
            text: 'Click here to add mileage circles', callback: circleKoords}],   
            icon: L.icon({iconUrl: manInTheMiddle_50 , iconSize: [32, 36] }),     
            title:'ob52'}).addTo(map).bindPopup('OBJ: OB52<br>The Objects Center Marker<br>'+middle2).openPopup();
            
            var ObjCornerList2 = L.layerGroup([ob12, ob22, ob32, ob42, ob52]);
            
  //3          
        var ob13 = new L.marker(new L.latLng( Osw3 ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
            icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
            title:'ob13'}).addTo(map).bindPopup('OBJ: OB13<br>The Objects SW Corner<br>'+Osw3).openPopup();
        
        var ob23 = new L.marker(new L.latLng( Onw3 ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
           icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
           title:'ob23'}).addTo(map).bindPopup('OBJ: OB23<br>The Objects NW Corner<br>'+Onw3).openPopup();
        
        var ob33 = new L.marker(new L.latLng( One3 ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
           icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
           title:'ob33'}).addTo(map).bindPopup('OBJ: OB33<br>The Objects NE Corner<br>'+One3).openPopup();
        
        var ob43 = new L.marker(new L.latLng( Ose3 ),{
           contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
           text: 'Click here to add mileage circles', callback: circleKoords}],
           icon: L.icon({iconUrl: greenmarkername , iconSize: [32,36] }),
           title:'ob43'}).addTo(map).bindPopup('OBJ: OB43<br>The Objects SE Corner<br>'+Ose3).openPopup();
    	
        // Add the temp center marker to the map here in the javascript code allows it to use the current map view,
        // When its earlier in the stack, it centers on our house becaue that is the default map location
        var ob53 = new L.marker(new L.latLng( middle3 ),{
            contextmenu: true, contextmenuWidth: 140, contextmenuItems: [{ 
            text: 'Click here to add mileage circles', callback: circleKoords}],   
            icon: L.icon({iconUrl: manInTheMiddle_50 , iconSize: [32, 36] }),     
            title:'ob53'}).addTo(map).bindPopup('OBJ: OB53<br>The Objects Center Marker<br>'+middle3).openPopup();
        
            var ObjCornerList3 = L.layerGroup([ob13, ob23, ob33, ob43, ob53]);
 //   } // end of for loop
      // ================== End of Object Marker Corners =======================
    } // End of test for object in this net

var classList = 'EOCL,FireL,HospitalL,RepeaterL,SheriffL,SkyWarnL, CornerL, ObjectL'.split(','); //alert(classList); // EOCL,FireL,HospitalL,RepeaterL,SheriffL,SkyWarnL,
   console.log('classList= '+classList);

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
         
    }else if (x == 'ObjectL') {
        let Objects = {"<img src='images/markers/marker00.png' align='middle' /> <span class='objmrkrs'>Objects</span>": ObjectList};
        y = {...y, ...Objects}; 
        
    }else if (x == ' CornerL') {
        let Corners = {"<img src='images/markers/red_50_flag.png' align='middle' /> <span class='corners'>Corners</span>": CornerList};
        y = {...y, ...Corners};
    }
}; // End of for loop
    
// Here we add the station object with the merged y objects from above
var overlayMaps = {...y }; 

console.log(overlayMaps); 

// Set the center point of the map based on the coordinates
map.fitBounds([[39.201825,-94.602723],[39.2028965,-94.602876],[39.204385,-94.606862],[39.2002636,-94.641221],[39.2232199,-94.568932]], {
  pad: 0.5
});

L.control.layers(baseMaps, overlayMaps, {position:'bottomright', collapsed:false}).addTo(map);


// Define the Plus and Minus for zooming and its location
map.scrollWheelZoom.disable();  // prevents the map from zooming with the mouse wheel (doesn't seem to work)

var arcgisOnline = L.esri.Geocoding.arcgisOnlineProvider();

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

// This function creates the circles around the right-clicked marker
var circfeqcnt = 0; // Sets a variable to count how many times the circleKoords() function is called

// This is where circleKoords() function 
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
	    

</script>

</body>
</html>

